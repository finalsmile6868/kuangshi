<?php

use Illuminate\Routing\Router;

//Admin::routes();
$attrs = [
    'prefix' => config('kuangshi.route.prefix','ks'),
    'middleware' => config('kuangshi.route.middleware'),
];

app('router')->group($attrs, function ($router) {

    $router->resource('person',\Finalsmile6868\Kuangshi\Controllers\PersonController::class);
    $router->get('sync-person','\Finalsmile6868\Kuangshi\Controllers\PersonController@sync');
});


app('router')->group(['prefix'=>config('kuangshi.route.prefix','ks')], function ($router) {

    $router->get('notify','\Finalsmile6868\Kuangshi\Controllers\NotifyController@index');

});
