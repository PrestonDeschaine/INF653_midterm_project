<?php
// Include necessary files
include_once '../../config/Database.php'; // Include the file containing the Database class definition
include_once '../../models/Category.php'; // Include the file containing the Category class definition

// Instantiate Database object and connect to the database
$database = new Database();    // Database class is responsible for establishing a database connection
$db = $database->connect();    // Connect to the database

// Instantiate Category object
$category = new Category($db); // Category class represents a category entity in the database

// Retrieve raw posted data from the request body and decode it
$data = json_decode(file_get_contents("php://input")); // Decode JSON data sent in the request body

// Set the ID of the category to update
$category->id = $data->id; // Set the ID of the category to be deleted

// Attempt to delete the category
if($category->delete()){ // Call the delete method of the Category object
    // If deletion is successful, create an array with the ID of the deleted category
    $category_arr = array(
        'id' => $category->id,
    );

    // Convert the array to JSON format and print
    print_r(json_encode($category_arr)); // Print the deleted category ID in JSON format
} else {
    // If deletion fails, print an error message
    echo json_encode(
        array('message' => 'Category Not Deleted')
    );  
}
?>
