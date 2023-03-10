<?php

include_once '../config/database.php';
include_once '../models/viaggio.php';

//Creazione nuova istanza e connessione al db
$database = new Database();
$db = $database->getConnection();
//Creazione nuova istanza Paese
$viaggio = new Viaggio($db);

//Lettura dati paesi
$stmt = $viaggio->read();

$num = $stmt->rowCount();

if($num > 0) {

    $viaggi_arr = array();
    $viaggi_arr["viaggi"] = array();
    
    //Ciclo su ogni riga della query
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);
        

        $viaggi_item = array(
            "id" => $id,
            "destinazione" => $destinazione,
            "posti_disponibili" => $posti_disponibili
        );
        

        array_push($viaggi_arr["viaggi"], $viaggi_item);
    }
    
    http_response_code(200);
    echo json_encode($viaggi_arr);
} else {
  
    http_response_code(404);
    echo json_encode( array("message" => "Nessun viaggio trovato nel database.") );
}



?>