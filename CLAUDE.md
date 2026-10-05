# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Overview

A Kirby CMS 5 site (PHP ^8.3) built from the `beebmx/kirby-starterkit`. Templates are written in Blade (via `beebmx/kirby-blade`), assets are built with Vite + Tailwind, and tests use Pest. The upstream repo is https://github.com/Jonatanceja/sicsi, but this local directory is not currently a git checkout (no `.git`).

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
- **Templates** live in `site/templates`. Blade templates (`*.blade.php`) share a layout in `site/templates/layout/index.blade.php`; the layout is also exposed as a Blade class component at `app/View/Components/Layout.php` (PSR-4 namespace `App\` → `app/`). A plain-PHP template (`home.php`) coexists with `home.blade.php`; check which one Kirby resolves when editing the home page.
- **Content** is flat-file in `content/` (`site.txt`, `home/`, `error/`); blueprints for the Panel are in `site/blueprints` (`site.yml`, `pages/*.yml`). Controllers go in `site/controllers`, snippets in `site/snippets`.
- **Plugins** in `site/plugins/` are installed by Composer (beebmx courier, email-plus, enum, env, scheduler, sign, blade) — treat them as vendor code. `site/plugins/app` is the project's own plugin (`index.php` registers extensions; `resources/` holds Panel Vue code built with kirbyup).
- **Front-end assets**: entries are `resources/css/app.css` and `resources/js/app.js` (alias `@` → `resources/js`; Alpine and Vue example components in `resources/js/components`). Built output goes to `public/`.
- **Compiled Blade views** are cached in `storage/views` (configured in `blade.php`); clear it if template changes don't show up.
- **Tests**: `tests/Unit` and `tests/Feature` (Feature tests extend `Tests\TestCase`, bound in `tests/Pest.php`).
