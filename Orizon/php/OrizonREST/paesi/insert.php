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

$Paese = new Paese($db);

$data = json_decode(file_get_contents("php://input"));


if(!empty($data->nome_paese) ){

    $Paese->nome_paese = $data->nome_paese;

    if($Paese->create()){
        //CREATED
        http_response_code(201);
        echo json_encode(array("message" => "Paese aggiunto correttamente."));
    }
    else{
        // Errore 503 servizio non disponibile
        http_response_code(503);
        echo json_encode(array("message" => "Impossibile aggiungere il paese."));
    }
}
else{
    // Errore 400 cattiva richiesta
    http_response_code(400);
    echo json_encode(array("message" => "Impossibile creare il paese i dati sono incompleti."));
}
?>