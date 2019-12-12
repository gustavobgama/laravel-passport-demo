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

use Illuminate\Http\Request;

Route::get('/', function () {
    $query = http_build_query([
        'client_id' => 4,
        'redirect_uri' => 'http://localhost:8001/callback',
        'response_type' => 'code',
        'scope' => ''
    ]);

    return redirect("http://localhost:8000/oauth/authorize?{$query}");
});

Route::get('/callback', function (Request $request) {
    $response = (new GuzzleHttp\Client)->post('http://localhost:8000/oauth/token', [
        'form_params' => [
            'grant_type' => 'authorization_code',
            'client_id' => 4,
            'client_secret' => 'm7X7tHreA5kEBg8XoqGFRpEC8xdbbpojQllwHgEd',
            'redirect_uri' => 'http://localhost:8001/callback',
            'code' => $request->code,
        ]
    ]);
    
    session()->put('token', json_decode((string) $response->getBody(), true));

    return redirect('/tasks');
});

Route::get('/tasks', function () {
    $response = (new GuzzleHttp\Client)->get('http://localhost:8000/api/tasks', [
        'headers' => [
            'Authorization' => 'Bearer '.session()->get('token.access_token')
        ]
    ]);

    return json_decode((string) $response->getBody(), true);
});