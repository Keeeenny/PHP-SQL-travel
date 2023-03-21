<?php

class Country
{

  private $conn;
  private $table_name = "country";

  public $id;
  public $country_name;




  //costructor
  public function __construct($db)
  {
    $this->conn = $db;
  }

  public function getTableName()
  {
    return $this->table_name;
  }

  //READ
  function read()
  {
    $query = "SELECT id, country_name FROM " . $this->table_name;
    $stmt = $this->conn->prepare($query);


    $stmt->execute();
    return $stmt;
  }


  //CREATE
  function create()
  {
    $query = "INSERT INTO " . $this->table_name . "
      SET country_name=:country_name;";

    $stmt = $this->conn->prepare($query);

    $this->country_name = htmlspecialchars(strip_tags($this->country_name));

    $stmt->bindParam(":country_name", $this->country_name);

    if ($stmt->execute()) {
      return true;
    }

    return false;
  }

  //UPDATE
  function update()
  {
    $query = "UPDATE " . $this->table_name . "
      SET country_name = :country_name
      WHERE id = :id";

    $stmt = $this->conn->prepare($query);

    $this->id = htmlspecialchars(strip_tags($this->id));
    $this->country_name = htmlspecialchars(strip_tags($this->country_name));

    $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":country_name", $this->country_name);


    if ($stmt->execute()) {
      return true;
    }

    return false;
  }



  //DELETE
  function delete()
  {
    $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

    $stmt = $this->conn->prepare($query);

    $this->id = htmlspecialchars(strip_tags($this->id));

    $stmt->bindParam(1, $this->id);


    if ($stmt->execute()) {
      return true;
    }

    return false;
  }
}
