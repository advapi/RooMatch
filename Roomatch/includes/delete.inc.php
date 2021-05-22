<?php
    
    if (isset($_POST["delete"])){
        require_once 'db.inc.php';
               
        $id = $_POST['id'];
        $sql = "SELECT * FROM apartmentImg WHERE apt_id = " .$id. ";";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($rowx = mysqli_fetch_array($result)){
                unlink('../uploads/'.$rowx["img"]);
            }
        }
        $sql = "DELETE FROM apartmentImg WHERE apt_id = ?;" ;
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)){
            echo "התרחשה שגיאה, נסה שנית מאוחר יותר";
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt, "s", $id);
            mysqli_stmt_execute($stmt);
            $sql = "DELETE FROM apartments WHERE id = ?;" ;
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)){
                echo "התרחשה שגיאה, נסה שנית מאוחר יותר";
                exit();
            }
            else{
                mysqli_stmt_bind_param($stmt, "s", $id);
                mysqli_stmt_execute($stmt);
                header("Location: ../addList.php?delete=success");
                exit();            
            }
        }
    }
    else {
        header("Location: ../addList.php");
        exit();
    }
