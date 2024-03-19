<?php
// Including necessary files
include_once '../../config/Database.php'; // Including the database configuration file
include_once '../../models/Quote.php'; // Including the Quote model file

// Creating a database connection
$database = new Database();
$db = $database->connect(); // Establishing a connection to the database

// Creating an instance of the Quote class and providing the database connection
$quote = new Quote($db);

// Querying for quotes
$result = $quote->read();

// Getting the number of rows returned
$num = $result->rowCount();

// Checking if any quotes are found
if($num > 0){
    // Initializing an array to store quotes
    $quotes_arr = array();

    // Looping through each row of the result set
    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        // Creating an array representing each quote
        $quote_item = array(
            'id'            => $id,
            'quote'         => $quote,
            'author'        => $author,
            'category'      => $category
        );

        // Adding the quote item to the quotes array
        array_push($quotes_arr, $quote_item);
    }

    // Converting the quotes array to JSON and outputting it
    echo json_encode($quotes_arr);
} else {
    // If no quotes are found, return an appropriate message
    echo json_encode(
        array(
            'message' => 'No Quotes Found'
        )
    );
}
?>
