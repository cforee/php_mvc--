<?php

// route to controller methods based on URL params
// this file is included from inside Controller &
// expects $this->location to be set
$action = '';
if (isset($_GET['action'])) $action = ereg_replace("[^A-Za-z0-9\_\-]", "", $_GET['action']);

switch ($this->location) {
  case 'home':
    $this->home($action);
    break;
  default:
    $this->home();
    break;
}
?>
