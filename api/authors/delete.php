<?php 
$author = new Author($db);

$data = json_decode(file_get_contents("php://input"));

if (isset($data->id)) {
  $author->id = $data->id;
  
  if($author->delete()) {
    echo json_encode(
    array(
      'id' => $author->id
      'message' => 'Author Deleted Successfully'
    ));
  } else {
    echo json_encode(
    array(
      'message' => 'author_id Not Found'
    ));
  }
} else {
  echo json_encode(
  array(
    'message' => 'Missing Required Parameters'
  ));
}