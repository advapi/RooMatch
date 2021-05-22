<?php
    session_start();
    
    if (isset($_POST["update"])) {
            
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
       
       require_once 'db.inc.php';
       require_once 'functions.inc.php';
       
        
        $aptid = $_SESSION['aptid'];
        $set = array();
        $index=0;
       
        if(!isset($include_furniture) && !$_SESSION['furniture-checked']){
            $include_furniture = 0;
        }
        else{
            $include_furniture = 1;
        }
        
        if(!isset($parking) && !$_SESSION['parking-checked']){
            $parking = 0;
        }
        else{
            $parking = 1;
        }
        
        if(!isset($pets) && !$_SESSION['pets-checked']){
            $pets = 0;
        }
        else{
            $pets = 1;
        }
        
        if(!isset($smoking) && !$_SESSION['smoking-checked']){
            $smoking = 0;
        }
        else{
            $smoking = 1;
        }
        
        if(!isset($kosher) && !$_SESSION['kosher-checked']){
            $kosher = 0;
        }
        else{
            $kosher = 1;
        }
        
        if(!isset($vegetarian_or_vegan) && !$_SESSION['vegetarian_or_vegan-checked']){
            $vegetarian_or_vegan = 0;
        }
        else{
            $vegetarian_or_vegan = 1;
        }
        
        if(!empty($structure_type)){
            $set[$index] = "structure_type = '{$structure_type}'";
            $index++;    
        }
        
        if (!empty($city)){
            $set[$index] = "city = '{$city}'";
            $index++;   
        }
        
        if(!empty($street)){
            $set[$index] = "street = '{$street}'";
            $index++;
        }
        
        if(!empty($building_num)){
            $set[$index] = "building_num = '{$building_num}'";
            $index++;
        }
        
        if(!empty($rent)){
            $set[$index] = "rent = '{$rent}'";
            $index++;
        }
        
        if(!empty($room_num)){
            $set[$index] = "room_num = '{$room_num}'";
            $index++;    
        }
        
        if(!empty($rommates_num)){
            $set[$index] = "rommates_num = '{$rommates_num}'";
            $index++;    
        }
        
        if (!empty($min_age) && !empty($max_age)){
            if(ageRange($min_age, $max_age) !== false){
                $_SESSION['error'] = "agerange";
                header("Location: ../edit_apartment_details.php?".$aptid);
                exit();   
            }
            else{
                $set[$index] = "min_age = '{$min_age}'";
                $index++;
                $set[$index] = "max_age = '{$max_age}'";
                $index++;
            }
        }    
        else if(!empty($min_age) && empty($max_age)){
            if (ageRange($min_age, $_SESSION['maxage']) !== false){
                $_SESSION['error'] = "agerange";
                header("Location: ../edit_apartment_details.php?".$aptid);
                exit(); 
            }
            else{
                $set[$index] = "min_age = '{$min_age}'";
                $index++;
            }
        }
        else if(!empty($max_age) && empty($min_age)){
            if (ageRange($_SESSION['minage'], $max_age) !== false){
                $_SESSION['error'] = "agerange";
                header("Location: ../edit_apartment_details.php?".$aptid);
                exit(); 
            }
            else{
                $set[$index] = "max_age = '{$max_age}'";
                $index++;
            }   
        }
        
        if (!empty($move_in_date)){
            $check_date = date("d-m-Y", strtotime ($move_in_date));
            $original_date = date("d-m-Y", strtotime ($_SESSION['movedate']));
            if ($check_date < $original_date){
                $_SESSION['error'] = "moveindate";
                header("Location: ../edit_apartment_details.php?".$aptid);
                exit();   
            }
            else{
                $set[$index] = "move_in_date = '{$move_in_date}'";
                $index++;
            }
        }
        
        $set[$index] = "roommates_gender = '{$roommates_gender}'";
        $index++;
        $set[$index] = "clean_rank = '{$clean_rank}'";
        $index++;
        $set[$index] = "hosting_rank = '{$hosting_rank}'";
        $index++;
        $set[$index] = "include_furniture = '{$include_furniture}'";
        $index++;
        $set[$index] = "parking = '{$parking}'";
        $index++;
        $set[$index] = "pets = '{$pets}'";
        $index++;
        $set[$index] = "smoking = '{$smoking}'";
        $index++;
        $set[$index] = "kosher = '{$kosher}'";
        $index++;
        $set[$index] = "vegetarian_or_vegan = '{$vegetarian_or_vegan}'";
            
            
        $final_set= implode(", ", $set);
        $sql = "UPDATE apartments SET " .$final_set. " WHERE id=" .$aptid. ";";
            if ($conn->query($sql) === TRUE) {
                header("Location: ../edit_apartment_details.php?".$aptid);
                exit();            
            } else {
                echo "התרחשה שגיאה, נסה שנית מאוחר יותר <br> ". $conn->error;
                exit();
            }
       }
    else {
        header("location: ../edit_apartment_details.php");
        exit();
    } 

