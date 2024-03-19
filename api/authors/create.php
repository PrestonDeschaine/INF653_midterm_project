<?php
// Include necessary files
include_once '../../config/Database.php';
include_once '../../models/Author.php';

// Create a new instance of the Database class
$database = new Database();
// Connect to the database
$db = $database->connect();

// Create a new instance of the Author class
$author = new Author($db);

// Retrieve data from the request body and decode it
$data = json_decode(file_get_contents("php://input"));

// Set the author property of the Author object if it exists in the decoded data
$author->author = isset($data->author) ? $data->author : null;

// Check if author data is set
if(isset($author->author)){
    // Call the create method of the Author object to insert the author into the database
    $author_id = $author->create();
    // Check if author creation was successful and author data is set
    if($author_id && $author->author){
        // Create an array containing author information
        $author_arr = array(
            'id'            => $author_id,
            'author'        => $author->author,
        );

        // Print the author information in JSON format
        print_r(json_encode($author_arr));
    }
} else {
    // If author data is missing, return an error message
    echo json_encode(
        array('message' => 'Missing Required Parameters')
    );  
}
?>
