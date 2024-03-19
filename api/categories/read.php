<?php
// Headers
include_once '../../config/Database.php'; // Including the database configuration file
include_once '../../models/Category.php'; // Including the Category model file

// Instantiate DB & connect
$database = new Database();
$db = $database->connect(); // Creating a database connection

// Instantiate category object
$category = new Category($db); // Creating an instance of the Category class and passing the database connection

// Quotes acategory query
$result = $category->read(); // Executing the read method to retrieve categories from the database
// Get row count
$num = $result->rowCount(); // Getting the number of rows returned from the query

// Check if any categories
if($num > 0){
    // Category array
    $categories_arr = array(); // Initializing an array to store category data

    // Loop through retrieved data
    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row); // Extracting variables from the row

        // Creating an array for each category
        $category_item = array(
            'id'            => $id,
            'category'      => $category
        );

        // Pushing the category data to the categories array
        array_push($categories_arr, $category_item);
    }

    // Convert the categories array to JSON format and output it
    echo json_encode($categories_arr);
} else {
    // If no categories found, print a message
    echo json_encode(
        array(
            'message' => 'No Categories Found'
        )
    );
}
