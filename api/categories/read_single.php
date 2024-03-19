<?php
include_once '../../config/Database.php'; // Including the database configuration file
include_once '../../models/Category.php'; // Including the Category model file

// Instantiate DB & connect
$database = new Database();
$db = $database->connect(); // Creating a database connection

// Instantiate category object
$category = new Category($db); // Creating an instance of the Category class and passing the database connection

// GET ID
$category->id = isset($_GET['id']) ? $_GET['id'] : die(); // Get the category ID from the request parameter or terminate the script if not provided

// Get category
$category->read_single(); // Retrieve details of a single category based on the provided ID

// Create array
if((isset($category->id) && isset($category->category))){
    // If category ID and name are set, create an array containing category details
    $category_arr = array(
        'id'            => $category->id,
        'category'      => $category->category,
    );

    // Convert the category details array to JSON format and output it
    print_r(json_encode($category_arr));
} else {
    // If category ID or name is not found, print an error message
    print_r(json_encode(array("message" => "category_id Not Found")));
}
