<?php

class AppController

{
    protected $database;

    public function __construct()
    {
        $this->database = App::get('database');
    }

    public function readCountry()
    {
        $countryList = $this->database->selectAll('countries');

        if (!empty($countryList)) {
            // 200 Okay
            http_response_code(200);
            echo json_encode($countryList);
        } else if (empty($countryList)) {
            // 204 No Content
            http_response_code(204);
            echo json_encode(["message" => "The list is empty or unable to read."]);
        }
    }

    public function storeCountry()
    {
        $data = json_decode(file_get_contents("php://input"));

        if (empty($data->country_name)) {
            // 400 Bad request
            http_response_code(400);
            echo json_encode(["message" => "Unable to add the country the data are incomplete."]);
        } else if ($this->database->nameExists('countries', 'country_name', $data->country_name)) {
            // 409 Conflict
            http_response_code(409);
            echo json_encode(["message" => "Country alredy exists."]);
        } else if ($this->database->insertCountry('countries', [
            'country_name' => $data->country_name
        ])) {
            // 201 Created
            http_response_code(201);
            echo json_encode(["message" => "Country successfully added."]);
        } else {
            //503 Service Unavailable
            http_response_code(503);
            echo json_encode(["message" => "Unable to add the country."]);
        }
    }

    public function deleteCountry($id)
    {

        if (empty($id)) {
            // 400 Bad request
            $message = "Unable to delete the country, the data are incomplete.";
            http_response_code(400);
        } else if (!is_numeric($id)) {
            // 400 Bad request
            $message = "Unable to delete the country, id is not a number.";
            http_response_code(400);
        } else if (!$this->database->doExists('countries', 'id', $id)) {
            // 404 Not found
            $message = "Country not found or unable to delete.";
            http_response_code(404);
        } else if ($this->database->delete('countries', [
            'id' => $id
        ])) {
            // 200 Okay
            $message = "The country has been deleted.";
            http_response_code(200);
        } else {
            //503 Service Unavailable
            $message = "Unable to delete the country";
            http_response_code(503);
        }

        echo json_encode(["message" => $message]);
    }

    public function updateCountry()
    {
        $data = json_decode(file_get_contents("php://input"));

        if (!$this->database->doExists('countries', 'id', $data->id)) {
            echo json_encode(["message" => "Country not found or unable to update."]);
            http_response_code(404);
        } else if ($this->database->nameExists('countries', 'country_name', $data->country_name)) {
            // 409 Conflict
            http_response_code(409);
            echo json_encode(["message" => "Country alredy exists."]);
        } else if (empty($data->id) || empty($data->country_name)) {
            // 400 Bad request
            http_response_code(400);
            echo json_encode(["message" => "Unable to update the country data are incomplete. "]);
        } else if ($this->database->editCountry('countries', [
            'id' => $data->id,
            'country_name' => $data->country_name
        ])) {
            // 200 Okay
            http_response_code(200);
            echo json_encode(["message" => "Country successfully updated."]);
        } else {
            //503 Service Unavailable
            http_response_code(503);
            echo json_encode(["message" => "Unable to update the country."]);
        }
    }

    public function readTrip()
    {
        $countryList = $this->database->selectAll('trips');

        if (!empty($countryList)) {
            // 200 Okay
            http_response_code(200);
            echo json_encode($countryList);
        } else {
            // 204 No Content
            http_response_code(204);
        }
    }


    public function storeTrip()
    {
        $data = json_decode(file_get_contents("php://input"));

        if (!empty($data->destination) && !empty($data->available_seats)) {
            if ($this->database->insertTrip('trips', [
                'destination' => $data->destination,
                'available_seats' => $data->available_seats
            ])) {
                // 201 Created
                http_response_code(201);
                echo json_encode(["message" => "Trip successfully added."]);
            } else {
                //503 Service Unavailable
                http_response_code(503);
                echo json_encode(["message" => "Unable to add the trip."]);
            }
        } else {
            // 400 Bad request
            http_response_code(400);
            echo json_encode(["message" => "Unable to add the trip data are incomplete."]);
        }
    }

    public function deleteTrip($id)
    {

        if (empty($id)) {
            $message = "Unable to delete the trip, the data are incomplete.";
            http_response_code(400);
        } else if (!is_numeric($id)) {
            $message = "Unable to delete the trip, id is not a number.";
            http_response_code(400);
        } else if (!$this->database->doExists('trips', 'id', $id)) {
            // 404 Not found
            $message = "Country not found or unable to delete.";
            http_response_code(404);
        } else if ($this->database->delete('trips', [
            'id' => $id
        ])) {
            // 200 Okay
            $message = "The trip has been deleted.";
            http_response_code(200);
        } else {
            //503 Service Unavailable
            $message = "Unable to delete the trip";
            http_response_code(503);
        }

        echo json_encode(["message" => $message]);
    }

    public function updateTrip()
    {
        $data = json_decode(file_get_contents("php://input"));

        if (!$this->database->doExists('trips', 'id', $data->id)) {
            echo json_encode(["message" => "trip not found or unable to update."]);
            http_response_code(404);
        } else if (!empty($data->id) && !empty($data->destination) && isset($data->available_seats) && is_numeric($data->available_seats)) {
            if ($this->database->editTrip('trips', [
                'id' => $data->id,
                'destination' => $data->destination,
                'available_seats' => $data->available_seats
            ])) {
                // 200 Okay
                http_response_code(200);
                echo json_encode(["message" => "Trip successfully updated."]);
            } else {
                //503 Service Unavailable
                http_response_code(503);
                echo json_encode(["message" => "Unable to update the trip."]);
            }
        } else {
            // 400 Bad request
            http_response_code(400);
            echo json_encode(["message" => "Unable to update the trip data are incomplete. "]);
        }
    }

    public function filterTrips()
    {
        $available_trips = App::get('database')->filterTrips('countries', 'trips', 'Available_Trips');

        if ($available_trips) {
            // 200 Okay
            http_response_code(200);
        } else {
            // 404 Not found
            http_response_code(404);
            echo json_encode(array("message" => "No trips found in the database that match the criteria."));
        }

        echo json_encode($available_trips);
    }
}
