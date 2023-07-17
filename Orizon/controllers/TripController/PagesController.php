<?php

namespace App\Controllers\TripController;

use App\Controllers\CommonController\CommonController;
use App\Core\App;

class PagesController
{
    protected $database;
    protected $error_503;

    public function __construct()
    {
        $this->database = App::get('database');
        $this->error_503 = "<p class='error'>Service Unavailable.</p>";
    }


    public function storeTrips()
    {
        try {

            if (!$this->database->insertTrip('trips', [
                'destination' => $_POST['destination'],
                'available_seats' => $_POST['available_seats']
            ])) {
                redirect('Orizon');
                //503 Service Unavailable
                http_response_code(503);
                echo $this->error_503;
            }

            redirect('Orizon');
            // 201 Created
            http_response_code(201);
        } catch (\Exception $e) {
            redirect('Orizon');
            // 500 Internal Server Error
            http_response_code(500);
            echo json_encode(["message" => "Error: " . $e->getMessage()]);
        }
    }

    public function removeTrip()
    {
        try {
            if (!$this->database->delete('trips', [
                'id' => $_POST['id']
            ])) {
                redirect('Orizon');
                //503 Service Unavailable
                http_response_code(503);
                echo $this->error_503;
            }

            redirect('Orizon');
            // 200 Okay
            http_response_code(200);
        } catch (\Exception $e) {
            redirect('Orizon');
            // 500 Internal Server Error
            http_response_code(500);
            echo json_encode(["message" => "Error: " . $e->getMessage()]);
        }
    }

    public function editTrip()
    {
        try {
            if (!$this->database->editTrip('trips', [
                'id' => $_POST['trip_id'],
                'destination' => $_POST['new_destination'],
                'available_seats' => $_POST['available_seats']
            ])) {
                redirect('Orizon');
                //503 Service Unavailable
                http_response_code(503);
                echo $this->error_503;
            }

            redirect('Orizon');
            // 200 Okay
            http_response_code(200);
        } catch (\Exception $e) {
            redirect('Orizon');
            // 500 Internal Server Error
            http_response_code(500);
            echo json_encode(["message" => "Error: " . $e->getMessage()]);
        }
    }

    public function filterTrips()
    {
        $countryName = $_POST['destination'] ? $_POST['destination'] : null;
        $availableSeats = isset($_POST['available_seats']) && is_numeric($_POST['available_seats']) ? $_POST['available_seats'] : null;

        if (is_null($countryName) && is_null($availableSeats)) {
            redirect('Orizon');
            // 200 Okay
            http_response_code(200);
        }

        $available_trips = $this->database->filterTrips('trips', $countryName, $availableSeats);

        if (!$available_trips) {
            // 503 Service Unavailable
            http_response_code(503);
        }

        if (empty($available_trips)) {
            // 200 Okay
            http_response_code(200);
        }

        return CommonController::index($available_trips);
        // 200 Okay
        http_response_code(200);
    }
}
