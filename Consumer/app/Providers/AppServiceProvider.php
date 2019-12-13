<?php

namespace App\Providers;

use App\GrantTypes\AuthorizationCode;
use App\GrantTypes\ClientCredentials;
use App\GrantTypes\GrantType;
use App\GrantTypes\Password;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

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
                case GrantType::GRANT_PASSWORD:
                    return new Password(
                        $httpClient,
                        config('oauth.token_url'),
                        config("oauth.{$configKey}")
                    );
                case GrantType::GRANT_CLIENT_CREDENTIALS:
                    return new ClientCredentials(
                        $httpClient,
                        config('oauth.token_url'),
                        config("oauth.{$configKey}")
                    );
                case GrantType::GRANT_AUTHORIZATION_CODE:
                    return new AuthorizationCode(
                        $httpClient,
                        config('oauth.token_url'),
                        config("oauth.{$configKey}")
                    );
                default:
                    $supportedGrants = implode(', ', [GrantType::GRANT_PASSWORD, GrantType::GRANT_CLIENT_CREDENTIALS, GrantType::GRANT_AUTHORIZATION_CODE]);
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
