<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require 'DatabaseFunctions.php';
ConnectDatabase();

if (isset($_POST['userID']) && isset($_POST['postID']) && isset($_POST['inputValue'])) {
    $userID = $_POST['userID'];
    $postID = $_POST['postID'];
    $inputValue = $_POST['inputValue'];
    $emetteur = $_POST['emetteur'];

    // Appel à la fonction pour ajouter une notification de commentaire
    addCommentNotification($userID, $postID, $emetteur,$inputValue);
    
    // Mise à jour du nombre de commentaires pour le poste
    updateNumberOfComments($postID);
    
    // Appel à la fonction pour ajouter le commentaire à la base de données
    Oncomment($userID, $postID, $inputValue);

    // Récupération des détails du nouveau commentaire ajouté
    //$newCommentDetails = getNewCommentDetails($userID, $postID);
    
    // Retourner les détails du nouveau commentaire au format JSON
    //echo json_encode($newCommentDetails);
    
} 

/* Fonction pour récupérer les détails du nouveau commentaire ajouté
function getNewCommentDetails($userID, $postID) {
    global $conn;

    $query = "SELECT utilisateurs.avatar, utilisateurs.prenom, utilisateurs.nom, Commentaire.contenu_commentaire
              FROM Commentaire
              INNER JOIN utilisateurs ON Commentaire.id_utilisateur = utilisateurs.id
              WHERE Commentaire.id_utilisateur = $userID AND Commentaire.id_poste = $postID
              ORDER BY Commentaire.id_commentaire DESC
              LIMIT 1";

    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row;
    } else {
        return null;
    }
}*/

?>