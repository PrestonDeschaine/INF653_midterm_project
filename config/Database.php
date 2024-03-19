<?php
class Database {
    private $conn;
    private $host;
    private $port;
    private $dbname;
    private $username;
    private $password;

    public function __construct() {
        // Set database connection parameters from environment variables
        $this->username = getenv('USERNAME');
        $this->password = getenv('PASSWORD');
        $this->dbname = getenv('DBNAME');
        $this->host = getenv('HOST');
        $this->port = getenv('PORT');
    }

    public function connect() {
        // Check if connection exists
        if ($this->conn) {
            // If connection exists, return it
            return $this->conn;
        } else {
            // Construct DSN for PostgreSQL connection
            $dsn = 'pgsql:host=' . $this->host . ';port=' . $this->port . ';dbname=' . $this->dbname;

            try {
                // Create a new PDO instance for database connection
                $this->conn = new PDO($dsn, $this->username, $this->password);
                // Set error mode to exceptions
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                // Return the database connection
                return $this->conn;
            } catch(PDOException $e) {
                // If an error occurs during connection, display error message
                echo 'Connection Error: ' . $e->getMessage();
            }
        }
    }
}
?>
