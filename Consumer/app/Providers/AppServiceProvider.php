<?php

namespace App\Providers;

use App\GrantTypes\ClientCredentials;
use App\GrantTypes\GrantType;
use App\GrantTypes\Password;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    const GRANT_PASSWORD = 'password';
    const GRANT_CLIENT_CREDENTIALS = 'client_credentials';

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(GrantType::class, function($app, $parameters) {
            $httpClient = resolve(Client::class);
            $grant = $parameters[0];
            $configKey = "grant_{$grant}";
            switch ($grant) {
                case static::GRANT_PASSWORD:
                    return new Password(
                        $httpClient,
                        config('oauth.token_url'),
                        config("oauth.{$configKey}")
                    );
                case static::GRANT_CLIENT_CREDENTIALS:
                    return new ClientCredentials(
                        $httpClient,
                        config('oauth.token_url'),
                        config("oauth.{$configKey}")
                    );
                default:
                    $supportedGrants = implode(', ', [static::GRANT_PASSWORD, static::GRANT_CLIENT_CREDENTIALS]);
                    throw new Exception("The informed grant {$grant} is not supported. The supported types are: {$supportedGrants}");

            }
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
