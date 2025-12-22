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

<body>

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
            $followers = getFollowersInfo($userID);
            $followed  =getFollowedInfo($userID);
            $numbFollowers=getNumberOfFollowers($userID);
            $numbSuivis=getNumberOfFollowings($userID);
            $postStatus = Onpost($userID);
            if ($postStatus["Successful"]) {
                $redirection = "profile.php";
                header("Location: $redirection");
            }
            $posts = postUser($userID);
            $nbposts = countUserPosts($userID);
            $moypostsweek = number_format(countMoyPostsSemaine($userID),3);
            $moypostsmonth = number_format(countMoyPostsMois($userID),3);

            $nblikesdonees = countLikesDonees($userID);
            $nblikesdoneesweek = number_format(countMoyLikesDonnesSemaine($userID), 3);
            $nblikesdoneesmonth = number_format(countMoyLikesDonnesMois($userID),3); 

            $nblikesrecus = countLikesRecus($userID);
            $nblikesrecusweek = number_format(countMoyLikesRecusSemaine($userID),3);
            $nblikesrecusmonth = number_format(countMoyLikesRecusMois($userID),3); 

            $nbcommentairesrecus = countCommentairesRecus($userID);
            $nbcommentairesdonees = countCommentairesDonnes($userID);

            $taux_engagement = calculTauxEngage($nblikesrecus, $nbcommentairesrecus, $nbposts);

            $messageInfos=getInteractedUsersAndMessages($userID);

    ?>

    <!-- header area start -->
    <header>
        <div class="header-top sticky bg-white d-none d-lg-block">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-5">
                        <!-- header top navigation start -->
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
                            <a href="accueil.php">
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
    <!-- header area end -->
    

    <main>

        <div class="main-wrapper">
            <!-- profile banner area start -->
            <div class="profile-banner-large bg-img" data-bg="assets/images/photos/baniere.jpg">
            </div>
            <!-- profile banner area end -->

            <!-- profile menu area start -->
            <div class="profile-menu-area bg-white">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-3 col-md-3">
                            <div class="profile-picture-box" style="width: 270px; height: 270px; overflow: hidden;">
                                <figure class="profile-picture">
                                    <a href="profile.php">
                                        <img src="<?php echo $infos['avatar']; ?>" alt="profile picture" style="width: 100%; height: 270px;">
                                    </a>
                                </figure>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 offset-lg-1">
                            <div class="profile-menu-wrapper">
                                <div class="main-menu-inner header-top-navigation">
                                    <nav>
                                        <ul class="main-menu">
                                            <li class="active"><a><?php echo $nbposts; ?> publications</a></li>
                                            <li><a><?php echo $numbFollowers; ?> followers</a></li>
                                            <li><a><?php echo $numbSuivis; ?> suivies</a></li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-3 d-none d-md-block">
                            <div class="profile-edit-panel">
                            <a href="parameters.php"><button class="edit-btn" >Edit Profile</button></a>                           
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- profile menu area end -->

            <!-- photo section start -->
            <div class="photo-section">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="content-box">
                                <h5 class="content-title">Mes Statistiques Personnelles</h5>
                                <div class="content-body">
                                    <div class="row mt--30">
                                        <div class="col-sm-6 col-md-4">
                                            <div class="photo-group">
                                                <div class="gallery-toggle">
                                                    <div class="gallery-overlay">
                                                        <h3 style="text-align: center; background-color: #D3D3D3; font-size: 15px; padding : 10px">Followers : <?php echo $numbFollowers; ?></h3>
                                                    </div>
                                                    <div class="gallery-overlay">
                                                        <h3 style="text-align: center; background-color: #D3D3D3; font-size: 15px; padding : 10px">Suivies : <?php echo $numbSuivis; ?></h3>
                                                    </div>
                                                    <div class="gallery-overlay">
                                                        <h3 style="text-align: center; background-color: #D3D3D3; font-size: 15px; padding : 10px"></h3>
                                                    </div>
                                                    <div class="photo-gallery-caption">
                                                        <h3 class="photos-caption">Follow</h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-4">
                                            <div class="photo-group">
                                                <div class="gallery-toggle">
                                                    <div class="gallery-overlay">
                                                        <h3 style="text-align: center; background-color: #D3D3D3; font-size: 15px; padding : 10px">Total : <?php echo $nbposts ?></h3>
                                                    </div>
                                                    <div class="gallery-overlay">
                                                        <h3 style="text-align: center; background-color: #D3D3D3; font-size: 15px; padding : 10px">Moyenne / semaine : <?php echo $moypostsweek ?></h3>
                                                    </div>
                                                    <div class="gallery-overlay">
                                                        <h3 style="text-align: center; background-color: #D3D3D3; font-size: 15px; padding : 10px">Moyenne / mois : <?php echo $moypostsmonth ?></h3>
                                                    </div>
                                                    <div class="photo-gallery-caption">
                                                        <h3 class="photos-caption">Posts</h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-4">
                                            <div class="photo-group">
                                                <div class="gallery-toggle">
                                                    <div class="gallery-overlay">
                                                        <h3 style="text-align: center; background-color: #D3D3D3; font-size: 15px; padding : 10px">Total : <?php echo $nblikesdonees ?></h3>
                                                    </div>
                                                    <div class="gallery-overlay">
                                                        <h3 style="text-align: center; background-color: #D3D3D3; font-size: 15px; padding : 10px">Moyenne / semaine : <?php echo $nblikesdoneesweek ?></h3>
                                                    </div>
                                                    <div class="gallery-overlay">
                                                        <h3 style="text-align: center; background-color: #D3D3D3; font-size: 15px; padding : 10px">Moyenne / mois : <?php echo $nblikesdoneesmonth ?></h3>
                                                    </div>
                                                    <div class="photo-gallery-caption">
                                                        <h3 class="photos-caption">Likes Données</h3>
                                                    </div>
                                                </div>
                                            </div> 
                                        </div>
                                        <div class="col-sm-6 col-md-4">
                                            <div class="photo-group">
                                                <div class="gallery-toggle">
                                                    <div class="gallery-overlay">
                                                        <h3 style="text-align: center; background-color: #D3D3D3; font-size: 15px; padding : 10px">Total : <?php echo $nblikesrecus ?></h3>
                                                    </div>
                                                    <div class="gallery-overlay">
                                                        <h3 style="text-align: center; background-color: #D3D3D3; font-size: 15px; padding : 10px">Moyenne / semaine : <?php echo $nblikesrecusweek ?></h3>
                                                    </div>
                                                    <div class="gallery-overlay">
                                                        <h3 style="text-align: center; background-color: #D3D3D3; font-size: 15px; padding : 10px">Moyenne / mois : <?php echo $nblikesrecusmonth?></h3>
                                                    </div>
                                                    <div class="photo-gallery-caption">
                                                        <h3 class="photos-caption">Likes Recus : </h3> 
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-4">
                                            <div class="photo-group">
                                                <div class="gallery-toggle">
                                                    <div class="gallery-overlay">
                                                        <h3 style="text-align: center; background-color: #D3D3D3; font-size: 15px; padding : 10px">Recus : <?php echo $nbcommentairesrecus ?></h3>
                                                    </div>
                                                    <div class="gallery-overlay">
                                                        <h3 style="text-align: center; background-color: #D3D3D3; font-size: 15px; padding : 10px">Donees : <?php echo $nbcommentairesdonees ?></h3>
                                                    </div>
                                                    <div class="photo-gallery-caption">
                                                        <h3 class="photos-caption">Commentaires : </h3> 
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-4">
                                            <div class="photo-group">
                                                <div class="gallery-toggle">
                                                    <div class="gallery-overlay">
                                                        <h3 style="text-align: center; background-color: #D3D3D3; font-size: 15px; padding : 10px">Taux : <?php echo $taux_engagement ?> %</h3>
                                                    </div>
                                                    <div class="photo-gallery-caption">
                                                        <h3 class="photos-caption">Taux Engagements : </h3> 
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- photo section end -->

            

        </div>

    </main>

    <!-- Scroll to top start -->
    <div class="scroll-top not-visible">
        <i class="bi bi-finger-index"></i>
    </div>
    <!-- Scroll to Top End -->

    <footer class="d-none d-lg-block">
        <div class="footer-area reveal-footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="footer-wrapper">
                            <div class="footer-card position-relative">
                                <div class="friends-search">
                                    <form class="search-box">
                                        <input type="text" placeholder="Search Your Friends" class="search-field" id="searchInput" onkeyup="searchFriends()">
                                        <button class="search-btn"><i class="flaticon-search"></i></button>
                                    </form>
                                </div>
                                <div class="friend-search-list">
                                    <div class="frnd-search-title">
                                        <button class="frnd-search-icon"><i class="flaticon-settings"></i></button>
                                        <p>search friends</p>
                                        <button class="close-btn" data-close="friend-search-list"><i class="flaticon-cross-out"></i></button>
                                    </div>
                                    <div class="frnd-search-inner custom-scroll">
                                        <ul id="suggestions">
                                            
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-small mb-0 active-profile-wrapper">
                                <div class="active-profiles-wrapper">
                                    <div class="active-profile-carousel slick-row-20 slick-arrow-style">
                                        <!-- profile picture end -->
                                        <?php foreach ($messageInfos as $messageInfo): 
                                        ?>
                                            <div class="single-slide">
                                                <div class="profile-thumb active profile-active">
                                                    <a href="#">
                                                    <button  data-user-id="<?php echo $messageInfo['utilisateur_id']; ?>" onclick="loadConversation(<?php echo $messageInfo['utilisateur_id']; ?>)">
                                                        <figure class="profile-thumb-small">
                                                            <img src="<?php echo $messageInfo['utilisateur_avatar']; ?> " alt="profile picture" style="width:100%">
                                                        </figure>
                                                    </button>
                                                    </a>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                        <!-- profile picture end -->
                                    </div>
                                </div>
                            </div>
                            <div class="footer-card position-relative">
                                <div class="live-chat-inner">

                                    <div class="chat-output-box">
                                        <div class="live-chat-title">
                                            <!-- profile picture end -->
                                            <div class="profile-thumb active">
                                                <a href="#">
                                                    <figure class="profile-thumb-small">
                                                        <img src="<?php echo $messageInfo['utilisateur_avatar']; ?> " alt="profile picture">
                                                    </figure>
                                                </a>
                                            </div>
                                            <!-- profile picture end -->
                                            <div class="posted-author">
                                                <h6 class="author"><a href="profile.html">Robart Marloyan</a></h6>
                                                <span class="active-pro">active now</span>
                                            </div>
                                            <div class="live-chat-settings ms-auto">
                                                <button class="chat-settings"><i class="flaticon-settings"></i></button>
                                                <button class="close-btn" data-close="chat-output-box"><i class="flaticon-cross-out"></i></button>
                                            </div>
                                        </div>
                                        <div class="message-list-inner">
                                            <ul class="message-list custom-scroll">
                                               
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="chat-text-field">
                                        <textarea class="live-chat-field custom-scroll" placeholder="Text Message"></textarea>
                                        <button class="chat-message-send" type="submit" value="submit">
                                            <img src="assets/images/icons/plane.png" alt="">
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    
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