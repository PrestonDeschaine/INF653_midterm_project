<?php
// This file is a class that will be used to create, read, update, and delete authors from the database.

class Author{
  private $conn;
  private $table = 'authors';

  public $id;
  public $author;

  public function __construct($db){
    $this->conn = $db;
  }

  // Creates a new author
  public function create(){
    $query = 'INSERT INTO ' . $this->table . ' SET author = :author';

    $stmt = $this->conn->prepare($query);

    $this->author = htmlspecialchars(strip_tags($this->author));

    $stmt->bindParam(':author', $this->author);

    if($stmt->execute()){
      return true;
    }

    echo "Error: $stmt->error.\n";

    return false;
  }

  // Reads authors
  public function read(){
    $query = 'SELECT id, author FROM ' . $this->table . ' ORDER BY id ASC';

    $stmt = $this->conn->prepare($query);

    if($stmt->execute()){
      return true;
    }

    echo "Error: $stmt->error.\n";

    return false;
  }

  // Gets authors
  public function readAll(){
    $query = 'SELECT id, author FROM ' . $this->table . ' ORDER BY id ASC';

    $stmt = $this->conn->prepare($query);

    if($stmt->execute()){
      return $stmt;
    }

    echo "Error: $stmt->error.\n";
  }

  // Gets authors by id
  public function read_single(){
    $query = 'SELECT id, author FROM ' . $this->table . ' WHERE id = :id';

    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(':id', $this->id);

    if($stmt->execute()){
      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      $this->author = $row['author'];

      return true;
    }

    echo "Error: $stmt->error.\n";

    return false;
  }

  // Updates author
  public function update(){
    $query = 'UPDATE ' . $this->table . ' SET author = :author WHERE id = :id';

    $stmt = $this->conn->prepare($query);

    $this->author = htmlspecialchars(strip_tags($this->author));
    $this->id = htmlspecialchars(strip_tags($this->id));

    $stmt->bindParam(':author', $this->author);
    $stmt->bindParam(':id', $this->id);

    if($stmt->execute()){
      return true;
    }

    echo "Error: $stmt->error.\n";

    return false;
  }

  // Deletes author
  public function delete(){
    $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

    $stmt = $this->conn->prepare($query);

    $this->id = htmlspecialchars(strip_tags($this->id));

    $stmt->bindParam(':id', $this->id);

    if($stmt->execute()){
      return true;
    }

    echo "Error: $stmt->error.\n";

    return false;
  }
}
?>