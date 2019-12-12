<?php

namespace App\GrantTypes;

class ClientCredentials extends GrantType
{

    /**
     * @inheritDoc
     */
    public function getToken(): string
    {
        $response = $this->httpClient->post($this->tokenUrl, [
            'form_params' => [
                'grant_type' => 'client_credentials',
                'client_id' => $this->config['client_id'],
                'client_secret' => $this->config['client_secret'],
                'scope' => '*',
            ],
        ]);

        return json_decode((string) $response->getBody())->access_token;
    }

}
