<?php
// This PHP script handles the creation of a new category.
// It receives JSON data containing the category and stores it in the database.
// It returns a JSON response with the new category's ID and a message.

$category = new Category($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

//Check for required data
if (!empty($data->category)) {
  $category->category = $data->category;

  //Create category with id
  if ($category->create()) {
    echo json_encode(
      array(
        'id' => $category->id,
        'category' => $category->category,
        'message' => 'Category Created'
      )
    );
  } else {
    echo json_encode(
      array('message' => 'Category Not Created')
    );
  }
}
?>
