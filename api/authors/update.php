<?php

include_once '../../config/Database.php'; // Including the database configuration file
include_once '../../models/Author.php'; // Including the Author model file

// Instantiate DB & connect
$database = new Database();
$db = $database->connect(); // Creating a database connection

// Instantiate author object
$author = new Author($db); // Creating an instance of the Author class and passing the database connection

// Get raw posted data
$data = json_decode(file_get_contents("php://input")); // Retrieving JSON data from the request body and decoding it

// Set ID and author to update
$author->id = isset($data->id) ? $data->id : null; // Setting the author ID to update
$author->author = isset($data->author) ? $data->author : null; // Setting the author name to update

if(isset($author->author) && isset($author->id)){
    // Update author
    if($author->update()){
        // Create array containing updated author details
        $author_arr = array(
            'id'            => $author->id,
            'author'        => $author->author,
        );

        // Convert the author details array to JSON format and output it
        print_r(json_encode($author_arr));
    } else {
        // If author update fails, return an error message
        echo json_encode(
            array('message' => 'Author Not Updated')
        );  
    }
} else {
    // If required parameters are missing, return an error message
    echo json_encode(
        array('message' => 'Missing Required Parameters')
    );  
}
