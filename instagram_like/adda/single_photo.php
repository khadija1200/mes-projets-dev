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
        if(isset($_GET['postId'])) {
            $ID_photo = $_GET['postId'];
        } 
        $post=getPostInfo($ID_photo)
        
        ?>
        <div class="main-wrapper pt-80" >
            <div class="container" >
                <div class="row justify-content-center" >
                    <div class="col-lg-6 order-1 order-lg-2">
                        <div class="card" >
                                <!-- post title start -->
                                <div class="post-title d-flex align-items-center">
                                    <!-- profile picture end -->
                                    <div class="posted-author">
                                        <span class="post-time"><?php echo $post['date_publication']; ?></span>
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
                        <!-- post status end -->
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