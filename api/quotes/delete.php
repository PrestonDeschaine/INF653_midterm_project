<?php 
$quote = new Quote($db);

$data = json_decode(file_get_contents("php://input"));

if (isset($data->id)) {
  $quote->id = $data->id;
  
  if($quote->delete()) {
    echo json_encode(
    array(
      'id' => $quote->id
    ));
  } else {
    echo json_encode(
    array(
      'message' => 'No Quotes Found'
    ));
  }
} else {
  echo json_encode(
  array(
    'message' => 'Missing Required Parameters'
  ));
}