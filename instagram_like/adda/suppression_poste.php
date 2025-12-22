<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require 'DatabaseFunctions.php';
ConnectDatabase();


// Vérifier si l'ID du poste est envoyé via la requête POST
if(isset($_POST['post_id'])) {
    // Récupérer l'ID du poste à supprimer depuis la requête POST
    $post_id = $_POST['post_id'];

    // Appeler la fonction deleteposte pour supprimer le poste
    if(deleteposte($conn, $post_id)) {
        echo "Le poste a été supprimé avec succès.";
    } else {
        echo "Erreur lors de la suppression du poste.";
    }
} else {
    echo "L'ID du poste n'est pas spécifié.";
}

// Fonction pour supprimer le poste de la base de données
function deleteposte($conn, $post_id) {
    // Requête SQL pour mettre à jour le champ visibilite du poste à 0
    $sql = "UPDATE poste SET visibilite = 0 WHERE id = $post_id";

    // Exécution de la requête SQL
    if (mysqli_query($conn, $sql)) {
        // Succès de la mise à jour
        return true;
    } else {
        // Erreur lors de la mise à jour
        return false;
    }
}
?>
