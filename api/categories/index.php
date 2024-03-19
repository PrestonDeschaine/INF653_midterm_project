<?php
header('Access-Control-Allow-Origin: *'); // Allowing cross-origin resource sharing
header('Content-Type: application/json'); // Setting the response content type to JSON
$method = $_SERVER['REQUEST_METHOD']; // Retrieving the HTTP request method

$param_passed = isset($_GET['id']) ? $_GET['id'] : null; // Checking if 'id' parameter is passed via GET request

// Handle OPTIONS request to allow CORS preflight requests
if ($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE'); // Allowing specific HTTP methods
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With'); // Allowing specific headers
    exit(); // Exiting script execution
}

// Handling GET request
if($method === 'GET'){
    // Including appropriate PHP file based on whether 'id' parameter is passed
    if(isset($param_passed)){
        include_once 'read_single.php';
    } else {
        include_once 'read.php';
    }
} 
// Handling POST request
else if($method === 'POST'){
    include_once 'create.php'; // Including the PHP file for handling POST request
} 
// Handling PUT request
else if($method === 'PUT'){
    include_once 'update.php'; // Including the PHP file for handling PUT request
}
// Handling DELETE request
else if($method === 'DELETE'){
    include_once 'delete.php'; // Including the PHP file for handling DELETE request
}
?>
