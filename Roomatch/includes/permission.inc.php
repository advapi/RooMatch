<?php
        session_start();
        require_once("db.inc.php");
        if (isset($_SESSION["id"])){
            $sql = "SELECT * FROM users WHERE id= {$_SESSION["id"]};";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                // conditions for publishing new apartment
                if (isset($_POST['create-apt'])){
                    if($row['ad_counter'] >= 5 && $row['status'] == 0 ){
                        header("location: ../paypal.php?needtoupgrade");
                        exit();
                    } else{
                        header("Location: ../add_new_apartment.php");
                        exit();            
                    }    
                }
                
                // conditions for watching apartment details
                if (isset($_POST['apt-page'])){
                    if($row['display_details_counter'] >= 5 && $row['status'] == 0 ){
                        header("location: ../paypal.php?needtoupgrade");
                        exit();
                    } else{
                        $_SESSION['aptid'] = $_POST['apt-id'];
                        $count = $row['display_details_counter'] + 1;
                        $sql = "UPDATE users SET display_details_counter={$count} WHERE id=" .$_SESSION["id"]. ";";
                        if ($conn->query($sql) === TRUE) {
                            header("Location: ../apartment.php");
                            exit();            
                        } else {
                            echo "התרחשה שגיאה, נסה שנית מאוחר יותר <br> ". $conn->error;
                            exit();
                        }
                    }    
                }
            }
        }
        else{
            header("Location: ../signup.php?newuser");
            exit();
        }
        
