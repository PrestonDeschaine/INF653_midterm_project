<?php
class Author {
    // Database connection and table name
    private $conn;
    private $table = 'authors';

    // Author properties
    public $id;
    public $author;

    // Constructor with $db as database connection
    public function __construct($db) {
        $this->conn = $db;
    }

    // Get all authors
    public function read() {
        // Create query
        $query = 'SELECT 
                    id,
                    author
                FROM
                    ' . $this->table;

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Execute query
        $stmt->execute();

        return $stmt;
    }

    // Get single author
    public function read_single() {
        // Create query
        $query = 'SELECT 
                    id,
                    author
                FROM
                    ' . $this->table . '
                WHERE
                    id = ?
                LIMIT 1';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind ID parameter
        $stmt->bindParam(1, $this->id);

        // Execute query
        $stmt->execute();

        // Fetch row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Set properties
        if ($row) {
            $this->id = $row['id'];
            $this->author = $row['author'];
        }
    }

    // Create author
    public function create() {
        // Create query
        $query = 'INSERT INTO ' . $this->table . ' (author) VALUES (:author) RETURNING id';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->author = htmlspecialchars(strip_tags($this->author));

        // Bind parameters
        $stmt->bindParam(':author', $this->author);

        // Execute query
        if ($stmt->execute()) {
            return $stmt->fetchColumn();
        } else {
            // Print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);
            return false;
        }
    }

    // Update author
    public function update() {
        // Update query
        $query = 'UPDATE ' . $this->table . ' SET author = :author WHERE id = :id';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->author = htmlspecialchars(strip_tags($this->author));

        // Bind parameters
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':id', $this->id);

        // Execute query
        if ($stmt->execute()) {
            return true;
        } else {
            // Print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);
            return false;
        }
    }

    // Delete author
    public function delete() {
        // Create query
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind parameter
        $stmt->bindParam(':id', $this->id);

        // Execute query
        if ($stmt->execute()) {
            return true;
        } else {
            // Print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);
            return false;
        }
    }
}
?>
