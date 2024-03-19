<?php
// Including necessary files
include_once '../../config/Database.php'; // Including the database configuration file
include_once '../../models/Author.php'; // Including the Author model file

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate authors object
$author = new Author($db);

// GET ID
$author->id = isset($_GET['id']) ? $_GET['id'] : die(); // Get the author ID from the request parameter or terminate the script if not provided

//Get post
$author->read_single(); // Retrieve details of a single author based on the provided ID

//Create array
if((isset($author->id) && isset($author->author))){
    // If author ID and name are set, create an array containing author details
    $author_arr = array(
        'id'            => $author->id,
        'author'        => $author->author,
    );

    // Make JSON
    print_r(json_encode($author_arr)); // Encode the author details array into JSON format and print it
} else {
    // If author ID or name is not found, print an error message
    print_r(json_encode(array("message" => "author_id Not Found")));
}
