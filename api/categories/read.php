<?php
// Include necessary files
include_once '../../config/Database.php'; // Include the file containing the Database class definition
include_once '../../models/Category.php'; // Include the file containing the Category class definition

// Instantiate Database object and connect to the database
$database = new Database();    // Database class is responsible for establishing a database connection
$db = $database->connect();    // Connect to the database

// Instantiate Category object
$category = new Category($db); // Category class represents a category entity in the database

// Query to fetch all categories
$result = $category->read(); // Call the read method of the Category object to retrieve all categories from the database

// Get the number of categories returned
$num = $result->rowCount(); // Get the number of rows returned by the query

// Check if there are categories found
if($num > 0){
    // If categories are found, initialize an empty array to hold category data
    $categories_arr = array();

    // Loop through each row returned by the query
    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        // Extract the values from the row
        extract($row);

        // Create an array representing a category
        $category_item = array(
            'id'       => $id,       // ID of the category
            'category' => $category  // Name of the category
        );

        // Add the category data to the array of categories
        array_push($categories_arr, $category_item);
    }

    // Convert the array of categories to JSON format and echo it
    echo json_encode($categories_arr); // Print the array of categories in JSON format
} else {
    // If no categories are found, print an error message
    echo json_encode(
        array(
            'message' => 'No Categories Found'
        )
    );
}
?>
