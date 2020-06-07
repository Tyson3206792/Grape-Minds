<?php 
require_once 'db_connect.php';
include 'class-wine.php';

//image stuff
$data = $_POST['picture'];
$file = 'images/'.'change_this_to_name'.'.png';

// remove "data:image/png;base64,"
$uri =  substr($data,strpos($data,",") +1);

// save to file
file_put_contents($file, base64_decode($uri));

// return the filename
echo json_encode($file);

if(false){     //Change to if picture gets saved successfully
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
}
?>