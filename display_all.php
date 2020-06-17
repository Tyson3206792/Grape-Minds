<head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!--<script src = "scripts.js"></script>-->
  <link rel="stylesheet" type="text/css" href="style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

  <title>Grape Minds</title>
</head>
<body>

<?php 
require_once 'db_connect.php';
include 'class-wine.php';
include 'navigation_bar.php';

if(isset($_POST['wine_id'])){
    $ranker = ($_POST['ranker']) ? mysqli_real_escape_string($mysqli, $_POST['ranker']) : NULL;
    $comments = ($_POST['comments']) ? mysqli_real_escape_string($mysqli, $_POST['comments']) : NULL;
    $rating = ($_POST['rating']) ? $_POST['rating'] : NULL;
    $wine_id = ($_POST['wine_id']) ? $_POST['wine_id']  : NULL;
    $query = "INSERT INTO rating (wine_id, comments, ranker, rating) VALUES ('$wine_id', '$comments', '$ranker', '$rating')";
    $result = $mysqli->query($query);
    $message = ($result) ? "Table updated" : "Error: ".$mysqli->error;
    echo $message;
}

if(isset($_POST['wine_id']) || isset($_GET['wine_id'])){//display information for a specific wine
  $wine_id = (isset($_POST['wine_id'])) ? $_POST['wine_id'] : $_GET['wine_id'];
  $wine = new Wine($wine_id);
  if($wine){
    $wine_info = $wine->get_wine_info();
    echo "Viewing wine: ".$wine_info['name'];
    $wine->add_rating();
  }
  
}



echo "<h2>Display all wines</h2>";
$query = "SELECT wine_id FROM wines";
if ($results = $mysqli-> query($query)) {
  $name = NULL;
  foreach($results as $result){
    $wine = new Wine($result['wine_id']);
    if($wine->get_wine_info() != NULL){
      $wine_info = $wine->get_wine_info();
      echo "<hr><table>";
      echo "<tr><td width = 40% rowspan='7'><img width=100% src='images/wine_".$wine_info['wine_id'].".png'></td>";
      echo "<th>".$wine_info['name']."</th></tr>";
      echo "<tr><td>".$wine_info['brand']."</td></tr>";
      echo "<tr><td>".$wine_info['strength']."%</td></tr>";
      echo "<tr><td>".$wine_info['volume']."mL</td></tr>";
      echo "<tr><td>".$wine_info['type']."</td></tr>";
      echo "<tr><td>".$wine_info['subtype']."</td></tr>";
      echo "<tr><td>$".$wine_info['price']."</td></tr>";
      echo "</table>";
    }  
  }
} 