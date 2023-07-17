<?php

namespace App\Controllers\CountryController;

use App\Core\App;

class AppController
{
    protected $commonQuery;
    protected $countryQuery;

    public function __construct()
    {
        $this->commonQuery = App::get('database')["common"];
        $this->countryQuery = App::get('database')["country"];
    }

    public function readCountry()
    {
        $countryList = $this->commonQuery->selectAll('countries');

        if (empty($countryList)) {
            // 200 Okay
            echo json_encode(["message" => "The list is empty."]);
            return http_response_code(200);
        }

        // 200 Okay
        http_response_code(200);
        echo json_encode($countryList);
    }


    public function storeCountry()
    {
        $data = json_decode(file_get_contents("php://input"));

        if (empty($data->country_name)) {
            // 400 Bad request
            echo json_encode(["message" => "Unable to add the country the data are incomplete."]);
            return http_response_code(400);
        }

        if ($this->commonQuery->nameExists('countries', 'country_name', $data->country_name)) {
            // 409 Conflict
            echo json_encode(["message" => "Country alredy exists."]);
            return http_response_code(409);
        }

        if (!$this->countryQuery->insertCountry('countries', [
            'country_name' => $data->country_name
        ])) {
            //503 Service Unavailable
            echo json_encode(["message" => "Unable to add the country."]);
            return http_response_code(503);
        }

        // 201 Created
        http_response_code(201);
        echo json_encode(["message" => "Country successfully added."]);
    }


    public function deleteCountry($id)
    {

        if (empty($id)) {
            // 400 Bad request
            echo json_encode(["message" => "Unable to delete the country, the data are incomplete"]);
            return http_response_code(200);
        }

        if (!is_numeric($id)) {
            // 400 Bad request
            echo json_encode(["message" => "Unable to delete the country, id is not a number."]);
            return http_response_code(400);
        }

        if (!$this->commonQuery->doExists('countries', 'id', $id)) {
            // 404 Not found
            echo json_encode(["message" => "Country not found or unable to delete."]);
            return http_response_code(404);
        }

        if (!$this->commonQuery->delete('countries', [
            'id' => $id
        ])) {
            //503 Service Unavailable
            echo json_encode(["message" => "Unable to delete the country"]);
            return http_response_code(503);
        }

        // 200 Okay
        http_response_code(200);
        echo json_encode(["message" => "The country has been deleted."]);
    }

    public function updateCountry()
    {
        $data = json_decode(file_get_contents("php://input"));

        if (!$this->commonQuery->doExists('countries', 'id', $data->id)) {
            // 404 Not found
            echo json_encode(["message" => "Country not found or unable to update."]);
            return http_response_code(404);
        }

        if ($this->commonQuery->nameExists('countries', 'country_name', $data->country_name)) {
            // 409 Conflict
            echo json_encode(["message" => "Country alredy exists."]);
            return http_response_code(409);
        }

        if (empty($data->id) || empty($data->country_name)) {
            // 400 Bad request
            echo json_encode(["message" => "Unable to update the country data are incomplete. "]);
            return http_response_code(400);
        }

        if (!$this->countryQuery->editCountry('countries', [
            'id' => $data->id,
            'country_name' => $data->country_name
        ])) {
            //503 Service Unavailable
            echo json_encode(["message" => "Unable to update the country."]);
            return http_response_code(503);
        }

        // 200 Okay
        http_response_code(200);
        echo json_encode(["message" => "Country successfully updated."]);
    }
}
