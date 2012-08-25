<?php
  require('config/dbconfig.php');
  require('application/finder.php');
  require('application/load.php');
  require('application/model.php');
  require('application/controller.php');
  $C = new Controller;
  if (isset($_GET['format'])) $C->set_format(trim($_GET['format']));
  $C->render();
?>