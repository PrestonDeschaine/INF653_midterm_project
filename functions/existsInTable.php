<?php
function existsInTable($id, $model) {
  $model->id = $id;
  if ($model->read_single()) {
      return true;
  }
  return false;
}