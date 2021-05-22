<?php
    include("templates/header.php");
?>
        <main>
            <section class="password-reset-form">
                <div class="container">
                    <form id="signup" action="includes/reset-request.inc.php" method="post">
                        <div class="header text-center">
                            <h3>אתחול סיסמה</h3>
                        </div>
                        <div class="sep"></div>
                        <div class="inputs" dir="rtl">
                            <p class="text-center" dir="rtl">הזן כתובת מייל כדי לקבל לינק לאיפוס סיסמה</p>
                            <input type="email" name="mail" placeholder="הזן כתובת מייל..">
                            <button id="submit" class="btn btn-info" type="submit" name="reset-request-submit"> שלח </button>
                            <div class="error text-center">
                                <?php
                                    if(isset($_GET["error"])){
                                        if($_GET["error"] == "emptyinput"){
                                            echo "<p dir='rtl'> אנא מלא את כתובת המייל! </p>";
                                        }
                                    }
                                    else if (isset($_GET["reset"])){
                                        if($_GET["reset"] == "success"){
                                            echo "<p dir='rtl'> המייל נשלח בהצלחה! בדוק את תיבת המייל שלך </p>";
                                        }
                                    }
                                ?>
                            </div>
                        </div>
                    </form>
                </div>
            </section>    
        </main>
    </body>
</html>