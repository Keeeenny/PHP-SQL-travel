<?php

namespace App\Controllers\TripController;

use App\Core\App;

class AppController
{
    protected $database;

    public function __construct()
    {
        $this->database = App::get('database');
    }

    public function readTrip()
    {
        $countryList = $this->database->selectAll('trips');

        if (empty($countryList)) {
            // 200 Okay
            echo json_encode(["message" => "The list is empty."]);
            return http_response_code(200);
        }

        // 200 Okay
        http_response_code(200);
        echo json_encode($countryList);
    }


    public function storeTrip()
    {
        $data = json_decode(file_get_contents("php://input"));

        if (empty($data->destination) || empty($data->available_seats)) {
            // 400 Bad request
            echo json_encode(["message" => "Unable to add the trip data are incomplete."]);
            return http_response_code(400);
        }

        if (!is_numeric($data->available_seats)) {
            // 400 Bad request
            echo json_encode(["message" => "Unable to add the trip, available seats is not a number."]);
            return http_response_code(400);
        }

        if (!$this->database->insertTrip('trips', [
            'destination' => $data->destination,
            'available_seats' => $data->available_seats
        ])) {
            //503 Service Unavailable
            echo json_encode(["message" => "Unable to add the trip."]);
            return http_response_code(503);
        }

        // 201 Created
        http_response_code(201);
        echo json_encode(["message" => "Trip successfully added."]);
    }

    public function deleteTrip($id)
    {
        if (empty($id)) {
            // 400 Bad request
            echo json_encode(["message" => "Unable to delete the trip, the data are incomplete."]);
            return http_response_code(400);
        }

        if (!is_numeric($id)) {
            // 400 Bad request
            echo json_encode(["message" => "Unable to delete the trip, id is not a number."]);
            return http_response_code(400);
        }

        if (!$this->database->doExists('trips', 'id', $id)) {
            // 404 Not found
            echo json_encode(["message" => "Country not found or unable to delete."]);
            return http_response_code(404);
        }

        if (!$this->database->delete('trips', [
            'id' => $id
        ])) {
            //503 Service Unavailable
            $message = "Unable to delete the trip";
            return http_response_code(503);
        }

        // 200 Okay
        $message = "The trip has been deleted.";
        http_response_code(200);

        echo json_encode(["message" => $message]);
    }



    public function updateTrip()
    {
        $data = json_decode(file_get_contents("php://input"));

        if (!$this->database->doExists('trips', 'id', $data->id)) {
            echo json_encode(["message" => "trip not found or unable to update."]);
            return http_response_code(404);
        }

        if (empty($data->id) || empty($data->destination) && !isset($data->available_seats) && !is_numeric($data->available_seats)) {

            // 400 Bad request
            echo json_encode(["message" => "Unable to update the trip data are incomplete. "]);
            return http_response_code(400);
        }

        if (!$this->database->editTrip('trips', [

            'id' => $data->id,
            'destination' => $data->destination,
            'available_seats' => $data->available_seats
        ])) {

            //503 Service Unavailable
            echo json_encode(["message" => "Unable to update the trip."]);
            return http_response_code(503);
        }

        // 200 Okay
        http_response_code(200);
        echo json_encode(["message" => "Trip successfully updated."]);
    }

    public function filterTrips()
    {

        $countryName = isset($_GET['filters']['country_name']) ? str_replace("'", '', $_GET['filters']['country_name']) : null;
        $availableSeats = isset($_GET['filters']['available_seats']) ? $_GET['filters']['available_seats'] : null;

        $available_trips = $this->database->filterTrips('trips', $countryName, $availableSeats);

        if (!$available_trips) {
            // 503 Service Unavailable
            echo json_encode(["message" => "Something went wrong."]);
            return http_response_code(503);
        }

        if (empty($available_trips)) {
            // 200 Okay
            echo json_encode(["message" => "The list is empty."]);
            return http_response_code(200);
        }

        // 200 Okay
        http_response_code(200);
        echo json_encode($available_trips);
    }
}
