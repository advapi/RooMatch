<?php
    session_start();
    if (isset($_POST["update-img"])) {
        $oldImg = $_SESSION['img'];
       $username = $_SESSION["username"];
       //img details
       //full name of the users img
       $imgname = $_FILES['img']['name'];
       //only the extension of the file
       $extension = pathinfo($imgname, PATHINFO_EXTENSION);
       // save the full name with the new name and extension
       $newname = $username.".".$extension;
       $filename = $_FILES['img']['tmp_name'];
       
       require_once 'db.inc.php';
       require_once 'functions.inc.php';
       unlink('../uploads/'.$oldImg);
       if (uploadImg($filename, $newname) !== false){
           header("location: ../private_profile.php?error=profileimg");
           exit();
       } else{
           $sql = "UPDATE users SET user_img = '$newname' WHERE id=" .$_SESSION["id"]. ";";
            if ($conn->query($sql) === TRUE) {
                header("Refresh:0.5; url=../private_profile.php");
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
