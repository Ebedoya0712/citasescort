<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useTailwind();
        \App\Models\Publication::observe(\App\Observers\PublicationObserver::class);
        \App\Models\Escort::observe(\App\Observers\EscortObserver::class);
        \App\Models\Story::observe(\App\Observers\StoryObserver::class);

        // Load DB settings into config dynamically
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('settings')) {
                foreach (\App\Models\Setting::all() as $setting) {
                    config(['settings.' . $setting->key => $setting->value]);
                }

                // Dynamically configure PayPal using database settings
                $mode = config('paypal.mode', 'sandbox');
                if (config('settings.paypal_client_id')) {
                    config(["paypal.{$mode}.client_id" => config('settings.paypal_client_id')]);
                }
                if (config('settings.paypal_secret')) {
                    config(["paypal.{$mode}.client_secret" => config('settings.paypal_secret')]);
                }
            }
        } catch (\Exception $e) {
            // Prevent failure during migrations or if DB is not connected
        }
    }
}
