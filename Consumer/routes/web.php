<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\GrantTypes\GrantType;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $query = http_build_query([
        'client_id' => config('oauth.grant_authorization_code.client_id'),
        'redirect_uri' => config('oauth.grant_authorization_code.redirect_uri'),
        'response_type' => 'code',
        'scope' => ''
    ]);
    $authorizeUrl = config('oauth.authorize_url');

    return redirect("{$authorizeUrl}?{$query}");
});

Route::get('/callback', function (Request $request) {
    $grantType = GrantType::GRANT_AUTHORIZATION_CODE;
    $grant = resolve(GrantType::class, [$grantType]);
    session()->put('token', $grant->getToken($request->code));

    return redirect('/tasks');
});

Route::get('/tasks', function () {
    $response = (new Client)->get(config('oauth.grant_authorization_code.api_url'), [
        'headers' => [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.session()->get('token')
        ]
    ]);

    return json_decode((string) $response->getBody(), true);
});