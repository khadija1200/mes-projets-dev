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
    $posts = getAllPosts();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['recent']) && $_POST['recent'] == 'on') {
            // Si l'utilisateur a coche la case "populaire", trier les posts par popularite
            $posts = postRecents($userID);
        }
        elseif (isset($_POST['averti_post']) && $_POST['averti_post'] == 'on') {
            // Si l'utilisateur a coche la case "averti", affiche post averti
            $posts = postAvertir($userID);
        }
        elseif (isset($_POST['retire_post']) && $_POST['retire_post'] == 'on') {
            // Si l'utilisateur a coche la case "averti", affiche post retire
            $posts = postRetire($userID);
        }
        else {
            // Sinon, trier les posts de non suivis par ordre le plus récent
            $posts = postRecents($userID);
        }
    }

    
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
                                <li class="active"><a href="index.php">Deconnexion</a></li>
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
                </div>
            </div>
        </div>
    </header>
    <!-- header area end -->
    <!-- header area start -->
    <header>
        <div class="mobile-header-wrapper sticky d-block d-lg-none">
            <div class="mobile-header position-relative ">
                <div class="mobile-logo">
                    <a href="index.html">
                        <img src="assets/images/logo/logo-white.png" alt="logo">
                    </a>
                </div>
            </div>
        </div>
    </header>
    <!-- header area end -->

    <main>

        <div class="main-wrapper pt-80">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 order-2 order-lg-1">
                        <aside class="widget-area">
                            <!-- widget single item start -->
                            <div class="card card-profile widget-item p-0">
                                <div class="profile-banner">
                                    <figure class="profile-banner-small">
                                        <a href="profile.html">
                                            <img src="<?php echo $infos['avatar']; ?>" alt="">
                                        </a>
                                        <a href="profile.html" class="profile-thumb-2">
                                            <img src="assets/images/photos/adda.png" alt="" >
                                        </a>
                                    </figure>
                                    <div class="profile-desc text-center">
                                        <?php
                                            $fullName = $infos['prenom'] . ' ' . $infos['nom'];
                                        ?>
                                        <h6 class="author"><a href="profile.php"><?php echo $fullName; ?></a></h6>
                                        <p>Page administrateur</p>
                                    </div>
                                </div>
                            </div>
                        </aside>
                    </div>

                    <div class="col-lg-6 order-1 order-lg-2">
                        <div class="card">
                            <h4 class="widget-title">Filtrer les posts</h4>
                            <!-- Formulaire pour trier les posts -->
                            <!-- <form id="post">
                                <input type="checkbox" id="plusRecents" name="plusRecents" value="plusRecents">
                                <label for="plusRecents">Plus recents</label>
                                <input type="checkbox" id="plusPopulaires" name="plusPopulaires" value="plusPopulaires">
                                <label for="plusPopulaires">Plus populaires</label>
                                <button class="edit-btn" type="submit">Filtrer</button>
                            </form> -->
                            <form method="post">
                                <label class="author" for="recent"><span style="padding-left: 10px;">Posts recents</span></label>
                                <input type="checkbox" id="recent" name="recent">
                                <label class="author" for="averti_post"><span style="padding-left: 10px;">Posts Averti</span></label>
                                <input type="checkbox" id="averti_post" name="averti_post">
                                <label class="author" for="retire_post"><span style="padding-left: 10px;">Posts Retire</span></label>
                                <input type="checkbox" id="retire_post" name="retire_post">
                                <button class="edit-btn" type="submit"><span style="font-size:12px; padding: 10px;">Filtrer</span></button>
                            </form>
                        </div>
                        <!-- post status start -->
                        <?php foreach ($posts as $post): 
                            $id_poste = $post['id'];
                        ?>
                        <div class="card">
                                <!-- post title start -->
                                <div class="post-title d-flex align-items-center">
                                    <!-- profile picture end -->
                                    <div class="profile-thumb">
                                        <a href="#">
                                            <figure class="profile-thumb-middle">
                                                <img src="<?php echo $post['utilisateur_avatar']; ?>" alt="profile picture" style="height:100%">
                                            </figure>
                                        </a>
                                    </div>
                                    <!-- profile picture end -->

                                    <div class="posted-author">
                                        <h6 class="author"><a href="profile1.php?id=<?php echo  $post['id_utilisateur']; ?>"><?php echo $post['utilisateur_prenom'] . ' ' . $post['utilisateur_nom'];?></a></h6>
                                        <span class="post-time"><?php echo $post['date_publication']; ?></span>
                                    </div>

                                    <div class="post-settings-bar">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                        <div class="post-settings arrow-shape">
                                            <ul>
                                                <li><a href="formulaire_avertissement.php?idPost=<?php echo  $post['id']; ?>&userId=<?php echo $post['id_utilisateur']; ?>"><button>Envoyer avertissement</button></a></li>
                                                <li><a href="formulaire_suppression.php?idPost=<?php echo  $post['id']; ?>&userId=<?php echo $post['id_utilisateur']; ?>"><button>Supprimer le post</button></li>
                                                <li><a href="formulaire_remettre.php?idPost=<?php echo  $post['id']; ?>&userId=<?php echo $post['id_utilisateur']; ?>"><button>Remettre le post</button></li>
                                                <li><a href="formulaire_sensibilite.php?idPost=<?php echo  $post['id']; ?>&userId=<?php echo $post['id_utilisateur']; ?>"><button>Marquer sensible</button></a></li>
                                                <li><a href="formulaire_banne.php?userId=<?php echo $post['id_utilisateur']; ?>"><button>Banir cet utilisateur</button></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!-- post title start -->
                                <div class="post-content">
                                    <p class="post-desc"><?php echo $post['description']; ?></p>
                                    <?php
                                            if ($post['visibilite']==0) {
                                                echo '<p class="post-desc">Ce post a été supprimé</p>';
                                            }
                                    ?>
                                    <?php
                                            if ($post['averti']==1) {
                                                echo '<p class="post-desc">Ce post a été averti</p>';
                                            }
                                    ?>
                                    <?php
                                            if ($post['sensible']==1) {
                                                echo '<p class="post-desc">Ce post a été marqué sensible</p>';
                                            }
                                    ?>
                                    <div class="post-thumb-gallery">
                                        <figure class="post-thumb img-popup">
                                            <a href="<?php echo $post['photo_url']; ?>">
                                                <img src="<?php echo $post['photo_url']; ?>">
                                            </a>
                                        </figure>
                                    </div>
                                </div> 
                            </div>
                        <?php endforeach; ?>
                        <!-- post status end -->
                    </div>

                    <div class="col-lg-3 order-3">
                        <aside class="widget-area">
                            
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

</body>

</html>