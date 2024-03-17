<?php
class Database {
  private $conn;
  private $host = 'localhost';
  private $port;
  private $db_name = 'midterm';
  private $username = 'root';
  private $password = '123456';
  
  public function __construct() {
    // Initialize connection parameters from environment variables
    $this->username = getenv('USERNAME');
    $this->password = getenv('PASSWORD');
    $this->db_name = getenv('DBNAME');
    $this->host = getenv('HOST');
    $this->port = getenv('PORT');
  }

  public function connect() {
    // Check if connection is already established
    if ($this->conn) {
      // Connection already exists, return it
      return $this->conn;
    } else {
      // Construct DSN (Data Source Name) for PDO
      $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->db_name};";

      try { 
        // Establish a new PDO connection
        $this->conn = new PDO($dsn, $this->username, $this->password);
        
        // Set error handling mode to throw exceptions
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Return the connection
        return $this->conn;
      } catch(PDOException $e) {
        // Catch any connection errors and display the message
        echo 'Connection Error: ' . $e->getMessage();
      }
    }
  }
}
?>