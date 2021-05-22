<?php
    include("templates/header.php");
    require_once("includes/db.inc.php");
    $sql = "SELECT * FROM users WHERE id=" .$_SESSION['profile-id']. ";";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    if ($resultCheck > 0) {
    $row = mysqli_fetch_assoc($result);
    }
?>
        <section class="container-fluid">
            <div class="row py-5 px-4 mt-5 main" id="notlong">
                <div class="col-sm-8 mx-auto">
                    <!-- Profile widget -->
                    <div class="bg-white shadow rounded overflow-hidden">
                        <div class="px-4 pt-0 pb-4 cover">
                            <div class="row">
                                <img src = 'uploads/<?php echo $row["user_img"]?>' alt="..."  class="rounded mt-3 user-img">
                            </div>
                        </div>
                        <div class="px-4 py-3">
                            <div class="row">
                                <div class="col-sm-6 float-left">
                                    <?php
                                        echo "<a href=\"javascript:history.go(-1)\" class='btn btn-info'>חזרה לעמוד הקודם</a>";
                                    ?>
                                </div>
                            <div class="clearfix"></div>    
                            </div>
                            <div>
                                <h3 class="mb-2 text-center"><b>מידע אישי </b></h3>
                            </div>
                            <hr>
                            <?php
                                        if(!empty($row['facebook'])){ ?>
                                            <a href="<?php echo $row['facebook']; ?>" style="font-size: 48px;" class="mr-2"> <i class="fab fa-facebook-square"></i></a>
                                        <?php    
                                        }
                                        if(!empty($row['instagram'])){ ?>
                                            <a href="<?php echo $row['instagram']; ?>" style="font-size: 44px; border-radius: 8px; background: #d6249f; background: radial-gradient(circle at 30% 107%, #fdf497 0%, #fdf497 5%, #fd5949 45%,#d6249f 60%,#285AEB 90%); color: #fff;"> <i class="fab fa-instagram"></i></a>
                                        <?php
                                        }
                            ?>
                            <div class="col-8 float-right" dir="rtl">
                                <div class="info">
                                    <div><h4  dir="rtl">שם פרטי:</h4> <?php echo $row["first_name"]; ?>  </div><br>
                                    <div><h4  dir="rtl">שם משפחה:</h4> <?php echo $row["last_name"]; ?>  </div><br>
                                    <div><h4  dir="rtl">תאריך לידה:</h4> <?php echo date("d-m-Y", strtotime ($row["birth_date"])); ?>   </div><br>
                                    <div><h4  dir="rtl">מגדר:</h4> <?php echo $row["gender"]; ?>  </div><br>
                                    <div><h4  dir="rtl">תיאור:</h4> <?php echo $row["description"]; ?>  </div><br>
                                 </div>
                            </div>
                        </div>
                 
                    </div>
                </div>
            </div>    
        </section>
    </body>
</html>