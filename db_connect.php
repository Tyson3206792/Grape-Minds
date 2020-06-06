<?php


function establish_connection(){
    return establish_local_connection();
    //return establish_main_connection();
}

 // Create connection
$mysqli = establish_connection();//can use as variable or can use function


//=========Helper Methods=========

function establish_local_connection(){     
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "test";
      
    // Create connection
    return new mysqli($servername, $username, $password, $dbname);
}

function establish_main_connection(){
    $servername = "localhost";
    $username = "tysonjgr_main";
    $password = "#B=_KZ!^GSfy";
    $dbname = "tysonjgr_wines";
      
    // Create connection
    return new mysqli($servername, $username, $password, $dbname);
}