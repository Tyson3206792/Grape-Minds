<head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!--<script src = "scripts.js"></script>-->
  <link rel="stylesheet" type="text/css" href="style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <!-- Latest compiled JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta charset="utf-8">
  <title>Grape Minds</title>
</head>

<?php
  require_once 'db_connect.php';
  include 'class-wine.php';
  include 'navigation_bar.php';
?>

<body>
<div id='message'></div>
<div class="container">

<?php

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
  ?><div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
    <?php
    $wine_id = (isset($_POST['wine_id'])) ? $_POST['wine_id'] : $_GET['wine_id'];
    $wine = new Wine($wine_id);
    if($wine){
      $wine_info = $wine->get_wine_info();
      echo "<h2>Wine: ".$wine_info['name']."</h2>";
      $wine->add_rating();
    }
    echo "</div>";
    echo "<div class='col-md-2'></div></div>";
    echo "<div class='row'><div class='col-md-12'><hr></div></div>";

}

?><div class="container">
  <div class="row">
    <div class="col-md-12"><h2>Display all wines</h2></div>
  </div>
<?php

$query = "SELECT wine_id FROM wines";
if ($results = $mysqli-> query($query)) {
  $name = NULL;
  foreach($results as $result){
    $wine = new Wine($result['wine_id']);
    if($wine->get_wine_info() != NULL){
      $wine_info = $wine->get_wine_info();
      ?><div class="row">
        <div class="col-md-4"><img width=100% src='images/wine_<?php echo $wine_info['wine_id']; ?>.png'></div>
        <div class="col-md-8">
          <?php
          foreach($wine_info as $key=>$data){
            if($key != "wine_id" && $key != "picture"){
              echo "<div class='row'><div class='col-md-12'>".ucwords($key).": ".$data."</div></div>";
            }
          }
          ?>
          <div class='row'><div class='col-md-12'>
          <form action="" method="get">
            <input type="hidden" name="wine_id" value="<?php echo $result['wine_id'];?>">
            <input type="submit" value="Edit Wine">
          </form></div></div>
          <?php
        echo "</div>";
      echo "</div>";
    }
  }
}

echo "</div>";//closing container tag
