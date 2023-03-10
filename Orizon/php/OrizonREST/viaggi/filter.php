<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type:application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../models/viaggio.php';
include_once '../models/paese.php';
 
$database = new Database();
$db = $database->getConnection();

$viaggio = new Viaggio($db);
$paese = new Paese($db);

$paese_table = $paese->getTableName();

$stmt = $viaggio->filter($paese_table);

$num = $stmt->rowCount();

if($num > 0) {

    $viaggi_arr = array();
    $viaggi_arr["viaggi"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $viaggi_item =array(
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
    echo json_encode( array("message" => "Nessun viaggio che corrisponda ai criteri trovato nel database.") );
}

?>