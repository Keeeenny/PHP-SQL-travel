<?php

class Viaggio 
  {
    private $conn;
    private $table_name = "viaggi";
    //proprieta dei paesi
    public $id;
    public $destinazione;
    public $posti_disponibili;


    //costruttore
    public function __construct($db)
    {
     $this->conn = $db;
    }



    //READ
    function read()
    {
     $query = "SELECT id, destinazione, posti_disponibili FROM " . $this->table_name;
     $stmt = $this->conn->prepare($query);

 
     $stmt->execute();
     return $stmt;
    }


    //CREATE
    function create(){
      $query = "INSERT INTO " . $this->table_name . "
      SET destinazione=:destinazione, posti_disponibili=:posti_disponibili;";
  
       $stmt = $this->conn->prepare($query);
          
      $this->destinazione = htmlspecialchars(strip_tags($this->destinazione));
      $this->posti_disponibili = htmlspecialchars(strip_tags($this->posti_disponibili));
          
       $stmt->bindParam(":destinazione", $this->destinazione);
       $stmt->bindParam(":posti_disponibili", $this->posti_disponibili);
      
       if($stmt->execute()){
          return true;
       }
      
       return false;
    }

    //UPDATE
    function update(){
      $query = "UPDATE " . $this->table_name . "
      SET destinazione = :destinazione,
          posti_disponibili = :posti_disponibili
      WHERE id = :id";

      $stmt = $this->conn->prepare($query);

      $this->id = htmlspecialchars(strip_tags($this->id));
      $this->destinazione = htmlspecialchars(strip_tags($this->destinazione));
      $this->posti_disponibili = htmlspecialchars(strip_tags($this->posti_disponibili));


      $stmt->bindParam(":id", $this->id);
      $stmt->bindParam(":destinazione", $this->destinazione);
      $stmt->bindParam(":posti_disponibili", $this->posti_disponibili);


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

    function getPaeseTable() {

    }

    //FILTER
    function filter($paese_table){


      $query = "SELECT * FROM " . $this->table_name . " WHERE EXISTS (
        SELECT * FROM " . $paese_table . "
        WHERE " . $this->table_name . ".destinazione LIKE CONCAT('%', " . $paese_table . ".nome_paese, '%')
        )  AND " . $this->table_name . ".posti_disponibili > 0;";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();
        return $stmt;
    }
  }

?>