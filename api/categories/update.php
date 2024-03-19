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

// Set the ID and category properties of the Category object if they exist in the decoded data
$category->id = isset($data->id) ? $data->id : null; // Set the ID of the category to be updated
$category->category = isset($data->category) ? $data->category : null; // Set the name of the category

// Check if both category ID and name are set
if(isset($category->category) && isset($category->id)){
    // If both parameters are set, attempt to update the category
    if($category->update()){ // Call the update method of the Category object
        // If the update is successful, create an array with updated category information
        $category_arr = array(
            'id'       => $category->id,       // ID of the updated category
            'category' => $category->category, // Name of the updated category
        );

        // Convert the array to JSON format and print
        print_r(json_encode($category_arr)); // Print the updated category information in JSON format
    } else {
        // If the update fails, print an error message
        echo json_encode(
            array('message' => 'Category Not Updated')
        );  
    }
} else {
    // If either category ID or name is missing, print an error message
    echo json_encode(
        array('message' => 'Missing Required Parameters')
    );  
}
?>
