<?php
    session_start();
    if (isset($_POST["update"])) {
        
       $username = $_POST["username"];
       $email = $_POST["email"];
       $password = $_POST["password"];
       $pwdRepeat = $_POST["pwdRepeat"];
       $first_name = $_POST["first_name"];
       $last_name = $_POST["last_name"];
       $birth_date = $_POST["birth_date"];
       $gender = $_POST["gender"];
       $description = $_POST["description"];
       $facebook = $_POST["facebook"];
       $instagram = $_Post['instagram'];
       
       require_once 'db.inc.php';
       require_once 'functions.inc.php';
       $set = array();
       $index=0;
       
       if(empty($username) && empty($email) && empty($password) && empty($first_name) && empty($last_name) && empty($birth_date) && empty($gender) && empty($description) && empty($facebook) && empty($instagram)){
            header("location: ../private_profile.php?error=noinput");
            exit();
       }
       else{
            if (!empty($username)){
                if (invalidUsername($username) !== false){
                   header("location: ../private_profile.php?error=invalidusername");
                   exit();
               }
               else if(usernameExists($conn, $username) !== false){
                   header("location: ../private_profile.php?error=usernametaken");
                   exit();
               }
               else{
                   $set[$index] = "username = '{$username}'";
                   $index++;
               }
           }
           
           if (!empty($email)){
                if (invalidEmail($email) !== false){
                   header("location: ../private_profile.php?error=invalidemail");
                   exit();
               }
               else if(emailExists($conn, $email) !== false){
                   header("location: ../private_profile.php?error=emailtaken");
                   exit();
               }
               else{
                   $set[$index] = "email = '{$email}'";
                   $index++;
               }
           }
           
           if (!empty($password)){
                if (pwdMtach($password, $pwdRepeat) !== false){
                   header("location: ../private_profile.php?error=passwordsdontmatch");
                   exit();
               }
               else{
                   $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
                   $set[$index] = "password = '{$hashedPwd}'";
                   $index++;
               }
           }
           
           if (!empty($birth_date)){
                if (ageGate($birth_date) !== false){
                   header("location: ../private_profile.php?error=agegate");
                   exit();
               }
               else{
                   $set[$index] = "birth_date = '{$birth_date}'";
                   $index++;
               }
           }
           
           if(!empty($first_name)){
                if (firstNameCheck($first_name) !== false){
                   header("location: ../private_profile.php?error=firstname");
                   exit();
               }
               else{
                   $set[$index] = "first_name = '{$first_name}'";
                   $index++;
               }
           }
           
           if(!empty($last_name)){
                if (lastNameCheck($last_name) !== false){
                   header("location: ../private_profile.php?error=lastname");
                   exit();
               }   
               else{
                   $set[$index] = "last_name = '{$last_name}'";
                   $index++;
               }
           }
           
           if(!empty($facebook)){
                if (validUrl($facebook) !== false){
                   header("location: ../private_profile.php?error=facebook");
                   exit();
               }   
               else{
                   $set[$index] = "facebook = '{$facebook}'";
                   $index++;
               }
           }
           
           if(!empty($instagram)){
                if (validUrl($instagram) !== false){
                   header("location: ../private_profile.php?error=instagram");
                   exit();
               }   
               else{
                   $set[$index] = "instagram = '{$instagram}'";
                   $index++;
               }
           }
           
           if(!empty($description)){
                if (descriptionCheck($description) !== false){
                   header("location: ../private_profile.php?error=description");
                   exit();
               }   
               else{
                   $set[$index] = "description = '{$description}'";
               }
           }
           
            
            $final_set= implode(", ", $set);
            $sql = "UPDATE users SET " .$final_set. " WHERE id=" .$_SESSION['id']. ";";
            if ($conn->query($sql) === TRUE) {
                header("Location: ../private_profile.php?updated");
                exit();            
            } else {
                echo "התרחשה שגיאה, נסה שנית מאוחר יותר <br> ". $conn->error;
                exit();
            }
       }
    }
    else {
        header("location: ../private_profile.php");
        exit();
    }
