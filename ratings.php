<?php 
require_once 'db_connect.php';
include 'class-wine.php';

if(isset($_POST['submit'])){//do form action
  //$sql = "INSERT INTO MyGuests (firstname, lastname, email) VALUES ('John', 'Doe', 'john@example.com')";
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
  


  //image stuff
 
  $target_dir = "images/";
  $target_file = $target_dir . basename($_FILES["picture"]["name"]);
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  // Check if image file is a actual image or fake image
  if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["picture"]["tmp_name"]);
    if($check !== false) {
      echo "File is an image - " . $check["mime"] . ".";
      $uploadOk = 1;
    } else {
      echo "File is not an image.";
      $uploadOk = 0;
    }
  }

  $extension = end(explode(".", $_FILES["picture"]["name"]));       // \/ change below to name of image \/
  if (move_uploaded_file($_FILES["picture"]["tmp_name"], $target_dir."changeThisToFileName.".$extension)) {
    echo "The file ". basename( $_FILES["picture"]["name"]). " has been uploaded.";
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}
?>
<br/><a href='index.php'><button>Return home</button></a>
<h2>Ratings Page</h2>