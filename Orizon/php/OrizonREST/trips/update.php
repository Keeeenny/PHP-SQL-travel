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

$trip->id = $data->id;
$trip->destination = $data->destination;
$trip->available_seats = $data->available_seats;

if($trip->update()){
    //OK
    http_response_code(200);
    echo json_encode(array("response" => "Trip updated"));
} else {
    //503 service unavailable
    http_response_code(503);
    echo json_encode(array("response" => "Unable to update the trip"));
}

?>