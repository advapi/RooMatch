<?php
    include("templates/header.php");
    require_once("includes/db.inc.php");
    $sql = "SELECT * FROM users WHERE id=" .$_SESSION["id"]. ";";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['img'] = $row['user_img'];
    }
?>
        <section class="container">
            <div class="page-head mt-5">
                <div class="text-center">
                    <h4 class="profile-header"><b>הפרופיל שלי </b></h4>
                    <form class="form-div" action="includes/update-user-profile.inc.php" method="post" enctype="multipart/form-data">
                        <div class="img-container text-center">
                            <img class='rounded' src='<?php echo "uploads/".$row["user_img"];?>' id="user-img" height='200' width='200' onclick="inputClick()">
                            <input type="file" name="img" id="img" required accept=".png, .jpg, .jpeg, .gif" onchange="fileValidation()">
                        </div>
                        <button id="submit" class="profile-img" type="submit" name="update-img">החלף תמונה</button>    
                        <div>לחץ על התמונה כדי להעלות תמונה חדשה</div>                    
                    </form>
                </div>
                <hr>
            </div>
            <?php
                        if ($row['status'] == 0){
                            echo "<h4 class='text-center'> מנוי חינמי </h4>";
                        }
                        else if ($row['status'] == 1){
                            echo "<h4 class='text-center'> מנוי פרימיום<i class='fas fa-star'></i> </h4>";
                        }
                    ?>
            <div class="mt-5 mb-3 text-center" dir="rtl">
                <form action="includes/update-user-details.inc.php" method="post">
                    <div class="row">
                        <div class="col-2">
                            <label for="username">שם משתמש</label>
                        </div>
                        <div class="col-10">
                            <input type="text" id="username" name="username" placeholder=<?php echo $row["username"]; ?> >
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <label for="password">בחירת סיסמה חדשה:</label>
                        </div>
                        <div class="col-10">
                            <input class="mb-2" type="password" id="pwd1" name="password" placeholder="הזן סיסמה.." autofocus onblur="enablePwd()"> 
                            <input class="mb-2" type="password" id="pwd2" name="pwdRepeat" placeholder="הזן סיסמה בשנית.." autofocus disabled>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <label for="email">דואר אלקטרוני</label>
                        </div>
                        <div class="col-10">
                            <input type="email" id="email" name="email" placeholder=<?php echo $row["email"]; ?>  >
                        </div>
                    </div>
                    <div class="row">
                        <small class="col-10 mr-2 text-primary">יש להזין בין 2 ל-15 תווים בשפה העברית בלבד(לא ניתן להזין רווח/ space)  </small>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <label for="first_name">שם פרטי </label>
                        </div>
                        <div class="col-10">
                            <input type="text" id="first_name" name="first_name" placeholder=<?php echo $row["first_name"]; ?> >
                        </div>
                    </div>    
                    <div class="row">
                        <small class="col-10 mr-1 text-primary">יש להזין בין 2 ל-20 תווים בשפה העברית בלבד(ניתן להזין רווח/ space)   </small>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <label for="last_name">שם משפחה </label>
                        </div>
                        <div class="col-10">
                            <input type="text" id="last_name" name="last_name" placeholder=<?php echo $row["last_name"]; ?> >
                        </div>
                    </div>   
                    <div class="row">
                        <div class="col-2">
                            <label for="birth_date">תאריך לידה  </label>
                        </div>
                        <div class="col-10">
                            <?php $date = date("d-m-Y", strtotime ($row['birth_date'])); ?>
                            <input type="text" id="birth_date" name="birth_date" onfocus="(this.type='date')" onblur="(this.type='text')" placeholder="<?php echo $date ; ?>" >    
                        </div>
                    </div>   
                    <div class="row">
                        <div class="col-2">
                            <label for="gender">מגדר</label>
                        </div>
                        <div class="col-10">
                            <input type="text" id="gender" name="gender" placeholder= <?php echo $row["gender"]; ?>  >    
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <label for="facebook">לינק לפייסבוק </label>
                        </div>
                        <div class="col-10">
                            <input type="text" id="facebook" name="facebook" placeholder=<?php echo $row["facebook"]; ?> >
                        </div>
                    </div>  
                    <div class="row">
                        <div class="col-2">
                            <label for="instagram">לינק לאינסטגרם</label>
                        </div>
                        <div class="col-10">
                            <input type="text" id="instagram" name="instagram" placeholder=<?php echo $row["instagram"]; ?> >
                        </div>
                    </div>  
                    <div class="row">
                        <div class="col-2">
                            <label for="description">תיאור</label>
                        </div>
                        <div class="col-10">
                            <?php
                                if (empty($row["description"])){ ?>
                                    <textarea id="description" name="description" placeholder= "על מנת לסייע לך למצוא את השותפים המתאימים ביותר עבורך אנו ממליצים לכתוב על עצמך במספר מילים "  style="height:200px"></textarea>
                            <?php } else { ?>
                                    <textarea id="description" name="description" placeholder= "<?php echo $row["description"]; ?> "  style="height:200px"></textarea>  
                            <?php } ?>
                        </div>
                    </div>
                    <br>
                    <div class="text-center mb-3">
                        <button type="submit" class="btn btn-info btn-lg" name="update"> עדכן פרטים! </button>
                    </div>
              </form>
            </div>
        </section>
        <?php
        if(isset($_GET["error"])){
            if($_GET["error"] == "noinput"){
                echo '<script>
                    swal("!שגיאה", " כל השדות ריקים ולכן לא עודכנו נתונים", "error");
                </script>';
            }
            else if ($_GET["error"] == "invalidusername"){
                echo '<script>
                    swal("!שגיאה", " אנא בחר שם משתמש בין 2 ל- 15 תווים עם אותיות בעברית או אותיות באנגלית או מספרים", "error");
                </script>';
            }
            else if ($_GET["error"] == "invalidemail"){
                echo '<script>
                    swal("!שגיאה", " אנא הזן כתובת מייל תקינה", "error");
                </script>';
            }
            else if ($_GET["error"] == "passwordsdontmatch"){
                echo '<script>
                    swal("!שגיאה", " הסיסמאות אינן תואמות. אנא בחר סיסמה בשנית", "error");
                </script>';
            }
            else if ($_GET["error"] == "usernametaken" || $_GET["error"] == "emailtaken"){
                echo '<script>
                    swal("!שגיאה", " שם המשתמש ו/או כתובת המייל תפוסים. אנא בחר שם משתמש/כתובת מייל אחרים", "error");
                </script>';
            }
            else if ($_GET["error"] == "agegate"){
                echo '<script>
                    swal("!שגיאה", "לפי תאריך הלידה נראה שישנה טעות. הגיל שלך נמוך מ-18. אנא עדכן את תאריך הלידה בשנית", "error");
                </script>';
            }
            else if ($_GET["error"] == "firstname"){
                echo '<script>
                    swal("!שגיאה", "השם הפרטי שהזנת אינו חוקי. אנא הזן שם לפי ההוראות", "error");
                </script>';
            }
            else if ($_GET["error"] == "lastname"){
                echo '<script>
                    swal("!שגיאה", "שם המשפחה שהזנת אינו חוקי. אנא הזן שם לפי ההוראות", "error");
                </script>';
            }
            else if ($_GET["error"] == "description"){
                echo '<script>
                    swal("!שגיאה", "יש לכתוב תיאור קצר עד כ-300 תווים בעברית/אנגלית עם הסימנים .,!@*", "error");
                </script>';
            }
            else if ($_GET["error"] == "profileimg"){ 
                echo '<script>
                    swal("!שגיאה", "לא הצלחנו לעדכן את תמונת הפרופיל. אנא נסה שנית", "error");
                </script>';
            }
            else if ($_GET["error"] == "facebook"){ 
                echo '<script>
                    swal("!שגיאה", "הלינק לפייסבוק אינו תקין. אנא נסה שנית", "error");
                </script>';
            }
            else if ($_GET["error"] == "instagram"){ 
                echo '<script>
                    swal("!שגיאה", "הלינק לאינסטגרם אינו תקין. אנא נסה שנית", "error");
                </script>';
            }
        }
        ?>
        <script>
            function enablePwd(){
                if($('#pwd1').val()!=""){
                 $("#pwd2").removeAttr("disabled");
                }else {
                    $("#pwd2").setAttribute("disabled");
                }
            }
            function inputClick(){
                document.querySelector('#img').click();
            }
            // validate image type
            function fileValidation() { 
                var fileInput = document.getElementById('img'); 
                var filePath = fileInput.value; 
                // Allowing file type
                //Whole combination is means, follow by dot “.” and string end in “jpg” or “png” or “gif” or “jpeg” , and the file extensive is case-insensitive.
                var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i; 
                if (!allowedExtensions.exec(filePath)) { 
                    fileInput.value = '';
                    swal("!שגיאה", "התמונה שהעלית מסוג קובץ לא חוקי. אנא נסה שנית", "error");
                    document.getElementById('Image').focus();
                    return false; 
                }  
                else { 
                    document.querySelector('#submit').click();
                    return true;
                } 
            }
        </script>
    </body>
</html>