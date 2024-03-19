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

// Execute query to retrieve all quotes
$result = $quote->read(); // Execute query to retrieve all quotes from the database

// Get the number of rows returned by the query
$num = $result->rowCount(); // Get the number of rows returned by the query

// Check if any quotes are found
if ($num > 0) {
    // If quotes are found, initialize an empty array to store quote data
    $quotes_arr = array();

    // Loop through each row returned by the query
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        // Extract individual row data into variables
        extract($row);

        // Create an associative array representing a single quote item
        $quote_item = array(
            'id'       => $id,       // ID of the quote
            'quote'    => $quote,    // Quote text
            'author'   => $author,   // Author of the quote
            'category' => $category, // Category of the quote
        );

        // Push the quote item array into the quotes array
        array_push($quotes_arr, $quote_item);
    }

    // Encode the quotes array into JSON format and print it
    echo json_encode($quotes_arr); // Print the quotes array in JSON format
} else {
    // If no quotes are found, print a message indicating no quotes were found
    echo json_encode(array('message' => 'No quotes found')); // Print a JSON-encoded error message
}
?>
