<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
include_once '../config/database.php';
include_once '../models/paese.php';

$database = new Database();
$db = $database->getConnection();

$paese = new Paese($db);

$data = json_decode(file_get_contents("php://input"));

$paese->id = $data->id;
$paese->nome_paese = $data->nome_paese;

if($paese->update()){
    //OK
    http_response_code(200);
    echo json_encode(array("risposta" => "Paese aggiornato"));
} else {
    //503 servizio non disponibile
    http_response_code(503);
    echo json_encode(array("risposta" => "Impossibile aggiornare il paese"));
}

?>