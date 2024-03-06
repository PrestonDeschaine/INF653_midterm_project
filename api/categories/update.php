<?php 
$category = new Category($db);

$data = json_decode(file_get_contents("php://input"));

if(isset($data->category) && isset($data->id)) {
  
  $category->id = $data->id;
  $category->category = $data->category;
  
  if($category->update()) {
    echo json_encode(
    array(
      'id' => $category->id,
      'category' => $category->category
    ));
    
  } else {
    echo json_encode(
    array(
      'message' => 'Category Not Updated'
    ));
  }
  
} else {
  echo json_encode(
  array(
    'message' => 'Missing Required Parameters'
  ));
}