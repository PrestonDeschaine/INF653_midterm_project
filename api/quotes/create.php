<?php
// This PHP script handles the creation of a new quote.
// It receives JSON data containing the quote and stores it in the database.
// It returns a JSON response with the new quote's ID and a message.

$quote = new Quote($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

//Check for required data
if (!empty($data->quote)) {
  $quote->quote = $data->quote;

  //Create quote with id
  if ($quote->create()) {
    echo json_encode(
      array(
        'id' => $quote->id,
        'quote' => $quote->quote,
        'message' => 'Quote Created'
      )
    );
  } else {
    echo json_encode(
      array('message' => 'Quote Not Created')
    );
  }
}
?>
