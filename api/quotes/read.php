<?php
$quote = new Quote($db);

$result = $quote->read();

$entries = $result->rowCount();

if ($entries > 0) {
  
  $quotes = array();

  while($entries = $result->fetch(PDO::FETCH_ASSOC)) {
    extract($entries);
    
    $quote_item = array(
        'id' => $id,
        'quote' => html_entity_decode($quote),
        'author' => $author,
        'category' => $category
    );

    array_push($quotes, $quote_item);
  }

  echo json_encode($quotes);
  echo json_encode(array('message' => 'Quotes Found'));
  
} else {
  echo json_encode(array('message' => 'No Quotes Found'));
}