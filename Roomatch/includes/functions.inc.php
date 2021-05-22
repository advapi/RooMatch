<?php
    //signup functions
    function emptyInputSignup($username, $email, $password, $first_name, $last_name, $birth_date, $gender){
        $result;
        if (empty($username) || empty($email) || empty($password) || empty($first_name) || empty($last_name) || empty($birth_date) || empty($gender)){
            $result = true;
        }
        else {
            $result = false;
        }
        return $result;
    }
    
    function invalidUsername($username){
        $result;
        $regexp="#^[\p{Hebrew} a-zA-Z0-9]{2,15}$#u";
        if (!preg_match($regexp, $username)){
            $result = true;
        }
        else {
            $result = false;
        }
        return $result;
    }
    
    function invalidEmail($email){
        $result;
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $result = true;
        }
        else {
            $result = false;
        }
        return $result;
    }
    
    function pwdMtach($password, $pwdRepeat){
        $result;
        if ($password !== $pwdRepeat){
            $result = true;
        }
        else {
            $result = false;
        }
        return $result;
    }
    
    function userExists($conn, $username, $email){
        $sql = "SELECT * FROM users WHERE username = ? OR email = ?;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)){
            header("location: ../signup.php?error=stmtfailed");
            exit();
        }
        
        mysqli_stmt_bind_param($stmt, "ss", $username, $email);
        mysqli_stmt_execute($stmt);
        
        $resultData = mysqli_stmt_get_result($stmt);
        
        if ($row = mysqli_fetch_assoc($resultData)){
            return $row;
        }
        else {
            $result = false;
            return $result;
        }
        
        mysqli_stmt_close($stmt);
    }
    
    function usernameExists($conn, $username){
        $sql = "SELECT * FROM users WHERE username = ?;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)){
            header("location: ../signup.php?error=stmtfailed");
            exit();
        }
        
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        
        $resultData = mysqli_stmt_get_result($stmt);
        
        if ($row = mysqli_fetch_assoc($resultData)){
            return $row;
        }
        else {
            $result = false;
            return $result;
        }
        
        mysqli_stmt_close($stmt);
    }
    
    function emailExists($conn, $email){
        $sql = "SELECT * FROM users WHERE email = ?;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)){
            header("location: ../signup.php?error=stmtfailed");
            exit();
        }
        
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        
        $resultData = mysqli_stmt_get_result($stmt);
        
        if ($row = mysqli_fetch_assoc($resultData)){
            return $row;
        }
        else {
            $result = false;
            return $result;
        }
        
        mysqli_stmt_close($stmt);
    }
    
    function ageGate($birth_date){
        $result;
        $changeDate = date("Y-m-d", strtotime($birth_date));
        $today = date("Y-m-d");
        $diff = date_diff(date_create($today), date_create($birth_date));
        $yearsDiff= $diff->format('%y');
        if ($yearsDiff < 18){
            $result = true;
        }
        else{
            $result = false;
        }
        return $result;
    }
    
    function firstNameCheck($first_name){
        $result;
        $regexp="#^[\p{Hebrew}]{2,15}$#u";
        if (!preg_match($regexp, $first_name)){
            $result = true;
        }
        else {
            $result = false;
        }
        return $result;
    }
    
    function lastNameCheck($last_name){
        $result;
        $regexp="#^([\p{Hebrew}]{2,}\s?(\p{Hebrew})?)$#u";
        if (!preg_match($regexp, $last_name) || strlen($last_name) > 20){
            $result = true;
        }
        else {
            $result = false;
        }
        return $result;
    }
    
    function descriptionCheck($description){
        $result;
        $regexp="/^[\p{Hebrew} a-zA-Z .?,?\r\n?*?@?!]+$/u";
        if (!preg_match($regexp, $description) || strlen($description) > 600){
            $result = true;
        }
        else {
            $result = false;
        }
        return $result;
    }
    
    function uploadImg($filename, $newname){
        $result;
        if(move_uploaded_file($filename, '../uploads/'.$newname)){
            $result = false;
        }
        else{
            $result = true;
        }
        return $result;
    }
    
    function validUrl($url){
        $result;
        if(filter_var($url, FILTER_VALIDATE_URL)){
            $result = false;
        }
        else{
            $result = true;
        }
        return $result;
    }
    
    function createUser($conn, $username, $email, $password, $first_name, $last_name, $birth_date, $gender,$newname){
        $sql = "INSERT INTO users (username, email, password, first_name, last_name, birth_date, gender, user_img) VALUES (?, ?, ?, ?, ?, ?, ?, ?);";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)){
            header("location: ../signup.php?error=stmtfailed");
            exit();
        }
        
        $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
        
        mysqli_stmt_bind_param($stmt, "ssssssss", $username, $email, $hashedPwd, $first_name, $last_name, $birth_date, $gender, $newname);
        mysqli_set_charset($conn, 'utf8mb4');
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("location: ../login.php?error=none");
        exit();
    }
    
    //login functions
    function emptyInputlogin($username, $pwd){
        $result;
        if (empty($username) || empty($pwd)){
            $result = true;
        }
        else {
            $result = false;
        }
        return $result;
    }
    
    function loginUser($conn, $username, $pwd){
        $user = userExists($conn, $username, $username);
        
        if($user === false){
            header("location: ../login.php?error=wronglogin");
            exit();
        }
        
        $pwdHashed = $user["password"];
        $checkPwd = password_verify($pwd, $pwdHashed);
        
        if ($checkPwd === false){
            header("location: ../login.php?error=wronglogin");
            exit();
        }
        else if ($checkPwd === true){
            session_start();
            $_SESSION["id"] = $user["id"];
            $_SESSION["username"] = $user["username"];
            header("location: ../index.php");
            exit();
        }
    }
    
    function emptyInputResetRequest($mail){
        $result;
        if (empty($mail)){
            $result = true;
        }
        else {
            $result = false;
        }
        return $result;
    }
    
    //add new apartment functions
    function emptyInputApartment($street, $building_num, $rent, $min_age, $max_age, $move_in_date){
        $result;
        if (empty($street) || empty($building_num) || empty($rent) || empty($min_age) || empty($max_age) || empty($move_in_date)){
            $result = true;
        }
        else {
            $result = false;
        }
        return $result;
    }
    
    // search apartment
    function emptyInputSearch($rent, $min_age, $max_age){
        $result;
        if (empty($rent) && empty($min_age) && empty($max_age)){
            $result = true;
        }
        else {
            $result = false;
        }
        return $result;
    }
    
    function moveDate($move_in_date){
        $result;
        $changeDate = date("Y-m-d", strtotime($move_in_date));
        $today = date("Y-m-d");
        if ($changeDate < $today){
            $result = true;
        }
        else{
            $result = false;
        }
        return $result;
    }
    
    function ageRange($min_age, $max_age){
        $result;
        if ($min_age > $max_age){
            $result = true;
        }
        else{
            $result = false;
        }
        return $result;
    }
    
    function createApartment($conn,$user_id, $structure_type, $city, $street, $building_num, $rent, $room_num, $rommates_num, $min_age, $max_age, $move_in_date, $roommates_gender, $clean_rank, $hosting_rank, $include_furniture, $parking, $pets, $smoking, $kosher, $vegetarian_or_vegan){
        $sql = "INSERT INTO apartments (user_id, structure_type, city, street, building_num, rent, room_num, rommates_num, min_age, max_age, move_in_date, roommates_gender, clean_rank, hosting_rank, include_furniture, parking, pets, smoking, kosher, vegetarian_or_vegan) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)){
            header("location: ../add_new_apartment.php?error=stmtfailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "ssssssssssssssssssss", $user_id, $structure_type, $city, $street, $building_num, $rent, $room_num, $rommates_num, $min_age, $max_age, $move_in_date, $roommates_gender, $clean_rank, $hosting_rank, $include_furniture, $parking, $pets, $smoking, $kosher, $vegetarian_or_vegan);
        mysqli_set_charset($conn, 'utf8mb4');
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    
    
    
    
    
    