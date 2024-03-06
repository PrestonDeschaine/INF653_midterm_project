<?php 
$quote = new Quote($db);

$data = json_decode(file_get_contents("php://input"));

if(isset($data->id) && isset($data->quote) && 
   isset($data->author_id) && isset($data->category_id)) {
  
  $quote->id = $data->id;
  $quote->quote = $data->quote;
  $quote->author_id = $data->author_id;
  $quote->category_id = $data->category_id;

  if (!existsInTable($data->author_id, new Author($db))) {
    echo json_encode(
      array(
        'message' => 'author_id Not Found'
      ));
  } else if (!existsInTable($data->category_id, new Category($db))) {
    echo json_encode(
      array(
        'message' => 'category_id Not Found'
      ));
  } else {
    if($quote->update()) {
      echo json_encode(
      array(
        'id' => $quote->id,
        'quote' => $quote->quote,
        'author_id' => $quote->author_id,
        'category_id' => $quote->category_id
      ));
      
    } else {
      echo json_encode(
      array(
        'message' => 'No Quotes Found'
      ));
    }
  }
    
  
} else {
  echo json_encode(
  array(
    'message' => 'Missing Required Parameters'
  ));
}