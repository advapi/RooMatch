<?php
    session_start();
?>
<!DOCTYPE html> 
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>RooMatch</title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <!-- Popper JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <!-- fontawesome -->
        <script src="https://kit.fontawesome.com/432e74f419.js" crossorigin="anonymous"></script>
        <!-- select2 -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <!-- sweetalert -->
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <!-- Fotorama img gallery/slider from CDNJS, 19 KB -->
        <link  href="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.css" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.js"></script>
        <?php
            if (basename($_SERVER['PHP_SELF']) == 'index.php'){ 
             echo  ' <link rel="stylesheet" type="text/css" href="css/style.css">';
            }
            else { ?>
                <link rel="stylesheet" type="text/css" href="css/nav_and_footer.css">
        <?php }
            if (basename($_SERVER['PHP_SELF'])=='signup.php' || basename($_SERVER['PHP_SELF'])=='add_new_apartment.php' || basename($_SERVER['PHP_SELF'])=='login.php' || basename($_SERVER['PHP_SELF'])=='reset_password.php' || basename($_SERVER['PHP_SELF'])=='create-new-password.php') { ?>
                <link rel="stylesheet" type="text/css" href="css/login-signup.css">
        <?php 
        }  
            if (basename($_SERVER['PHP_SELF'])=='public_profile.php' || basename($_SERVER['PHP_SELF']) == 'apartment.php') { ?>
            <link rel="stylesheet" type="text/css" href="css/user_profile.css">
        <?php }
            if (basename($_SERVER['PHP_SELF']) == 'private_profile.php' || basename($_SERVER['PHP_SELF']) == 'edit_apartment_details.php') { ?>
            <link rel="stylesheet" type="text/css" href="css/private_user_style.css">
        <?php }
            if (basename($_SERVER['PHP_SELF']) == 'paypal.php') { ?>
                        <link rel="stylesheet" type="text/css" href="css/paypal.css">
        <?php } ?>
    </head>  
    <body>
        <!-- start of navbar -->
        <nav class="navbar navbar-expand-lg navbar-light fixed-top">
            <div class="container-fluid">
                <a class="navbar-brand" id="brand-logo" href="index.php">
                    <img class"logo" src="css/img/roomatch.jpg" alt="logo" width="130" height="40">
                </a> 
                <button class="navbar-toggler" data-target="#navbarSupportedContent" data-toggle="collapse" type="button">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul id="nav" class="nav navbar-nav ml-auto" dir="rtl">
                        <?php
                            if (isset($_SESSION["username"])){ ?>
                                <li class='mt-2' style='color:black;'><h3 class="text-right"><b> שלום, <?php echo $_SESSION["username"] ?> </b></h3></li>
                                    <li class='nav-item'>
                                        <a class='nav-link btn btn-info' href='index.php'>עמוד הבית</a>
                                    </li>
                                    <li class='nav-item'>
                                        <a class='nav-link btn btn-info' href='private_profile.php'>פרופיל</a>
                                    </li>
                                    <li class='nav-item'>
                                        <a class='nav-link btn btn-info' href="addList.php">מודעות</a>
                                    </li>
                                    <li class='nav-item'>
                                        <a class='nav-link btn btn-info' href='paypal.php'>שדרוג מסלול</a>
                                    </li>
                                    <li class='nav-item'>
                                        <a class='nav-link btn btn-info' href='includes/logout.inc.php'>התנתק</a>
                                    </li>
                            <?php   
                            }
                            else { ?>
                                    <li class='nav-item'>
                                        <a class='nav-link btn btn-info' href='index.php'>עמוד הבית</a>
                                    </li>
                                    <li class='nav-item'>
                                        <a class='nav-link btn btn-info' href='login.php'>התחבר</a>
                                    </li>
                                    <li class='nav-item'>
                                        <a class='nav-link btn btn-info' href='signup.php'>הירשם</a>
                                    </li>
                            <?php
                            }
                        ?>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- end of navbar -->