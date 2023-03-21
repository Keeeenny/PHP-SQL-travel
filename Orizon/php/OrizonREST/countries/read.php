<?php

include_once '../config/database.php';
include_once '../models/country.php';


$database = new Database();
$db = $database->getConnection();
$country = new Country($db);
$stmt = $country->read();

$num = $stmt->rowCount();

if($num > 0) {

    $country_arr = array();
    $country_arr["country"] = array();
    

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);
        

        $country_item = array(
            "id" => $id,
            "country_name" => $country_name
        );
        

        array_push($country_arr["country"], $country_item);
    }
    

    http_response_code(200);

    echo json_encode($country_arr);
} else {
  
    http_response_code(404);
    echo json_encode( array("message" => "No country found.") );
}



?>