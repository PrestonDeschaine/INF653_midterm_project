<?php
include_once '../../config/Database.php'; // Including the database configuration file
include_once '../../models/Category.php'; // Including the Category model file

// Instantiate DB & connect
$database = new Database();
$db = $database->connect(); // Creating a database connection

// Instantiate category object
$category = new Category($db); // Creating an instance of the Category class and passing the database connection

// Get raw posted data
$data = json_decode(file_get_contents("php://input")); // Retrieving JSON data from the request body and decoding it

// Set ID to update
$category->id = $data->id; // Setting the category ID to be deleted

// Delete category
if($category->delete()){
    // Create array containing deleted category ID
    $category_arr = array(
        'id'            => $category->id,
    );

    // Convert the category details array to JSON format and output it
    print_r(json_encode($category_arr));
} else {
    // If category deletion fails, return an error message
    echo json_encode(
        array('message' => 'Category Not Deleted')
    );  
}
