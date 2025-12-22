<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Adda - Social Network HTML Template</title>
    <meta name="robots" content="noindex, follow" />
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.ico">

    <!-- CSS
	============================================ -->
    <!-- google fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/vendor/bootstrap.min.css">
    <!-- Icon Font CSS -->
    <link rel="stylesheet" href="assets/css/vendor/bicon.min.css">
    <!-- Flat Icon CSS -->
    <link rel="stylesheet" href="assets/css/vendor/flaticon.css">
    <!-- audio & video player CSS -->
    <link rel="stylesheet" href="assets/css/plugins/plyr.css">
    <!-- Slick CSS -->
    <link rel="stylesheet" href="assets/css/plugins/slick.min.css">
    <!-- nice-select CSS -->
    <link rel="stylesheet" href="assets/css/plugins/nice-select.css">
    <!-- perfect scrollbar css -->
    <link rel="stylesheet" href="assets/css/plugins/perfect-scrollbar.css">
    <!-- light gallery css -->
    <link rel="stylesheet" href="assets/css/plugins/lightgallery.min.css">
    <!-- Main Style CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-transparent">

    <main>
        <?php
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        require 'DatabaseFunctions.php';
        ConnectDatabase();
        session_start();
        if (isset($_SESSION['userID'])) {
            $userID = $_SESSION['userID'];
        } 
        $infos = getUserInfoById($userID);
        
        $updateStatus = Onupdate($userID);
        if ($updateStatus["Successful"]) {
                header("Refresh:0");
                exit;
            }

        ?>

          

        <div class="main-wrapper pb-0 mb-0">
            <div class="timeline-wrapper overflow-hidden">
            <header>
                                    <div class="header-top sticky bg-white d-none d-lg-block">
                                        <div class="container">
                                            <div class="row align-items-center">
                                                <div class="col-md-5">
                                                    <!-- header top navigation start -->
                                                    <div class="header-top-navigation">
                                                        <nav>
                                                            <ul>
                                                                <li class="active"><a href="accueil.php">Home</a></li>
                                                                <li class="notification-trigger">
                                                                    <a class="notification1" href="notifications.php">
                                                                        Notification
                                                                    <span id="notificationCount"></span>
                                                                    </a>
                                                                </li>

                                                                <li class="notification-trigger"><a href="statistique.php">Statistique</a></li>
                                                            </ul>
                                                        </nav>
                                                    </div>
                                                    <!-- header top navigation start -->
                                                </div>

                                                <div class="col-md-2">
                                                    <!-- brand logo start -->
                                                    <div class="brand-logo text-center">
                                                        <a href="index.html">
                                                            <img src="assets/images/logo/logo.png" alt="brand logo">
                                                        </a>
                                                    </div>
                                                    <!-- brand logo end -->
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="header-top-right d-flex align-items-center justify-content-end">
                                                        <div class="header-top-search">
                                                            <a style="color: black; 
                                                                    background-color: #eebbc3; 
                                                                    border:none;
                                                                    border-radius:10px;
                                                                    padding:7px;
                                                                    min-height:30px; 
                                                                    min-width: 120px;" href="decouvrir.php">Decouvrir</a>
                                                        </div>
                                                        <!-- profile picture start -->
                                                        <div class="profile-setting-box">
                                                            <div class="profile-thumb-small">
                                                                <a href="javascript:void(0)" class="profile-triger">
                                                                    <figure>
                                                                        <img src="<?php echo $infos['avatar']; ?>"  alt="profile picture" style="height:100%">
                                                                    </figure>
                                                                </a>
                                                                <div class="profile-dropdown">
                                                                    <div class="profile-head">
                                                                        <?php
                                                                            $fullName = $infos['prenom'] . ' ' . $infos['nom'];
                                                                        ?>
                                                                        <h5 class="name"><a href="accueil.php"><?php echo $fullName; ?></a></h5>
                                                                        <a class="mail"><?php echo $infos['email']?></a>
                                                                    </div>
                                                                    <div class="profile-body">
                                                                        <ul>
                                                                            <li><a href="parameters.php"><i class="flaticon-settings"></i>Paramétres</a></li>
                                                                            <li><a href="index.php"><i class="flaticon-unlock"></i>Deconnexion</a></li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- profile picture end -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </header>
                                <?php
                                if ( $updateStatus["Attempted"] ){
                                        echo '<p style="color:#dc4734;margin-bottom:2%">'.$updateStatus["ErrorMessage2"].'</p>';
                                }
                                ?>  
                                <div class="signup-form-wrapper" style="margin-top:5%" >
                                    <h1 class="create-acc text-center">Change your settings</h1>
                                    <div class="signup-inner text-center">
                                        <h3 class="title">Settings</h3>
                                        <form class="signup-inner--form" method="post" action="./parameters.php" enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="col-12">
                                                    <input type="hidden" name="MAX_FILE_SIZE" value="5242880" />
                                                    <label for="fileUpload" class="upload-icon">
                                                        <img class="img-profile rounded-circle" src="<?php echo $infos['avatar']; ?>" style="width: 70px; height: 70px;">
                                                    </label>
                                                    <input type="file" id="fileUpload" name="fileUpload" style="display: none;" value="<?php echo $infos['avatar'];?>">
                                                </div>
                                                <?php
                                                        if ( $updateStatus["Attempted"] ){
                                                            echo '<p style="color:#dc4734;margin-bottom:2%">'.$updateStatus["ErrorMessage5"].'</p>';
                                                        }
                                                    ?>
                                                <div class="col-12">
                                                    <input type="email" class="single-field" name="new_mail" value="<?php echo $infos['email']; ?>">
                                                </div>
                                                <?php
                                                        if ( $updateStatus["Attempted"] ){
                                                            echo '<p style="color:#dc4734;margin-bottom:2%">'.$updateStatus["ErrorMessage"].'</p>';
                                                        }
                                                    ?>
                                                    <?php
                                                        if ( $updateStatus["Attempted"] ){
                                                            echo '<p style="color:#dc4734;margin-bottom:2%">'.$updateStatus["ErrorMessage3"].'</p>';
                                                        }
                                                    ?>    
                                                <div class="col-12">
                                                    <input type="password" class="single-field"  name="new_password"  placeholder="reinitialiser le mot de passe">
                                                </div>
                                                <?php
                                                if ( $updateStatus["Attempted"] ){
                                                    echo '<p style="color:#dc4734;margin-bottom:2%">'.$updateStatus["ErrorMessage1"].'</p>';
                                                }
                                                 ?> 
                                                <div class="col-md-6">
                                                    <input type="text" class="single-field"  name="first_name" value="<?php echo $infos['prenom']; ?>">
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" class="single-field" name="last_name" value="<?php echo $infos['nom']; ?>">
                                                </div>
                                                <div class="col-md-6">
                                                    <select class="nice-select" name="genre" value=>
                                                        <option value="<?php echo $infos['genre'];?>"selected><?php echo $infos['genre'];?></option>
                                                        <option value="male">Male</option>
                                                        <option value="female">Female</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <select class="nice-select" name="age">
                                                        <option value="<?php echo $infos['age'];?>" selected><?php echo $infos['age'];?></option>
                                                        <option value="18+">18+</option>
                                                        <option value="18-">18-</option>
                                                    </select>
                                                </div>
                                                <div class="col-12">
                                                    <select class="nice-select" name="pays" style="height:auto">
                                                        <option value="<?php echo $infos['pays']; ?>"><?php echo $infos['pays']; ?></option>
                                                        <option value="Bangladesh">Bangladesh</option>
                                                        <option value="Noakhali">Noakhali</option>
                                                        <option value="Australia">Australia</option>
                                                        <option value="Chine">China</option>
                                                        <option value="Inde">Inde</option>
                                                    </select>
                                                </div>
                                                <div class="col-12">
                                                    <input type="date" class="single-field" style="color:#999" class="naissance" name="naissance" max="2024-04-08" value="<?php echo $infos['naissance']; ?>">
                                                </div>
                                                <?php
                                                        if ( $updateStatus["Attempted"] ){
                                                            echo '<p style="color:#dc4734;margin-bottom:2%">'.$updateStatus["ErrorMessage4"].'</p>';
                                                        }
                                                    ?>

                                                <div class="col-md-12">
                                                    <input type="text" class="single-field" placeholder="Description de votre compte" name="desc" value="<?php echo $infos['description_user']; ?>">
                                                </div>
                                                <div class="col-12">
                                                    <button class="submit-btn" type="submit">Apply</button>
                                                </div>

                                                
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>

        </div>
    </main>

    <!-- JS
============================================ -->
    <script>
    document.getElementById('fileLabel').addEventListener('click', function() {
    document.getElementById('fileUpload').click();
    });
    </script>
    <!-- Modernizer JS -->
    <script src="assets/js/vendor/modernizr-3.6.0.min.js"></script>
    <!-- jQuery JS -->
    <script src="assets/js/vendor/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="assets/js/vendor/bootstrap.bundle.min.js"></script>
    <!-- Slick Slider JS -->
    <script src="assets/js/plugins/slick.min.js"></script>
    <!-- nice select JS -->
    <script src="assets/js/plugins/nice-select.min.js"></script>
    <!-- audio video player JS -->
    <script src="assets/js/plugins/plyr.min.js"></script>
    <!-- perfect scrollbar js -->
    <script src="assets/js/plugins/perfect-scrollbar.min.js"></script>
    <!-- light gallery js -->
    <script src="assets/js/plugins/lightgallery-all.min.js"></script>
    <!-- image loaded js -->
    <script src="assets/js/plugins/imagesloaded.pkgd.min.js"></script>
    <!-- isotope filter js -->
    <script src="assets/js/plugins/isotope.pkgd.min.js"></script>
    <!-- Main JS -->
    <script src="assets/js/main.js"></script>

</body>

</html>