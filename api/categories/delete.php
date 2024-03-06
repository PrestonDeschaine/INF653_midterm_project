<?php 
$category = new Category($db);

$data = json_decode(file_get_contents("php://input"));

if (isset($data->id)) {
  $category->id = $data->id;
  
  if($category->delete()) {
    echo json_encode(
    array(
      'id' => $category->id
      'message' => 'Category Deleted Successfully'
    ));
  } else {
    echo json_encode(
    array(
      'message' => 'category_id Not Found'
    ));
  }
} else {
  echo json_encode(
  array(
    'message' => 'Missing Required Parameters'
  ));
}