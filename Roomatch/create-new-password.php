<?php
    include("templates/header.php");
?>
        
        <section class="password-reset-form">
            <div class="container">
                <?php
                    $selector = $_GET["selector"];
                    $validator = $_GET["validator"];
                    
                    if (empty($selector) || empty($validator)){
                        echo "לא הצלחנו לאמת את בקשתך";
                    }
                    else {
                        if (ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false){
                ?>
                            <form id="signup" name="form" action="includes/reset-password.inc.php" method="post">
                                <div class="header text-center">
                                    <h3>בחירת סיסמה</h3>
                                </div>
                                    <div class="sep"></div>
                                    <div class="inputs" dir="rtl">
                                        <input type="hidden" name="selector" value="<?php echo $selector ?>">
                                        <input type="hidden" name="validator" value="<?php echo $validator ?>">
                                        <input id="pwd1" type="password" name="pwd" placeholder="הזן סיסמה חדשה.." required>
                                        <input id="pwd2" type="password" name="pwd-repeat" placeholder="הזן סיסמה בשנית.." required>
                                        <input id="submit" class="btn btn-info" type="submit" name="reset-password-submit" value="אפס סיסמה" onClick="return checkPass()">
                                        <div class="error text-center">
                                            <p id="error"></p>
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    function checkPass(){
                                        var pwd1  = document.getElementById("pwd1").value;
                                        var pwd2  = document.getElementById("pwd2").value;
                                        if(pwd1 != pwd2){
                                            document.getElementById("error").innerHTML = "הסיסמאות אינן תואמות. הזמן סיסמאות בשנית";
                                            return false;
                                        }
                                        else{
                                            document.getElementById("error").innerHTML = "";
                                        }
                                        return true;   
                                    }
                                </script>
                            </form>
                <?php
                        }
                    }
                    
                ?>

            </div>
        </section>
    </body>
</html>