<?php
    
    include("templates/header.php");
    require_once("includes/db.inc.php");
    if($_SESSION['id']!=''){
        $sql1 = "SELECT * FROM users INNER JOIN userPayment ON users.id = userPayment.user_id WHERE users.id=".$_SESSION['id'].";";
        $result1 = mysqli_query($conn, $sql1);
        if (mysqli_num_rows($result1) > 0) {
            $row1 = mysqli_fetch_assoc($result1);
            if($row1['status'] == 1 && $row1['exp_date'] == date('Y-m-d')){
                $sql2 = "UPDATE users SET status = 0 WHERE id=" .$_SESSION["id"]. ";";
                if ($conn->query($sql2) === FALSE) {
                    echo "התרחשה שגיאה, נסה שנית מאוחר יותר <br> ". $conn->error;
                }
            }   
        }
    }
    $sql = "SELECT name FROM city ORDER BY name;";
    $result = mysqli_query($conn, $sql);
?>
<html>
    <body>
        <!-- start landing page section -->
        <div class="banner">
            <div class="page-wrap">
                <div class="page-inner">
                </div>
            </div>
        </div>
        
        <section class="container">
            <form action="results.php" method="post" id="search" class="index-form" dir="rtl">
                <div class="inputs mr-2"  dir="rtl">
                    <h2 class="text-center mb-3"><b>חיפוש מהיר</b></h2>
                    <div class="row d-flex justify-content-between">
                       <div class="col-md-3">
                            <select name="structure_type" autofocus >
                                <option value=""> בחר סוג מבנה </option>
                                <option value="דירה">דירה</option> 
                                <option value="בית קרקע" >בית קרקע</option>
                            </select>     
                       </div>
                       <div class="col-md-3">
                            <select name="room_num" autofocus>
                                <option value=""> בחר מספר חדרים בדירה.. </option>
                                <option value="2">2</option>
                                <option value="3">3</option> 
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                            </select>       
                       </div>
                       <div class="col-md-3">
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
                       </div>
                       <div class="col-md-3">
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
                    </div>
                    <div class="row d-flex justify-content-between">
                       <div class="col-md-3">
                            <input type="number" name="min_age" placeholder="הזן את הגיל המינימלי.." autofocus min="18">
                       </div>
                       <div class="col-md-3">
                            <input type="number" name="max_age" placeholder="הזן את הגיל המקסימלי.." autofocus min="18">
                       </div>
                       <div class="col-md-3">
                            <input type="number" name="rent" placeholder="גובה שכר דירה מקסימלי.." autofocus min="0" >
                       </div>
                       <div class="col-md-3">
                            <select name="roommates_gender">
                                <option value="">בחר את מגדר השותפים</option>
                                <option value="גברים בלבד">גברים בלבד </option>
                                <option value="נשים בלבד">נשים בלבד </option>
                                <option value="גברים ונשים">גברים ונשים </option>
                            </select>                       
                       </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                           <label><b> תאריך כניסה לדירה:</b>
                                <input type="date" name="move_in_date">
                            </label>
                       </div>
                       <div class="col-md-3">
                            <label><input type="checkbox" name="include_furniture" value="1"><b> הדירה מרוהטת</b></label>
                        </div>
                        <div class="col-md-3">
                            <label><input type="checkbox" name="parking" value="1"> <b> יש חניה באזור הדירה</b></label>
                        </div>
                        <div class="col-md-3">
                            <label><input type="checkbox" name="pets" value="1"><b>  ניתן להכניס בעלי חיים</b></label>
                        </div>
                    </div>    
                    <div class="row">    
                        <div class="col-md-3">
                            <label><input type="checkbox" name="smoking" value="1"><b> מעשנים בדירה</b></label>
                        </div>
                        <div class="col-md-3">
                            <label><input type="checkbox" name="kosher" value="1"> <b> שומרים על כשרות בדירה</b></label>
                        </div>
                        <div class="col-md-3">
                            <label><input type="checkbox" name="vegetarian_or_vegan" value="1"> <b> אוכלים רק צמחוני/טבעוני בדירה</b></label>
                        </div>
                    </div>
                    <br>
                    <button type="submit" class="btn" name="search"> מצא לי את החדר המושלם! </button>
                </div>    
              </form>
        </section> 
        <?php
            if(isset($_GET["success"])){
                echo '<script> swal("!התשלום בוצע בהצלחה", "שידרגת למנוי פרימיום! כעת תוכל לפרסם מודעות ולצפות במודעות ללא הגבלה", "success"); </script>';
                $sql = "UPDATE users SET status = 1 WHERE id=" .$_SESSION["id"]. ";";
                if ($conn->query($sql) === FALSE) {
                    echo "התרחשה שגיאה, נסה שנית מאוחר יותר <br> ". $conn->error;
                }
                
                $invoice = $_SESSION['id'].rand();
                $user_id = $_SESSION['id'];
                $today = date('Y');
                $nextY = $today + 1;
                $exp_date = date($nextY.'-m-d');
                $sql = "INSERT INTO userPayment (invoice_num, user_id, exp_date) VALUES ($invoice, $user_id, '$exp_date')";
                if ($conn->query($sql) === FALSE) {
                  echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
        ?>
        <script>
            $(document).ready(function() {
                $('#js-example-basic-single').select2();
            });
        </script>                                
    </body>
</html>