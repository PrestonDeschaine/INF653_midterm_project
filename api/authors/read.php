<?php
$author = new Author($db);

$result = $author->read();

$entries = $result->rowCount();

if ($entries > 0) {
  
  $authors_arr = array();

  while($entries = $result->fetch(PDO::FETCH_ASSOC)) {
    extract($entries);

    $author_item = array(
        'id' => $id,
        'author' => $author
    );

    array_push($authors_arr, $author_item);
  }

  echo json_encode($authors_arr);
  echo json_encode(array('message' => 'Authors Found'));
  
} else {
  echo json_encode(array('message' => 'No Authors Found'));
}