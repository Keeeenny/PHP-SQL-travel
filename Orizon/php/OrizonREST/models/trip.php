<?php

class Trip 
  {
    private $conn;
    private $table_name = "trips";

    public $id;
    public $destination;
    public $available_seats;


    //construct
    public function __construct($db)
    {
     $this->conn = $db;
    }



    //READ
    function read()
    {
     $query = "SELECT id, destination, available_seats FROM " . $this->table_name;
     $stmt = $this->conn->prepare($query);

 
     $stmt->execute();
     return $stmt;
    }


    //CREATE
    function create(){
      $query = "INSERT INTO " . $this->table_name . "
      SET destination=:destination, available_seats=:available_seats;";
  
       $stmt = $this->conn->prepare($query);
          
      $this->destination = htmlspecialchars(strip_tags($this->destination));
      $this->available_seats = htmlspecialchars(strip_tags($this->available_seats));
          
       $stmt->bindParam(":destination", $this->destination);
       $stmt->bindParam(":available_seats", $this->available_seats);
      
       if($stmt->execute()){
          return true;
       }
      
       return false;
    }

    //UPDATE
    function update(){
      $query = "UPDATE " . $this->table_name . "
      SET destination = :destination,
      available_seats = :available_seats
      WHERE id = :id";

      $stmt = $this->conn->prepare($query);

      $this->id = htmlspecialchars(strip_tags($this->id));
      $this->destination = htmlspecialchars(strip_tags($this->destination));
      $this->available_seats = htmlspecialchars(strip_tags($this->available_seats));


      $stmt->bindParam(":id", $this->id);
      $stmt->bindParam(":destination", $this->destination);
      $stmt->bindParam(":available_seats", $this->available_seats);


      if($stmt->execute()){
        return true;
      }

      return false;
    }


    //DELETE
    function delete(){
      $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

      $stmt = $this->conn->prepare($query);

      $this->id = htmlspecialchars(strip_tags($this->id));

      $stmt->bindParam(1, $this->id);


      if($stmt->execute()){
        return true;
      }
 
      return false;

    }


    //FILTER
    function filter($country_table){


      $query = "SELECT * FROM " . $this->table_name . " WHERE EXISTS (
        SELECT * FROM " . $country_table . "
        WHERE " . $this->table_name . ".destination LIKE CONCAT('%', " . $country_table . ".country_name, '%')
        )  AND " . $this->table_name . ".available_seats > 0;";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();
        return $stmt;
    }
  }

?>