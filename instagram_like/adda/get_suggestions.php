<?php
// Connexion à la base de données et configuration
error_reporting(E_ALL);
ini_set('display_errors', 1);
require 'DatabaseFunctions.php';
ConnectDatabase();
// Récupérer le terme de recherche depuis la requête GET
$searchTerm = isset($_GET['searchTerm']) ? trim(mysqli_real_escape_string($conn, $_GET['searchTerm'])) : '';

// Requête SQL pour rechercher les utilisateurs dont le nom correspond au terme de recherche
$sql = "SELECT id, nom, prenom, avatar FROM utilisateurs WHERE (nom LIKE '%$searchTerm%' OR prenom LIKE '%$searchTerm%') AND isadmin = 0 ORDER BY nom";

// Exécuter la requête SQL
$result = $conn->query($sql);

// Tableau pour stocker les suggestions
$suggestions = array();

// Parcourir les résultats et les ajouter au tableau de suggestions
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $suggestion = array(
            'id' => $row['id'],
            'name' => $row['prenom'] . ' ' . $row['nom'],
            'avatar' => $row['avatar']
        );
        $suggestions[] = $suggestion;
    }
}

// Renvoyer les suggestions au format JSON
echo json_encode($suggestions);
?>
