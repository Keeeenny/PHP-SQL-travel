<?php


$router->get('Orizon', 'PagesController@index');

$router->post('Orizon/country', 'PagesController@storeCountries');
$router->post('Orizon/removeCountry', 'PagesController@removeCountry');
$router->post('Orizon/editCountry', 'PagesController@editCountry');

$router->post('Orizon/trip', 'PagesController@storeTrips');
$router->post('Orizon/removeTrip', 'PagesController@removeTrip');
$router->post('Orizon/editTrip', 'PagesController@editTrip');

$router->get('Orizon/countries', 'AppController@readCountry');
$router->post('Orizon/countries', 'AppController@storeCountry');
$router->delete('Orizon/countries', 'AppController@deleteCountry');
$router->put('Orizon/countries', 'AppController@updateCountry');

$router->get('Orizon/trips', 'AppController@readTrip');
$router->post('Orizon/trips', 'AppController@storeTrip');
$router->delete('Orizon/trips', 'AppController@deleteTrip');
$router->put('Orizon/trips', 'AppController@updateTrip');

$router->get('Orizon/trips/filter', 'AppController@filterTrips');
