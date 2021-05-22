<?php
    
    include("templates/header.php");
    
    if (isset($_POST["search"])) {
        
       $structure_type = $_POST["structure_type"];    
       $city = $_POST["city"];
       $rent = $_POST["rent"];
       $room_num = $_POST["room_num"];
       $rommates_num = $_POST["rommates_num"];
       $min_age = $_POST["min_age"];
       $max_age = $_POST["max_age"];
       $move_in_date = $_POST['move_in_date'];
       $roommates_gender = $_POST["roommates_gender"];
       $include_furniture = $_POST['include_furniture'];
       $parking = $_POST['parking'];
       $pets = $_POST['pets'];
       $smoking = $_POST['smoking'];
       $kosher = $_POST['kosher'];
       $vegetarian_or_vegan = $_POST['vegetarian_or_vegan'];
       $filter_count = 0;
       $match_count = 0;
       
        if($smoking == 1){
            $filter_count++;
        }
        if($kosher == 1){
            $filter_count++;
        }
        if($vegetarian_or_vegan == 1){
            $filter_count++;
        }
       
       require_once 'includes/db.inc.php';
       require_once 'includes/functions.inc.php';
        
        if(!$_POST['structure_type'] && !$_POST["city"] && !$_POST["room_num"] && !$_POST["rommates_num"] && !$_POST["roommates_gender"] && !$_POST["move_in_date"] && !$_POST["include_furniture"] && !$_POST["parking"] && !$_POST["pets"] && emptyInputSearch($rent, $min_age, $max_age) !== false){
           $sql = "SELECT * FROM users INNER JOIN apartments ON apartments.user_id = users.id ;";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                ?>
                    <div class="container">
                        <div class="results-h text-center">
                            <h3><b>תוצאות חיפוש</b></h3>   
                            <div class='text-center mt-4 float-right'><h3><a href='index.php' class='btn btn-info'> לחץ לחיפוש חדש </a></h3></div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="card-columns text-center">
                    
                <?php
                while($row = mysqli_fetch_assoc($result)){ ?>
                            <div class="card">
                                    <div class="fotorama"  data-width="100%" data-height="400" data-ratio="600/400" data-allowfullscreen="true" data-transition="crossfade">
                                        <?php $resultx = mysqli_query($conn, "SELECT img FROM apartmentImg WHERE apt_id = " .$row['id']); ?>
                                        <?php if (mysqli_num_rows($resultx) > 0) : ?>
                                            <?php while ($rowx = mysqli_fetch_array($resultx)) : ?>
                                                <img src='../uploads/<?php echo $rowx['img']; ?>' width="100%">
                                            <?php endwhile; ?>
                                        <?php endif; ?>
                                    </div>
                                <div class="card-body">
                                    <?php
                                            if($smoking == 1 && $row['smoking'] == 1){
                                                $match_count++;
                                            }
                                            if($kosher == 1 && $row['kosher'] == 1){
                                                $match_count++;
                                            }
                                            if($vegetarian_or_vegan == 1 && $row['vegetarian_or_vegan'] == 1){
                                                $match_count++;
                                            }
                                            if($filter_count > 0){
                                                if($match_count == 0){
                                                    echo "<h6 class='card-title font-weight-bold' dir='rtl'>אופי שותפים פחות מתאים</h6>";
                                                }
                                                else if($match_count > 0){
                                                    $percentage = round($match_count/$filter_count*100,1);
                                                    if($percentage < 40.0){
                                                        echo "<h6 class='card-title font-weight-bold' dir='rtl'>אופי שותפים פחות מתאים</h6>";
                                                    }
                                                    else{
                                                        echo "<h6 class='card-title font-weight-bold' dir='rtl'>".$percentage."% התאמה</h6>";   
                                                    }
                                                }
                                            }
                                            $match_count = 0;
                                    
                                    ?>
                                    <h5 class="card-title"> פורסם ע"י: <?php echo $row['username'] ?></h5>
                                    <h6 class="card-title"><?php echo $row['structure_type'] ?></h6>
                                    <p class="card-text"><?php echo $row['rent'] ?></p>
                                    <p class="card-text"><?php echo $row['city']. ", " .$row['street']. ", " . $row['building_num'] ?></p>
                                    <p class="card-text">תאריך כניסה לדירה:
                                        <?php
                                            $date = date("d-m-Y", strtotime ($row['move_in_date']));
                                            echo $date 
                                        ?>
                                    </p>
                                    <form  action = "includes/permission.inc.php" method = "post">
                                        <p class="card-text">
                                            <small class="text-muted">
                                                <button class="btn btn-info"  type = "submit" name = "apt-page"> לחץ לצפייה במודעה </button>
                                            </small>
                                        </p>
                                        <?php 
                                            $aptId = $row['id'];
                                            echo "<input type='hidden' value= '$aptId' name='apt-id'>";
                                        ?>
                                    </form>
                                </div>
                            </div>
    
                    <?php
                }
                ?>
                        </div>
                    </div>
                    
                <?php
            } else {
                echo "<h1 class='mt-5 text-center'>לא נמצאו תוצאות</h1>";
                echo "<div class='text-center mt-4'><h3><a href='index.php' class='btn btn-info'> לחץ לחיפוש חדש </a></h3></div>";
            }
        } else {
            $and = ' apartments.id > 0 ';
            if (!empty($_POST['structure_type'])) {
                $and .= "AND apartments.structure_type = '$structure_type' ";
            }
            if (!empty($_POST['city'])) {
                $and .= "AND apartments.city = '$city' ";
            }
            if (!empty($_POST['rent'])) {
                $and .= "AND apartments.rent <= $rent ";
            }
            if (!empty($_POST['room_num'])) {
                $and .= "AND apartments.room_num = $room_num ";
            }
            if (!empty($_POST['rommates_num'])) {
                $and .= "AND apartments.rommates_num = $rommates_num ";
            }
            if (!empty($_POST['min_age'])) {
                $and .= "AND apartments.min_age <= $min_age ";
            }
            if (!empty($_POST['max_age'])) {
                $and .= "AND apartments.max_age >= $max_age ";
            }
            if (!empty($_POST['move_in_date'])) {
                $date = date("Y-m-d", strtotime ($move_in_date));
                $and .= "AND move_in_date >= '$date' ";
            }
            if (!empty($_POST['roommates_gender'])) {
                $and .= "AND apartments.roommates_gender = '$roommates_gender' ";
            }
            if($include_furniture == 1){
                $and .= "AND apartments.include_furniture = '$include_furniture' ";
            }
            if($parking == 1){
                $and .= "AND apartments.parking = '$parking' ";
            }
            if($pets == 1){
                $and .= "AND apartments.pets = '$pets' ";
            }
            $sql = "SELECT * FROM users INNER JOIN apartments ON apartments.user_id = users.id WHERE" .$and. ";";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                ?>
                    <div class="container">
                        <div class="results-h text-center">
                            <h3><b>תוצאות חיפוש</b></h3>   
                            <div class='text-center mt-4 float-right'><h3><a href='index.php' class='btn btn-info'> לחץ לחיפוש חדש </a></h3></div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="card-columns text-center">
                        
                    
                <?php
                while($row = mysqli_fetch_assoc($result)){
                    ?>
                            <div class="card">
                                <div class="fotorama"  data-width="100%" data-height="400" data-allowfullscreen="true" data-transition="crossfade">
                                    <?php $resultx = mysqli_query($conn, "SELECT img FROM apartmentImg WHERE apt_id = " .$row['id']); ?>
                                    <?php if (mysqli_num_rows($resultx) > 0) : ?>
                                        <?php while ($rowx = mysqli_fetch_array($resultx)) : ?>
                                            <img src='../uploads/<?php echo $rowx['img']; ?>' width="100%">
                                        <?php endwhile; ?>
                                    <?php endif; ?>
                                </div>
                                <div class="card-body">
                                    <?php
                                            if($smoking == 1 && $row['smoking'] == 1){
                                                $match_count++;
                                            }
                                            if($kosher == 1 && $row['kosher'] == 1){
                                                $match_count++;
                                            }
                                            if($vegetarian_or_vegan == 1 && $row['vegetarian_or_vegan'] == 1){
                                                $match_count++;
                                            }
                                            if($filter_count > 0){
                                                if($match_count == 0){
                                                    echo "<h6 class='card-title font-weight-bold' dir='rtl'>אופי שותפים פחות מתאים</h6>";
                                                }
                                                else if($match_count > 0){
                                                    $percentage = round($match_count/$filter_count*100,1);
                                                    if($percentage < 40.0){
                                                        echo "<h6 class='card-title font-weight-bold' dir='rtl'>אופי שותפים פחות מתאים</h6>";
                                                    }
                                                    else{
                                                        echo "<h6 class='card-title font-weight-bold' dir='rtl'>".$percentage."% התאמה</h6>";   
                                                    }
                                                }
                                            }
                                            $match_count = 0;
                                    
                                    ?>
                                    <h5 class="card-title"> פורסם ע"י: <?php echo $row['username'] ?></h5>
                                    <h6 class="card-title"><?php echo $row['structure_type'] ?></h6>
                                    <p class="card-text"><?php echo $row['rent'] ?></p>
                                    <p class="card-text"><?php echo $row['city']. ", " .$row['street']. ", " . $row['building_num'] ?></p>
                                    <p class="card-text">תאריך כניסה לדירה:
                                        <?php
                                            $date = date("d-m-Y", strtotime ($row['move_in_date']));
                                            echo $date 
                                        ?>
                                    </p>
                                    <form  action = "includes/permission.inc.php" method = "post">
                                        <p class="card-text">
                                            <small class="text-muted">
                                                <button class="btn btn-info"  type = "submit" name = "apt-page"> לחץ לצפייה במודעה </button>
                                            </small>
                                        </p>
                                        <?php 
                                            $aptId = $row['id'];
                                            echo "<input type='hidden' value= '$aptId' name='apt-id'>";
                                        ?>
                                    </form>
                                </div>
                            </div>
    
                    <?php
                }
                
                ?>
                        </div>
                    </div>
                <?php
                } else {
                    echo "<h1 class='mt-5 text-center'>לא נמצאו עבורך תוצאות מתאימות</h1>";
                    echo "<div class='text-center mt-4'><h3><a href='index.php' class='btn btn-info'> לחץ לחיפוש חדש </a></h3></div>";
                }
        }
    } else {
        header("location: index.php");
        exit();
    }

?>

