<?php

namespace App\Controllers\CountryController;


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

    public function storeCountries()
    {
        $countryName = $_POST['country'];

        try {

            if ($this->database->nameExists('countries', 'country_name', $countryName)) {
                redirect('Orizon');
                // 409 Conflict
                http_response_code(409);
                echo "<p class='error'>The country you have sent already exists.</p>";
            }

            if (!$this->database->insertCountry('countries', [
                'country_name' => $countryName
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

    public function editCountry()
    {
        try {

            $id = $_POST['country_id'];
            $countryName = $_POST['new_name'];

            if ($this->database->nameExists('countries', 'country_name', $countryName)) {
                redirect('Orizon');
                // 409 Conflict
                http_response_code(409);
                echo json_encode(["message" => "Country alredy exists."]);
            } 

            if (!$this->database->editCountry('countries', [
                'id' => $id,
                'country_name' => $countryName
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
    
    public function removeCountry1()
    {
        try {
            if ($this->database->delete('countries', [
                'id' => $_POST['id']
            ])) {
                redirect('Orizon');
                // 200 Okay
                http_response_code(200);
            } else {
                redirect('Orizon');
                //503 Service Unavailable
                http_response_code(503);
                echo $this->error_503;
            }
        } catch (\Exception $e) {
            redirect('Orizon');
            // 500 Internal Server Error
            http_response_code(500);
            echo json_encode(["message" => "Error: " . $e->getMessage()]);
        }
    }

    public function removeCountry()
    {
        try {
            if (!$this->database->delete('countries', [
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
}
