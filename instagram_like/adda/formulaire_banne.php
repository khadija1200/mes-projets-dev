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

        <?php
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        require 'DatabaseFunctions.php';
        ConnectDatabase();
        session_start();
        if (isset($_SESSION['userID'])) {
            $userID = $_SESSION['userID'];
        } 
        $IdPost = null;
        $userId = null; 
        if(isset($_GET['userId'])) {
            $userId = $_GET['userId'];
        } 
        ?>

        <div class="signup-form-wrapper" style="margin-top:5%" >
            <h1 class="create-acc text-center">Banir cet utilisateur</h1>
            <div class="signup-inner text-center">
                <h3 class="title">Motifs</h3>
                <form class="signup-inner--form" method="post" action="./formulaire_banne.php">
                    <div class="row">
                        
                        <div class="col-12">
                            <input type="text" class="single-field" name="motifs" value="Nos moderateurs ont décidé de vous banir temporairement ">
                            <input type="hidden" name="emetteur_id" value=<?php echo $userID ?>> 
                            <input type="hidden" name="post_id" value=<?php echo $IdPost ?>> 
                            <input type="hidden" name="id_utilisateur" value=<?php echo $userId ?>> 
                        </div>
                        <div class="col-12">
                            <button class="submit-btn" type="submit">Envoyer</button>
                        </div>
                    </div>
                </form>
            </div>
            
<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!empty($_POST['motifs'])) {
            $motif = $_POST['motifs'];
            $emetteur_id = $_POST['emetteur_id']; 
    
            // Vérifier si la variable id_utilisateur est définie
            if(isset($_POST['id_utilisateur'])) {
                $utilisateur_id = $_POST['id_utilisateur']; 
    
                // Mettre à jour le champ banni de l'utilisateur à 1
                $sql_update_banni = "UPDATE utilisateurs SET banni = 1 WHERE id = $utilisateur_id";
                if(mysqli_query($conn, $sql_update_banni)) {
    
                    // Récupérer l'e-mail de l'utilisateur concerné
                    $sql_get_email = "SELECT email FROM utilisateurs WHERE id = $utilisateur_id";
                    $result = mysqli_query($conn, $sql_get_email);
                    $row = mysqli_fetch_assoc($result);
                    $email_utilisateur = $row['email'];
    
                    // Envoi de l'e-mail à l'utilisateur concerné
                    $sujet = "Vous avez été banni de notre site";
                    $message = "Bonjour, \n\n$motif\n\nCordialement,\nVotre équipe de modération";
                    $headers = "From: dijadione120@gmail.com";
    
                    if(mail($email_utilisateur, $sujet, $message, $headers)) {
                        echo "E-mail envoyé à l'utilisateur.";
                    } else {
                        echo "Erreur lors de l'envoi de l'e-mail à l'utilisateur.";
                    }
                } else {
                    echo "Erreur lors de la mise à jour du champ banni de l'utilisateur.";
                }
            } else {
                echo "La variable id_utilisateur n'est pas définie.";
            }
        } else {
            echo "Veuillez donner un motif";
        }
    }
    

?>



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