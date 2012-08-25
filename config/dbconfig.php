<?php

  // db connections
  $dbhost = 'localhost';
  $dbuser = 'dbuser';
  $dbpass = 'dbpass';
  $dbname = 'dbname';
  $dbh = mysql_connect("$dbhost", "$dbuser", "$dbpass") 
    or die ("Could not connect: " . mysql_error());
  mysql_select_db("$dbname") or die ("Could not connect to db: " . mysql_error());

  // table definitions
  define("FOO", "foo");
  
?>
