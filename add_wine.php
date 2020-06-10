<?php 
require_once 'db_connect.php';
include 'class-wine.php';


$wine_id = '1';             //get id of next row to be inserted
$query = "SELECT * FROM wines ORDER BY wine_id DESC LIMIT 1";  //get most recent wine
if ($result = $mysqli->query($query)) {
    $row = $result->fetch_row();
    $wine_id = $row[0] +1;   //increment for next row
}
echo 'wine_id: '.$wine_id;

//image stuff
$data = $_POST['picture'];
$file = 'images/wine_'.$wine_id.'.png';
$uri =  substr($data,strpos($data,",") +1);         // remove "data:image/png;base64,"
file_put_contents($file, base64_decode($uri));      // save to file
echo json_encode($file);                            // return the filename

if (file_exists($file)) {   //Change to if picture gets saved successfully
    //$sql = "INSERT INTO MyGuests (firstname, lastname, email) VALUES ('John', 'Doe', 'john@example.com')";
    $name = ($_POST['name']) ? mysqli_real_escape_string($mysqli, $_POST['name']) : NULL;
    $brand = ($_POST['brand']) ? mysqli_real_escape_string($mysqli, $_POST['brand']) : NULL;
    $strength = ($_POST['strength']) ? $_POST['strength'] : NULL;
    $volume = ($_POST['volume']) ? $_POST['volume']  : NULL;
    $type = ($_POST['type']) ? mysqli_real_escape_string($mysqli, $_POST['type']) : NULL;
    $subtype = ($_POST['subtype']) ? mysqli_real_escape_string($mysqli, $_POST['subtype']) : NULL;
    $price = ($_POST['price']) ? mysqli_real_escape_string($mysqli, $_POST['price']) : NULL;
    $query = "INSERT INTO wines (wine_id, name, brand, strength, volume, type, subtype, price) VALUES ('$wine_id', '$name', '$brand', '$strength', '$volume', '$type', '$subtype', '$price')";
    $result = $mysqli->query($query);
    $message = ($result) ? "Table updated" : "Error: ".$mysqli->error;
    echo $message;
}
else{
    echo 'file does not exist';
}
?>