<?php
    include("templates/header.php");
?>
        
        <section class="login-form">
            <div class="container">
                <form id="signup" action="includes/login.inc.php" method="post">
                    <div class="header text-center">
                        <h3>התחבר למערכת</h3>
                    </div>
                    <div class="sep"></div>
                    <div class="inputs" dir="rtl">
                        <input type="text" name="user" placeholder="הזן שם משתמש\כתובת מייל..">
                        <input type="password" name="password" placeholder="הזן סיסמה..">
                        <button id="submit" class="btn btn-info" type="submit" name="submit"> התחבר </button>
                        <div class="error text-center">
                            <?php
                                if(isset($_GET["error"])){
                                    if($_GET["error"] == "emptyinput"){
                                        echo "<p dir='rtl'> אנא מלא את כל השדות! </p>";
                                    }
                                    else if ($_GET["error"] == "wronglogin"){
                                        echo "<p dir='rtl'> שם המשתמש או הסיסמה שהזנת אינם נכונים </p>";
                                    }
                                    else if ($_GET["error"] == "none"){
                                        echo "<p dir='rtl' class='mx-auto' style='width: 50%;'> נרשמת בהצלחה למערכת!הזן את פרטיך כדי להתחבר </p>";
                                    }
                                }
                                else if(isset($_GET["newpwd"])){
                                    if($_GET["newpwd"] == "passwordupdated"){
                                        echo "<p dir='rtl' class='text-center'> הסיסמה התעדכנה בהצלחה! </p>";
                                    }
                                }
                            ?>
                        </div>
                        <p dir="rtl" class="text-center"> שכחת את הסיסמה? <a href="reset_password.php">לחץ כאן לאיפוס סיסמה</a></p>
                        <p dir="rtl" class="text-center">עדיין לא נרשמת למערכת? <a href="signup.php">לחץ להרשמה</a>
                    </div>
                </form>
            </div>
        </section>
    </body>
</html>