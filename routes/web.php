<?php
$router->get('/login', 'AuthController@login');
$router->post('/login', 'AuthController@authenticate');
$router->get('/logout', 'AuthController@logout');

$router->get('/', 'DashboardController@index');
$router->get('/dashboard', 'DashboardController@index');

$router->get('/products', 'ProductController@index');
$router->get('/products/create', 'ProductController@create');
$router->post('/products/store', 'ProductController@store');
$router->get('/products/edit', 'ProductController@edit');
$router->post('/products/update', 'ProductController@update');
$router->post('/products/delete', 'ProductController@delete');
$router->get('/products/search', 'ProductController@searchAjax');

$router->get('/pos', 'PosController@index');
$router->post('/pos/checkout', 'PosController@checkout');
$router->get('/pos/invoice', 'PosController@invoice');
