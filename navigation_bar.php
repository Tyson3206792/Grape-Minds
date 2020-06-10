<!-- Navbar (sit on top) -->
<div class="topnav" id="myTopnav">
  <a href="index.php" class="fa fa-home">HOME</a>
  <a href="display_all.php" class="fa fa-glass">WINES</a>
  <a href="javascript:void(0);" style="font-size:34px;" class="icon" onclick="show_menu()">&#9776;</a>
</div>

<script>
function show_menu() {
  var x = document.getElementById("myTopnav");
  if (x.className === "topnav") {
    x.className += " responsive";
  } else {
    x.className = "topnav";
  }
}
</script>