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
 
$country->id = $data->id;
 
if($country->delete()){
    //OK
    http_response_code(200);
    echo json_encode(array("response" => "The country has been deleted."));
}else{
    //503 service unavailable
    http_response_code(503);
    echo json_encode(array("response" => "Unable to delete the country."));
}

?>