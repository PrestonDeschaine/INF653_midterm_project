<?php 
$quote = new Quote($db);

if (isset($_GET['id'])) {
  $quote->id = $_GET['id'];
} else if (isset($_GET['authorId'], $_GET['categoryId'])) {
  $quote->author_id = $_GET['authorId'];
  $quote->category_id =  $_GET['categoryId'];
} else if (isset($_GET['authorId'])) {
  $quote->author_id = $_GET['authorId'];
} else if (isset($_GET['categoryId'])) {
  $quote->category_id = $_GET['categoryId'];   
} else {
  die();
}

$result = $quote->read_single();

$entries = $result->rowCount();

if ($entries === 1) {
  while($entries = $result->fetch(PDO::FETCH_ASSOC)) {
    extract($entries);
    
    $quote = array(
        'id' => $id,
        'quote' => html_entity_decode($quote),
        'author' => $author,
        'category' => $category
    );
  }
  echo json_encode($quote); 
}

else if ($entries > 0) {
  
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
  'message' => 'Quotes Found';
  
} else {
  echo json_encode(
  array(
    'message' => 'No Quotes Found'
  ));
}