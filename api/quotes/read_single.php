<?php
// Set content type header to JSON
header('Content-Type: application/json');

// Include necessary files
include_once '../../config/Database.php'; // Include the file containing the Database class definition
include_once '../../models/Quote.php';    // Include the file containing the Quote class definition

// Instantiate Database object and connect to the database
$database = new Database();    // Database class is responsible for establishing a database connection
$db = $database->connect();    // Connect to the database

// Instantiate Quote object
$quote = new Quote($db); // Quote class represents a quote entity in the database

// Get the ID from the query parameters
$quote->id = isset($_GET['id']) ? $_GET['id'] : die(); // Get the ID of the quote from the request URL

// Retrieve data for a single quote based on the provided ID
$quote->read_single(); // Retrieve a single quote's data from the database

// Check if quote was found
if ($quote->id != null && $quote->quote != null) {
    // If quote is found, create an array with quote information
    $quote_arr = array(
        'id'       => $quote->id,       // ID of the quote
        'quote'    => $quote->quote,    // Quote text
        'author'   => $quote->author,   // Author of the quote
        'category' => $quote->category, // Category of the quote
    );

    // Return JSON data for the quote
    echo json_encode($quote_arr); // Print the quote information in JSON format
} else {
    // If quote is not found, return a message indicating no quotes were found
    echo json_encode(array('message' => 'No Quotes Found')); // Print a JSON-encoded error message
}
?>
