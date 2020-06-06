<?php 
    $conn = establish_connection();        // Create connection
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $sql = "INSERT INTO wines(name) VALUES('".$_POST['name']."')";
    $conn->query($sql);
    echo $sql;
    $conn->close();
 
    function establish_connection(){
       /* $servername = "localhost";
        $username = "tysonjgr_main";
        $password = "#B=_KZ!^GSfy";
        $dbname = "tysonjgr_wines";*/
        
        $servername = "localhost";
        $username = "admin";
        $password = "";
        $dbname = "test";
        
    
        // Create connection
        return new mysqli($servername, $username, $password, $dbname);
    }