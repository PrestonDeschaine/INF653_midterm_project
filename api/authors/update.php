<?php 
$author = new Author($db);

$data = json_decode(file_get_contents("php://input"));

if(isset($data->author) && isset($data->id)) {
  
  $author->id = $data->id;
  $author->author = $data->author;
  
  if($author->update()) {
    echo json_encode(
    array(
      'id' => $author->id,
      'author' => $author->author
    ));
    
  } else {
    echo json_encode(
    array(
      'message' => 'Author Not Updated'
    ));
  }
  
} else {
  echo json_encode(
  array(
    'message' => 'Missing Required Parameters'
  ));
}