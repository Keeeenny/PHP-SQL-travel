<?php

class PagesController

{

    protected $database;
    protected $error_503;

    public function __construct()
    {
        $this->database = App::get('database');
        $this->error_503 = "<p class='error'>Service Unavailable.</p>";
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
                echo "<p class='error'>The list is empty or unable to read.</p>";
            }
        } catch (\Exception $e) {
            //503 Service Unavailable
            http_response_code(503);
            echo $this->error_503;
        }

        return view('index', compact('countries', 'trips', 'available_trips'));
    }

    public function storeCountries()
    {
        $countryName = $_POST['country'];

        try {
            if ($this->database->nameExists('countries', 'country_name', $countryName)) {
                // 409 Conflict
                http_response_code(409);
                echo "<p class='error'>The country you have sent already exists.</p>";
            } else if ($this->database->insertCountry('countries', [
                'country_name' => $countryName
            ])) {
                // 201 Created
                http_response_code(201);
            } else {
                //503 Service Unavailable
                http_response_code(503);
                echo $this->error_503;
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
                echo $this->error_503;
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
                echo $this->error_503;
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
                echo $this->error_503;
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
                echo $this->error_503;
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
                echo $this->error_503;
            }
        } catch (\Exception $e) {
            // 500 Internal Server Error
            http_response_code(500);
            echo json_encode(["message" => "Error: " . $e->getMessage()]);
        }

        return redirect('Orizon');
    }
}
