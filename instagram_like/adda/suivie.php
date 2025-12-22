<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require 'DatabaseFunctions.php';
ConnectDatabase();
// Vérifiez le paramètre d'action pour décider de suivre ou de ne plus suivre
if ($_POST['action'] === 'suivre') {
    // Appeler la fonction pour ajouter une relation follow dans la base de données
    followUser($_POST['followerID'], $_POST['followedID']);
} else {
    // Appeler la fonction pour supprimer une relation follow de la base de données
    unfollowUser($_POST['followerID'], $_POST['followedID']);
}
?>
