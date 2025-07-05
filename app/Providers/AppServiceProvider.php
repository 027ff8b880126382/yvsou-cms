<?php

namespace App\Providers;
use App\Http\Middleware;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use App\Services\ConstantService;
use App\Services\LocaleService;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\Facades\Config;

use Illuminate\Support\Facades\View;
use App\Models\MailSetting;
use Illuminate\Support\Facades\Gate;


class AppServiceProvider extends ServiceProvider
{
    
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('admin', function ($user) {
            return $user->role === 'admin'; // or $user->is_admin, etc.
        });


        try {
            if (Schema::hasTable('mail_settings')) {
                $settings = MailSetting::getSettings();

                config([
                    'mail.mailers.smtp.host' => $settings['host'] ?? null,
                    'mail.mailers.smtp.port' => $settings['port'] ?? null,
                    'mail.mailers.smtp.encryption' => $settings['encryption'] ?? null,
                    'mail.mailers.smtp.username' => $settings['username'] ?? null,
                    'mail.mailers.smtp.password' => $settings['password'] ?? null,
                    'mail.from.address' => $settings['from_address'] ?? null,
                    'mail.from.name' => $settings['from_name'] ?? null,
                ]);
            } else {
                // Optional: log or use default mail config
                logger('mail_settings table does not exist.');
            }
        } catch (\Throwable $e) {
            logger()->error('Error loading mail settings: ' . $e->getMessage());
            // Optional: fallback config
        }


        if (app()->runningInConsole() && basename($_SERVER['PHP_SELF']) === 'generate_migrations_from_models.php') {
            return; // prevent loading shortcodes
        }
        // app(LocaleService::class)->setbootLocaleFromCookie();
        ConstantService::$adminHasAllRights = config('yvsou_config.ADMINHASRIGHTS') ?? false;
        View::composer('*', function ($view) {
            $localeService = app(LocaleService::class);
            // $view->with('getlangSet', $localeService->getlangSet(config('yvsou_config.LANGUAGESET')));
            $view->with('getlangSet', $localeService->getlangSet(config('yvsou_config.LANGUAGESET')));
        });
        try {
            if (Schema::hasTable('shortcodes')) {
                $shortcodes = \App\Models\Shortcode::all();
                $shortcodeManager = new \App\Services\ShortcodeManager();
                $shortcodeManager->loadFromDatabase();
                app()->instance('shortcode', $shortcodeManager);
            } else {
                // Optional: log or use default mail config
                logger('shortcodes table does not exist.');
            }
        } catch (\Throwable $e) {
            logger()->error('Error shortcodes: ' . $e->getMessage());
            // Optional: fallback config
        }

    }
}

