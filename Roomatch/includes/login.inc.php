<?php

    if (isset($_POST["submit"])){
        $username = $_POST[user];
        $pwd = $_POST["password"];
        
        require_once 'db.inc.php';
        require_once 'functions.inc.php';
        mysqli_set_charset($conn, 'utf8mb4');
        
        if (emptyInputlogin($username, $pwd) !== false){
           header("location: ../login.php?error=emptyinput");
           exit();
        }
        
        loginUser($conn, $username, $pwd);
    }
    else{
        header("location: ../login.php?welcome");
        exit();
    }
    