<?php


$router->get('Orizon', 'PagesController@index');

$router->post('Orizon/countries', 'PagesController@storeCountries');
$router->post('Orizon/removeCountry', 'PagesController@removeCountry');
$router->post('Orizon/editCountry', 'PagesController@editCountry');

$router->post('Orizon/trips', 'PagesController@storeTrips');
$router->post('Orizon/removeTrip', 'PagesController@removeTrip');
$router->post('Orizon/editTrip', 'PagesController@editTrip');

$router->get('Orizon/country', 'AppController@readCountry');
$router->post('Orizon/country', 'AppController@storeCountry');
$router->delete('Orizon/country', 'AppController@deleteCountry');
$router->put('Orizon/country', 'AppController@updateCountry');

$router->get('Orizon/trip', 'AppController@readTrip');
$router->post('Orizon/trip', 'AppController@storeTrip');
$router->delete('Orizon/trip', 'AppController@deleteTrip');
$router->put('Orizon/trip', 'AppController@updateTrip');

$router->get('Orizon/filter', 'AppController@filterTrips');
