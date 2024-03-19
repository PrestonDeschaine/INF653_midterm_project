<?php
// Allow cross-origin resource sharing and set content type to JSON
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Retrieve the HTTP request method
$method = $_SERVER['REQUEST_METHOD'];

// Get the value of the 'id' parameter from the query string, if present
$param_passed = isset($_GET['id']) ? $_GET['id'] : null;

// Check if the request method is OPTIONS (preflight request)
if ($method === 'OPTIONS') {
    // Set allowed HTTP methods and headers for CORS
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    // Exit to prevent further processing
    exit();
}

// Determine the action based on the HTTP request method
if($method === 'GET'){
    // If the method is GET, check if 'id' parameter is passed
    if(isset($param_passed)){
        // If 'id' parameter is present, include script to read a single record
        include_once 'read_single.php';
    } else {
        // If 'id' parameter is not present, include script to read multiple records
        include_once 'read.php';
    }
} else if($method === 'POST'){
    // If the method is POST, include script to create a new record
    include_once 'create.php';
} else if($method === 'PUT'){
    // If the method is PUT, include script to update an existing record
    include_once 'update.php';
} else if($method === 'DELETE'){
    // If the method is DELETE, include script to delete a record
    include_once 'delete.php';
}
?>
