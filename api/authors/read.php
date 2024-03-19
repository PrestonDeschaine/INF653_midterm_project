<?php
// Include necessary files
include_once '../../config/Database.php'; // Include the file containing the Database class definition
include_once '../../models/Author.php';   // Include the file containing the Author class definition

// Instantiate Database object and connect to the database
$database = new Database();    // Database class is responsible for establishing a database connection
$db = $database->connect();    // Connect to the database

// Instantiate Author object
$author = new Author($db); // Author class represents an author entity in the database

// Call the read method to retrieve all authors from the database
$result = $author->read(); // Retrieve all authors from the database

// Get the number of authors returned
$num = $result->rowCount(); // Get the number of rows returned by the query

// Check if there are authors found
if($num > 0){
    // If authors are found, initialize an empty array to hold authors data
    $authors_arr = array();

    // Loop through each row returned by the query
    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        // Extract the values from the row
        extract($row);

        // Create an array representing an author
        $author_item = array(
            'id'     => $id,      // ID of the author
            'author' => $author   // Name of the author
        );

        // Add the author data to the array of authors
        array_push($authors_arr, $author_item);
    }

    // Convert the array of authors to JSON format and echo it
    echo json_encode($authors_arr); // Print the array of authors in JSON format
} else {
    // If no authors are found, print an error message
    echo json_encode(
        array(
            'message' => 'No Authors Found'
        )
    );
}
?>
