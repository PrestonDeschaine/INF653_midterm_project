<?php
    class Author{
        // Database connection
        private $conn;
        private $table = 'authors'; // Table name

        // Author Properties
        public $id;
        public $author;

        // Constructor with database connection injection
        public function __construct($db){
            $this->conn = $db;
        }

        // Get all authors
        public function read(){
            // SQL query to fetch all authors
            $query = 'SELECT 
                        id,
                        author
                    FROM
                    ' . $this->table . '';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Execute query
            $stmt->execute();

            return $stmt;
        }

        // Get single author by id
        public function read_single(){
            // SQL query to fetch single author by id
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

            // Bind Id parameter
            $stmt->bindParam(1, $this->id);

            // Execute query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Set Properties
            if(isset($row['id']) && isset($row['author'])){
                $this->id = $row['id'];
                $this->author = $row['author'];
            }
        }

        // Create new author
        public function create(){
            // SQL query to insert new author
            $query = 'INSERT INTO ' .
                    $this->table . '
                (
                author)
                VALUES
                    (
                    :author)
                RETURNING id, author';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->author = htmlspecialchars(strip_tags($this->author));

            // Bind Data
            $stmt->bindParam(':author', $this->author);

            // Execute query
            if($stmt->execute()){
                return $stmt->fetch()["id"];
            }else{
                // Print error if something goes wrong.
                printf("Error: %s.\n", $stmt->error);
                return false;
            }
        }

        // Update author
        public function update(){
            // SQL query to update author
            $query = 'UPDATE ' .
            $this->table . '
        SET
            author = :author
            WHERE
                id = :id';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->id = htmlspecialchars(strip_tags($this->id));
            $this->author = htmlspecialchars(strip_tags($this->author));

            // Bind Data
            $stmt->bindParam(':author', $this->author);
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

        // Delete author
        public function delete(){
            // SQL query to delete author by id
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
