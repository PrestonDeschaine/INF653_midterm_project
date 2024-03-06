<?php 
$category = new Category($db);

$category->id = isset($_GET['id']) ? $_GET['id'] : die();

if ($category->read_single()) {
  echo json_encode(
  array(
    'id' => $category->id,
    'category' => $category->category
    'message' => 'Category Retrieved Successfully'
  ));
} else {
  echo json_encode(
  array(
    'message' => 'category_id Not Found'
  ));
}