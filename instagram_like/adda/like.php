<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require 'DatabaseFunctions.php';
ConnectDatabase();

// Vérifier les paramètres reçus
if (isset($_POST['userID']) && isset($_POST['postID']) && isset($_POST['userId'])) {
    $userID = $_POST['userID'];
    $postID = $_POST['postID'];
    $userId=$_POST['userId'];
    // Vérifier si l'utilisateur a déjà aimé le post
    if (doLike($userID, $postID)) {
        decrementLikes($postID);
        deleteNotification($postID, $userID);
        $conn->query("DELETE FROM dolike WHERE utilisateur_id = $userID AND post_id = $postID");
    } else {
        incrementLikes($postID);
        $conn->query("INSERT INTO dolike (utilisateur_id, post_id) VALUES ($userID, $postID)");
        addLikeNotification($userID, $postID, $userId);
    }
}
?>
