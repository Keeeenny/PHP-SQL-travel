<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../models/trip.php';


$database = new Database();
$db = $database->getConnection();

$trip = new Trip($db);

$data = json_decode(file_get_contents("php://input"));


if(!empty($data->destination) && !empty($data->available_seats)){

    $trip->destination = $data->destination;
    $trip->available_seats = $data->available_seats;

    if($trip->create()){
        //CREATED
        http_response_code(201);
        echo json_encode(array("message" => "Trip correctly added."));
    }
    else{
        // Errore 503 service unavailable
        http_response_code(503);
        echo json_encode(array("message" => "Unable to add the trip."));
    }
}
else{
    // Errore 400 bad request
    http_response_code(400);
    echo json_encode(array("message" => "Unable to add the trip the data are incomplete."));
}
?>