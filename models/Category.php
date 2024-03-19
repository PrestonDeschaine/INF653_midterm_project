<?php
class Category {
    // Database connection and table name
    private $conn;
    private $table = 'categories';

    // Category properties
    public $id;
    public $category;

    // Constructor with $db as database connection
    public function __construct($db) {
        $this->conn = $db;
    }

    // Get all categories
    public function read() {
        // Create query
        $query = 'SELECT 
                    id,
                    category
                FROM
                    ' . $this->table . '
                ORDER BY
                    id ASC';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Execute query
        $stmt->execute();

        return $stmt;
    }

    // Get single category
    public function read_single() {
        // Create query
        $query = 'SELECT 
                    id,
                    category
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
            $this->category = $row['category'];
        }
    }

    // Create category
    public function create() {
        // Create query
        $query = 'INSERT INTO ' . $this->table . ' (category) VALUES (:category) RETURNING id';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->category = htmlspecialchars(strip_tags($this->category));

        // Bind parameters
        $stmt->bindParam(':category', $this->category);

        // Execute query
        if ($stmt->execute()) {
            return $stmt->fetchColumn();
        } else {
            // Print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);
            return false;
        }
    }

    // Update category
    public function update() {
        // Update query
        $query = 'UPDATE ' . $this->table . ' SET category = :category WHERE id = :id';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->category = htmlspecialchars(strip_tags($this->category));

        // Bind parameters
        $stmt->bindParam(':category', $this->category);
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

    // Delete category
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
