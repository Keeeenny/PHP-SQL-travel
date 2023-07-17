<?php

class CountryQueryBuilder
{
    protected $pdo;
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    //CREATE COUNTRY
    public function insertCountry($table, $parameters)
    {
        $trimmedParameters = array_map('trim', $parameters);

        if (empty(implode('', $trimmedParameters))) {
            echo 'Invalid parameter value ';
            return false;
        }

        $column = implode(', ', array_keys($trimmedParameters));
        $value = ':' . implode(', :', array_keys($trimmedParameters));

        $sql = sprintf(
            'INSERT INTO %s (%s) VALUES (%s)',
            $table,
            $column,
            $value
        );
        try {
            $statement = $this->pdo->prepare($sql);
            $statement->execute($trimmedParameters);
        } catch (Exception $e) {
            echo('Something went wrong. ' . $e);
            return false;
        }
        return true;
    }

    //UPDATE COUNTRY
    public function editCountry($table, $parameters)
    {
        $trimmedParameters = array_map('trim', $parameters);

        if (empty(trim($trimmedParameters['country_name']))) {
            echo 'Invalid parameter value ';
            return false;
        }

        $sql = "UPDATE $table SET country_name = :country_name WHERE id = :id";

        try {
            $statement = $this->pdo->prepare($sql);
            $statement->execute($trimmedParameters);
        } catch (Exception $e) {
            die('Something went wrong. ' . $e);
            return false;
        }

        return true;
    }
}
