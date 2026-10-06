# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Overview

A Kirby CMS 5 site (PHP ^8.3) built from the `beebmx/kirby-starterkit`. Templates are written in Blade (via `beebmx/kirby-blade`), assets are built with Vite + Tailwind, and tests use Pest. Remote: https://github.com/Jonatanceja/sicsi (branch `main`).

## Commands

```sh
composer install            # PHP deps (also copies .env.example -> .env on first install)
npm install
npm run dev                 # Vite dev server (HMR; refreshes on site/templates/** changes)
npm run build               # production assets (aliases: prod, production)
composer test               # runs tests/helpers.php, then vendor/bin/pest
vendor/bin/pest tests/Feature/ExampleTest.php            # single file
vendor/bin/pest --filter "test name"                     # single test
vendor/bin/pint             # PHP formatting (pint.json)
npx prettier --write <file> # JS/Blade formatting (prettier-plugin-blade + tailwindcss)
```

Panel plugin (Vue 2 / kirbyup) in `site/plugins/app`: `npm run app-dev`, `npm run app` (build), `npm run app-setup`.

## Architecture

- **Config is split per concern.** `site/config/config.php` loads `.env` via `KirbyEnv`, sets the cookie key, then assembles the Kirby config array by `require`-ing sibling files (`app.php`, `api.php`, `auth.php`, `cache.php`, `hooks.php`, `routes.php`, `panel.php`, `blade.php`, `courier.php`, `tasks.php`, …). Add settings to the matching file, not to `config.php`. Plugin options are namespaced (`beebmx.courier`, `beebmx.kirby-blade`, `beebmx.scheduler.tasks`, …).
- **Environment** comes from `.env` (see `.env.example`): `KIRBY_ENV` (local/production, drives the custom Blade `@local`/`@production`/`@analytics` ifs in `site/config/blade.php`), `KIRBY_DEBUG`, `KIRBY_KEY`, cache/session, DB and mail settings. Use the `env()` helper.
- **Templates** live in `site/templates`. Blade templates (`*.blade.php`) share a layout in `site/templates/layout/index.blade.php`; the layout is also exposed as a Blade class component at `app/View/Components/Layout.php` (PSR-4 namespace `App\` → `app/`). Page sections are anonymous Blade components in `site/templates/components/` (`<x-site-header>`, `<x-home.hero :page="$page" />`; no `components.` prefix in the tag). `home.blade.php` only composes them.
- **Content** is flat-file in `content/` (`site.txt`, `home/`, `error/`); blueprints for the Panel are in `site/blueprints` (`site.yml`, `pages/*.yml`). Controllers go in `site/controllers`, snippets in `site/snippets`.
- **Plugins** in `site/plugins/` are installed by Composer (beebmx courier, email-plus, enum, env, scheduler, sign, blade) — treat them as vendor code. `site/plugins/app` is the project's own plugin (`index.php` registers extensions; `resources/` holds Panel Vue code built with kirbyup).
- **Front-end assets**: entries are `resources/css/app.css` and `resources/js/app.js` (alias `@` → `resources/js`; Alpine components in `resources/js/components`). Built output goes to `public/`.
- **Compiled Blade views** are cached in `storage/views` (configured in `blade.php`); clear it if template changes don't show up.
- **Tests**: `tests/Unit` and `tests/Feature` (Feature tests extend `Tests\TestCase`, bound in `tests/Pest.php`).

## Content model conventions

- **Everything editable lives in the blueprint.** Each home section has its own tab file in `site/blueprints/tabs/home/*.yml`, pulled into `pages/home.yml` via `tabs: name: tabs/home/name`. Header/footer content lives in `site/blueprints/site.yml` and is read with `site()->field()`. When adding copy to a template, add the field to the matching tab; repeated items use `structure` fields read with `->toStructure()`.
- **Pages:** `home` (tabs in `site/blueprints/tabs/home/`), `about` (slug `nosotros`, `tabs/about/`, `components/about/`) and `services` (slug `servicios`, `tabs/services/`, `components/services/`). The SEO/Open Graph tab is shared (`tabs/seo.yml`) and read by `components/seo.blade.php`, with the site SEO tab as fallback. Header nav URLs are stored as `/`, `/nosotros`, `/#servicios` so they work from any page (rendered through `url()`; the current page gets the active pill).
- **Icons are a field, not markup.** `app/View/icons.php` is the single icon registry (name => [Panel label, SVG path]); `<x-icon :name="..." class="..." />` renders it and `site/plugins/app/index.php` registers the `fields/icon` blueprint (select) from the same file. Use `extends: fields/icon` in blueprints. PHP blueprints cannot live in `site/blueprints` (only `.yml` is loaded there); register them as plugin `blueprints` extensions.
- **Alpine** is started in `resources/js/app.js`; components are in `resources/js/components/` (`siteHeader`, `quoteForm`, plus the `x-reveal` scroll-in directive). Tailwind v4 theme tokens (`ink-*`, `brand-*`, `font-display`) and `.btn`/`.card`/`.section` helpers are in `resources/css/app.css`.
- **Quote forms** (home and services) share the `quoteForm` Alpine component, which posts JSON to the `cotizar` route in `site/config/routes.php` (CSRF via the `csrf-token` meta tag). Required keys are `name`, `company`, `email`, `phone`; every other field goes in `extra` as `label => value` (configured per form through the component's `extras` option) and is appended to the email sent to `formRecipient` or `MAIL_FROM_ADDRESS`.
- Seeding pages via PHP: use `$page = $page->update(...)` before `changeStatus()`; Kirby validates blueprint rules (e.g. `maxlength`) when publishing.
- `@js` is not available in this Blade setup; use `{{ json_encode(...) }}` for passing data to Alpine.
- `@vite` emits `//build/...` (double slash) via Kirby's `Asset`; nginx/Herd tolerate it, PHP's built-in server does not.
