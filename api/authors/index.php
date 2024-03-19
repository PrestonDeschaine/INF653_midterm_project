<?php
// Set headers to allow cross-origin resource sharing and specify JSON content type
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Retrieve the HTTP request method
$method = $_SERVER['REQUEST_METHOD'];

// Check if 'id' parameter is passed via GET request
$param_passed = isset($_GET['id']) ? $_GET['id'] : null;

// Handle OPTIONS request to allow CORS preflight requests
if ($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    exit();
}

// Handle GET request
if($method === 'GET'){
    // Include appropriate PHP file based on whether 'id' parameter is passed
    if(isset($param_passed)){
        include_once 'read_single.php';
    } else {
        include_once 'read.php';
    }
} 
// Handle POST request
else if($method === 'POST'){
    include_once 'create.php';
} 
// Handle PUT request
else if($method === 'PUT'){
    include_once 'update.php';
}
// Handle DELETE request
else if($method === 'DELETE'){
    include_once 'delete.php';
}
?>
