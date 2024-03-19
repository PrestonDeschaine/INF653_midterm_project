<?php
// Including necessary files
include_once '../../config/Database.php'; // Including the database configuration file
include_once '../../models/Quote.php'; // Including the Quote model file

// Creating a database connection
$database = new Database();
$db = $database->connect(); // Establishing a connection to the database

// Creating an instance of the Quote class and providing the database connection
$quote = new Quote($db);

// Retrieving raw posted data and decoding JSON
$data = json_decode(file_get_contents("php://input"));

// Checking if the required parameters are present
if(!isset($data->author_id) && !isset($data->category_id)){
    // If both author_id and category_id are missing, return an error message and stop further execution
    echo json_encode(
        array('message' => 'Missing Required Parameters: author_id and category_id')
    );
    exit;
}

if(!isset($data->author_id)){
    // If author_id is missing, return an error message and stop further execution
    echo json_encode(
        array('message' => 'author_id Not Found')
    );
    exit;
}

if(!isset($data->category_id)){
    // If category_id is missing, return an error message and stop further execution
    echo json_encode(
        array('message' => 'category_id Not Found')
    );
    exit;
}

// Assigning values from the POST data
$quote->quote = isset($data->quote) ? $data->quote : null; // Setting the quote, if provided
$quote->author_id = $data->author_id; // Setting the author ID
$quote->category_id = $data->category_id; // Setting the category ID

// Creating a new quote
$quote_id = $quote->create();

if($quote_id){
    // If quote creation is successful, create an array containing quote details
    $quote_arr = array(
        'id'            => $quote_id,
        'quote'         => $quote->quote,
        'author_id'     => $quote->author_id,
        'category_id'   => $quote->category_id,
    );

    // Convert the quote details array to JSON format and output it
    echo json_encode($quote_arr);
} else {
    // If quote creation fails, return an error message
    echo json_encode(
        array('message' => 'Quote Not Created')
    );
}
?>
