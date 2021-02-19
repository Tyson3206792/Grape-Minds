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
  <div class="row">
  <div class="col-md-2"></div>
  <div class="col-md-8">
    <form method="post" onsubmit="search.php">
      <table>
        <h3>Fill out one or more fields</h3>
        <tr><td>
        <label for="keyword">Keyword:</label>
        <input type="text" name="keyword" id="keyword">
        </tr></td>
        <tr><td>
          <label for="brand">Brand:</label>
          <select name="brand" id="brand"><?php
            echo "<option></option>";
            if ($results = $mysqli-> query("SELECT DISTINCT brand FROM wines")) {
              foreach($results as $result){
                echo "<option>".$result['brand']."</option>";
              }
            }?>
          </select>
        </tr></td>
        <tr><td>
          <label for="strength">Alc/Vol (%):</label>
          <input type="number" name="strength" id="strength" value="" step="0.5">
        </tr></td>
        <tr><td>
          <label for="volume">Size (mL):</label>
          <input type="number" name="volume" id="volume" value="" step="125">
        </tr></td>
        <tr><td>
          <label for="type">Type:</label>
          <select name="type" id="type">
            <option></option>
            <option>White</option>
            <option>Red</option>
            <option>Rosé</option>
            <option>Other</option>
          </select>
        </tr></td>
        <tr><td>
        <tr><td>
          <label for="brand">Subtype:</label>
          <select name="subtype" id="subtype"><?php
            echo "<option></option>";
            if ($results = $mysqli-> query("SELECT DISTINCT subtype FROM wines")) {
              foreach($results as $result){
                echo "<option>".$result['subtype']."</option>";
              }
            }?>
          </select>
        </tr></td>
        <tr><td>
          <label for="price">Price ($):</label>
          <input type="number" name="price" id="price">
        </tr></td>
        <tr><td><br/>
          <div id='error_message'></div>
          <input type="submit" class="submit" name="submit" value="Search">
        </tr></td>


      </table>
    </form>
    </div>
    <div class="col-md-2"></div>
  </div>
  <div class="row">
    <div class="col-md-12"><hr></div>
  </div>

  <div class="row">
    <div class="col-md-12"><h2>Results</h2></div>
  </div>
<?php

if(isset($_POST['submit'])){
  $form_keyword = ($_POST['keyword']) ? "'%".mysqli_real_escape_string($mysqli, $_POST["keyword"])."%'" : "NULL";
  $form_brand = ($_POST['brand']) ? "'".mysqli_real_escape_string($mysqli, $_POST['brand'])."'" : "NULL";
  $form_strength = ($_POST['strength']) ? "'".mysqli_real_escape_string($mysqli, $_POST['strength'])."'" : "NULL";
  $form_volume = ($_POST['volume']) ? "'".mysqli_real_escape_string($mysqli, $_POST['volume'])."'" : "NULL";
  $Form_type = ($_POST['type']) ? "'".mysqli_real_escape_string($mysqli, $_POST['type'])."'" : "NULL";
  $form_subtype = ($_POST['subtype']) ? "'".mysqli_real_escape_string($mysqli, $_POST['subtype'])."'" : "NULL";
  $form_price = ($_POST['price']) ? "'".mysqli_real_escape_string($mysqli, $_POST['price'])."'" : "NULL";
  $query = "CALL SearchWines(".$form_keyword.",".$form_brand.",".$form_strength.",".$form_volume.",".$Form_type.",".$form_subtype.",".$form_price.")";
  echo $query;
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
}

echo "</div>";//closing container tag

?>
  </div>
</div>
</body>
