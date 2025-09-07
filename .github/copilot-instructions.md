# Copilot Instructions for Worksuite Codebase

## Architecture & Structure
- **Framework**: Laravel (PHP) with Blade templates for views, heavy use of controllers/resources/routes.
- **Main App Code**: Located in `app/` (Controllers, Models, Services, etc.), `resources/views/` (Blade templates), and `routes/web.php` (route definitions).
- **Modules**: Feature modules are in `Modules/` (e.g., Affiliate, Payroll, Recruit, etc.), each with its own substructure.
- **Assets**: CSS/JS and vendor files are in `public/assets/` and `public/vendor/`.
- **Configuration**: App and package configs in `config/`.
- **Database**: Migrations, factories, and seeders in `database/`.

## Key Patterns & Conventions
- **Routes**: All main routes are defined in `routes/web.php`, grouped by middleware and feature. Use resource controllers for CRUD.
- **Controllers**: Use Laravel resource controllers for RESTful endpoints. Custom actions are added as explicit routes.
- **Blade Views**: Use `@extends`, `@section`, `@include`, and `@stack` for layout composition. Asset URLs use `{{ asset('...') }}`.
- **Localization**: Use `@lang()` and `__()` for all user-facing strings. Translation files are in `resources/lang/`.
- **Assets**: Always reference CSS/JS via `asset()` helper. Example: `<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">`.
- **Plugins**: Many JS/CSS plugins are included (see README). Initialize them in Blade or via custom JS in `public/js/`.
- **Custom CSS/JS**: Place overrides in `public/css/app-custom.css` and `public/js/main.js`.

## Developer Workflows
- **Build**: Use Laravel Mix (`webpack.mix.js`). Run `npm install && npm run dev` for asset compilation.
- **Database**: Use `php artisan migrate` for migrations. Seeders in `database/seeders/`.
- **Testing**: PHPUnit config in `phpunit.xml`. Run tests with `php artisan test` or `vendor/bin/phpunit`.
- **Serve**: Use `php artisan serve` or Docker (see `Dockerfile`).
- **Debug**: Use Laravel Debugbar (enabled via `config/debugbar.php`).

## Integration & External Dependencies
- **3rd Party Plugins**: See `README.md` for a list of JS/CSS plugins used throughout the app.
- **Notifications**: Uses Pusher, OneSignal, and other services (see `config/` and relevant controllers).
- **Custom Modules**: Integrate new features as Laravel modules in `Modules/`.

## Examples
- **Route Example**: `Route::resource('clients', ClientController::class);`
- **Blade Asset Example**: `<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">`
- **Localization Example**: `@lang('app.save')`

## References
- Main entry: `routes/web.php`, `app/Http/Controllers/`, `resources/views/layouts/app.blade.php`
- For new features, follow the modular structure and use Laravel conventions.

---

If you are unsure about a workflow or pattern, check for similar implementations in the `app/`, `Modules/`, or `resources/views/` directories, or review the `README.md` for plugin usage.
