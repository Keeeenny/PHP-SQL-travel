<?php

class TripQueryBuilder
{
    protected $pdo;
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }


    // READ FILTER
    public function filterTrips($table, $countryName = null, $availableSeats = null)
    {
        $sql = "SELECT * FROM {$table} WHERE 1=1";
        $params = array();

        if (!is_null($countryName)) {
            $trimmedCountryName = trim($countryName);
            $sql .= " AND LOWER(destination) = LOWER(:destination)";
            $params[':destination'] = $trimmedCountryName;
        }

        if (!is_null($availableSeats)) {
            $sql .= " AND available_seats = :availableSeats";
            $params[':availableSeats'] = $availableSeats;
        }

        try {
            $statement = $this->pdo->prepare($sql);
            $statement->execute($params);
            return $statement->fetchAll(PDO::FETCH_CLASS);
        } catch (Exception $e) {
            die('Something went wrong while getting the data. ' . $e);
            return false;
        }
    }

    //CREATE TRIP
    public function insertTrip($table, $parameters)
    {
        $trimmedDestination = trim($parameters['destination']);

        if (empty($trimmedDestination)) {
            echo 'Invalid destination value ';
            return false;
        }

        $parameters['destination'] = $trimmedDestination;

        $column = implode(', ', array_keys($parameters));
        $value = ':' . implode(', :', array_keys($parameters));

        $sql = sprintf(
            'INSERT INTO %s (%s) VALUES (%s)',
            $table,
            $column,
            $value
        );

        try {
            $statement = $this->pdo->prepare($sql);
            $statement->execute($parameters);
        } catch (Exception $e) {
            die('Something went wrong. ' . $e);
            return false;
        }

        return true;
    }

    //UPDATE TRIP
    public function editTrip($table, $parameters)
    {
        $trimmedDestination = trim($parameters['destination']);

        if (empty($trimmedDestination)) {
            echo 'Invalid destination value ';
            return false;
        }

        $parameters['destination'] = $trimmedDestination;

        $sql = "UPDATE $table 
                SET destination = :destination, 
                    available_seats = :available_seats 
                WHERE id = :id";

        try {
            $statement = $this->pdo->prepare($sql);
            $statement->execute($parameters);
        } catch (Exception $e) {
            die('Something went wrong. ' . $e);
            return false;
        }

        return true;
    }
}
