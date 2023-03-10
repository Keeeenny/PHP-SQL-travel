<?php

class Paese 
  {

    private $conn;
    private $table_name = "paesi";
    //proprietà dei paesi
    public $id;
    public $nome_paese;
   



    //costruttore
    public function __construct($db)
    {
     $this->conn = $db;
    }

    public function getTableName(){
      return $this->table_name;
    }

    //READ
    function read()
    {
     $query = "SELECT id, nome_paese FROM " . $this->table_name;
     $stmt = $this->conn->prepare($query);

 
     $stmt->execute();
     return $stmt;

    }


     //CREATE
    function create(){
      $query = "INSERT INTO " . $this->table_name . "
      SET nome_paese=:nome_paese;";
  
       $stmt = $this->conn->prepare($query);
          
      $this->nome_paese = htmlspecialchars(strip_tags($this->nome_paese));
          
       $stmt->bindParam(":nome_paese", $this->nome_paese);
      
       if($stmt->execute()){
          return true;
       }
      
       return false;
    }

    //UPDATE
    function update(){
      $query = "UPDATE " . $this->table_name . "
      SET nome_paese = :nome_paese
      WHERE id = :id";

      $stmt = $this->conn->prepare($query);

      $this->id = htmlspecialchars(strip_tags($this->id));
      $this->nome_paese = htmlspecialchars(strip_tags($this->nome_paese));

      $stmt->bindParam(":id", $this->id);
      $stmt->bindParam(":nome_paese", $this->nome_paese);


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
    }


?>