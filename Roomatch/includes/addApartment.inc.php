<?php
    session_start();
    
    if (isset($_POST["add-apartment"])) {
        
       $structure_type = $_POST["structure_type"];    
       $city = $_POST["city"];
       $street = $_POST["street"];
       $building_num = $_POST["building_num"];
       $rent = $_POST["rent"];
       $room_num = $_POST["room_num"];
       $rommates_num = $_POST["rommates_num"];
       $min_age = $_POST["min_age"];
       $max_age = $_POST["max_age"];
       $move_in_date = $_POST["move_in_date"];
       $roommates_gender = $_POST["roommates_gender"];
       $clean_rank = $_POST["clean_rank"];
       $hosting_rank = $_POST["hosting_rank"];
       $include_furniture = $_POST["include_furniture"];
       $parking = $_POST["parking"];
       $pets = $_POST["pets"];
       $smoking = $_POST["smoking"];
       $kosher = $_POST["kosher"];
       $vegetarian_or_vegan = $_POST["vegetarian_or_vegan"];
       //allowed extensions
       $extension = array('jpeg', 'jpg', 'png', 'gif');
       
       
       require_once 'db.inc.php';
       require_once 'functions.inc.php';
       
        
       if(!$_POST['structure_type'] || !$_POST["city"] || !$_POST["room_num"] || !$_POST["rommates_num"] || !$_POST["roommates_gender"] || !$_POST["clean_rank"] || !$_POST["hosting_rank"] || emptyInputApartment($street, $building_num, $rent, $min_age, $max_age, $move_in_date) !== false){
           header("location: ../add_new_apartment.php?error=emptyinput");
           exit();
       }
       else{
            if(!isset($include_furniture)){
                $include_furniture = 0;
            }
            if(!isset($parking)){
                $parking = 0;
            }
            if(!isset($pets)){
                $pets = 0;
            }
            if(!isset($smoking)){
                $smoking = 0;
            }
            if(!isset($kosher)){
                $kosher = 0;
            }
            if(!isset($vegetarian_or_vegan)){
                $vegetarian_or_vegan = 0;
            }
            
            if (moveDate($move_in_date) !== false){
               header("location: ../add_new_apartment.php?error=moveindate");
               exit();
            }
            
            if (ageRange($min_age, $max_age) !== false){
               header("location: ../add_new_apartment.php?error=agerange");
               exit();
            }
            
            $user_id = $_SESSION['id'];
            createApartment($conn, $user_id, $structure_type, $city, $street, $building_num, $rent, $room_num, $rommates_num, $min_age, $max_age, $move_in_date, $roommates_gender, $clean_rank, $hosting_rank, $include_furniture, $parking, $pets, $smoking, $kosher, $vegetarian_or_vegan);   
            
            $apt_id = mysqli_insert_id($conn);
            
            foreach($_FILES['img']['name'] as $key => $value){
               //full name of the users img
               $imgname = $_FILES['img']['name'][$key];
               //tmp name
               $tmpname = $_FILES['img']['tmp_name'][$key];
               // file extensions
               $ext = pathinfo($imgname, PATHINFO_EXTENSION);
               //new name with user id
               $newname = $_SESSION['id'].$apt_id.mt_rand(0,100).".".$ext;
               while(file_exists('../uploads/'.$newname)){
                    $newname = $_SESSION['id'].$apt_id.mt_rand(0,100).".".$ext;
               }
               
               if(in_array($ext, $extension)){
                    if (!move_uploaded_file($tmpname, '../uploads/' . $newname)){
                        header("location: ../add_new_apartment?error=imgnotuploaded");
                        exit();
                    }
                    $sql = "INSERT INTO apartmentImg (apt_id, img) VALUES ($apt_id, '$newname');";
                    if ($conn->query($sql) === TRUE) {
                        header("Location: ../addList.php");
                    } else {
                        echo "התרחשה שגיאה. נסה שנית מאוחר יותר <br> ". $conn->error;
                        exit();
                    }
               }
               else{
                    header("location: ../add_new_apartment.php?error=imgext");
                    exit();
               }
               
            }
            
            $sql = "SELECT * FROM users WHERE id= {$_SESSION["id"]};";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $count = $row['ad_counter'] + 1;
                $sql = "UPDATE users SET ad_counter={$count} WHERE id=" .$_SESSION["id"]. ";";
                    if ($conn->query($sql) === TRUE) {
                        header("Location: ../addList.php");
                        exit();            
                    } else {
                        echo "התרחשה שגיאה, נסה שנית מאוחר יותר <br> ". $conn->error;
                        exit();
                    }
            }
       }
    }
    else {
        header("location: ../add_new_apartment.php");
        exit();
    } 

