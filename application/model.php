<?php

class Model {

  // NOTE: table name constants are defined in dbconfig.php

  // find by id if available
  // else find by conditions if no id is provided
  public function find($table_name, $conditions = "1=1") {
    if (is_numeric($conditions)) {
       // id was passed in, find a single row in $table_name by id
       $conditions = ("id = '" . $conditions . "'");
    }
    // conditions were passed in, find rows where conditions are true
    $query = ("SELECT COUNT(*) AS row_count FROM " . $table_name . ' WHERE ' . $conditions);
    $data = db_query($query);
    if ((int)$data[0]['row_count'] < 1) return false;
    $query = ("SELECT *, UNIX_TIMESTAMP(updated_at) FROM " . $table_name . ' WHERE ' . $conditions);
    return db_query($query);
  }
  
  public function find_join($table_one, $table_two, $id_one, $id_two, $conditions = null, $order_by = null) {
    $query_body = ("FROM " . 
                   $table_two . " RIGHT JOIN " . $table_one . 
                   " ON " . 
                   $table_two . "." . $id_two . 
                   " = " . 
                   $table_one . "." . $id_one);
    if ($conditions != null) {
      $query_body .= (" WHERE " . $conditions);
    }
    $query_body .= (" GROUP BY " . $table_one . ".id");
    if(isset($order_by)) $query_body .= (" ORDER BY " . $table_one . '.' . $order_by);
    $query_prefix = ("SELECT COUNT(*) AS row_count ");
    $data = db_query($query_prefix . $query_body);
    if ((int)$data[0]['row_count'] < 1) return false;
    $query_prefix = ("SELECT *, UNIX_TIMESTAMP(" . $table_one . ".updated_at) AS timestamp ");
    return db_query($query_prefix . $query_body);
  }

  // try and create a record in table $table_name, and return the record
  public function create($table_name, $data) {
    // pull client timestamp if possible for updated_at
    if (isset($_GET['ts'])) {
      $ts = trim($_GET['ts']);
      $client_timestamp = preg_replace('/[^0-9-]/', '', $ts);
    }
    if ($current_record = $this->identical_record_exists($table_name, $data)) {
      // if an identical record already exists, return it (skip create)
      return $current_record;
    }
    // initialize container arrays for params and their associated values
    $fields = array();
    $values = array();
    // build query parameters
    foreach ($data as $field => $value) {
      array_push($fields, $field);
      array_push($values, ("'" . htmlspecialchars($value) . "'"));
    }
    // join query parameters
    $fields = implode(',', $fields);
    $values = implode(',', $values);
    // build query
    $query = ("INSERT INTO " . $table_name . "(" . $fields . ",updated_at) VALUES (" . $values . ", NOW())");
    $data = db_query($query);
    // insert is successful, return inserted record
    $query = ("SELECT * FROM " . $table_name . " WHERE id = " . mysql_insert_id());
    return db_query($query);
  }

  public function update($table_name, $data) {
    // TBD
  }

  public function destroy($table_name, $id) {
    // ensure first that target row exists in $table_name
    $query = ("SELECT COUNT(*) as row_count FROM " . $table_name . " WHERE id = " . $id);
    $data = db_query($query);
    if ((int)$data[0]['row_count'] < 1) {
      // target row did not exist, do nothing and return true
      return true;
    }
    // target row exists, delete it and return true on success
    $query = ("DELETE FROM " . $table_name . " WHERE id = " . $id);
    db_query($query) or die(mysql_error());
    return true;
  }

  public function validate_thing($user, $format = 'html') {
    // add validation logic here
    return $thing;
  }
  
  // check if an record with identical values exists inside $table_name's
  // if a record already exists, return it
  private function identical_record_exists($table_name, $data) {
    $conditions = (" WHERE ");
    $particles = array();
    foreach ($data as $field => $value) {
       array_push($particles, ($field . " = '" . $value . "'"));
    }
    $conditions .= implode(' AND ',$particles);
    $query = ("SELECT COUNT(*) AS row_count FROM " . $table_name . ' ' . $conditions);
    $data = db_query($query);
    if ((int)$data[0]['row_count'] < 1) return false;
    $query = ("SELECT * FROM " . $table_name . ' ' . $conditions);
    return db_query($query);
  }

}

?>
