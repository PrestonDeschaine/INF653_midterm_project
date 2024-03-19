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

// Set ID and category to update
$category->id = isset($data->id) ? $data->id : null; // Setting the category ID to update
$category->category = isset($data->category) ? $data->category : null; // Setting the category name to update

// Update category
if(isset($category->category) && isset($category->id)){
    // Check if category name and ID are set
    if($category->update()){
        // If category update is successful, create an array containing updated category details
        $category_arr = array(
            'id'            => $category->id,
            'category'      => $category->category,
        );

        // Convert the category details array to JSON format and output it
        print_r(json_encode($category_arr));
    } else {
        // If category update fails, return an error message
        echo json_encode(
            array('message' => 'Category Not Updated')
        );  
    }
} else {
    // If required parameters are missing, return an error message
    echo json_encode(
        array('message' => 'Missing Required Parameters')
    );  
}
