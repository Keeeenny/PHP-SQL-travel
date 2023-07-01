<?php


// $router->get('Orizon', 'PagesController@index');

// $router->post('Orizon/country', 'PagesController@storeCountries');
// $router->post('Orizon/removeCountry', 'PagesController@removeCountry');
// $router->post('Orizon/editCountry', 'PagesController@editCountry');

// $router->post('Orizon/trip', 'PagesController@storeTrips');
// $router->post('Orizon/removeTrip', 'PagesController@removeTrip');
// $router->post('Orizon/editTrip', 'PagesController@editTrip');

// $router->get('Orizon/countries', 'AppController@readCountry');
// $router->post('Orizon/countries', 'AppController@storeCountry');
// $router->delete('Orizon/countries', 'AppController@deleteCountry');
// $router->put('Orizon/countries', 'AppController@updateCountry');

// $router->get('Orizon/trips', 'AppController@readTrip');
// $router->post('Orizon/trips', 'AppController@storeTrip');
// $router->delete('Orizon/trips', 'AppController@deleteTrip');
// $router->put('Orizon/trips', 'AppController@updateTrip');

// $router->get('Orizon/trips_filtered', 'AppController@filterTrips');


$router->get('Orizon', 'CommonController\CommonController@index');

//Pages
$router->post('Orizon/country', 'CountryController\PagesController@storeCountries');
$router->post('Orizon/removeCountry', 'CountryController\PagesController@removeCountry');
$router->post('Orizon/editCountry', 'CountryController\PagesController@editCountry');

$router->post('Orizon/trip', 'TripController\PagesController@storeTrips');
$router->post('Orizon/removeTrip', 'TripController\PagesController@removeTrip');
$router->post('Orizon/editTrip', 'TripController\PagesController@editTrip');
$router->post('Orizon/filter', 'TripController\PagesController@filterTrips');

//App
$router->get('Orizon/countries', 'CountryController\AppController@readCountry');
$router->post('Orizon/countries', 'CountryController\AppController@storeCountry');
$router->delete('Orizon/countries', 'CountryController\AppController@deleteCountry');
$router->put('Orizon/countries', 'CountryController\AppController@updateCountry');

$router->get('Orizon/trips', 'TripController\AppController@readTrip');
$router->post('Orizon/trips', 'TripController\AppController@storeTrip');
$router->delete('Orizon/trips', 'TripController\AppController@deleteTrip');
$router->put('Orizon/trips', 'TripController\AppController@updateTrip');

$router->get('Orizon/filtered_trips', 'TripController\AppController@filterTrips');
