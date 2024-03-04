<?php
// This PHP script handles the creation of a new author.
// It receives JSON data containing the author and stores it in the database.
// It returns a JSON response with the new author's ID and a message.

$author = new Author($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

//Check for required data
if (!empty($data->author)) {
  $author->author = $data->author;

  //Create author with id
  if ($author->create()) {
    echo json_encode(
      array(
        'id' => $author->id,
        'author' => $author->author,
        'message' => 'Author Created'
      )
    );
  } else {
    echo json_encode(
      array('message' => 'Author Not Created')
    );
  }
}
?>
