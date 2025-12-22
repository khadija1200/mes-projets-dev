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
     if(isset($_GET['id'])) {
        $userId = $_GET['id'];
    } 
    $infos = getUserInfoById($userId);
    $followers = getFollowersInfo($userId);
    $followed  =getFollowedInfo($userId);
    $numbFollowers=getNumberOfFollowers($userId);
    $numbSuivis=getNumberOfFollowings($userId);
    $posts=postUser($userId);
    $nbposts=countUserPosts($userId);

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

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    
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
                                    <a href="profile.html">
                                        <img src="<?php echo $infos['avatar']; ?>" alt="profile picture" style="width: 100%; height: 270px;;">
                                    </a>
                                </figure>
                            </div>

                        </div>
                        <div class="col-lg-6 col-md-6 offset-lg-1">
                            <div class="profile-menu-wrapper">
                                <div class="main-menu-inner header-top-navigation">
                                    <nav>
                                        <ul class="main-menu">
                                            <li class="active"><a href="#"><?php echo $nbposts; ?> publications </a></li>
                                            <li><a href="about.html"><span id="followersCount"><?php echo $numbFollowers; ?></span> followers</a></li>
                                            <li><a href="photos.html"><?php echo $numbSuivis; ?> suivies</a></li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-3 d-none d-md-block">
                            <div class="profile-edit-panel">
                            <button class="edit-btn" onclick="suivie(<?php echo $userID; ?>, <?php echo $userId; ?>)">
                                <?php
                                if (followedExists($userID, $userId)) {
                                    echo "Ne plus suivre ";
                                } else {
                                    echo "suivre";
                                }
                                ?>
                            </button>
                           
                            </div>
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
                                            <li><a href="#"><i class="bi bi-home"></i><?php echo $infos['pays']; ?></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- widget single item end -->

                            <!-- widget single item start -->
                            <div class="card widget-item">
                                <h4 class="widget-title">Suivies</h4>
                                <div class="widget-body">
                                    <ul class="like-page-list-wrapper">
                                        <?php
                                            
                                            if (!empty($followed)) {
                                                // Parcourir le tableau des utilisateurs suivis
                                                foreach ($followed as $followedUsers) {
                                                    // Construire la structure HTML pour chaque utilisateur suivi
                                                    echo '<li class="unorder-list">';
                                                    echo '<div class="profile-thumb">';
                                                    echo '<a><figure class="profile-thumb-small">';
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

                    <div class="col-lg-6 order-1 order-lg-2">                        
                    <?php foreach ($posts as $post): 
                            $id_poste = $post['id'];
                            $comments = commentairesUtilisateur($id_poste);
                    ?>
                        <div class="card">
                                <!-- post title start -->
                                <div class="post-title d-flex align-items-center">
                                    <!-- profile picture end -->
                                    <div class="profile-thumb">
                                        <a href="#">
                                            <figure class="profile-thumb-middle">
                                                <img src="<?php echo $post['avatar']; ?>" alt="profile picture" style="height:100%">
                                            </figure>
                                        </a>
                                    </div>
                                    <!-- profile picture end -->

                                    <div class="posted-author">
                                        <h6 class="author"><a href="profile.html"><?php echo $post['prenom'] . ' ' . $post['nom'];?></a></h6>
                                        <span class="post-time"><?php echo $post['date_publication']; ?></span>
                                    </div>

                                    <div class="post-settings-bar">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                        
                                    </div>
                                </div>
                                <!-- post title start -->
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
                                    <button class="post-meta-like" id="likeButton<?php echo $post['id'];?>" onclick="onlike(<?php echo $userID; ?>, <?php echo $post['id']; ?>); event.preventDefault();">
                                    <?php
                                        if (doLike($userID,$post['id'] )) {
                                            echo '<i class="bi bi-heart-beat" style="color:red"></i>';
                                        } else {
                                            echo '<i class="bi bi-heart-beat"></i>';
                                        }
                                    ?>
                                        <span id="likesCount<?php echo $post['id'];?>"><?php echo $post['nombre_likes'];?></span><span>likes</span>
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
                                    <!-- comment box start -->
                                    <div class="card card-small">
                                        <div class="share-box-inner">
                                            <!-- share content box start -->
                                            <div class="share-content-box w-100">
                                                <form class="share-text-box">
                                                    <textarea  class="share-text-field" aria-disabled="true" placeholder="Tu as envie de partager quelque chose !?" id="commentInput<?php echo $post['id']; ?>" ></textarea>
                                                    <button class="btn-share" onclick="sendcomment(<?php echo $userID; ?>, <?php echo $post['id']; ?>,<?php echo $post['utilisateur_id']; ?>) ; event.preventDefault();">comment</button>
                                                </form>
                                            </div>
                                            <!-- share content box end -->
                                            <!-- Modal start -->
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
                                                                                echo '<a>';
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
                                    </div>
                                    <!-- share box end -->
                            </div>
                        <?php endforeach; ?>
                        
                        <!-- post status end -->
                    </div>

                    <div class="col-lg-3 order-3">
                        <aside class="widget-area">
                            <!-- widget single item start -->
                            
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
                                            }else {

                                                echo 'Aucun folowers.';
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