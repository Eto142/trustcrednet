<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mailer\Transport\Dsn;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransportFactory;
use Symfony\Component\Mailer\Transport\Smtp\Stream\SocketStream;

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

        // Laravel 11 does not forward stream SSL options from config/mail.php
        // to Symfony Mailer. We override the smtp driver to patch SSL options directly.
        Mail::extend('smtp', function (array $config): EsmtpTransport {
            $factory = new EsmtpTransportFactory();
            $scheme  = $config['scheme'] ?? (($config['port'] ?? 25) == 465 ? 'smtps' : 'smtp');

            $transport = $factory->create(new Dsn(
                $scheme,
                $config['host'] ?? '127.0.0.1',
                $config['username'] ?? null,
                $config['password'] ?? null,
                $config['port'] ?? null,
                $config
            ));

            $stream = $transport->getStream();
            if ($stream instanceof SocketStream) {
                $stream->setStreamOptions([
                    'ssl' => [
                        'verify_peer'      => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true,
                    ],
                ]);
            }

            return $transport;
        });
    }
}
