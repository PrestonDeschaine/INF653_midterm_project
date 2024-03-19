<?php
// Include necessary files
include_once '../../config/Database.php'; // Include the file containing the Database class definition
include_once '../../models/Category.php'; // Include the file containing the Category class definition

// Instantiate Database object and connect to the database
$database = new Database();    // Database class is responsible for establishing a database connection
$db = $database->connect();    // Connect to the database

// Instantiate Category object
$category = new Category($db); // Category class represents a category entity in the database

// Get the ID from the query parameters
$category->id = isset($_GET['id']) ? $_GET['id'] : die(); // Get the ID of the category from the request URL

// Retrieve the category data using the provided ID
$category->read_single(); // Retrieve a single category's data from the database

// Create an array to hold category data
if(isset($category->id) && isset($category->category)){
    // If category ID and name are set, create an array with category information
    $category_arr = array(
        'id'       => $category->id,       // ID of the category
        'category' => $category->category, // Name of the category
    );

    // Convert category array to JSON format and print
    print_r(json_encode($category_arr)); // Print the category information in JSON format
} else {
    // If category ID or name is not found, print an error message
    print_r(json_encode(array("message" => "category_id Not Found"))); // Print a JSON-encoded error message
}
?>
