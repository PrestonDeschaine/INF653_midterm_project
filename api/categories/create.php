<?php
// Headers

include_once '../../config/Database.php'; // Including the database configuration file
include_once '../../models/Category.php'; // Including the Category model file

// Instantiate DB & connect
$database = new Database();
$db = $database->connect(); // Creating a database connection

// Instantiate category object
$category = new Category($db); // Creating an instance of the Category class and passing the database connection

// Get raw posted data
$data = json_decode(file_get_contents("php://input")); // Retrieving JSON data from the request body and decoding it

// Set category name
$category->category = isset($data->category) ? $data->category : null; // Setting the category name from the posted data

if(isset($category->category)){
    // Create category
    $category_id = $category->create(); // Creating a new category in the database

    if($category_id){
        // Create array containing category details
        $category_arr = array(
            'id'              => $category_id,
            'category'        => $category->category,
        );

        // Convert the category details array to JSON format and output it
        print_r(json_encode($category_arr));
    }
} else {
    // If required parameters are missing, return an error message
    echo json_encode(
        array('message' => 'Missing Required Parameters')
    ); 
}
