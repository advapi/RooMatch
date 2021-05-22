<?php
    include("templates/header.php");
    require_once("includes/db.inc.php");
    $_SESSION['aptid'] = $_SERVER['QUERY_STRING'];
    $sql = "SELECT * FROM apartments WHERE id=" .$_SERVER['QUERY_STRING']. ";";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    if ($resultCheck > 0) {
    $row = mysqli_fetch_assoc($result);
    }
    $sql = "SELECT name FROM city ORDER BY name;";
    $result = mysqli_query($conn, $sql);
?>
        <section class="container">
            <div class="page-head">
                <h4><b> עדכון פרטי מודעה</b></h4>
                <hr>
            </div>
            <div class="mt-5 mb-3 text-center" dir="rtl">
                <form action="includes/update-apartment.inc.php" method="post">
                    <div class="row">
                        <div class="col-2">
                            <label for="structure_type">סוג מבנה<label>
                        </div>
                        <div class="col-10">
                            <select name="structure_type" autofocus >
                                <?php 
                                    if ($row["structure_type"] == "דירה"){
                                        echo '<option value="דירה" selected> דירה</option> 
                                            <option value="בית קרקע" >בית קרקע</option>';        
                                    }else{
                                        echo '<option value="דירה" > דירה</option> 
                                            <option value="בית קרקע" selected >בית קרקע</option>';        
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <label for="city">עיר</label>
                        </div>
                        <div class="col-10">
                            <select name="city" id="js-example-basic-single" class="select2" autofocus>
                                <option value="" selected><?php echo $row["city"]; ?> </option>
                                <?php
                                    if (mysqli_num_rows($result) > 0) {
                                        while($city = mysqli_fetch_assoc($result)){
                                            $name = $city['name'];
                                            echo "<option value='$name'> $name <option>";
                                        }   
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <label for="street">רחוב </label>
                        </div>
                        <div class="col-10">
                            <input type="text" id="street" name="street" placeholder=<?php echo $row["street"]; ?> >
                        </div>
                    </div>         
                    <div class="row">
                        <div class="col-2">
                            <label for="building_num">מספר בית </label>
                        </div>
                        <div class="col-10">
                            <input type="number" id="building_num" name="building_num" min="1" placeholder="<?php echo $row["building_num"]; ?> ">
                        </div>
                    </div>   
                    <div class="row">
                        <div class="col-2">
                            <label for="rent">שכירות  </label>
                        </div>
                        <div class="col-10">
                            <input type="number" id="rent" name="rent" placeholder="<?php echo $row["rent"]; ?>" min="0">    
                        </div>
                    </div>   
                    <div class="row">
                        <div class="col-2">
                            <label for="room_num">מספר חדרים</label>
                        </div>
                        <div class="col-10">
                            <select name="room_num" autofocus>
                                <?php 
                                    $num = 2;
                                    for($i=0; $i<6; $i++){
                                        if ($num != $row['room_num']){
                                            echo "<option value='$num'>$num</option>";    
                                        }
                                        else{
                                            echo "<option value='$num' selected>$num</option>";                                            
                                        }
                                        $num++;
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <label for="rommates_num">מספר שותפים</label>
                        </div>
                        <div class="col-10">
                            <select name="rommates_num" autofocus>
                                <?php 
                                    $num = 1;
                                    for($i=0; $i<7; $i++){
                                        if ($num != $row['rommates_num']){
                                            echo "<option value='$num'>$num</option>";    
                                        }
                                        else{
                                            echo "<option value='$num' selected>$num</option>";
                                        }
                                        $num++;
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <label for="min_age">גיל מינימלי</label>
                        </div>
                        <div class="col-10">
                            <input type="number" id="min_age" name="min_age" placeholder="<?php echo $row['min_age']; ?>" min="18" >
                            <?php $_SESSION['minage'] = $row['min_age']; ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <label for="max_age">גיל מקסימלי</label>
                        </div>
                        <div class="col-10">
                            <input type="number" id="max_age" name="max_age" placeholder="<?php echo $row['max_age']; ?> " min="18" >
                            <?php $_SESSION['maxage'] = $row['max_age']; ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <label for="move_in_date">תאריך כניסה </label>
                        </div>
                        <div class="col-10">
                            <?php 
                                $date = date("d-m-Y", strtotime ($row['move_in_date'])); 
                                $_SESSION['movedate'] = $row['move_in_date'];
                            ?>
                            <input type="text" id="move_in_date" name="move_in_date" onfocus="(this.type='date')" onblur="(this.type='text')" placeholder="<?php echo $date ; ?>" >    
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-2 text-center">
                            <label for="roommates_gender">מין השותפים</label>
                        </div>
                        <div class="col-3 mr-3">
                            <?php 
                                $checked1='';
                                $checked2='';
                                $checked3='';
                                if ($row['roommates_gender'] == "גברים בלבד"){
                                    $checked1 = "checked";
                                }
                                else if ($row['roommates_gender'] == "נשים בלבד") {
                                    $checked2 = "checked";
                                }
                                else{
                                    $checked3 = "checked";
                                }
                            ?>
                            <input type="radio" id="male" name="roommates_gender" value="גברים בלבד" <?php echo $checked1; ?>>
                            <label for="male">גברים בלבד</label><br>
                            <div class="ml-2">
                                <input type="radio" id="female" name="roommates_gender" value="נשים בלבד"  <?php echo $checked2; ?>> 
                                <label for="female">נשים בלבד</label><br>
                            </div>
                            <input type="radio" id="other" name="roommates_gender" value="גברים ונשים"  <?php echo $checked3; ?>>
                            <label for="other">גברים ונשים</label><br>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-2 text-center">
                            <label for="clean_rank">מידת ניקיון</label>
                        </div>
                        <div class="col-3 mr-3">
                            <?php 
                                $checked1='';
                                $checked2='';
                                $checked3='';
                                if ($row['clean_rank'] == 1){
                                    $checked1 = "checked";
                                }
                                else if ($row['clean_rank'] == 2) {
                                    $checked2 = "checked";
                                }
                                else{
                                    $checked3 = "checked";
                                }
                            ?>
                            <input type="radio" id="1" name="clean_rank" value="1"  <?php echo $checked1; ?>>
                            <label for="1">1- פחות נקי</label><br>
                            <input class="mr-5" type="radio" id="2" name="clean_rank" value="2"  <?php echo $checked2; ?>>
                            <label for="2">2- נקי ברמה סבירה</label><br>
                            <input type="radio" id="3" name="clean_rank" value="3"  <?php echo $checked3; ?>>
                            <label for="3">3- נקי ממש</label><br>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-2 text-center">
                            <label for="hosting_rank">מידת אירוח</label>
                        </div>
                        <div class="col-4 mr-1">
                            <?php 
                                $checked1='';
                                $checked2='';
                                $checked3='';
                                if ($row['hosting_rank'] == 1){
                                    $checked1 = "checked";
                                }
                                else if ($row['hosting_rank'] == 2) {
                                    $checked2 = "checked";
                                }
                                else{
                                    $checked3 = "checked";
                                }
                            ?>
                            <input type="radio" id="h-1" name="hosting_rank" value="1" <?php echo $checked1; ?>>
                            <label for="h-1">1- לא מארחים אף פעם</label><br>
                            <div class="ml-4">
                                <input type="radio" id="h-2" name="hosting_rank" value="2" <?php echo $checked2; ?>>
                                <label for="h-2">2- מארחים לפעמים</label><br>
                            </div>
                            <div class="ml-5 pr-2">
                                <input type="radio" id="h-3" name="hosting_rank" value="3" <?php echo $checked3; ?>>
                                <label for="h-3">3- תמיד מארחים</label><br>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class = "col-2 text-center">
                            <p class="mt-2">פרטים נוספים:</p>        
                        </div>    
                        <div class = "text-right  col-5 mr-5 pr-5">
                            <?php 
                                $checked1='';
                                $checked2='';
                                $checked3='';
                                $checked4='';
                                $checked5='';
                                $checked6='';
                                if ($row['include_furniture'] == 1){
                                    $checked1 = "checked";
                                }
                                if ($row['parking'] == 1) {
                                    $checked2 = "checked";
                                }
                                if ($row['pets'] == 1) {
                                    $checked3 = "checked";
                                }
                                if ($row['smoking'] == 1) {
                                    $checked4 = "checked";
                                }
                                if ($row['kosher'] == 1) {
                                    $checked5 = "checked";
                                }
                                if ($row['vegetarian_or_vegan'] == 1) {
                                    $checked6 = "checked";
                                }
                            ?>
                            <label> <input type="checkbox" name="include_furniture" value="1" <?php echo $checked1; ?>> הדירה מרוהטת </label><br>
                            <label> <input type="checkbox" name="parking" value="1" <?php echo $checked2; ?>> יש חניה באזור הדירה </label><br>
                            <label> <input type="checkbox" name="pets" value="1" <?php echo $checked3; ?>> ניתן להכניס בעלי חיים </label><br>
                            <label> <input type="checkbox" name="smoking" value="1" <?php echo $checked4; ?>> מעשנים בדירה </label><br>
                            <label> <input type="checkbox" name="kosher" value="1" <?php echo $checked5; ?>> שומרים על כשרות בדירה </label><br>
                            <label> <input type="checkbox" name="vegetarian_or_vegan" value="1" <?php echo $checked6; ?>> אוכלים רק צמחוני/טבעוני בדירה </label><br>    
                        </div>
                    </div>
                    <div class="text-center mb-3 mt-2">
                        <button type="submit" class="btn btn-info btn-lg" name="update"> עדכן פרטים! </button>
                    </div>
                </form>
                <?php
                    if($_SESSION['error'] == "moveindate"){
                        echo '<script>
                            swal("!שגיאה", "תאריך הכניסה לדירה הוא מיום פרסום המודעה והלאה. תאריך כניסה מלפני פרסום המודעה אינו חוקי", "error");
                            </script>';
                        $_SESSION['error'] = '';
                    }
                    else if($_SESSION['error'] == "agerange"){
                        echo '<script>
                            swal("!שגיאה", "הגיל המקסימלי שהזנת נמוך מהגיל המינימלי. אנא הזן שוב את טווח הגילאים", "error");
                            </script>';
                        $_SESSION['error']='';
                    }
                ?>
            </div>
        </section>
        <script>
            $(document).ready(function() {
                $('#js-example-basic-single').select2();
                
            });
        </script>
    </body>     
</html>