<?php
// Include necessary files
include_once '../../config/Database.php'; // Include the file containing the Database class definition
include_once '../../models/Author.php';   // Include the file containing the Author class definition

// Instantiate Database object and connect to the database
$database = new Database();    // Database class is responsible for establishing a database connection
$db = $database->connect();    // Connect to the database

// Instantiate Author object
$author = new Author($db); // Author class represents an author entity in the database

// Retrieve data from the request body and decode it
$data = json_decode(file_get_contents("php://input")); // Decode JSON data sent in the request body

// Set the id and author properties of the Author object if they exist in the decoded data
$author->id = isset($data->id) ? $data->id : null; // Set the ID of the author
$author->author = isset($data->author) ? $data->author : null; // Set the name of the author

// Check if both author ID and name are set
if(isset($author->author) && isset($author->id)){
    // If both parameters are set, attempt to update the author
    if($author->update()){ // Call the update method of the Author object
        // If the update is successful, create an array with updated author information
        $author_arr = array(
            'id'     => $author->id,
            'author' => $author->author,
        );

        // Convert the array to JSON format and print
        print_r(json_encode($author_arr)); // Print the updated author information in JSON format
    } else {
        // If the update fails, print an error message
        echo json_encode(
            array('message' => 'Author Not Updated')
        );  
    }
} else {
    // If either author ID or name is missing, print an error message
    echo json_encode(
        array('message' => 'Missing Required Parameters')
    );  
}
?>
