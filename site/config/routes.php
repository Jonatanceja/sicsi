<?php

use Kirby\Cms\App;
use Kirby\Http\Response;
use Kirby\Toolkit\Str;
use Kirby\Toolkit\V;

return [
    [
        'pattern' => 'robots.txt',
        'action' => function () {
            $kirby = App::instance();
            $body = "User-agent: *\nDisallow: /panel\nDisallow: /solicitudes\nDisallow: /cotizar\n\nSitemap: ".$kirby->url()."/sitemap.xml\n";

            return new Response($body, 'text/plain');
        },
    ],
    [
        'pattern' => 'sitemap.xml',
        'action' => function () {
            $kirby = App::instance();
            $pages = $kirby->site()->index()->listed()->filter(
                fn ($page) => $page->intendedTemplate()->name() !== 'error' && $page->seoRobots()->value() !== 'noindex,nofollow'
            );

            $urls = '';
            foreach ($pages as $page) {
                $urls .= '  <url><loc>'.htmlspecialchars($page->url(), ENT_XML1).'</loc><lastmod>'.$page->modified('Y-m-d').'</lastmod></url>'."\n";
            }

            return new Response('<?xml version="1.0" encoding="UTF-8"?>'."\n".'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n".$urls.'</urlset>'."\n", 'application/xml');
        },
    ],
    // Leads are private Panel content: never render them on the public site
    [
        'pattern' => ['solicitudes', 'solicitudes/(:all)'],
        'action' => function () {
            $kirby = App::instance();
            $kirby->response()->code(404);

            return $kirby->site()->errorPage();
        },
    ],
    [
        'pattern' => 'cotizar',
        'method' => 'POST',
        'action' => function () {
            $kirby = App::instance();
            $site = $kirby->site();
            $data = $kirby->request()->data();

            if (csrf($kirby->request()->header('X-CSRF-Token')) !== true) {
                return Response::json(['message' => 'Sesión expirada, recarga la página.'], 419);
            }

            // Honeypot: pretend success so bots learn nothing
            if (trim((string) ($data['website'] ?? '')) !== '') {
                return Response::json(['ok' => true]);
            }

            $clip = fn ($value, int $max) => Str::substr(trim(strip_tags((string) $value)), 0, $max);
            $name = $clip($data['name'] ?? '', 120);
            $company = $clip($data['company'] ?? '', 160);
            $email = $clip($data['email'] ?? '', 160);
            $phone = $clip($data['phone'] ?? '', 40);

            if ($name === '' || $company === '' || V::email($email) === false || strlen(preg_replace('/\D/', '', $phone)) < 8) {
                return Response::json(['message' => $site->formError()->value()], 422);
            }

            // Extra fields arrive as label => value; keep them for the email and by key for the lead
            $extra = [];
            foreach ((array) ($data['extra'] ?? []) as $label => $value) {
                if (is_scalar($value) && trim((string) $value) !== '') {
                    $extra[$clip($label, 60)] = $clip($value, 2000);
                }
            }

            $labels = [
                'service' => $site->formServiceLabel()->value(),
                'location' => $site->formLocationLabel()->value(),
                'people' => $site->formPeopleLabel()->value(),
                'modality' => $site->formModalityLabel()->value(),
                'comments' => $site->formCommentsLabel()->value(),
            ];
            $byKey = [];
            foreach ($labels as $key => $label) {
                $byKey[$key] = $extra[trim(str_replace('*', '', $label))] ?? '';
            }

            $source = $clip($kirby->request()->header('Referer', ''), 255);

            // 1) Save the lead in the Panel (works even if mail is not configured)
            try {
                $kirby->impersonate('kirby', function () use ($kirby, $name, $company, $email, $phone, $byKey, $source) {
                    $parent = $kirby->page('solicitudes');
                    $now = date('Y-m-d H:i:s');

                    $parent->createChild([
                        'slug' => 'solicitud-'.date('YmdHis').'-'.strtolower(Str::random(4, 'alphaNum')),
                        'template' => 'lead',
                        'draft' => false,
                        'content' => [
                            'title' => $company.' – '.$name,
                            'name' => $name,
                            'company' => $company,
                            'email' => $email,
                            'phone' => $phone,
                            ...$byKey,
                            'leadStatus' => 'new',
                            'createdAt' => $now,
                            'source' => $source,
                        ],
                    ]);
                });
            } catch (Throwable $e) {
                return Response::json(['message' => $site->formError()->value()], 500);
            }

            // 2) Notify by email; a mail failure must not lose the lead
            $lines = ['Nombre: '.$name, 'Empresa: '.$company, 'Correo: '.$email, 'Teléfono: '.$phone];
            foreach ($extra as $label => $value) {
                $lines[] = $label.': '.$value;
            }
            $lines[] = 'Origen: '.($source ?: $kirby->url());

            try {
                $to = $site->formRecipient()->or(env('MAIL_FROM_ADDRESS'))->value();

                if ($to) {
                    $kirby->email([
                        'from' => env('MAIL_FROM_ADDRESS', $to),
                        'fromName' => env('MAIL_FROM_NAME', $site->title()->value()),
                        'replyTo' => $email,
                        'to' => $to,
                        'subject' => 'Nueva solicitud de cotización – '.$company,
                        'body' => implode("\n", $lines),
                    ]);
                }
            } catch (Throwable $e) {
                // Lead is already stored in the Panel
            }

            return Response::json(['ok' => true]);
        },
    ],
];
