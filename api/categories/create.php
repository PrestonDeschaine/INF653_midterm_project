<?php
// Include necessary files
include_once '../../config/Database.php'; // Include the file containing the Database class definition
include_once '../../models/Category.php'; // Include the file containing the Category class definition

// Instantiate Database object and connect to the database
$database = new Database();    // Database class is responsible for establishing a database connection
$db = $database->connect();    // Connect to the database

// Instantiate Category object
$category = new Category($db); // Category class represents a category entity in the database

// Retrieve data from the request body and decode it
$data = json_decode(file_get_contents("php://input")); // Decode JSON data sent in the request body

// Set the category property of the Category object if it exists in the decoded data
$category->category = isset($data->category) ? $data->category : null; // Set the category name

// Check if category name is set
if(isset($category->category)){
    // If category name is set, attempt to create the category
    $category_id = $category->create(); // Call the create method of the Category object to create the category

    // Check if category creation was successful
    if($category_id){
        // If category is successfully created, create an array with category information
        $category_arr = array(
            'id'       => $category_id,          // ID of the created category
            'category' => $category->category,   // Name of the created category
        );

        // Convert the array to JSON format and print
        print_r(json_encode($category_arr)); // Print the created category information in JSON format
    }
} else {
    // If category name is missing, print an error message
    echo json_encode(
        array('message' => 'Missing Required Parameters')
    ); 
}
?>
