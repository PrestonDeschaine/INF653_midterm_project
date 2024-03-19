<?php
    class Category{
        // Database connection
        private $conn;
        private $table = 'categories'; // Table name

        // Category Properties
        public $id;
        public $category;

        // Constructor with database connection injection
        public function __construct($db){
            $this->conn = $db;
        }

        // Get all categories
        public function read(){
            // SQL query to fetch all categories
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

        // Get single category by id
        public function read_single(){
            // SQL query to fetch single category by id
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

            // Bind Id parameter
            $stmt->bindParam(1, $this->id);

            // Execute query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Set Properties
            if(isset($row['id']) && isset($row['category'])){
                $this->id = $row['id'];
                $this->category = $row['category'];
            }
        }

        // Create new category
        public function create(){
            // SQL query to insert new category
            $query = 'INSERT INTO ' .
                    $this->table . '
                (
                category)
                VALUES
                    (
                    :category)
                RETURNING id, category';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->category = htmlspecialchars(strip_tags($this->category));

            // Bind Data
            $stmt->bindParam(':category', $this->category);

            // Execute query
            if($stmt->execute()){
                return $stmt->fetch()["id"];
            }else{
                // Print error if something goes wrong.
                printf("Error: %s.\n", $stmt->error);
                return false;
            }
        }

        // Update category
        public function update(){
            // SQL query to update category
            $query = 'UPDATE ' .
            $this->table . '
        SET
            category = :category
            WHERE
                id = :id';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->id = htmlspecialchars(strip_tags($this->id));
            $this->category = htmlspecialchars(strip_tags($this->category));

            // Bind Data
            $stmt->bindParam(':category', $this->category);
            $stmt->bindParam(':id', $this->id);

            // Execute query
            if($stmt->execute()){
                return true;
            }else{
                // Print error if something goes wrong.
                printf("Error: %s.\n", $stmt->error);
                return false;
            }
        }

        // Delete category
        public function delete(){
            // SQL query to delete category by id
            $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->id = htmlspecialchars(strip_tags($this->id));

            // Bind data
            $stmt->bindParam(':id', $this->id);

            // Execute query
            if($stmt->execute()){
                return true;
            }else{
                // Print error if something goes wrong.
                printf("Error: %s.\n", $stmt->error);
                return false;
            }
        }

}
?>
