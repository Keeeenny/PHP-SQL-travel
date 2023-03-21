<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../models/country.php';


$database = new Database();
$db = $database->getConnection();

$country = new Country($db);

$data = json_decode(file_get_contents("php://input"));


if (!empty($data->country_name)) {

    $country->country_name = $data->country_name;

    if ($country->create()) {
        //CREATED
        http_response_code(201);
        echo json_encode(array("message" => "Country successfully added."));
    } else {
        // Errore 503 service unavailable
        http_response_code(503);
        echo json_encode(array("message" => "Unable to add the country."));
    }
} else {
    // Errore 400 Bad request
    http_response_code(400);
    echo json_encode(array("message" => "Unable to add the country the data is incomplete."));
}
