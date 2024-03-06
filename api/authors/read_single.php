<?php 
$author = new Author($db);

$author->id = isset($_GET['id']) ? $_GET['id'] : die();

if ($author->read_single()) {
  echo json_encode(
  array(
    'id' => $author->id,
    'author' => $author->author
    'message' => 'Author Retrieved Successfully'
  ));
} else {
  echo json_encode(
  array(
    'message' => 'author_id Not Found'
  ));
}