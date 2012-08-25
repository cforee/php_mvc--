<?php

// this function serves as (sort of) a simplified ORM layer,
// so we're not passing direct "mysql_query" commands to the DB
function db_query($query) {
  $result = mysql_query($query) or die(mysql_error());
  $data = array();
  $n = 0;
  if ($result == 1) {
    // if this query returned a success flag vs. a row, return true
    return true;
  }
  while ($row = mysql_fetch_assoc($result)) {
    $data[$n] = $row;
    $n++;
  }
  return $data;
}

?>
