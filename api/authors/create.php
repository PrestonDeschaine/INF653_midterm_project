<?php
// Including necessary files
include_once '../../config/Database.php'; // Including the database configuration file
include_once '../../models/Author.php'; // Including the Author model file

// Creating a new instance of the Database class
$database = new Database();
// Establishing a database connection
$db = $database->connect();

// Creating a new instance of the Author class and passing the database connection to it
$author = new Author($db);

// Retrieving JSON data from the request body and decoding it
$data = json_decode(file_get_contents("php://input"));

// Assigning the author property from the decoded JSON data to the author object
$author->author = isset($data->author) ? $data->author : null;

// Checking if the author property is set
if(isset($author->author)){
    // If author property is set, create a new author record in the database
    $author_id = $author->create();

    // If author creation is successful and author property is not null
    if($author_id && $author->author){
        // Creating an array containing author details
        $author_arr = array(
            'id'            => $author_id,
            'author'        => $author->author,
        );

        // Encoding the author details array into JSON format and printing it
        print_r(json_encode($author_arr));
    }
} else {
    // If author property is not set, return an error message indicating missing parameters
    echo json_encode(
        array('message' => 'Missing Required Parameters')
    );  
}
