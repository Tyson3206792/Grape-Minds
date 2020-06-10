<?php 
  require_once 'db_connect.php';
  include 'class-wine.php';
?>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!--<script src = "scripts.js"></script>-->
    <link rel="stylesheet" type="text/css" href="style.css">
    <!--<link rel="shortcut icon" href="data:image/x-icon;," type="image/x-icon"> -->
    <title>Grape Minds</title>
</head>
<body>
<!--<?php include 'confirm_submission.php';?>//do form action when submitted -->

<h1>Grape Wines Drink Alike</h1>
<form action="" method="post" onsubmit="add_wine()">
  <table>
    <tr><th></th>
    <th colspan='3'><input type="text" placeholder="Label Description" name="name" id="name" required></th>
    </tr>
    <tr><td><label for="brand">Brand:</label><br/>Add new: <input type='checkbox' style='float:right;'></td>
    <td colspan='3'>
      <select name="brand" id="brand" style='float:right;'><?php 
        if ($results = $mysqli-> query("SELECT DISTINCT brand FROM wines")) {
          foreach($results as $result){
            echo "<option>".$result['brand']."</option>";
          }
        }?>
      </select></td>
    </tr>
    <tr><td><label for="original_picture">Picture:</label></td>
    <td colspan='3'><input type="button" value="Add Image" onclick="take_image()">
      <canvas type="file" id="picture" width="720" height="200" style="border:1px solid #d3d3d3;"></td>
          <!--sort out image size next-->
    </tr>  
    <tr><td width='25%'><label for="strength">Alc/Vol (%):</label></td>
    <td width='25%'><input type="number" name="strength" id="strength" value="14" step="0.5" style='max-width: 6em;'></td>
    <td width='25%'><label for="volume">Size (mL):</label></td>
    <td width='25%'><input type="number" name="volume" id="volume" value="750" step="125" style='max-width: 6em;'></td>
    </tr>  
    <tr><td><label for="type">Type:</label></td>
    <td colspan='3'><select name="type" id="type">
        <option>White</option>
        <option>Red</option>
        <option>Rosé</option>
        <option>Other</option>
      </select></td>
    </tr>  
    <tr><td><label for="subtype">Subtype:</label></td>
    <td colspan='3'>
    <!-- If possible, use AJAx to find the subtypes we've already added for the preselected main category-->
      <select name="subtype" id="subtype">
        <option>Other</option>
        <option>Cabernet</option>
        <option>Semillon</option>
        <option>Pinot Gris</option>
      </select></td>
    </tr>  
    <tr><td><label for="price">Price ($):</label></td>
    <td colspan='3'>
      <input type="number" name="price" id="price">
      </td></tr> 
    <tr><td colspan='4'><br/>
      <input type="submit" name="submit" class="submit" value="Add Wine">
      </td></tr>  
    
    <tr><td colspan='4'><br/>
      <input type="button" value="Test submit without reload" onclick="add_wine()">
      </td></tr>  
    
    
  </table>
</form>
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
      echo "<td>This wine is missing a rating! Add your thoughts here:";
      ?>
      <form><input type='text' placeholder='Add your comments here' name='comments'>
      <input type='number' value='5' min="1" max="10" step=".01" name='rating'>
      <select name='ranker'>
        <option>Both</option>
        <option>Claire</option>
        <option>Tyson</option>
      </select>
      <input type='submit' value='Add Rating'></form>
      <?php
      echo "</td></tr>";
     
    }    
  }
  echo "</table>";
} 

?>





<script>
    function add_wine(){    //Sends all form information to php file to save
        ajaxurl = 'add_wine.php',
        data =  {
        'name': document.getElementById("name").value,
        'brand': document.getElementById("brand").value,
        'picture': dataURL,
        'strength': document.getElementById("strength").value,
        'volume': document.getElementById("volume").value,
        'type': document.getElementById("type").value,
        'subtype': document.getElementById("subtype").value,
        'price': document.getElementById("price").value
      };
        $.post(ajaxurl, data, function (response) {console.log(response)});
        document.body.appendChild(document.createTextNode("Added successfully"));
        console.log("done");
    }
  
var dataURL;
    var c = document.getElementById("picture");  //Canvas
    var ctx = c.getContext("2d");
    c.style.display="none";
    
    function take_image(){  //Creates a file upload button and clicks it. that way can style our own button onstead of custom file type button
        var input = document.createElement("input");
        input.type = "file";
        input.addEventListener('change', add_to_canvas);
        input.click();
    }
    
    function add_to_canvas(e){
        var img = new Image();
        img.src = URL.createObjectURL(e.target.files[0]);
        img.onload = function() {
            console.log(img.width);
            console.log(img.height);
            ratio = img.height/img.width;
            c.height = c.width*ratio;
            console.log(ratio);
            console.log(c.height);
            ctx.drawImage(img, 0, 0, c.width, c.height);
            dataURL = c.toDataURL();
            c.style.display="";
        }
    }

</script>

</body>