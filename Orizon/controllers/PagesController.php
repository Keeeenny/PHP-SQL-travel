<?php

class PagesController

{

    protected $database;

    public function __construct()
    {
        $this->database = App::get('database');
    }

    public function index()
    {
        try {
            $countries = $this->database->selectAll('countries');
            $trips = $this->database->selectAll('trips');
            $available_trips = $this->database->filterTrips('countries', 'trips');

            if (!empty($countries) && !empty($trips) && !empty($available_trips)) {
                // 200 Okay
                http_response_code(200);
            } else {
                // 204 No Content
                http_response_code(204);
            }
        } catch (\Exception $e) {
            //503 Service Unavailable
            http_response_code(503);
        }

        return view('index', compact('countries', 'trips', 'available_trips'));
    }

    public function storeCountries()
    {
        try {
            if ($this->database->insertCountry('countries', [
                'country_name' => $_POST['country']
            ])) {
                // 201 Created
                http_response_code(201);
            } else {
                //503 Service Unavailable
                http_response_code(503);
            }
        } catch (\Exception $e) {
            // 500 Internal Server Error
            http_response_code(500);
            echo json_encode(["message" => "Error: " . $e->getMessage()]);
        }

        return $this->index();
    }

    public function removeCountry()
    {
        try {
            if ($this->database->delete('countries', [
                'id' => $_POST['id']
            ])) {
                // 200 Okay
                http_response_code(200);
            } else {
                //503 Service Unavailable
                http_response_code(503);
            }
        } catch (\Exception $e) {
            // 500 Internal Server Error
            http_response_code(500);
            echo json_encode(["message" => "Error: " . $e->getMessage()]);
        }

        return redirect('Orizon');
    }

    public function editCountry()
    {
        try {
            if ($this->database->editCountry('countries', [
                'id' => $_POST['country_id'],
                'country_name' => $_POST['new_name']
            ])) {
                // 200 Okay
                http_response_code(200);
            } else {
                //503 Service Unavailable
                http_response_code(503);
            }
        } catch (\Exception $e) {
            // 500 Internal Server Error
            http_response_code(500);
            echo json_encode(["message" => "Error: " . $e->getMessage()]);
        }

        return redirect('Orizon');
    }


    public function storeTrips()
    {
        try {
            if ($this->database->insertTrip('trips', [
                'destination' => $_POST['destination'],
                'available_seats' => $_POST['available_seats']
            ])) {
                // 201 Created
                http_response_code(201);
            } else {
                //503 Service Unavailable
                http_response_code(503);
            }
        } catch (\Exception $e) {
            // 500 Internal Server Error
            http_response_code(500);
            echo json_encode(["message" => "Error: " . $e->getMessage()]);
        }

        return $this->index();
    }

    public function removeTrip()
    {
        try {
            if ($this->database->delete('trips', [
                'id' => $_POST['id']
            ])) {
                // 200 Okay
                http_response_code(200);
            } else {
                //503 Service Unavailable
                http_response_code(503);
            }
        } catch (\Exception $e) {
            // 500 Internal Server Error
            http_response_code(500);
            echo json_encode(["message" => "Error: " . $e->getMessage()]);
        }

        return redirect('Orizon');
    }

    public function editTrip()
    {
        try {
            if ($this->database->editTrip('trips', [
                'id' => $_POST['trip_id'],
                'destination' => $_POST['new_destination'],
                'available_seats' => $_POST['available_seats']
            ])) {
                // 200 Okay
                http_response_code(200);
            } else {
                //503 Service Unavailable
                http_response_code(503);
            }
        } catch (\Exception $e) {
            // 500 Internal Server Error
            http_response_code(500);
            echo json_encode(["message" => "Error: " . $e->getMessage()]);
        }

        return redirect('Orizon');
    }
}
