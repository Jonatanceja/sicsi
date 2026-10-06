<?php

use Kirby\Cms\App;
use Kirby\Http\Response;
use Kirby\Toolkit\Str;
use Kirby\Toolkit\V;

return [
    [
        'pattern' => 'cotizar',
        'method' => 'POST',
        'action' => function () {
            $kirby = App::instance();
            $data = $kirby->request()->data();
            $home = $kirby->page('home');

            if (csrf($kirby->request()->header('X-CSRF-Token')) !== true) {
                return Response::json(['message' => 'Sesión expirada, recarga la página.'], 419);
            }

            $name = trim((string) ($data['name'] ?? ''));
            $company = trim((string) ($data['company'] ?? ''));
            $email = trim((string) ($data['email'] ?? ''));
            $phone = trim((string) ($data['phone'] ?? ''));

            if ($name === '' || $company === '' || V::email($email) === false || strlen(preg_replace('/\D/', '', $phone)) < 8) {
                return Response::json(['message' => $home->formError()->value()], 422);
            }

            $lines = [
                'Nombre: '.$name,
                'Empresa: '.$company,
                'Correo: '.$email,
                'Teléfono: '.$phone,
            ];

            foreach ((array) ($data['extra'] ?? []) as $label => $value) {
                if (is_scalar($value) && trim((string) $value) !== '') {
                    $lines[] = Str::substr(strip_tags((string) $label), 0, 60).': '.Str::substr(trim((string) $value), 0, 2000);
                }
            }

            $lines[] = 'Origen: '.$kirby->request()->header('Referer', $kirby->url());

            try {
                $kirby->email([
                    'from' => env('MAIL_FROM_ADDRESS', 'no-reply@'.$kirby->url('index', true)->host()),
                    'fromName' => env('MAIL_FROM_NAME', $kirby->site()->title()->value()),
                    'replyTo' => $email,
                    'to' => $home->formRecipient()->or(env('MAIL_FROM_ADDRESS'))->value(),
                    'subject' => 'Nueva solicitud de cotización – '.$company,
                    'body' => implode("\n", $lines),
                ]);
            } catch (Throwable $e) {
                return Response::json(['message' => $home->formError()->value()], 500);
            }

            return Response::json(['ok' => true]);
        },
    ],
];
