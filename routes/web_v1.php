<?php

use Illuminate\Support\Facades\Route;
use Elastic\Elasticsearch\ClientBuilder;

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

Route::get('/', function () {
    $client = ClientBuilder::create()->build();
    var_dump($client);
});
Route::get('/enter/{age}/{name}', function ($age, $name) {
    $client = ClientBuilder::create()
        ->build();    //connect with the client
    $params = array();
    $params['body'] = array(
        'name' => $name,                                            //preparing structred data
        'age' => $age
    );
    $params['index'] = 'BeyBlade';
    $params['type'] = 'BeyBlade_Owner';
    $result = $client->index($params);                            //using Index() function to inject the data
    var_dump($result);
});
Route::get('/config-cache', function () {
    \Illuminate\Support\Facades\Artisan::call('config:cache');
    \Illuminate\Support\Facades\Artisan::call('migrate');
    \Illuminate\Support\Facades\Artisan::call('db:seed');
});
