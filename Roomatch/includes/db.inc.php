<?php

	$host = "localhost";  
	$user = "advapi_admin";
	$pass = "Rm22021";
	$db = "advapi_roomatch";
	//create connection
	$conn = mysqli_connect($host,$user,$pass,$db);
	mysqli_set_charset($conn, 'utf8mb4'); 
	if (!$conn){
            die("Connection failed: " .mysqli_connect_error());
    }
