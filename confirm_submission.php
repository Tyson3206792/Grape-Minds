<?php
require_once 'db_connect.php';
if(isset($_POST['submit'])){//do form action
  //$sql = "INSERT INTO MyGuests (firstname, lastname, email) VALUES ('John', 'Doe', 'john@example.com')";
  $picture = "img.png";//$_POST['picture'];
  $name = ($_POST['name']) ? mysqli_real_escape_string($mysqli, $_POST['name']) : NULL;
  $brand = ($_POST['brand']) ? mysqli_real_escape_string($mysqli, $_POST['brand']) : NULL;
  $strength = ($_POST['strength']) ? $_POST['strength'] : NULL;
  $volume = ($_POST['volume']) ? $_POST['volume']  : NULL;
  $type = ($_POST['type']) ? mysqli_real_escape_string($mysqli, $_POST['type']) : NULL;
  $subtype = ($_POST['subtype']) ? mysqli_real_escape_string($mysqli, $_POST['subtype']) : NULL;
  $query = "INSERT INTO wines (name, brand, strength, volume, type, subtype) VALUES ('$name', '$brand', '$strength', '$volume', '$type', '$subtype')";
  $result = $mysqli->query($query);
  $message = ($result) ? "Table updated" : "Error: ".$mysqli->error;
  echo $message;
}