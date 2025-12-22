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
    $notifications = getNotifications($userID);
    ?>

<div class="message-dropdown" id="b">
    <div class="dropdown-title">
        <p class="recent-msg" style="font-size:40px;color:#dc4734;margin:auto">Notifications</p>
    </div>
    <ul class="dropdown-msg-list">
    <?php foreach ($notifications as $notification): ?>
        <li class="msg-list-item d-flex justify-content-between">
            <!-- profile picture -->
            <div class="profile-thumb">
                <figure class="profile-thumb-middle">
                    <img src="<?php echo $notification['emetteur_avatar']; ?>" alt="profile picture" style="width: 100%; height: auto;">
                </figure>
            </div>

            <!-- message content -->
            <div class="msg-content notification-content">
                <p style="font-size:20px"><?php echo $notification['contenu']; ?> </p><br>
                <p><a href="single_photo.php?postId=<?php echo $notification['post_id']; ?>">Cliquez pour voir le poste</a></p>
            </div>
            <!-- message time -->
            <div class="msg-time">
                <p><?php echo $notification['date_notification']; ?></p>
            </div>
        </li>
    <?php endforeach; ?>

        
    </ul>
    
</div>
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