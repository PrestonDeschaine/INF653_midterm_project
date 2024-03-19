<?php
// Include necessary files
include_once '../../config/Database.php'; // Include the file containing the Database class definition
include_once '../../models/Author.php';   // Include the file containing the Author class definition

// Instantiate Database object and connect to the database
$database = new Database();    // Database class is responsible for establishing a database connection
$db = $database->connect();    // Connect to the database

// Instantiate Author object
$author = new Author($db); // Author class represents an author entity in the database

// Get the ID from the query parameters
$author->id = isset($_GET['id']) ? $_GET['id'] : die(); // Get the ID of the author from the request URL

// Retrieve the author data using the provided ID
$author->read_single(); // Retrieve a single author's data from the database

// Create an array to hold author data
if(isset($author->id) && isset($author->author)){
    // If author ID and name are set, create an array with author information
    $author_arr = array(
        'id'     => $author->id,
        'author' => $author->author,
    );

    // Convert author array to JSON format and print
    print_r(json_encode($author_arr)); // Print the author information in JSON format
} else {
    // If author ID or name is not found, print an error message
    print_r(json_encode(array("message" => "author_id Not Found"))); // Print a JSON-encoded error message
}
?>
