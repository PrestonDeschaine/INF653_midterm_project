<?php
// Headers for CORS and content type
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization.X-Requested-With');

// Include necessary files
include_once '../../config/Database.php'; // Include the file containing the Database class definition
include_once '../../models/Quote.php';    // Include the file containing the Quote class definition
include_once '../../models/Author.php';   // Include the file containing the Author class definition
include_once '../../models/Category.php'; // Include the file containing the Category class definition

// Instantiate Database object and connect to the database
$database = new Database();    // Database class is responsible for establishing a database connection
$db = $database->connect();    // Connect to the database

// Instantiate Quote object
$quo = new Quote($db); // Quote class represents a quote entity in the database

// Instantiate Author and Category objects
$aut = new Author($db); // Author class represents an author entity in the database
$cat = new Category($db); // Category class represents a category entity in the database

// Retrieve raw posted data from the request body and decode it
$data = json_decode(file_get_contents("php://input")); // Decode JSON data sent in the request body

// Check if all required parameters are set in the posted data
if (!isset($data->quote) || !isset($data->author_id) || !isset($data->category_id)) {
    // If any required parameter is missing, send an error message and exit
    echo json_encode(array('message' => 'Missing Required Parameters'));
    exit();
}

// Set data for quote creation
$quo->quote = $data->quote; // Set the quote text
$quo->author_id = $data->author_id; // Set the author ID
$quo->category_id = $data->category_id; // Set the category ID

// Set author ID and category ID for validation
$aut->id = $data->author_id; // Set the author ID for validation
$cat->id = $data->category_id; // Set the category ID for validation

// Read single category to check if it exists
$cat->read_single(); // Retrieve category data to check if it exists
if (!$cat->category) {
    // If category does not exist, send an error message and exit
    echo json_encode(array('message' => 'category_id Not Found'));
    exit();
}

// Read single author to check if it exists
$aut->read_single(); // Retrieve author data to check if it exists
if (!$aut->author) {
    // If author does not exist, send an error message and exit
    echo json_encode(array('message' => 'author_id Not Found'));
    exit();
}

// Create the quote
if ($quo->create()) {
    // If quote is successfully created, send the quote data in JSON format
    echo json_encode(array(
        'id' => $quo->id,
        'quote' => $quo->quote,
        'author_id' => $quo->author_id,
        'category_id' => $quo->category_id
    ));
} else {
    // If quote creation fails, send an error message
    echo json_encode(array('message' => 'No Quotes Found'));
}
?>
