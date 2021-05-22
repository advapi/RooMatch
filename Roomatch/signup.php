<?php
    include("templates/header.php");
?>
        
        <section class="signup-form">
            <div class="container">
                <form id="signup" action="includes/signup.inc.php" method="post" enctype="multipart/form-data">
                    <div class="header text-center">
                        <h3>טופס הרשמה</h3>
                        <small class="text-danger"><b>יש למלא את כל השדות בטופס</b></small>
                    </div>
                    <div class="sep"></div>
                    <div class="inputs" dir="rtl">
                        <div>
                            <label for="img" dir="rtl" class="float-right">ניתן להעלות קבצים מסוג: jpeg/png/jpg/gif</label>
                            <div class="clearfix"></div>
                            <small id="error-img" class="error d-blobk float-right" dir="rtl"></small>
                            <div class="clearfix"></div>
                            <input id="img" name="img" type="file" required accept=".png, .jpg, .jpeg, .gif" onchange="fileValidation()">
                        </div>
                        <input type="text" name="username" placeholder="הזן שם משתמש.." autofocus > 
                        <input type="email" name="email" placeholder="הזן כתובת מייל.." autofocus >
                        <input type="password" name="password" placeholder="הזן סיסמה.." autofocus > 
                        <input type="password" name="pwdRepeat" placeholder="הזן סיסמה בשנית.." autofocus >
                        <sub><p class="text-right mt-2 pt-0">  יש להזין בין 2 ל-15 תווים בשפה העברית בלבד(לא ניתן להזין רווח/ space)  </p> </sub>
                        <input type="text" name="first_name" placeholder="הזן שם פרטי.." autofocus >
                        <sub><p class="text-right mt-2 pt-0">  יש להזין בין 2 ל-20 תווים בשפה העברית בלבד(ניתן להזין רווח/ space)  </p> </sub>
                        <input type="text" name="last_name" placeholder="הזן שם משפחה.." autofocus >
                        <div class="checkboxy text-right mr-4" dir="rtl">
                            <label> תאריך לידה:
                                <input type="date" name="birth_date">
                            </label>
                            <p>אנא בחר את המגדר שלך:</p>
                            <input type="radio" id="male" name="gender" value="גבר">
                            <label for="male">גבר</label><br>
                            <input type="radio" id="female" name="gender" value="אישה">
                            <label for="female">אישה</label><br>
                            <input type="radio" id="other" name="gender" value="אחר">
                            <label for="other">אחר</label><br>
                        </div>
                        <button id="submit" class="btn btn-info" type="submit" name="Submit"> לחץ להרשמה </button>
                        <div class="error text-center">
                            <?php
                                if(isset($_GET["error"])){
                                    if($_GET["error"] == "emptyinput"){
                                        echo "<p dir='rtl' class='mx-auto' style='width: 50%;'> אנא מלא את כל השדות! </p>";
                                    }
                                    else if ($_GET["error"] == "invalidusername"){
                                        echo "<p dir='rtl' class='mx-auto' style='width: 50%;'> אנא בחר שם משתמש בין 2 ל- 15 תווים עם אותיות בעברית או אותיות באנגלית או מספרים </p>";
                                    }
                                    else if ($_GET["error"] == "invalidemail"){
                                        echo "<p dir='rtl' class='mx-auto' style='width: 50%;'> אנא הזן כתובת מייל תקינה </p>";
                                    }
                                    else if ($_GET["error"] == "passwordsdontmatch"){
                                        echo "<p dir='rtl' class='mx-auto' style='width: 50%;'> הסיסמאות אינן תואמות </p>";
                                    }
                                    else if ($_GET["error"] == "usernametaken"){
                                        echo "<p dir='rtl' class='mx-auto' style='width: 50%;'> שם המשתמש ו/או כתובת המייל תפוסים. אנא בחר שם משתמש/כתובת מייל אחרים </p>";
                                    }
                                    else if ($_GET["error"] == "stmtfailed"){
                                        echo "<p dir='rtl' class='mx-auto' style='width: 50%;'> משהו השתבש. אנא נסה שנית </p>";
                                    }
                                    else if ($_GET["error"] == "agegate"){
                                        echo "<p dir='rtl' class='mx-auto' style='width: 50%;'> לא ניתן להרשם לאתר. ההרשמה מתאפשרת מגיל 18 ומעלה </p>";
                                    }
                                    else if ($_GET["error"] == "firstname"){
                                        echo "<p dir='rtl' class='mx-auto' style='width: 50%;'> השם הפרטי שהזנת אינו חוקי. אנא הזן שם לפי ההוראות </p>";
                                    }
                                    else if ($_GET["error"] == "lastname"){
                                        echo "<p dir='rtl' class='mx-auto' style='width: 50%;'> שם המשפחה שהזנת אינו חוקי. אנא הזן שם לפי ההוראות </p>";
                                    }
                                    else if ($_GET["error"] == "img"){
                                        echo "<p dir='rtl' class='mx-auto' style='width: 50%;'> לא הצלחנו להעלות את התמונה שבחרת. אנא נסה שנית </p>";
                                    }
                                }
                                else if(isset($_GET["newuser"])){ ?>
                                    <script>
                                        swal("?רוצה לצפות בפרטים", "!כדי לצפות בפרטי המודעה עליך להירשם תחילה לאתר", "info");
                                    </script>
                                <?php
                                }
                            ?>
                        </div>
                        <p dir="rtl" class="text-center">יש לך משתמש קיים? <a href="login.php">לחץ להתחברות</a></p>
                    </div>
                </form>
            </div>
        </section>
        <script>
            // validate image type
            function fileValidation() { 
                var fileInput = document.getElementById('img'); 
                var filePath = fileInput.value; 
                // Allowing file type
                //Whole combination is means, follow by dot “.” and string end in “jpg” or “png” or “gif” or “jpeg” , and the file extensive is case-insensitive.
                var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i; 
                if (!allowedExtensions.exec(filePath)) { 
                    document.getElementById("error-img").innerHTML = "סוג קובץ לא תקין. אנא בחר תמונה אחרת";
                    fileInput.value = '';
                    document.getElementById('Image').focus();
                    return false; 
                }  
                else { 
                    document.getElementById("error-img").innerHTML = "";
                    return true;
                } 
            }
        </script>
    </body>
</html>