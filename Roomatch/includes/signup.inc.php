<?php
    
    if (isset($_POST["Submit"])) {
        
       $username = $_POST["username"];
       $email = $_POST["email"];
       $password = $_POST["password"];
       $pwdRepeat = $_POST["pwdRepeat"];
       $first_name = $_POST["first_name"];
       $last_name = $_POST["last_name"];
       $birth_date = $_POST["birth_date"];
       $gender = $_POST["gender"];
       //img details
       //full name of the users img
       $imgname = $_FILES['img']['name'];
       //only the extension of the file
       $extension = pathinfo($imgname, PATHINFO_EXTENSION);

       require_once 'db.inc.php';
       require_once 'functions.inc.php';
       
       if (emptyInputSignup($username, $email, $password, $first_name, $last_name, $birth_date, $gender) !== false){
           header("location: ../signup.php?error=emptyinput");
           exit();
       }
       
        if (invalidUsername($username) !== false){
           header("location: ../signup.php?error=invalidusername");
           exit();
       }
       
        if (invalidEmail($email) !== false){
           header("location: ../signup.php?error=invalidemail");
           exit();
       }
       
       if (pwdMtach($password, $pwdRepeat) !== false){
           header("location: ../signup.php?error=passwordsdontmatch");
           exit();
       }
       
       if (userExists($conn, $username, $email) !== false){
           header("location: ../signup.php?error=usernametaken");
           exit();
       }
       
        if (ageGate($birth_date) !== false){
           header("location: ../signup.php?error=agegate");
           exit();
       }
       
       if (firstNameCheck($first_name) !== false){
           header("location: ../signup.php?error=firstname");
           exit();
       }
       
        if (lastNameCheck($last_name) !== false){
           header("location: ../signup.php?error=lastname");
           exit();
       }
       
       // save the full name with the new name and extension
       $newname = $username.".".$extension;
       $filename = $_FILES['img']['tmp_name'];
       
       if (uploadImg($filename, $newname) !== false){
           header("location: ../signup.php?error=img");
           exit();
       }
       
       
       createUser($conn, $username, $email, $password, $first_name, $last_name, $birth_date, $gender,$newname);
        
    }
    else {
        header("location: ../signup.php");
        exit();
    }
