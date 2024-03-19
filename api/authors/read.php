<?php
// Headers
include_once '../../config/Database.php'; // Including the database configuration file
include_once '../../models/Author.php'; // Including the Author model file

// Instantiate DB & connect
$database = new Database();
$db = $database->connect(); // Creating a database connection

// Instantiate authors object
$author = new Author($db); // Creating an instance of the Author class and passing the database connection

// Quotes author query
$result = $author->read(); // Executing the read method to retrieve authors from the database
// Get row count
$num = $result->rowCount(); // Getting the number of rows returned from the query

// Check if any authors
if($num > 0){
    // Author array
    $authors_arr = array(); // Initializing an array to store author data

    // Loop through retrieved data
    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row); // Extracting variables from the row

        // Creating an array for each author
        $author_item = array(
            'id'         => $id,
            'author'     => $author
        );

        // Pushing the author data to the authors array
        array_push($authors_arr, $author_item);
    }

    // Turn to JSON and output
    echo json_encode($authors_arr); // Converting the authors array to JSON format and outputting it
} else {
    // No Authors
    echo json_encode(
        array(
            'message' => 'No Authors Found'
        )
    );
}
