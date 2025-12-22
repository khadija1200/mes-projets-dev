<?php
// Inclure le fichier de configuration de la base de données et autres fonctions nécessaires
error_reporting(E_ALL);
ini_set('display_errors', 1);
require 'DatabaseFunctions.php';
ConnectDatabase();

// Récupérer l'ID de l'utilisateur à partir des paramètres de la requête
$userId = $_GET['userId'];

// Requête SQL pour récupérer les messages de l'utilisateur
$sql = "SELECT contenu_message, date_envoi
        FROM messages
        WHERE id_utilisateur_emetteur = ? OR id_utilisateur_destinataire = ?
        ORDER BY date_envoi";

// Préparation de la requête
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $userId, $userId);

// Exécution de la requête
$stmt->execute();

// Récupération des résultats
$result = $stmt->get_result();

// Générer le HTML des messages avec les classes appropriées
$html = '';
while ($row = $result->fetch_assoc()) {
    // Déterminer la classe CSS en fonction de l'auteur du message
    $messageClass = ($row['author_id'] == $userId) ? 'text-author' : 'text-friends';
    
    // Générer le HTML du message
    $html .= '<li class="' . $messageClass . '">';
    $html .= '<p>' . $row['contenu_message'] . '</p>';
    $html .= '<div class="message-time">' . $row['date_envoi'] . '</div>';
    $html .= '</li>';
}

// Retourner le HTML des messages
echo $html;
?>
