<?php
    class Quote{
        // Database connection
        private $conn;
        private $table = 'quotes'; // Table name

        // Quote Properties
        public $id;
        public $quote;
        public $author_id;
        public $category_id;
        public $author;
        public $category;

        // Constructor with database connection injection
        public function __construct($db){
            $this->conn = $db;
        }

        // Get all quotes with corresponding author and category
        public function read(){
            // SQL query to fetch all quotes with author and category details
            $query = 'SELECT 
                        quotes.id,
                        quotes.quote,
                        authors.author,
                        categories.category
                    FROM
                    ' . $this->table . '
                    LEFT JOIN
                        authors ON quotes.author_id = authors.id
                    LEFT JOIN
                        categories ON quotes.category_id = categories.id
                    ';
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Execute query
            $stmt->execute();

            return $stmt;
        }

        // Get single quote by id with corresponding author and category
        public function read_single(){
            // SQL query to fetch single quote by id with author and category details
            $query = 'SELECT 
                    quotes.id,
                    quotes.quote,
                    authors.author,
                    categories.category
                FROM
                ' . $this->table . '
                LEFT JOIN
                    authors ON quotes.author_id = authors.id
                LEFT JOIN
                    categories ON quotes.category_id = categories.id
                WHERE quotes.id = ?
                LIMIT 1';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Bind Id parameter
            $stmt->bindParam(1, $this->id);

            // Execute query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if(isset($row['id'])&& isset($row['author'])){
                // Set Properties
                $this->id = $row['id'];
                $this->quote = $row['quote'];
                $this->author = $row['author'];
                $this->category = $row['category'];
            }
        }

        // Create new quote
        public function create(){
            // SQL query to insert new quote
            $query = 'INSERT INTO ' .
                    $this->table . '
                (quote,
                author_id,
                category_id)
                VALUES
                    (
                    :quote,
                    :author_id,
                    :category_id)
                RETURNING id, quote, author_id, category_id';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->quote = htmlspecialchars(strip_tags($this->quote));
            $this->author_id = htmlspecialchars(strip_tags($this->author_id));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));

            // Bind Data
            $stmt->bindParam(':quote', $this->quote);
            $stmt->bindParam(':author_id', $this->author_id);
            $stmt->bindParam(':category_id', $this->category_id);

            // Execute query
            if($stmt->execute()){
                return $stmt->fetch()["id"];
            }else{
                // Print error if something goes wrong.
                printf("Error: %s.\n", $stmt->error);
                return false;
            }
        }

        // Update quote
        public function update(){
            // SQL query to update quote
            $query = 'UPDATE ' .
            $this->table . '
        SET
            quote = :quote,
            author_id = :author_id,
            category_id = :category_id
            WHERE
                id = :id';


            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->id = htmlspecialchars(strip_tags($this->id));
            $this->quote = htmlspecialchars(strip_tags($this->quote));
            $this->author_id = htmlspecialchars(strip_tags($this->author_id));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));

            // Bind Data
            $stmt->bindParam(':quote', $this->quote);
            $stmt->bindParam(':author_id', $this->author_id);
            $stmt->bindParam(':category_id', $this->category_id);
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

        // Delete quote
        public function delete(){
            // SQL query to delete quote by id
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
                return false;
            }

        }

}
?>
