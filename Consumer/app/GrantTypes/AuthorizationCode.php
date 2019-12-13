<?php

namespace App\GrantTypes;

class AuthorizationCode extends GrantType
{

    /**
     * @inheritDoc
     */
    public function getToken(string $code = null): string
    {
        $response = $this->httpClient->post($this->tokenUrl, [
            'form_params' => [
                'grant_type' => 'authorization_code',
                'client_id' => $this->config['client_id'],
                'client_secret' => $this->config['client_secret'],
                'redirect_uri' => $this->config['redirect_uri'],
                'code' => $code,
            ],
        ]);

        return json_decode((string) $response->getBody())->access_token;
    }
    
}
