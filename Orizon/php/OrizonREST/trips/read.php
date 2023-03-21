<?php

include_once '../config/database.php';
include_once '../models/trip.php';

$database = new Database();
$db = $database->getConnection();
$trip = new Trip($db);


$stmt = $trip->read();

$num = $stmt->rowCount();

if($num > 0) {

    $trips_arr = array();
    $trips_arr["trip"] = array();
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);
        

        $trips_item = array(
            "id" => $id,
            "destination" => $destination,
            "avable_seats" => $available_seats
        );
        

        array_push($trips_arr["trip"], $trips_item);
    }
    
    http_response_code(200);
    echo json_encode($trips_arr);
} else {
  
    http_response_code(404);
    echo json_encode( array("message" => "No trips found in the database.") );
}



?>