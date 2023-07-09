<?php

namespace App\Controllers\CommonController;

use App\Core\App;

class CommonController
{
    public static function readData()
    {
        try {
            $countries = App::get('database')->selectAll('countries');
            $trips = App::get('database')->selectAll('trips');

            if (empty($countries) && empty($trips)) {
                // 204 No Content
                http_response_code(204);
                echo "<p class='error'>The list is empty or unable to read.</p>";
            }

            // 200 Okay
            http_response_code(200);

            $data = [
                "countries" => $countries,
                "trips" => $trips
            ];

            return $data;

        } catch (\Exception $e) {
            //503 Service Unavailable
            http_response_code(503);
            echo "<p class='error'>Service Unavailable.</p>";
        }
    }

    public static function index($filtered_trips = [])
    {
        $data = CommonController::readData();

        $countries = $data['countries'];
        $trips = $data['trips'];

        if (!is_array($filtered_trips)) {
            $filtered_trips = [];
        }

        $available_trips = $filtered_trips;

        return view('index', compact('countries', 'trips', 'available_trips'));
    }


}
