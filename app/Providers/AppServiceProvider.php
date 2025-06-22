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
     * Register any application services.
     */

    /*
   public function register(): void
   {

       $jsonPath = base_path('config/yvsou_config.php');

       if (file_exists($jsonPath)) {
           $json = file_get_contents($jsonPath);
           $configData = json_decode($json, true);

           if (json_last_error() === JSON_ERROR_NONE) {
               foreach ($configData as $key => $value) {
                   config()->set($key, $value);
                   // putenv("$key=$value");
                   // $_ENV[$key] = $_SERVER[$key] = $value;

               }
               config(['site' => $configData]);
           } else {
               logger()->error('Invalid JSON in customconfig.json: ' . json_last_error_msg());
           }
       }

   }
       */

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('admin', function ($user) {
            return $user->role === 'admin'; // or $user->is_admin, etc.
        });
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


        // app(LocaleService::class)->setLocaleFromCookie();
        ConstantService::$adminHasAllRights = config('yvsou_config.ADMINHASRIGHTS') ?? false;

        View::composer('*', function ($view) {
            $localeService = app(LocaleService::class);
            // $view->with('getlangSet', $localeService->getlangSet(config('yvsou_config.LANGUAGESET')));
            $view->with('getlangSet', $localeService->getlangSet(config('yvsou_config.LANGUAGESET')));

        });
        app(LocaleService::class)->setLocaleFromCookie();
        if (app()->runningInConsole() && basename($_SERVER['PHP_SELF']) === 'generate_migrations_from_models.php') {
            return; // prevent loading shortcodes
        }
        if (Schema::hasTable('shortcodes')) {

            $shortcodes = \App\Models\Shortcode::all();
            $shortcodeManager = new \App\Services\ShortcodeManager();
            $shortcodeManager->loadFromDatabase();

            app()->instance('shortcode', $shortcodeManager);


        }


    }
}

