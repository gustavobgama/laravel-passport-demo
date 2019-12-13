<?php

namespace App\GrantTypes;

class Password extends GrantType
{

    /**
     * @inheritDoc
     */
    public function getToken(string $code = null): string
    {
        $response = $this->httpClient->post($this->tokenUrl, [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => $this->config['client_id'],
                'client_secret' => $this->config['client_secret'],
                'username' => $this->config['username'],
                'password' => $this->config['password'],
                'scope' => '*',
            ],
        ]);

        return json_decode((string) $response->getBody())->access_token;
    }
    
}
