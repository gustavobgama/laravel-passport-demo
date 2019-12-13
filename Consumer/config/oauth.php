<?php

return [
    'token_url' => 'http://api:8000/oauth/token',
    'authorize_url' => 'http://localhost:8000/oauth/authorize',
    'grant_password' => [
        'api_url' => 'http://api:8000/api/tasks-password-protected',
        'client_id' => env('OAUTH_GRANT_PASSWORD_CLIENT_ID'),
        'client_secret' => env('OAUTH_GRANT_PASSWORD_CLIENT_SECRET'),
        'username' => env('OAUTH_GRANT_PASSWORD_CLIENT_USERNAME'),
        'password' => env('OAUTH_GRANT_PASSWORD_CLIENT_PASSWORD'),
    ],
    'grant_client_credentials' => [
        'api_url' => 'http://api:8000/api/tasks-client-protected',
        'client_id' => env('OAUTH_GRANT_CLIENT_CREDENTIALS_CLIENT_ID'),
        'client_secret' => env('OAUTH_GRANT_CLIENT_CREDENTIALS_CLIENT_SECRET'),
    ],
    'grant_authorization_code' => [
        'api_url' => 'http://api:8000/api/tasks-password-protected',
        'client_id' => env('OAUTH_GRANT_AUTHORIZATION_CODE_CLIENT_ID'),
        'client_secret' => env('OAUTH_GRANT_AUTHORIZATION_CODE_CLIENT_SECRET'),
        'redirect_uri' => env('OAUTH_GRANT_AUTHORIZATION_CODE_REDIRECT_URI'),
    ],
];
