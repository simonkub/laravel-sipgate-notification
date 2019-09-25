<?php

namespace SimonKub\Laravel\Notifications\Sipgate;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use Illuminate\Notifications\ChannelManager;

class SipgateServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->app->afterResolving(ChannelManager::class, function (ChannelManager $channels) {
            $channels->extend('sipgate', function ($app) {
                return $app[SipgateChannel::class];
            });
        });

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

    /**
     * Register the application services.
     */
    public function register()
    {
        //
    }
}
