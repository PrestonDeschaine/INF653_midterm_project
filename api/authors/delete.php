<?php
// Include necessary files
include_once '../../config/Database.php'; // Include the file containing the Database class definition
include_once '../../models/Author.php';   // Include the file containing the Author class definition

// Create a new instance of the Database class
$database = new Database();    // Database class is responsible for establishing a database connection
// Connect to the database
$db = $database->connect();

// Create a new instance of the Author class and pass the database connection
$author = new Author($db); // Author class represents an author entity in the database

// Retrieve data from the request body and decode it
$data = json_decode(file_get_contents("php://input")); // Decodes JSON data sent in the request body

// Set the id property of the Author object from the decoded data
$author->id = $data->id; // ID of the author to be deleted

// Attempt to delete the author
if($author->delete()){ // Call the delete method of the Author object
    // If deletion is successful, create an array containing the deleted author's ID
    $author_arr = array(
        'id' => $author->id,
    );

    // Print the deleted author's ID in JSON format
    print_r(json_encode($author_arr));
} else {
    // If deletion fails, return an error message
    echo json_encode(
        array('message' => 'Author Not Deleted')
    );  
}
?>
