<?php

namespace App\Providers;

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
        // Fix Guzzle SSL on Windows — point cURL to the local CA bundle
        $caBundle = 'C:\php-8.2\cacert.pem';
        putenv("CURL_CA_BUNDLE={$caBundle}");
        putenv("SSL_CERT_FILE={$caBundle}");
    }
}
