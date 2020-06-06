<?php 
  require_once 'db_connect.php';
  include 'class-wine.php';
?>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!--<script src = "scripts.js"></script>-->
    <!--<link rel="stylesheet" type="text/css" href="style.css">-->
    <!--<link rel="shortcut icon" href="data:image/x-icon;," type="image/x-icon"> -->
    <title>Grape Minds</title>
</head>
<body>
<?php 
if(isset($_POST['submit'])){//do form action
  //$sql = "INSERT INTO MyGuests (firstname, lastname, email) VALUES ('John', 'Doe', 'john@example.com')";
  $name = $_POST['name'];
  $brand = $_POST['brand'];
  $query = "INSERT INTO wines (name, brand) VALUES ('$name', '$brand')";
  $result = $mysqli-> query($query);
  $message = ($result) ? "Table updated" : "Error, table not updated. ".$result;
  echo $message;

}
?>
<fieldset>
<h1>Grape Wines Drink Alike</h1>
<p>I know it looks like this website is entirely devoted to ranking wine</p>
<form action="index.php" method="post">
    <input type="text" placeholder="Name" name="name" id="name" required><label for="brand">Brand:</label>
    <select name="brand" id="brand"><?php 
      if ($results = $mysqli-> query("SELECT DISTINCT brand FROM wines")) {
        foreach($results as $result){
          echo "<option>".$result['brand']."</option>";
        }
      }   ?>
    </select>
    
    <label for="minutes">Alc/Vol:</label>
    <input type="number" name="volume" value="14" step="0.5">
    
    <label for="type">Type:</label>
    <select name="type" id="type">
      <option>White</option>
      <option>Red</option>
      <option>Rosé</option>
      <option>Other</option>
    </select>
    
    <!-- Haven't added this to the database yet, but thought it might be a good idea. 
    If possible, use AJAx to find the subtypes we've already added for the preselected main category-->
    <label for="type">Subtype:</label>
    <select name="subtype" id="subtype">
      <option>Other</option>
      <option>Cabernet</option>
      <option>Semillon</option>
      <option>Pinot Gris</option>
    </select>
    
    <input type="text" placeholder="Volume (mL)" name="volume" id="volume" >
    
    <input type="submit" name="submit" value="Add Wine">
    <!--<button onclick="add_wine()">Add!</button>-->
</form>
</fieldset>

<br/><hr><br/>
<?php 

echo "<h2>The Goodest Wines</h2>";
$query = "SELECT wine_id FROM wines";
if ($results = $mysqli-> query($query)) {
  echo "<table>";
  $name = NULL;
  foreach($results as $result){
    $wine = new Wine($result['wine_id']);
    if($wine->get_wine_info() != NULL){
      $wine_info = $wine->get_wine_info();
      echo "<tr><th colspan='2'>".$wine_info['wine_id'].": ".$wine_info['brand']."</th></tr><tr>";
      $rowspan = ($wine->ratings_count() >= 1) ? $wine->ratings_count() : 1;
      echo "<td rowspan='".$rowspan."'><img src='img.png'></td>";//format 300x300
    }
    if($wine->get_ratings() != NULL){
      $ratings = $wine->get_ratings();
      $i = 0;
      foreach($ratings as $rating){
        if($i>=1){echo "<tr>";}//start new row
        echo "<td>".$rating['ranker']." gave this wine ".$rating['rating']."/10.";
        if(isset($rating['comments'])){
          echo "<br/><i>'".$rating['comments']."'</i>";
        }
        echo "</td></tr>";
      }
    }else{
      echo "<td>This wine is missing a rating! Add your thoughts here:</td></tr>";
    }    
  }
  echo "</table>";
} 

?>





<script>
    function add_wine(){
        ajaxurl = 'add_wine.php',
        data =  {
    		'name': document.getElementById("name").value
    	};
        $.post(ajaxurl, data, function (response) {console.log(response)});
        document.body.appendChild(document.createTextNode("Added successfully"));
    }
</script>

</body>