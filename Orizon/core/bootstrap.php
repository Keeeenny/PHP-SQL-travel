<?php

use App\Core\App;

App::bind('config', require 'config.php');

$commonQuery = new CommonQueryBuilder(
    Connection::make(App::get('config')['database'])
);

$countryQuery = new CountryQueryBuilder(
    Connection::make(App::get('config')['database'])
);

$TripQuery = new TripQueryBuilder(
    Connection::make(App::get('config')['database'])
);

App::bind('database', [
    'common' => $commonQuery,
    'country' => $countryQuery,
    'trip' => $TripQuery
]);



function view($name, $data = [])
{
    extract($data);
    return require "views/{$name}.view.php";
}

function redirect($path)
{
    header("Location: /{$path}");
    exit();
}
