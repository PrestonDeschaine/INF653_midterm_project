<?php
// Including necessary files
include_once '../../config/Database.php'; // Including the database configuration file
include_once '../../models/Author.php'; // Including the Author model file

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate author object
$author = new Author($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

// Set ID to update
$author->id = $data->id;

// Delete author
if($author->delete()){
    // Create array
    $author_arr = array(
        'id'            => $author->id,
    );

    // Make JSON
    print_r(json_encode($author_arr));
} else {
    // If author deletion fails, return an error message
    echo json_encode(
        array('message' => 'Author Not Deleted')
    );  
}
