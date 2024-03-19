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

// Setting the ID of the quote to be deleted
$quote->id = isset($data->id) ? $data->id : null;

// Deleting the quote if ID is set
if(isset($quote->id)){
    if($quote->delete()){
        // If quote deletion is successful, create an array containing the deleted quote's ID
        $quote_arr = array(
            'id'            => $quote->id,
        );

        // Convert the quote details array to JSON format and output it
        print_r(json_encode($quote_arr));
    } else {
        // If no quotes found for deletion, return an appropriate message
        echo json_encode(
            array('message' => 'No Quotes Found')
        );  
    }
} else {
    // If no ID is provided, return an appropriate message
    echo json_encode(
        array('message' => 'No Quotes Found')
    ); 
}
?>
