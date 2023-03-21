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

if ($trip->delete()) {
    //OK
    http_response_code(200);
    echo json_encode(array("response" => "The trip has been deleted"));
} else {
    //503 service unavailable
    http_response_code(503);
    echo json_encode(array("response" => "Unable to delete the trip."));
}
