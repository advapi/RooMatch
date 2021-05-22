<?php

    require_once 'functions.inc.php';

    if (isset($_POST["reset-request-submit"])){
        $mail = $_POST[mail];
        
        if (emptyInputResetRequest($mail) !== false){
           header("location: ../reset_password.php?error=emptyinput");
           exit();
        }
        
        $selector = bin2hex(openssl_random_pseudo_bytes(4));
        $token = openssl_random_pseudo_bytes(16);
        
        $url = "https://advapi.mtacloud.co.il/create-new-password.php?selector=" . $selector . "&validator=" . bin2hex($token);
    
        $expires = date("U") + 1800;
        
        require 'db.inc.php';
        
        $sql = "DELETE FROM pwdReset WHERE pwdResetEmail=?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)){
            echo "התרחשה שגיאה, נסה שנית מאוחר יותר";
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt, "s", $mail);
            mysqli_stmt_execute($stmt);
        }
        
        $sql = "INSERT INTO pwdReset (pwdResetEmail, pwdResetSelector, pwdResetToken, pwdResetExpires) VALUES (?, ?, ?, ?);";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)){
            echo "התרחשה שגיאה, נסה שנית מאוחר יותר";
            exit();
        }
        else{
            $hashedToken = password_hash($token, PASSWORD_DEFAULT);
            mysqli_stmt_bind_param($stmt, "ssss", $mail, $selector, $hashedToken, $expires);
            mysqli_stmt_execute($stmt);
        }
        
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        
        $to = $mail;
        
        $subject = "איפוס סיסמה RooMatch";
        
        $message = '<p dir="rtl">קיבלנו בקשה לאיפוס סיסמה. הלינק לאיפוס הסיסמה מצורף מטה, אם לא אתה ביקשת לאפס סיסמה התעלם ממייל זה.</p>';
        
        $message .='<p dir="rtl">לינק לאיפוס סיסמה: <br>';
        $message .= '<a href ="' . $url . '">' . $url . '</a></p>';
        
        $headers = "From: RooMatch <RooMatchIL@gmail.com>\r\n";
        $headers .= "Reply-To: RooMatchIL@gmail.com\r\n";
        $headers .= "Content-type: text/html\r\n";
        
        mail($to, $subject, $message, $headers);
        
        header("location: ../reset_password.php?reset=success");
        exit();
        
    }
    else {
        header("location: ../index.php");
        exit();
    }
    
