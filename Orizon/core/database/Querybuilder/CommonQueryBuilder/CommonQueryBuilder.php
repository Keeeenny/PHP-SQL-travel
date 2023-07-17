<?php

class CommonQueryBuilder
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

    //DELETE
    public function delete($table, $parameters)
    {

        $sql = "DELETE FROM $table WHERE id = :id";

        try {
            $statement = $this->pdo->prepare($sql);
            $statement->execute($parameters);
        } catch (Exception $e) {
            echo('Something went wrong. ' . $e);
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
