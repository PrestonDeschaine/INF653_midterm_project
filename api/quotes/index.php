<?php
// Allowing cross-origin resource sharing
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Retrieving the request method
$method = $_SERVER['REQUEST_METHOD'];

// Retrieving the 'id' parameter from the query string
$param_passed = isset($_GET['id']) ? $_GET['id'] : null;

// Handling preflight OPTIONS request
if ($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    exit();
}

// Routing based on the request method
if ($method === 'GET') {
    // Including read_single.php if 'id' parameter is provided, else including read.php
    if (isset($param_passed)) {
        include_once 'read_single.php';
    } else {
        include_once 'read.php';
    }
} else if ($method === 'POST') {
    // Including create.php for POST requests
    include_once 'create.php';
} else if ($method === 'PUT') {
    // Including update.php for PUT requests
    include_once 'update.php';
} else if ($method === 'DELETE') {
    // Including delete.php for DELETE requests
    include_once 'delete.php';
}
?>
