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
    <link href="fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <script src="functions.js"></script>


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
            $posts=postUser($userID);
            $nbposts=countUserPosts($userID);
            $messageInfos=getInteractedUsersAndMessages($userID);


    ?>
    <!-- header area start -->
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
            <div class="profile-banner-large bg-img" data-bg="assets/images/photos/baniere.jpg">
            </div>
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
                                            <li class="active"><a><?php echo $nbposts; ?> publications </a></li>
                                            <li><a><?php echo $numbFollowers; ?> followers</a></li>
                                            <li><a><?php echo $numbSuivis; ?> suivies</a></li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-3 d-none d-md-block">
                            <div class="profile-edit-panel">
                            <button class="edit-btn" onclick="redirectToParameters()">Edit Profile</button>                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 order-2 order-lg-1">
                        <aside class="widget-area profile-sidebar">
                            <!-- widget single item start -->
                            <div class="card widget-item">
                                <?php
                                 $fullName = $infos['prenom'] . ' ' . $infos['nom'];
                                ?>
                                <h4 class="widget-title"><?php echo $fullName; ?></h4>
                                <div class="widget-body">
                                    <div class="about-author">
                                        <p><?php echo $infos['description_user']; ?></p>
                                        <ul class="author-into-list">
                                            <li><a href="#"><i class="bi bi-home"></i><?php echo$infos['pays']?></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- widget single item end -->

                            <!-- widget single item start -->
                            <div class="card widget-item">
                                <h4 class="widget-title">Followers</h4>
                                <div class="widget-body">
                                    <ul class="like-page-list-wrapper">
                                    <?php
                                    if (!empty($followers)) {
                                        foreach ($followers as $follower) {
                                            echo '<li class="unorder-list">';
                                            // Profile picture
                                                echo '<div class="profile-thumb">';
                                                echo '<a>';
                                                echo '<figure class="profile-thumb-small">';
                                                // Utilisation de l'URL de l'image stockée dans la base de données
                                                echo '<img src="' . $follower['avatar'] . '" alt="profile picture">';
                                                echo '</figure>';
                                                echo '</a>';
                                                echo '</div>';
                                                // Informations du follower
                                                echo '<div class="unorder-list-info">';
                                                $fullName = $follower['prenom'] . ' ' . $follower['nom'];
                                                echo '<h3 class="list-title"><a href="profile1.php?id=' . $follower['id'] . '">' . $fullName . '</a></h3>';
                                                echo '</div>';
                                                // Bouton de like
                                                echo '<button class="like-button">';
                                                echo '<img class="heart" src="assets/images/icons/heart.png" alt="">';
                                                echo '<img class="heart-color" src="assets/images/icons/heart-color.png" alt="">';
                                                echo '</button>';
                                            echo '</li>';
                                        } 
                                    }else{
                                            echo 'Aucun folowers.';
                                        }
                                    ?>
                                    </ul>
                                </div>
                            </div>
                            <!-- widget single item end -->
                        </aside>
                    </div>

                    <div class="col-lg-6 order-1 order-lg-2">
                        <!-- share box start -->
                        <div class="card card-small">
                            <div class="share-box-inner">
                                <!-- profile picture end -->
                                <div class="profile-thumb">
                                    <a href="#">
                                        <figure class="profile-thumb-middle">
                                            <img src="<?php echo $infos['avatar']; ?>" style="height:100%" alt="profile picture">
                                        </figure>
                                    </a>
                                </div>
                                <!-- profile picture end -->

                                <!-- share content box start -->
                                <div class="share-content-box w-100">
                                    <form class="share-text-box">
                                        <textarea name="share" class="share-text-field" aria-disabled="true" placeholder="Say Something" data-bs-toggle="modal" data-bs-target="#textbox" id="email"></textarea>
                                        <button class="btn-share" type="submit">share</button>
                                    </form>
                                </div>
                                <!-- share content box end -->
                                <!-- Modal start -->
                                <div class="modal fade" id="textbox" aria-labelledby="textbox">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Share Your Mood</h5>
                                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form method="post" action="./profile.php" enctype="multipart/form-data">
                                                <div class="modal-body custom-scroll">
                                                    <textarea name="share" class="share-field-big custom-scroll" placeholder="Partage quelque chose"></textarea>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="post-share-btn" data-bs-dismiss="modal">cancel</button>
                                                    <button type="submit" class="post-share-btn">post</button>
                                                    <input type="hidden" name="MAX_FILE_SIZE" value="5242880" />
                                                    <label for="fileUpload" class="upload-icon">
                                                    <i class="bi bi-share"></i>
                                                    </label>
                                                    <input type="file" id="fileUpload" name="fileUpload" style="display: none;">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal end -->
                            </div>
                        </div>
                        <!-- share box end -->

                        <?php foreach ($posts as $post):
                        $id_poste = $post['id'];
                        $comments = commentairesUtilisateur($id_poste);
                         ?>
                            <div class="card">
                                 <!-- post title start -->
                                <div class="post-settings-bar">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                        <div class="post-settings arrow-shape">
                                            <ul>
                                                <li><button class="delete-btn" onclick="deletePost(<?php echo $post['id']; ?>)">Supprimer le poste</button></li>
                                            </ul>
                                        </div>
                                </div>
                                <div class="post-content">
                                    <p class="post-desc"><?php echo $post['description']; ?></p>
                                    <div class="post-thumb-gallery">
                                        <figure class="post-thumb img-popup">
                                            <a href="<?php echo $post['photo_url']; ?>">
                                                <img src="<?php echo $post['photo_url']; ?>">
                                            </a>
                                        </figure>
                                    </div>
                                    <div class="post-meta">
                                    <button class="post-meta-like" >
                                       <i class="bi bi-heart-beat"></i>
                                       <span><?php echo $post['nombre_likes'];?>  likes </span>
                                    </button>
                                        <ul class="comment-share-meta">
                                            <li>
                                                <button class="post-comment" data-bs-toggle="modal" data-bs-target="#textbox<?php echo $post['id']; ?>">
                                                        <i class="bi bi-chat-bubble"></i>
                                                        <span id="commentsCount<?php echo $post['id'];?>"><?php echo $post['nombre_commentaires']; ?></span>
                                                </button>
                                            </li>
                                            <li>
                                                <button class="post-share">
                                                    <i class="bi bi-share"></i>
                                                    <span>2</span>
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="modal fade" id="textbox<?php echo $post['id']; ?>" aria-labelledby="textbox">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Commentaires</h5>
                                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form method="post" action="./index.php" enctype="multipart/form-data">
                                                            <div class="modal-body custom-scroll">
                                                                <ul class="like-page-list-wrapper">
                                                                    <?php
                                                                    if (!empty($comments)) {
                                                                        foreach ($comments as $comment) {
                                                                            echo '<li class="unorder-list">';
                                                                            // Profile picture
                                                                                echo '<div class="profile-thumb">';
                                                                                echo '<a href="#">';
                                                                                echo '<figure class="profile-thumb-small">';
                                                                                // Utilisation de l'URL de l'image stockée dans la base de données
                                                                                echo '<img src="' . $comment['avatar'] . '" alt="profile picture" style="width: 100%;">';
                                                                                echo '</figure>';
                                                                                echo '</a>';
                                                                                echo '</div>';
                                                                                // Informations du follower
                                                                                echo '<div class="unorder-list-info">';
                                                                                $fullName = $comment['prenom'] . ' ' . $comment['nom'];
                                                                                echo '<h3 class="list-title"><a href="profile1.php">' . $fullName . '</a></h3>';
                                                                                echo '<p class="list-subtitle">'. $comment['contenu_commentaire'] .'</p>';
                                                                                echo '</div>';
                                                                                // Bouton de like
                                                                                echo '<button class="like-button">';
                                                                                echo '<img class="heart" src="assets/images/icons/heart.png" alt="">';
                                                                                echo '<img class="heart-color" src="assets/images/icons/heart-color.png" alt="">';
                                                                                echo '</button>';
                                                                            echo '</li>';
                                                                        } 
                                                                        }else{
                                                                            echo 'Aucun commentaires';
                                                                        }
                                                                    ?>
                                                                </ul>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal end -->
                            </div>
                        <?php endforeach; ?>
                        
                    </div>

                    <div class="col-lg-3 order-3">
                        <aside class="widget-area">
                            <!-- widget single item start -->
                            <div class="card widget-item">
                                <h4 class="widget-title">Suivies</h4>
                                <div class="widget-body">
                                    <ul class="like-page-list-wrapper">
                                        <?php

                                            // Vérifier si des utilisateurs ont été récupérés
                                            if (!empty($followed)) {
                                                // Parcourir le tableau des utilisateurs suivis
                                                foreach ($followed as $followedUsers) {
                                                    // Construire la structure HTML pour chaque utilisateur suivi
                                                    echo '<li class="unorder-list">';
                                                    echo '<div class="profile-thumb">';
                                                    echo '<a href="#"><figure class="profile-thumb-small">';
                                                    echo '<img src="' . $followedUsers['avatar'] . '" alt="profile picture">';
                                                    echo '</figure></a></div>';
                                                    echo '<div class="unorder-list-info">';
                                                    echo '<h3 class="list-title"><a href="profile1.php?id=' . $followedUsers['id'] . '">' . $followedUsers['prenom'] . ' ' . $followedUsers['nom'] . '</a></h3>';
                                                    echo '</div>';
                                                    echo '<button class="like-button">';
                                                    echo '<img class="heart" src="assets/images/icons/heart.png" alt="">';
                                                    echo '<img class="heart-color" src="assets/images/icons/heart-color.png" alt="">';
                                                    echo '</button>';
                                                    echo '</li>';
                                                }
                                            } else {
                                                echo 'Aucun utilisateur suivi.';
                                            }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                            <!-- widget single item end -->
                        </aside>
                    </div>
                </div>
            </div>
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
    <!-- footer area end -->
    <!-- footer area start -->
    
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
    <script>
    function redirectToParameters() {
        window.location.href = 'parameters.php';
    }
</script>

</body>

</html>