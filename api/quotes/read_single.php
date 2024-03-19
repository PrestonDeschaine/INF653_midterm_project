<?php
// Including necessary files
include_once '../../config/Database.php'; // Including the database configuration file
include_once '../../models/Quote.php'; // Including the Quote model file

// Creating a database connection
$database = new Database();
$db = $database->connect(); // Establishing a connection to the database

// Creating an instance of the Quote class and providing the database connection
$quote = new Quote($db);

// Retrieving the quote ID from the query string or terminating the script if not provided
$quote->id = isset($_GET['id']) ? $_GET['id'] : die();

// Retrieving the single quote based on the provided ID
$quote->read_single();

// Checking if both the quote ID and quote text are set
if((isset($quote->id) && isset($quote->quote))){
    // Creating an array containing quote details
    $quote_arr = array(
        'id'            => $quote->id,
        'quote'         => $quote->quote,
        'author'        => $quote->author,
        'category'      => $quote->category,
    );

    // Converting the quote details array to JSON format and outputting it
    print_r(json_encode($quote_arr));
} else {
    // If no quotes found, return an appropriate message
    print_r(json_encode(array("message" => "No Quotes Found")));
}
?>
