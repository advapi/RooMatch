<?php
    require_once("templates/header.php");
    require_once("includes/db.inc.php");
    $sql = "SELECT * FROM users INNER JOIN apartments ON apartments.user_id = users.id WHERE apartments.id = {$_SESSION['aptid']} ;";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['profile-id'] = $row['user_id'];
    }
?>
    
    <div class="row py-5 px-4 mt-5">
        <div class="col-md-9 mx-auto">
            <!-- Apartment widget -->
            <div class="bg-white shadow rounded overflow-hidden">
                <div class="px-4 py-3">
                    <div class="col-3 float-right">
                        <a class='btn btn-info' href='public_profile.php'>צפייה בפרופיל המפרסם</a>
                    </div>
                    <div class="col-3 float-left">
                        <?php
                            echo "<a href=\"javascript:history.go(-1)\" class='btn btn-info'>חזרה לעמוד הקודם</a>";
                        ?>
                    </div>
                    <div class="clearfix mb-3"></div>
                    <div class="fotorama"  data-width="100%" data-ratio="400/200" data-allowfullscreen="true" data-nav="thumbs"  data-transition="crossfade">
                        <?php $resultx = mysqli_query($conn, "SELECT img FROM apartmentImg WHERE apt_id = " .$row['id']); ?>
                        <?php if (mysqli_num_rows($resultx) > 0) : ?>
                            <?php while ($rowx = mysqli_fetch_array($resultx)) : ?>
                                <img src='../uploads/<?php echo $rowx['img']; ?>' width="100%">
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </div>
                    <hr>
                    <br>
                    <div class="col-8 m-auto">
                        <div class="info">
                            <div class="row">
                                <div class="col-lg-4 mt-2"><h4  dir="rtl">סוג מבנה: </h4> <?php echo $row["structure_type"]; ?> </div>
                                <div class="col-lg-4 mt-2"><h4  dir="rtl">עיר:</h4> <?php echo $row["city"]; ?>  </div>
                                <div class="col-lg-4 mt-2"><h4  dir="rtl">רחוב:</h4> <?php echo $row["street"]; ?>  </div>  
                            </div>
                            <div class="row">
                                <div class="col-lg-4 mt-2"><h4  dir="rtl">מספר בית:</h4> <?php echo $row["building_num"]; ?>  </div>
                                <div class="col-lg-4 mt-2"><h4  dir="rtl">שכירות:</h4> <?php echo $row["rent"]; ?>   </div>
                                <div class="col-lg-4 mt-2"><h4  dir="rtl">מספר חדרים:</h4> <?php echo $row["room_num"]; ?>  </div>    
                            </div>
                            <div class="row">
                                <div class="col-lg-4 mt-2"><h4  dir="rtl">מספר שותפים:</h4> <?php echo $row["rommates_num"]; ?>  </div>
                                <div class="col-lg-4 mt-2"><h4  dir="rtl">גיל מינימלי:</h4> <?php echo $row["min_age"]; ?>  </div>
                                <div class="col-lg-4 mt-2"><h4  dir="rtl">גיל מקסימלי:</h4> <?php echo $row["max_age"]; ?>  </div>    
                            </div>
                            <div class="row">
                                <div class="col-lg-4 mt-2"><h4  dir="rtl">תאריך כניסה:</h4><?php echo date("d-m-Y", strtotime ($row["move_in_date"])); ?>  </div>
                                <div class="col-lg-4 mt-2"><h4  dir="rtl">מין השותפים:</h4> <?php echo $row["roommates_gender"]; ?>  </div>
                                <div class="col-lg-4 mt-2">
                                    <h4  dir="rtl">מידת ניקיון:</h4>
                                    <?php 
                                        if ($row["clean_rank"] == 1){
                                            echo "פחות נקי";
                                        }
                                        else if ($row["clean_rank"] == 2){
                                            echo "נקי ברמה סבירה";
                                        }
                                        else{
                                            echo "נקי ממש";
                                        }
                                    ?>  
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 mt-2">
                                    <h4  dir="rtl">מידת אירוח:</h4>
                                    <?php 
                                        if ($row["hosting_rank"] == 1){
                                            echo "לא מארחים אף פעם";
                                        }
                                        else if ($row["hosting_rank"] == 2){
                                            echo "מארחים לפעמים";
                                        }
                                        else{
                                            echo "תמיד מארחים";
                                        }
                                    ?>  
                                </div>
                                <div class="col-lg-4 mt-2">
                                    <h4  dir="rtl">מרוהטת:</h4> 
                                    <?php 
                                        if ($row["include_furniture"] == 1){
                                            echo "הדירה מרוהטת";
                                        }
                                        else{
                                            echo "הדירה לא מרוהטת";
                                        }
                                    ?>
                                </div>
                                <div class="col-lg-4 mt-2">
                                    <h4  dir="rtl">חניה:</h4>
                                    <?php 
                                        if ($row["parking"] == 1){
                                            echo "יש חניה מסודרת לשותפים בדירה";
                                        }
                                        else{
                                            echo "אין חניה מסודרת לשותפים בדירה";
                                        }
                                    ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 mt-2">
                                    <h4  dir="rtl">בעלי חיים:</h4>
                                    <?php 
                                        if ($row["pets"] == 1){
                                            echo "ניתן לגדל בעלי חיים בדירה";
                                        }
                                        else{
                                            echo "לא ניתן לגדל בעלי חיים בדירה";
                                        }
                                    ?>
                                </div>
                                <div class="col-lg-3 mt-2">
                                    <h4  dir="rtl">מעשן:</h4> 
                                    <?php 
                                        if ($row["smoking"] == 1){
                                            echo "ניתן לעשן בדירה";
                                        }
                                        else{
                                            echo "לא ניתן לעשן בדירה";
                                        }
                                    ?>
                                </div>
                                <div class="col-lg-3 mt-2">
                                    <h4  dir="rtl">כשרות:</h4> 
                                    <?php 
                                        if ($row["kosher"] == 1){
                                            echo "השותפים בדירה שומרים כשרות";
                                        }
                                        else{
                                            echo "השותפים בדירה לא שומרים כשרות";
                                        }
                                    ?>
                                </div>
                                <div class="col-lg-3 mt-2">
                                    <h4  dir="rtl">צמחוני/טבעוני:</h4>
                                    <?php 
                                        if ($row["vegetarian_or_vegan"] == 1){
                                            echo "צורכים אוכל טבעוני/צמחוני בדירה";
                                        }
                                        else{
                                            echo "לא צורכים אוכל טבעוני/צמחוני בדירה";
                                        }
                                    ?>
                                </div>
                            </div>
                         </div>
                    </div>
                </div>
         
            </div>
        </div>
    </div>
        
    </body>     
</html>