<!doctype html>
<html class="no-js" lang="en">

<head>
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
                $loginStatus = CheckLogin();
                if ($loginStatus["Successful"]) {
                    $_SESSION['userID'] = $loginStatus['userID'];
                    if ($loginStatus['isAdmin'] == 1) {
                        $redirect = "index_admin.php";
                    } else {
                        $redirect = "accueil.php";
                    }
                    header("Location: $redirect");
                    exit;
                }
                $registerStatus = Onregister();
                if ($registerStatus["Successful"]) {
                    $redirection = "landing.php";
                    header("Location: $redirection");
                    exit;
                }
                else{
                    echo $registerStatus["ErrorMessage2"];
                }
            ?>

        <div class="main-wrapper pb-0 mb-0">
            <div class="timeline-wrapper overflow-hidden">
                <div class="timeline-header">
                    <div class="container-fluid p-0">
                        <div class="row g-0 align-items-center">
                            <div class="col-lg-6">
                                <div class="timeline-logo-area d-flex align-items-center">
                                    <div class="timeline-logo">
                                        <a href="index.html">
                                            <img src="assets/images/logo/logo.png" alt="timeline logo">
                                        </a>
                                    </div>
                                    <div class="timeline-tagline">
                                        <h6 class="tagline">Ça aide de se connecter et de partager avec les gens</h6>
                                    </div>
                                </div>
                            </div>
                            <form class="col-lg-6" action="./index.php" method="post">
                                    <div class="login-area">
                                        <div class="row align-items-center">
                                            <div class="col-12 col-sm">
                                                <input type="text" placeholder="Email" class="single-field" name="login">
                                            </div>
                                            <div class="col-12 col-sm">
                                                <input type="password" placeholder="Mot de passe" class="single-field" name="password">
                                            </div>
                                            <div class="col-12 col-sm-auto">
                                                <button class="login-btn" type="submit">Se connecter</button>
                                            </div>
                                            <?php
                                                if ( $loginStatus["Attempted"] ){
                                                    echo '<p style="color:white;margin-top:2%;margin-left:23%;font-size:bold">'.$loginStatus["ErrorMessage"].'</p>';
                                                }
                                            ?>
                                        </div>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="timeline-page-wrapper">
                    <div class="container-fluid p-0">
                        <div class="row g-0">
                            <div class="col-lg-6 order-2 order-lg-1">
                                <div class="timeline-bg-content bg-img" data-bg="assets/images/photos/baniere.jpg">
                                    <h3 class="timeline-bg-title">Voyons ce qui se passe dans votre monde.Bienvenue sur Adda</h3>
                                </div>
                            </div>
                            <div class="col-lg-6 order-1 order-lg-2 d-flex align-items-center justify-content-center">
                                <div class="signup-form-wrapper">
                                    <h1 class="create-acc text-center">Creer un compte</h1>
                                    <div class="signup-inner text-center">
                                        <h3 class="title">Bienvenue sur Adda</h3>
                                        <form class="signup-inner--form" action="./index.php" method="post">
                                            <div class="row">
                                                <div class="col-12">
                                                    <input type="email" class="single-field" placeholder="Email" name="new_mail">
                                                    <?php
                                                        if ( $registerStatus["Attempted"] ){
                                                            echo '<p style="color:#dc4734;margin-bottom:2%">'.$registerStatus["ErrorMessage"].'</p>';
                                                        }
                                                    ?>
                                                    <?php
                                                        if ( $registerStatus["Attempted"] ){
                                                            echo '<p style="color:#dc4734;margin-bottom:2%">'.$registerStatus["ErrorMessage3"].'</p>';
                                                        }
                                                    ?>                                                
                                                </div>
                                               
                                                <div class="col-12">
                                                    <input type="password" class="single-field" placeholder="Password" name="new_password">
                                                </div>
                                                <?php
                                                if ( $registerStatus["Attempted"] ){
                                                    echo '<p style="color:#dc4734;margin-bottom:2%">'.$registerStatus["ErrorMessage1"].'</p>';
                                                }
                                                 ?>
                                                <div class="col-md-6">
                                                    <input type="text" class="single-field" placeholder="First Name" name="first_name">
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" class="single-field" placeholder="Last Name" name="last_name">
                                                </div>
                                                <div class="col-md-6">
                                                    <select class="nice-select" name="genre">
                                                        <option value="trending">Gender</option>
                                                        <option value="male">Male</option>
                                                        <option value="female">Female</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <select class="nice-select" name="age">
                                                        <option value="age">Age</option>
                                                        <option value="18+">18+</option>
                                                        <option value="18-">18-</option>
                                                    </select>
                                                </div>
                                                <div class="col-12">
                                                    <select class="nice-select" name="pays">
                                                        <option value="trending">Country</option>
                                                        <option value="Bangladesh">Bangladesh</option>
                                                        <option value="Noakhali">Noakhali</option>
                                                        <option value="Australia">Australia</option>
                                                        <option value="Chine">China</option>
                                                        <option value="Inde">Inde</option>
                                                        
                                                    </select>
                                                </div>
                                                <div class="col-12">
                                                    <button class="submit-btn" type="submit">Creer mon compte</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- JS
============================================ -->

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