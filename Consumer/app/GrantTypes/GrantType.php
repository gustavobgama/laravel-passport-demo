<?php

namespace App\GrantTypes;

use GuzzleHttp\Client;

abstract class GrantType
{

    const GRANT_PASSWORD = 'password';
    const GRANT_CLIENT_CREDENTIALS = 'client_credentials';
    const GRANT_AUTHORIZATION_CODE = 'authorization_code';

    /**
     * @var Client
     */
    protected $httpClient;

    /**
     * @var string
     */
    protected $tokenUrl;

    /**
     * @var array
     */
    protected $config;

    /**
     * Constructor.
     *
     * @param Client $httpClient
     * @param string $tokenUrl
     * @param array $config
     */
    public function __construct(Client $httpClient, string $tokenUrl, array $config)
    {
        $this->httpClient = $httpClient;
        $this->tokenUrl = $tokenUrl;
        $this->config = $config;
    }

    /**
     * Get authentication token.
     *
     * @return string
     */
    abstract public function getToken(string $code = null): string;

}