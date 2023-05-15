<?php

class QueryBuilder
{
    protected $pdo;
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    //READ
    public function selectAll($table)
    {

        $sql = "select * from {$table}";

        try {
            $statement = $this->pdo->prepare($sql);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_CLASS);
        } catch (Exception $e) {
            die('Something went wrong while getting the data. ' .  $e);
            return false;
        }
        return true;
    }

    //READ FILTER
    public function filterTrips($country_table, $trip_table)
    {
        $sql = "SELECT * FROM $trip_table WHERE EXISTS (
               SELECT * FROM  $country_table WHERE $trip_table.destination LIKE CONCAT('%', " . $country_table . ".country_name, '%')
            )  AND  $trip_table.available_seats > 0;";

        try {
            $statement = $this->pdo->prepare($sql);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_CLASS);
        } catch (Exception $e) {
            die('Something went wrong while getting the data.' . $e);
            return false;
        }
        return true;
    }


    //CREATE COUNTRY 
    public function insertCountry($table, $parameters)
    {
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
            echo ('Something went wrong. ' . $e);
            return false;
        }
        return true;
    }


    //CREATE TRIP 
    public function insertTrip($table, $parameters)
    {
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

    //DELETE
    public function delete($table, $parameters)
    {

        $sql = "DELETE FROM $table WHERE id = :id";

        try {
            $statement = $this->pdo->prepare($sql);
            $statement->execute($parameters);
        } catch (Exception $e) {
            echo ('Something went wrong. ' . $e);
            return false;
        }
        return true;
    }

    //UPDATE COUNTRY
    public function editCountry($table, $parameters)
    {
        $sql = "UPDATE $table SET country_name = :country_name WHERE id = :id";

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

    //Do exists?
    public function doExists($table, $column, $id)
    {
        $sql = "SELECT COUNT(*) FROM $table WHERE $column = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $count = $stmt->fetchColumn();
        return $count > 0;
    }

    //Do the country name already exists?
    public function nameExists($table, $column, $name)
    {
        $sql = "SELECT COUNT(*) FROM $table WHERE $column = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$name]);
        $count = $stmt->fetchColumn();

        return $count > 0 && $name !== "";
    }
}
