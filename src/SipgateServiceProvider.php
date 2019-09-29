<?php

namespace Simonkub\Laravel\Notifications\Sipgate;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class SipgateServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->app->when(SipgateChannel::class)
            ->needs('$smsId')
            ->give($this->app['config']['services.sipgate.smsId']);

        $this->app->bind(SipgateClient::class, function () {
            return new SipgateClient(
                new Client([
                    'base_uri' => 'https://api.sipgate.com/v2/',
                    'auth' => [
                        $this->app['config']['services.sipgate.username'],
                        $this->app['config']['services.sipgate.password'],
                    ],
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                    ],
                ])
            );
        });
    }
}
