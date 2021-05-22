<?php
    include("templates/header.php");
    require_once("includes/db.inc.php");
    $sql = "SELECT * FROM apartments WHERE user_id = " .$_SESSION['id']. ";";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) { ?>
                    
        <div class="container" dir="rtl">
            <div class="results-h">
                <div class="text-right">
                    <form action="includes/permission.inc.php" method="post">
                        <button id="submit" class="btn btn-info" type="submit" name="create-apt">יצירת מודעה חדשה</button>
                    </form>
                </div>
                <div class="text-center">
                    <h3 dir="rtl"><b>דירות שפרסמת:</b></h3>    
                </div>
            </div>
            <form action="includes/delete.inc.php" method="post">
                <div class="table-responsive-sm">
                    <table class="table table-hover" style="width:100%">
                        <thead>
                          <tr>
                            <th scope="col" class= "text-right">תמונה</th>
                            <th scope="col">עיר</th>
                            <th scope="col">רחוב</th>
                            <th scope="col">מספר בניין</th>
                            <th scope="col">שכר דירה</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                          </tr>
                        </thead>
        <?php
            while($row = mysqli_fetch_assoc($result)){ ?>
                        <tr scope="row">
                            <td scope="col">
                                <div class="fotorama"  data-width="100%" data-height="400" data-minwidth="150" data-maxwidth="500" data-minheight="150" data-ratio="800/600"   data-allowfullscreen="true" data-transition="crossfade" data-fit="contain">
                                    <?php $resultx = mysqli_query($conn, "SELECT img FROM apartmentImg WHERE apt_id = " .$row['id']); ?>
                                    <?php if (mysqli_num_rows($resultx) > 0) : ?>
                                        <?php while ($rowx = mysqli_fetch_array($resultx)) : ?>
                                            <img src='../uploads/<?php echo $rowx['img']; ?>' width="100%">
                                        <?php endwhile; ?>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td scope="col"> <?php echo $row['city']; ?> </td>
                            <td scope="col"> <?php echo $row['street']; ?> </td>
                            <td scope="col"> <?php echo $row['building_num']; ?> </td>
                            <td scope="col"> <?php echo $row['rent']; ?> </td>
                            <td scope="col"><?php echo "<a href='edit_apartment_details.php?".$row['id']."' class='btn btn-info'>לחץ לעריכה</a>" ?></td>
                            <td scope="col"><button id="submit" class="btn btn-danger" type="submit" name="delete">לחץ למחיקה</button></td>
                        </tr>
                        <?php 
                            $id = $row['id'];
                            echo "<input type='hidden' value= '$id' name='id'>"; 
            }
        ?>
                    </table>
                </div>
            </form>
        </div>
                    
        <?php } 
            else { ?>
            <div class="container" dir="rtl">
                <div class="results-h">
                    <div class="text-right">
                        <a href="add_new_apartment.php" class="btn btn-info flex-right">יצירת מודעה חדשה</a>
                    </div>
                    <div class="text-center">
                        <h3 dir="rtl"><b>לא פירסמת מודעות</b></h3>    
                    </div>
                </div>
            </div>
        <?php        
            }
        ?>