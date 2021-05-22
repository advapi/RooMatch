<?php
    include("templates/header.php");
    require_once("includes/db.inc.php");
    $sql = "SELECT name FROM city ORDER BY name;";
    $result = mysqli_query($conn, $sql);
?>
        
        <section class="signup-form">
            <div class="container">
                <form id="signup" action="includes/addApartment.inc.php" method="post" enctype="multipart/form-data">
                    <div class="header text-center">
                        <h3>הוספת דירה חדשה</h3>
                        <small class="text-danger"><b>יש למלא את כל השדות בטופס</b></small>
                    </div>
                    <div class="sep"></div>
                    <div class="inputs"  dir="rtl">
                        <label for="img" dir="rtl" class="float-right">ניתן להעלות עד 5 קבצים מסוג: jpeg/png/jpg/gif</label>
                        <div class="clearfix"></div>
                        <small id="error-img" class="error d-blobk float-right" dir="rtl"></small>
                        <div class="clearfix"></div>
                        <input id="img" name="img[]" multiple type="file" class="form-control-file" required accept=".png, .jpg, .jpeg, .gif" onchange="checkFiles(this.files)">
                        <select name="structure_type" autofocus >
                            <option value=""> בחר סוג מבנה </option>
                            <option value="דירה">דירה</option> 
                            <option value="בית קרקע" >בית קרקע</option>
                        </select>
                        <select name="city" id="js-example-basic-single" class="select2" autofocus>
                                <option value="">בחר עיר..</option>
                                <?php
                                    if (mysqli_num_rows($result) > 0) {
                                        while($row = mysqli_fetch_assoc($result)){
                                            $name = $row['name'];
                                            echo "<option value='$name'> $name <option>";       
                                        }   
                                    }
                                ?>
                        </select>
                        </div>
                        <input type="text" name="street" placeholder="הזן רחוב.." autofocus > 
                        <input type="number" name="building_num" placeholder="הזן מספר בית.." autofocus min="1"  >
                        <input type="number" name="rent" placeholder="גובה שכר דירה מקסימלי.." autofocus min="0" >
                        <select name="room_num" autofocus>
                            <option value=""> בחר מספר חדרים בדירה.. </option>
                            <option value="2">2</option>
                            <option value="3">3</option> 
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                        </select>
                        <select name="rommates_num" autofocus>
                            <option value=""> בחר מספר שותפים בדירה.. </option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option> 
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                        </select>
                        <label class="text-right" dir="rtl"> טווח גילאי השותפים: (גילאי 18+)
                            <input type="number" name="min_age" placeholder="הזן את הגיל המינימלי.." autofocus min="18">
                            <input type="number" name="max_age" placeholder="הזן את הגיל המקסימלי.." autofocus min="18">
                        </label>
                        <div class="checkboxy text-right" dir="rtl">
                            <label> תאריך כניסה לדירה:
                                <input type="date" name="move_in_date">
                            </label><br>
                            <div class="sep"></div>
                            <p>אנא בחר את מגדר השותפים בדירה:</p>
                            <input type="radio" id="male" name="roommates_gender" value="גברים בלבד">
                            <label for="male">גברים בלבד</label><br>
                            <input type="radio" id="female" name="roommates_gender" value="נשים בלבד">
                            <label for="female">נשים בלבד</label><br>
                            <input type="radio" id="other" name="roommates_gender" value="גברים ונשים">
                            <label for="other">גברים ונשים</label><br>
                            <div class="sep"></div>
                            <p class="mt-2">מידת הניקיון בדירה:</p>
                            <input type="radio" id="1" name="clean_rank" value="1">
                            <label for="1">1- פחות נקי</label><br>
                            <input type="radio" id="2" name="clean_rank" value="2">
                            <label for="2">2- נקי ברמה סבירה</label><br>
                            <input type="radio" id="3" name="clean_rank" value="3">
                            <label for="3">3- נקי ממש</label><br>
                            <div class="sep"></div>
                            <p class="mt-2">מידת האירוח בדירה:</p>
                            <input type="radio" id="h-1" name="hosting_rank" value="1">
                            <label for="h-1">1- לא מארחים אף פעם</label><br>
                            <input type="radio" id="h-2" name="hosting_rank" value="2">
                            <label for="h-2">2- מארחים לפעמים</label><br>
                            <input type="radio" id="h-3" name="hosting_rank" value="3">
                            <label for="h-3">3- תמיד מארחים</label><br>
                            <div class="sep"></div>
                            <p class="mt-2">פרטים נוספים:</p>
                            <label> <input type="checkbox" name="include_furniture" value="1"> הדירה מרוהטת </label><br>
                            <label> <input type="checkbox" name="parking" value="1"> יש חניה באזור הדירה </label><br>
                            <label> <input type="checkbox" name="pets" value="1"> ניתן להכניס בעלי חיים </label><br>
                            <label> <input type="checkbox" name="smoking" value="1"> מעשנים בדירה </label><br>
                            <label> <input type="checkbox" name="kosher" value="1"> שומרים על כשרות בדירה </label><br>
                            <label> <input type="checkbox" name="vegetarian_or_vegan" value="1"> אוכלים רק צמחוני/טבעוני בדירה </label><br>
                        </div>
                        <div class="text-center mt-2">
                            <button id="submit" class="btn btn-info" type="submit" name="add-apartment"> לחץ ליצירת מודעה </button>
                        </div>
                        <div class="error text-center">
                            <?php
                                if(isset($_GET["error"])){
                                    if($_GET["error"] == "emptyinput"){
                                        echo '<script>
                                                swal("!שגיאה", " אנא מלא את כל השדות", "error");
                                            </script>';
                                    }
                                    else if ($_GET["error"] == "stmtfailed"){
                                        echo '<script>
                                                swal("!שגיאה", " משהו השתבש. אנא נסה שנית", "error");
                                            </script>';
                                    }
                                    else if($_GET["error"] == "imgnotuploaded"){
                                        echo '<script>
                                            swal("!שגיאה", "לא הצלחנו להעלות את התמונות. אנא נסה שנית", "error");
                                        </script>';
                                    }
                                    else if($_GET["error"] == "imgext"){
                                        echo '<script>
                                            swal("!שגיאה", "אחת התמונות שהעלית מסוג קובץ לא חוקי. אנא נסה שנית", "error");
                                        </script>';
                                    }
                                    else if($_GET["error"] == "moveindate"){
                                        echo '<script>
                                            swal("!שגיאה", "תאריך הכניסה לדירה הוא מיום פרסום המודעה והלאה. תאריך כניסה מלפני פרסום המודעה אינו חוקי", "error");
                                        </script>';
                                    }
                                    else if($_GET["error"] == "agerange"){
                                        echo '<script>
                                            swal("!שגיאה", "הגיל המקסימלי שהזנת נמוך מהגיל המינימלי. אנא הזן שוב את טווח הגילאים", "error");
                                        </script>';
                                    }
                                }
                            ?>
                        </div>
                    </div>
                </form>
            </div>
        </section>
        <script>
            $(document).ready(function() {
                $('#js-example-basic-single').select2();
            });
            
            function checkFiles(files) {       
                if(files.length>5) {
                    var fileInput = document.getElementById('img');
                    document.getElementById("error-img").innerHTML= "מספר התמונות שבחרת גבוה מהמותר. אנא בחר עד 5 תמונות";
                    fileInput.value = '';
                }       
            }
        </script>
    </body>
</html>