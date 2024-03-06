<?php
$category = new Category($db);

$result = $category->read();

$entries = $result->rowCount();

if ($entries > 0) {
  
  $categories = array();

  while($entries = $result->fetch(PDO::FETCH_ASSOC)) {
    extract($entries);

    $category_item = array(
        'id' => $id,
        'category' => $category
    );

    array_push($categories, $category_item);
  }

  echo json_encode($categories);
  echo json_encode(array('message' => 'Categories Found'));
  
} else {
  echo json_encode(array('message' => 'No Categories Found'));
}