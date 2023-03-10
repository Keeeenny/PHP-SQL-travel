<?php

include_once '../config/database.php';
include_once '../models/paese.php';

//Creazione nuova istanza e connessione al db
$database = new Database();
$db = $database->getConnection();
//Creazione nuova istanza Paese
$paese = new Paese($db);

//Lettura dati paesi
$stmt = $paese->read();

$num = $stmt->rowCount();

if($num > 0) {

    $paesi_arr = array();
    $paesi_arr["paesi"] = array();
    

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);
        

        $paese_item = array(
            "id" => $id,
            "nome_paese" => $nome_paese
        );
        

        array_push($paesi_arr["paesi"], $paese_item);
    }
    

    http_response_code(200);

    echo json_encode($paesi_arr);
} else {
  
    http_response_code(404);
    echo json_encode( array("message" => "Nessun paese trovato nel database.") );
}



?>