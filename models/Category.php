<?php
 class Category{
  private $conn;
  private $table = 'categories';

  public $id;
  public $category;

  public function __construct($db){
    $this->conn = $db;
 }

 // Creates a new category
 public function create(){
  $query = 'INSERT INTO ' . $this->table . ' SET category = :category';

  $stmt = $this->conn->prepare($query);

  $this->category = htmlspecialchars(strip_tags($this->category));

  $stmt->bindParam(':category', $this->category);

  if($stmt->execute()){
    return true;
  }

  echo "Error: $stmt->error.\n";

  return false;
}

// Reads category
public function read(){
  $query = 'SELECT id, category FROM ' . $this->table . ' ORDER BY id ASC';

  $stmt = $this->conn->prepare($query);

  if($stmt->execute()){
    return $stmt;
  }

  echo "Error: $stmt->error.\n";
}

// Gets categories
public function readAll(){
  $query = 'SELECT id, category FROM ' . $this->table . ' ORDER BY id ASC';

  $stmt = $this->conn->prepare($query);

  if($stmt->execute()){
    return true;
  }

  echo "Error: $stmt->error.\n";

  return false;
}

// Gets categories by id
public function read_single(){
  $query = 'SELECT id, category FROM ' . $this->table . ' WHERE id = :id';

  $stmt = $this->conn->prepare($query);

  $stmt->bindParam(1, $this->id);

  if($stmt->execute()){
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $this->category = $row['category'];

    return true;
  }

  echo "Error: $stmt->error.\n";

  return false;
}

// Updates category
public function update(){
  $query = 'UPDATE ' . $this->table . ' SET category = :category WHERE id = :id';

  $stmt = $this->conn->prepare($query);

  $this->id = htmlspecialchars(strip_tags($this->id));
  $this->category = htmlspecialchars(strip_tags($this->category));

  $stmt->bindParam(':id', $this->id);
  $stmt->bindParam(':category', $this->category);

  if($stmt->execute()){
    return true;
  }

  echo "Error: $stmt->error.\n";

  return false;
}

// Deletes category
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