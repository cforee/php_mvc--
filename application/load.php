<?php
  class Load {
    function view($filename, $data = null) {
      if (!isset($_GET['format'])) include('views/' . $filename . '.php');
      else if (strtolower($_GET['format']) == 'json') include('views/' . $filename . '.json.php');
    }
  }
?>
