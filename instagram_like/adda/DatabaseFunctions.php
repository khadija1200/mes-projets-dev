<?php

// Function to open connection to database
//--------------------------------------------------------------------------------
function ConnectDatabase(){
    // Create connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "projet1";
    global $conn; //Crée variable globale depuis une fonction
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Check connection
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }
}


//Fonction pour traiter les données fornit par l'utilisateur
function SecurizeString_ForSQL($string) {
    $string = trim($string);//enleve les espaces
    $string = stripcslashes($string);
    $string = addslashes($string);
    $string = htmlspecialchars($string);//transforme les caracteres speciaux en entites
    return $string;
}
//Fonction pour la connexion

function CheckLogin() {
    global $conn, $username, $userID;

    $error = NULL; 
    $loginSuccessful = false;
    $isAdmin = false; // Initialiser isAdmin à false par défaut

    // Données reçues via formulaire?
    if(isset($_POST["login"]) && isset($_POST["password"])){
        $username = SecurizeString_ForSQL($_POST["login"]);
        $password = $_POST["password"];
        $loginAttempted = true;
    }
    else {
        $loginAttempted = false;
    }

    //Si un login a été tenté, on interroge la BDD
    if ($loginAttempted){
        $query = "
        SELECT *
        FROM utilisateurs
        WHERE email = '".$username."'
        AND mot_de_passe = '".$password."'
        AND banni = 0";

            
        $result = $conn->query($query);

        if ($result->num_rows != 0 ){
            $row = $result->fetch_assoc();
            $userID = $row["id"];
            $isAdmin = $row["isadmin"] == 1; // Vérifier si l'utilisateur est un administrateur
            $loginSuccessful = true;
        }
        else {
            $error = "*Email ou mot de passe incorrect";
        }
    }
    
    $resultArray = [
        'Successful' => $loginSuccessful, 
        'Attempted' => $loginAttempted, 
        'ErrorMessage' => $error,
        'userID' => $userID,
        'isAdmin' => $isAdmin // Ajouter isAdmin au tableau de retour
    ];

    return $resultArray;
}

//Fonction pour l'inscription
function Onregister() {
    global $conn;

    $error = NULL;
    $error1 = NULL;
    $error2 = NULL;
    $error3 = NULL;

    $mail = "";
    $password = "";
    $first_name = "";
    $last_name = "";
    $genre = "";
    $pays = "";

    $registerSuccessful = false;

    if(isset($_POST["new_mail"]) && isset($_POST["new_password"]) && isset($_POST["first_name"]) && isset($_POST["last_name"]) && isset($_POST["genre"]) && isset($_POST["age"]) && isset($_POST["pays"])) {
        $mail = SecurizeString_ForSQL($_POST["new_mail"]);
        $password = $_POST["new_password"];
        $first_name = $_POST["first_name"];
        $last_name = $_POST["last_name"];
        $genre = $_POST["genre"];
        $age = $_POST["age"];
        $pays = $_POST["pays"];
        $registerAttempted = true;
    } else {
        $registerAttempted = false;
    }
    
    // Validation de l'email
    if($registerAttempted){
        if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            $error= "* Veuillez fournir un email valide !";
        }

        // Validation du mot de passe
        if (!preg_match("/^(?=.*[A-Z])(?=.*\d)(?=.*[^\w\s]).{10,}$/", $password)) {
            $error1 = "* Mot de passe doit contenir au moins 10 caractères, des chiffres, des caractères spéciaux et des majuscules!";
        }
      
        
        // Vérification de l'unicité de l'adresse e-mail
        $checkEmailQuery = "SELECT * FROM utilisateurs WHERE email = '$mail'";
        $result = $conn->query($checkEmailQuery);
        if ($result->num_rows > 0) {
            $error3 = "* L'adresse e-mail est déjà utilisée. Veuillez en choisir une autre.";
        }
        
        $defaultAvatar = "assets/images/photos/compte.png";
        // Si aucune erreur n'a été détectée
        if (empty($error) && empty($error1) && empty($error3)) {
            // Requête d'insertion dans la base de données
            $sql = "INSERT INTO utilisateurs (email, mot_de_passe, nom, prenom, genre, age, pays, avatar, date_inscription) 
             VALUES ('" . $mail . "', '" . md5($password) . "', '" . $last_name . "', '" . $first_name . "', '" . $genre . "', '" . $age . "', '" . $pays . "', '" . $defaultAvatar . "', NOW())";

          
            if ($conn && $conn->query($sql) === TRUE) {
                // Insertion réussie dans la table utilisateurs
                $registerSuccessful = true;

                // Récupérer l'ID de l'utilisateur nouvellement inscrit
                $newUserID = $conn->insert_id;

                // Insertion dans la table "follows"
                $followsQuery = "INSERT INTO follows (follower_id, followed_id) VALUES (8, $newUserID)";

                if ($conn->query($followsQuery) !== TRUE) {
                    // Erreur lors de l'insertion dans la table "follows"
                    $error2 = "Erreur lors de l'insertion dans la table follows : " . $conn->error;
                }
            } else {
                $error2 = "Erreur lors de l'insertion dans la base de données : " . $conn->error;
            }
        }
    }

    $resultArray = array(
        'Successful' => $registerSuccessful,
        'Attempted' => $registerAttempted,
        'ErrorMessage' => $error,
        'ErrorMessage1' => $error1,
        'ErrorMessage2' => $error2,
        'ErrorMessage3' => $error3,
    );

    return $resultArray;
}

//Fonction qu retourne les informations concernant un utilisateur
function getUserInfoById($userID) {
    global $conn;
    $sql = "SELECT * FROM utilisateurs WHERE id = $userID";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $userInfo = $result->fetch_assoc();
        return $userInfo;
    } 
}



//Fonction pour la mise à jour des parametres
function Onupdate($userID) {

    global $conn;

    $error = NULL;
    $error1 = NULL;
    $error2 = NULL;
    $error3 = NULL;
    $error4 = NULL;
    $error5 = NULL;

    $infos = getUserInfoById($userID);
    $updateSuccessful = false;

    // Vérifier si les données ont été soumises
    if(isset($_POST["new_mail"]) && isset($_POST["new_password"]) && isset($_POST["first_name"]) && isset($_POST["last_name"]) && isset($_POST["genre"]) && isset($_POST["age"]) && isset($_POST["pays"]) && isset($_POST["naissance"])) {
        // Récupérer les données du formulaire
        $mail = SecurizeString_ForSQL($_POST["new_mail"]);
        $password = $_POST["new_password"];
        $first_name = $_POST["first_name"];
        $last_name = $_POST["last_name"];
        $genre = $_POST["genre"];
        $age = $_POST["age"];
        $pays = $_POST["pays"];
        $naissance = $_POST["naissance"];
        $description = $_POST["desc"];

        // Validation de l'email
        if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            $error = "* Veuillez fournir un email valide !";
        }

        // Validation du mot de passe
        if (!preg_match("/^(?=.*[A-Z])(?=.*\d)(?=.*[^\w\s]).{10,}$/", $password)) {
            $error1 = "* Mot de passe doit contenir au moins 10 caractères, des chiffres, des caractères spéciaux et des majuscules!";
        }

        // Vérification de l'unicité de l'adresse email
        $checkEmailQuery = "SELECT * FROM utilisateurs WHERE email = '$mail' AND id != $userID"; // Exclure l'utilisateur actuel de la vérification
        $result = $conn->query($checkEmailQuery);
        if ($result->num_rows > 0) {
            $error3 = "* L'adresse e-mail est déjà utilisée. Veuillez en choisir une autre.";
        }

        // Vérification de la date de naissance
        if (empty($naissance)) {
            $error4 = "* Veuillez fournir une date de naissance.";
        }

        if(isset($_FILES["fileUpload"]) && $_FILES["fileUpload"]["error"] == 0) {
            // Un nouveau fichier a été téléchargé, traiter l'avatar
            $filename = $_FILES["fileUpload"]["name"];
            $tempFilePath = $_FILES["fileUpload"]["tmp_name"];
            $targetFilePath = "../uploads/" . $filename;
        
            // Déplacer le fichier téléchargé vers le dossier 'uploads'
            if (move_uploaded_file($tempFilePath, $targetFilePath)) {
                $avatar = $targetFilePath;
            } else {
                // Gérer l'erreur de téléchargement de fichier
                $error5 = "Erreur lors de l'upload de l'image : " . error_get_last()['message'];
            }
        } else {
            // Aucun nouveau fichier téléchargé, conserver l'avatar actuel
            $avatar = $infos['avatar'];
        }

        // Si aucune erreur n'est détectée
        if (empty($error) && empty($error1) && empty($error3) && empty($error4)) {
            // Requête de mise à jour dans la base de données
            $sql = "UPDATE utilisateurs SET email='$mail', mot_de_passe='$password', nom='$last_name', prenom='$first_name', genre='$genre', age='$age', pays='$pays', naissance='$naissance', avatar='$avatar',description_user='$description' WHERE id=$userID";

            if ($conn->query($sql) === TRUE) {
                $updateSuccessful = true;
            } else {
                $error2 = "Erreur lors de la mise à jour dans la base de données : " . $conn->error;
            }
        }
    }

    $resultArray = array(
        'Successful' => $updateSuccessful,
        'Attempted' => isset($_POST["new_mail"]), // Indiquer si une tentative de mise à jour a été effectuée
        'ErrorMessage' => $error,
        'ErrorMessage1' => $error1,
        'ErrorMessage2' => $error2,
        'ErrorMessage3' => $error3,
        'ErrorMessage4' => $error4,
        'ErrorMessage5' => $error5,

    );

    return $resultArray;
}

// Requete pour recuperer les infos sur les followers
function getFollowersInfo($userID) {
    global $conn;

    // Requête SQL pour récupérer les informations des followers de l'utilisateur
    $sql = "SELECT u.id, u.nom, u.prenom, u.avatar
            FROM follows AS f
            INNER JOIN utilisateurs AS u ON f.follower_id = u.id
            WHERE f.followed_id = $userID";

    $result = $conn->query($sql);

    $followersInfo = array();

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $followersInfo[] = $row;
        }
    }

    return $followersInfo;
}
// Requete pour recuperer les infos sur les suivis d'un utilisateur
function getFollowedInfo($userID) {
    global $conn;

    $sql = "SELECT u.id, u.nom, u.prenom, u.avatar
            FROM follows AS f
            INNER JOIN utilisateurs AS u ON f.followed_id = u.id
            WHERE f.follower_id = $userID";

    $result = $conn->query($sql);

    $followedInfo = array();

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $followedInfo[] = $row;
        }
    }

    return $followedInfo;
}



// Fonction pour récupérer le nombre de followers d'un utilisateur
function getNumberOfFollowers($userID) {
    global $conn;

    // Requête SQL pour compter le nombre de followers
    $sql = "SELECT COUNT(*) AS total_followers FROM follows WHERE followed_id = $userID";

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['total_followers'];
    } else {
        return 0;
    }
}
// Fonction pour récupérer le nombre de suivis d'un utilisateur

function getNumberOfFollowings($userID) {
    global $conn;

    // Requête SQL pour compter le nombre de personnes suivies
    $sql = "SELECT COUNT(*) AS total_followings FROM follows WHERE follower_id = $userID";

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['total_followings'];
    } else {
        return 0;
    }
}
//Fonction pour follow
function followUser($followerID, $followedID) {
    global $conn; // Assurez-vous que $conn est défini globalement dans votre fichier

    // Préparez votre requête SQL
    $sql = "INSERT INTO follows (follower_id, followed_id) VALUES ($followerID, $followedID)";

    // Exécutez la requête et vérifiez si elle s'est bien déroulée
    if ($conn->query($sql) === TRUE) {
        // La requête s'est bien déroulée, retournez true ou effectuez d'autres opérations si nécessaire
        return true;
    } else {
        // La requête a échoué, vous pouvez afficher un message d'erreur ou gérer l'erreur autrement
        echo "Erreur lors de l'insertion dans la table follows : " . $conn->error;
        return false;
    }
}
//Pour unfollow
function unfollowUser($followerID, $followedID) {
    global $conn;

    // Préparez votre requête SQL
    $sql = "DELETE FROM follows WHERE follower_id = $followerID AND followed_id = $followedID";

    // Exécutez la requête et vérifiez si elle s'est bien déroulée
    if ($conn->query($sql) === TRUE) {
        // La requête s'est bien déroulée, retournez true ou effectuez d'autres opérations si nécessaire
        return true;
    } else {
        // La requête a échoué, vous pouvez afficher un message d'erreur ou gérer l'erreur autrement
        echo "Erreur lors de la suppression du suivi dans la table follows : " . $conn->error;
        return false;
    }
}
//Pour verifier si un utilisateur follow un autre
function followedExists($followerID, $followedID) {
    global $conn;

    // Requête SQL pour vérifier si la relation follow existe
    $sql = "SELECT COUNT(*) AS count FROM follows WHERE follower_id = $followerID AND followed_id = $followedID";

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $count = $row['count'];
        return $count > 0; // Retourne true si la relation follow existe, sinon false
    } else {
        // Gérer les erreurs de la requête SQL
        echo "Erreur lors de la vérification de l'existence de la relation follow : " . $conn->error;
        return false;
    }
}
//Fonction pour reuperer les posts des utilisateurs suivis
function postFollowed($userID) {
    global $conn;

    // Requête SQL pour récupérer les publications des utilisateurs suivis par l'utilisateur donné
    $sql = "SELECT p.*,u.id AS id_utilisateur, u.nom AS utilisateur_nom, u.prenom AS utilisateur_prenom, u.avatar AS utilisateur_avatar
            FROM poste AS p
            INNER JOIN follows AS f ON p.utilisateur_id = f.followed_id
            INNER JOIN utilisateurs AS u ON p.utilisateur_id = u.id
            WHERE f.follower_id = $userID AND p.visibilite = 1
            ORDER BY p.id DESC";

    $result = $conn->query($sql);

    $posts = array();

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $posts[] = $row;
        }
    }

    return $posts;
}
// Fonction pour incrémenter le nombre de likes pour un post
function incrementLikes($postId) {
    global $conn;
    
    // Exemple de requête SQL pour incrémenter le nombre de likes
    $sql = "UPDATE poste SET nombre_likes = nombre_likes + 1 WHERE id = $postId";
    
    // Exécution de la requête
    if ($conn->query($sql) === TRUE) {
        // Succès
        return true;
    } else {
        // Erreur
        return false;
    }
}
// Fonction pour decrémenter le nombre de likes pour un post
function decrementLikes($postId) {
    global $conn;
    
    // Exemple de requête SQL pour décrémenter le nombre de likes
    $sql = "UPDATE poste SET nombre_likes = nombre_likes - 1 WHERE id = $postId";
    
    // Exécution de la requête
    if ($conn->query($sql) === TRUE) {
        // Succès
        return true;
    } else {
        // Erreur
        return false;
    }
}
//Verifie si un user a aimé un post
function doLike($utilisateur_id, $post_id) {
    global $conn;

    // Requête SQL pour vérifier si l'utilisateur a aimé le post
    $sql = "SELECT COUNT(*) AS count FROM dolike WHERE utilisateur_id = $utilisateur_id AND post_id = $post_id";

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $count = $row['count'];
        return $count > 0; // Renvoie true si l'utilisateur a aimé le post, sinon false
    } else {
        return false; // En cas d'erreur ou si aucun enregistrement trouvé, renvoie false
    }
}
//Fonction pour faire un post
function Onpost($userID) {
    global $conn;
    $updateSuccessful = false;
    $error = '';

    // Vérifier si les données ont été soumises
    if(isset($_POST["share"])) {
        // Récupérer la description partagée
        $description = $_POST["share"];
        
        // Vérifier si une image a été téléchargée
        if (isset($_FILES["fileUpload"]) && $_FILES["fileUpload"]["error"] == 0) {
            $filename = $_FILES["fileUpload"]["name"];
            $tempFilePath = $_FILES["fileUpload"]["tmp_name"];
            $targetFilePath = "../uploads/posts/" . $filename;

            // Déplacer le fichier téléchargé vers le dossier 'uploads'
            if (move_uploaded_file($tempFilePath, $targetFilePath)) {
                $photo_url = $targetFilePath;
            } else {
                $error = "Erreur lors du déplacement du fichier téléchargé.";
            }
        } else {
            // Aucune image téléchargée, donc définir l'URL de l'image sur NULL dans la base de données
            $photo_url = NULL;
        }

        // Utilisation d'une instruction préparée pour éviter les injections SQL
        $sql = "INSERT INTO poste (utilisateur_id, description, photo_url, nombre_likes, nombre_commentaires, date_publication,visibilite)
                VALUES (?, ?, ?, 0, 0, NOW(),1)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iss", $userID, $description, $photo_url);

        if ($stmt->execute()) {
            $updateSuccessful = true;
        } else {
            $error = "Erreur lors de l'insertion dans la base de données : " . $stmt->error;
        }

        $stmt->close();
    }

    $resultArray = array(
        'Successful' => $updateSuccessful,
        'ErrorMessage' => $error,
    );

    return $resultArray;
}

//Fonction pour recuperer les posts de l'utilisateur connecté

function commentairesUtilisateur($id_poste) {
    global $conn;
    $sql = "SELECT c.*, u.nom, u.prenom, u.avatar
            FROM Commentaire AS c
            INNER JOIN utilisateurs AS u ON c.id_utilisateur = u.id
            WHERE c.id_poste = $id_poste
            ORDER BY c.date_commentaire DESC";

    $result = $conn->query($sql);

    $commentaires = array();

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $commentaires[] = $row;
        }
    }

    return $commentaires;
}
//Fonction pour enregistrer un commentaire laissez sous un post

function Oncomment($userID, $id_poste, $contenu_commentaire) {

    global $conn;
    $userID = mysqli_real_escape_string($conn, $userID);
    $id_poste = mysqli_real_escape_string($conn, $id_poste);
    $contenu_commentaire = mysqli_real_escape_string($conn, $contenu_commentaire);

    $sql = "INSERT INTO Commentaire (id_utilisateur, id_poste, contenu_commentaire, date_commentaire, nombre_likes) 
            VALUES ('$userID', '$id_poste', '$contenu_commentaire', NOW(), 0)";

    if (mysqli_query($conn, $sql)) {
        echo "Nouveau commentaire ajouté avec succès !";
    } else {
        echo "Erreur lors de l'ajout du commentaire : " . mysqli_error($conn);
    }
}
//Fonction pour update le nombre de commentaire
function updateNumberOfComments($postID) {
    global $conn;

    // Requête SQL pour récupérer le nombre actuel de commentaires pour ce post
    $sql = "SELECT nombre_commentaires FROM poste WHERE id = $postID";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $currentNumberOfComments = $row['nombre_commentaires'];

        // Incrémenter le nombre de commentaires
        $currentNumberOfComments++;

        // Mettre à jour le nombre de commentaires dans la base de données
        $sqlUpdate = "UPDATE poste SET nombre_commentaires = $currentNumberOfComments WHERE id = $postID";
        $conn->query($sqlUpdate);
    } else {
        echo "Erreur lors de la récupération du nombre de commentaires pour le post $postID";
    }
}


function postUser($userID) {

    global $conn;

    $sql = "SELECT p.* ,u.nom, u.prenom, u.avatar FROM poste AS p INNER JOIN utilisateurs AS u ON p.utilisateur_id = u.id
    WHERE p.utilisateur_id = $userID AND p.visibilite = 1 ORDER BY p.id DESC";

    $result = $conn->query($sql);

    $posts = array();

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $posts[] = $row;
        }
    }

    return $posts;
}
//Fonction pour compter le nombres de post d'un utilisateur

function countUserPosts($userID) {
    global $conn; 

    $sql = "SELECT COUNT(*) AS post_count FROM poste WHERE utilisateur_id = $userID AND visibilite=1";

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $postCount = $row['post_count'];
        return $postCount;
    } else {
        return 0;
    }
}

// Fonction pour récupérer les informations relatives aux utilisateurs avec lesquels un utilisateur a interagi ainsi que leurs messages
function getInteractedUsersAndMessages($userID) {
    global $conn; 


    $sql = "SELECT u.id AS utilisateur_id, u.nom AS utilisateur_nom, u.prenom AS utilisateur_prenom, u.avatar AS utilisateur_avatar,
               m.id AS message_id, m.contenu_message AS message_contenu, m.date_envoi AS message_date_envoi
        FROM utilisateurs u
        INNER JOIN messages m ON u.id = m.id_utilisateur_emetteur OR u.id = m.id_utilisateur_destinataire
        WHERE (m.id_utilisateur_emetteur = ? OR m.id_utilisateur_destinataire = ?)
              AND u.id != ?
        ORDER BY m.date_envoi DESC";

    // Préparation de la requête
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $userID, $userID, $userID);

    // Exécution de la requête
    $stmt->execute();

    // Récupération des résultats
    $result = $stmt->get_result();

    // Tableau pour stocker les informations des utilisateurs et de leurs messages
    $interactions = array();

    // Parcourir les résultats et les ajouter au tableau des interactions
    while ($row = $result->fetch_assoc()) {
        // Ajouter les informations de l'utilisateur
        $interaction = array(
            'utilisateur_id' => $row['utilisateur_id'],
            'utilisateur_nom' => $row['utilisateur_nom'],
            'utilisateur_prenom' => $row['utilisateur_prenom'],
            'utilisateur_avatar' => $row['utilisateur_avatar']
        );

        // Ajouter les informations du message
        $message = array(
            'message_id' => $row['message_id'],
            'message_contenu' => $row['message_contenu'],
            'message_date_envoi' => $row['message_date_envoi']
        );

        // Ajouter les informations de l'interaction au tableau
        $interaction['message'] = $message;
        $interactions[] = $interaction;
    }

    // Fermer la connexion et retourner les informations des interactions
    return $interactions;
}

//Pour recuperer tous les posts
function getAllPosts() {
    global $conn;

    // Requête SQL pour récupérer tous les posts
    $sql = "SELECT p.*, u.id AS id_utilisateur, u.nom AS utilisateur_nom, u.prenom AS utilisateur_prenom, u.avatar AS utilisateur_avatar
            FROM poste AS p
            INNER JOIN utilisateurs AS u ON p.utilisateur_id = u.id
            ORDER BY p.id DESC";

    $result = $conn->query($sql);

    $posts = array();

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $posts[] = $row;
        }
    }

    return $posts;
}
//notifiactions
function addLikeNotification($userID, $postID, $likedUserID) {
    global $conn;
    error_reporting(E_ALL);
   ini_set('display_errors', 1);
    // Récupérer le nom et le prénom de l'utilisateur qui a aimé la photo
    $result = $conn->query("SELECT nom, prenom FROM utilisateurs WHERE id = $userID");
    $userData = $result->fetch_assoc();
    $likerName = $userData['prenom'] . ' ' . $userData['nom'];

    // Créer le contenu de la notification
    $contenu = "$likerName a aimé votre photo.";

    // Insérer la notification dans la table notification avec l'ID de l'émetteur
    $sql = "INSERT INTO notification (contenu, id_utilisateur, emetteur,post_id) VALUES ('$contenu', $likedUserID, $userID,$postID)";
    $conn->query($sql);
}

//Recuperer les notifications de l'utilisateur connecté
function getNotifications($userID) {
    global $conn;

    // Requête SQL pour récupérer les notifications de l'utilisateur avec l'avatar de l'émetteur et les informations sur le post liké
    $sql = "SELECT n.*, u.avatar AS emetteur_avatar, p.*
            FROM notification AS n
            INNER JOIN utilisateurs AS u ON n.emetteur = u.id
            LEFT JOIN poste AS p ON n.post_id = p.id
            WHERE n.id_utilisateur = $userID
            ORDER BY n.date_notification DESC";

    $result = $conn->query($sql);

    $notifications = array();

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $notifications[] = $row;
        }
    }

    return $notifications;
}
//Supprmer une notification
function deleteNotification($postID, $userID) {
    global $conn;

    // Requête SQL pour supprimer la notification
    $sql = "DELETE FROM notification WHERE post_id = ? AND emetteur = ?";
    
    // Préparation de la requête
    $stmt = $conn->prepare($sql);
    
    // Liaison des paramètres
    $stmt->bind_param("ii", $postID, $userID);
    
    // Exécution de la requête
    $stmt->execute();

    // Vérification de la réussite de la suppression
    if ($stmt->affected_rows > 0) {
        return true; // Suppression réussie
    } else {
        return false; // Échec de la suppression
    }
}
//Ajouter notification commentaire
function addCommentNotification($userID, $postID, $userId, $commentText) {
    global $conn;
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // Récupérer le nom et le prénom de l'utilisateur qui a commenté
    $result = $conn->query("SELECT nom, prenom FROM utilisateurs WHERE id = $userID");
    $userData = $result->fetch_assoc();
    $commenterName = $userData['prenom'] . ' ' . $userData['nom'];

    // Créer le contenu de la notification en concaténant le nom de l'utilisateur avec le commentaire
    $contenu = "$commenterName a commenté \n $commentText sous votre photo:";

    // Insérer la notification dans la table notification avec l'ID de l'émetteur et l'ID du post
    $sql = "INSERT INTO notification (contenu, id_utilisateur, emetteur, post_id) VALUES ('$contenu', $userId, $userID, $postID)";
    $conn->query($sql);
}


//Fonction pour recuperer un post unique
function getPostInfo($postID) {
    global $conn;

    // Préparation de la requête SQL
    $query = "SELECT * FROM poste WHERE id = ?";

    // Préparation de la déclaration SQL
    $statement = $conn->prepare($query);

    // Liaison des paramètres
    $statement->bind_param("i", $postID);

    // Exécution de la requête
    $statement->execute();

    // Récupération des résultats
    $result = $statement->get_result();

    // Vérification s'il y a des résultats
    if ($result->num_rows > 0) {
        // Récupération de la ligne de résultat
        $row = $result->fetch_assoc();
        return $row; // Retourne les informations du post
    } else {
        return null; // Aucun post trouvé avec cet ID
    }
}
//fontion pour calculer le nombr moyenne de post par semaine
function countMoyPostsSemaine($userID) {
    global $conn;

    $sql = "SELECT COUNT(*) AS post_count FROM poste WHERE utilisateur_id = $userID";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $postCount = $row['post_count'];
    } else {
        $postCount = 0;
    }

    $sql = "SELECT date_inscription FROM utilisateurs WHERE id = $userID";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $dateInscription = strtotime($row['date_inscription']);
    } else {
        $dateInscription = strtotime('today'); 
    }

    // Calculer le nombre de semaines depuis l'inscription
    $today = strtotime('today');
    $weeksSinceInscription = ceil(($today - $dateInscription) / (60 * 60 * 24 * 7));

    // Calculer le nombre moyen de posts par semaine
    if ($weeksSinceInscription > 0) {
        $moyPostSemaine = $postCount / $weeksSinceInscription;
    } else {
        $moyPostSemaine = 0;
    }

    return $moyPostSemaine;
}

//fontion pour calculer le nombr moyenne de post par mois
function countMoyPostsMois($userID) {
    global $conn;

    $sql = "SELECT COUNT(*) AS post_count FROM poste WHERE utilisateur_id = $userID";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $postCount = $row['post_count'];
    } else {
        $postCount = 0;
    }

    $sql = "SELECT date_inscription FROM utilisateurs WHERE id = $userID";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $dateInscription = strtotime($row['date_inscription']);
    } else {
        $dateInscription = strtotime('today'); 
    }

    // Calculer le nombre de mois depuis l'inscription
    $today = strtotime('today');
    $monthsSinceInscription = max(1, ceil(($today - $dateInscription) / (60 * 60 * 24 * 30)));

    // Calculer le nombre moyen de posts par mois
    $moyPostsMois = $postCount / $monthsSinceInscription;

    return $moyPostsMois;
}

//fontion pour calculer nombre likes donees au total 
function countLikesDonees($userID) {
    global $conn;

    $sql = "SELECT COUNT(*) AS likes_donnes_count FROM dolike WHERE utilisateur_id = $userID";

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $likesDonnesCount = $row['likes_donnes_count'];
        return $likesDonnesCount;
    } else {
        return 0;
    }
}

//fonction pour calculer nombre likes donnes en moyenne par semaine
function countMoyLikesDonnesSemaine($userID) {
    global $conn;

    $sqlLikes = "SELECT COUNT(*) AS likes_donnes_count FROM dolike WHERE utilisateur_id = $userID";
    $resultLikes = $conn->query($sqlLikes);

    if ($resultLikes && $resultLikes->num_rows > 0) {
        $rowLikes = $resultLikes->fetch_assoc();
        $likesDonnesCount = $rowLikes['likes_donnes_count'];
    } else {
        $likesDonnesCount = 0;
    }

    $sqlInscription = "SELECT date_inscription FROM utilisateurs WHERE id = $userID";
    $resultInscription = $conn->query($sqlInscription);

    if ($resultInscription && $resultInscription->num_rows > 0) {
        $rowInscription = $resultInscription->fetch_assoc();
        $dateInscription = strtotime($rowInscription['date_inscription']);
    } else {
        $dateInscription = strtotime('today'); 
    }

    // Calculer le nombre de semaines depuis l'inscription
    $today = strtotime('today');
    $weeksSinceInscription = ceil(($today - $dateInscription) / (60 * 60 * 24 * 7));

    // Calculer le nombre moyen de likes donnés par semaine
    if ($weeksSinceInscription > 0) {
        $moyLikesSemaine = $likesDonnesCount / $weeksSinceInscription;
    } else {
        $moyLikesSemaine = 0;
    }

    return $moyLikesSemaine;
}

//fonction pour calculer le moyenne de likes donne par mois 
function countMoyLikesDonnesMois($userID) {
    global $conn;

    $sqlLikes = "SELECT COUNT(*) AS likes_donnes_count FROM dolike WHERE utilisateur_id = $userID";
    $resultLikes = $conn->query($sqlLikes);

    if ($resultLikes && $resultLikes->num_rows > 0) {
        $rowLikes = $resultLikes->fetch_assoc();
        $likesDonnesCount = $rowLikes['likes_donnes_count'];
    } else {
        $likesDonnesCount = 0;
    }

    $sqlInscription = "SELECT date_inscription FROM utilisateurs WHERE id = $userID";
    $resultInscription = $conn->query($sqlInscription);

    if ($resultInscription && $resultInscription->num_rows > 0) {
        $rowInscription = $resultInscription->fetch_assoc();
        $dateInscription = strtotime($rowInscription['date_inscription']);
    } else {
        $dateInscription = strtotime('today'); 
    }

    // Calculer le nombre de mois depuis l'inscription
    $today = strtotime('today');
    $monthsSinceInscription = ceil(($today - $dateInscription) / (60 * 60 * 24 * 30));

    // Calculer le nombre moyen de likes donnés par mois
    if ($monthsSinceInscription > 0) {
        $moyLikesPerMonth = $likesDonnesCount / $monthsSinceInscription;
    } else {
        $moyLikesPerMonth = 0;
    }

    return $moyLikesPerMonth;
}

//fontion pour calculer nombre likes recus
function countLikesRecus($userID) {
    global $conn;

    $sql = "SELECT COUNT(*) AS likes_recus_count FROM dolike WHERE post_id IN (SELECT id FROM poste WHERE utilisateur_id = $userID)";

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $likesRecusCount = $row['likes_recus_count'];
        return $likesRecusCount;
    } else {
        return 0;
    }
}

//focntion pour calculer la moyenne nombre likes recus par semaine
function countMoyLikesRecusSemaine($userID) {
    global $conn;

    $sqlLikesRecus = "SELECT COUNT(*) AS likes_recus_count FROM dolike WHERE post_id IN (SELECT id FROM poste WHERE utilisateur_id = $userID)";
    $resultLikesRecus = $conn->query($sqlLikesRecus);

    if ($resultLikesRecus && $resultLikesRecus->num_rows > 0) {
        $rowLikesRecus = $resultLikesRecus->fetch_assoc();
        $likesRecusCount = $rowLikesRecus['likes_recus_count'];
    } else {
        $likesRecusCount = 0;
    }

    $sqlDateInscription = "SELECT date_inscription FROM utilisateurs WHERE id = $userID";
    $resultDateInscription = $conn->query($sqlDateInscription);

    if ($resultDateInscription && $resultDateInscription->num_rows > 0) {
        $rowDateInscription = $resultDateInscription->fetch_assoc();
        $dateInscription = strtotime($rowDateInscription['date_inscription']);
    } else {
        $dateInscription = strtotime('today'); 
    }

    // Calculer le nombre de semaines depuis l'inscription
    $today = strtotime('today');
    $weeksSinceInscription = ceil(($today - $dateInscription) / (60 * 60 * 24 * 7));

    // Calculer la moyenne de likes reçus par semaine
    if ($weeksSinceInscription > 0) {
        $moyLikesRecusSemaine = $likesRecusCount / $weeksSinceInscription;
    } else {
        $moyLikesRecusSemaine = 0;
    }

    return $moyLikesRecusSemaine;
}

//fonction pour calculer moyenne like recus par mois
function countMoyLikesRecusMois($userID) {
    global $conn;

    $sqlLikesRecus = "SELECT COUNT(*) AS likes_recus_count FROM dolike WHERE post_id IN (SELECT id FROM poste WHERE utilisateur_id = $userID)";
    $resultLikesRecus = $conn->query($sqlLikesRecus);

    if ($resultLikesRecus && $resultLikesRecus->num_rows > 0) {
        $rowLikesRecus = $resultLikesRecus->fetch_assoc();
        $likesRecusCount = $rowLikesRecus['likes_recus_count'];
    } else {
        $likesRecusCount = 0;
    }

    $sqlDateInscription = "SELECT date_inscription FROM utilisateurs WHERE id = $userID";
    $resultDateInscription = $conn->query($sqlDateInscription);

    if ($resultDateInscription && $resultDateInscription->num_rows > 0) {
        $rowDateInscription = $resultDateInscription->fetch_assoc();
        $dateInscription = strtotime($rowDateInscription['date_inscription']);
    } else {
        $dateInscription = strtotime('today'); 
    }

    // Calculer le nombre de mois depuis l'inscription
    $today = strtotime('today');
    $monthsSinceInscription = ceil(($today - $dateInscription) / (60 * 60 * 24 * 30));

    // Calculer la moyenne de likes reçus par mois
    if ($monthsSinceInscription > 0) {
        $moyLikesRecusMois = $likesRecusCount / $monthsSinceInscription;
    } else {
        $moyLikesRecusMois = 0;
    }

    return $moyLikesRecusMois;
}

//fonction pour calculer nombre commentaire recus
function countCommentairesRecus($userID) {
    global $conn;

    $sql = "SELECT COUNT(*) AS commentaires_recus_count FROM commentaire WHERE id_poste IN (SELECT id FROM poste WHERE utilisateur_id = $userID)";

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $commentairesRecusCount = $row['commentaires_recus_count'];
        return $commentairesRecusCount;
    } else {
        return 0;
    }
}

//focntion pour calculer nombre commentaires donnes
function countCommentairesDonnes($userID) {
    global $conn;

    $sql = "SELECT COUNT(*) AS commentaires_donnes_count FROM commentaire WHERE id_utilisateur = $userID";

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $commentairesDonnesCount = $row['commentaires_donnes_count'];
        return $commentairesDonnesCount;
    } else {
        return 0;
    }
}

//focntion pour calculer le taux d'engagement,cela indique proportion d'audience réagit activement à chaque post 
function calculTauxEngage($nblikesrecus, $nbcommentairesrecus, $nbposts) {
    if ($nbposts > 0) {
        $taux_engagement = (($nblikesrecus + $nbcommentairesrecus) / $nbposts) * 100;
    } else {
        $taux_engagement = 0;
    }
    return $taux_engagement;
}

// fontion pour recupere les posts des gens non suivis en ordre plus recents
function postUnfollowed($userID) {
    global $conn;

    $sql = "SELECT p.*, u.id AS id_utilisateur, u.nom AS utilisateur_nom, u.prenom AS utilisateur_prenom, u.avatar AS utilisateur_avatar
            FROM poste AS p
            INNER JOIN utilisateurs AS u ON p.utilisateur_id = u.id
            WHERE u.id NOT IN (
                SELECT followed_id FROM follows WHERE follower_id = $userID
            ) AND p.utilisateur_id != $userID AND p.visibilite = 1
            ORDER BY p.id DESC";

    $result = $conn->query($sql);

    $posts = array();

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $posts[] = $row;
        }
    }

    return $posts;
}

//fonction pour recupere tous les posts des gens qu'il ne suivi pas en ordre plus recents
function postRecents($userID) {
    global $conn;

    $sql = "SELECT p.*, u.id AS id_utilisateur, u.nom AS utilisateur_nom, u.prenom AS utilisateur_prenom, u.avatar AS utilisateur_avatar
            FROM poste AS p
            INNER JOIN utilisateurs AS u ON p.utilisateur_id = u.id
            WHERE p.visibilite = 1
            ORDER BY p.id DESC";

    $result = $conn->query($sql);

    $posts = array();

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $posts[] = $row;
        }
    }

    return $posts;
}


//Fonction pour reuperer tout les posts(non retire par admin) en order plus populaire en fonction de nombre_likes
function postPopulaire($userID) {
    global $conn;

    $sql = "SELECT p.*, u.id AS id_utilisateur, u.nom AS utilisateur_nom, u.prenom AS utilisateur_prenom, u.avatar AS utilisateur_avatar
            FROM poste AS p
            INNER JOIN utilisateurs AS u ON p.utilisateur_id = u.id
            WHERE u.id NOT IN (
                SELECT followed_id FROM follows WHERE follower_id = $userID
            ) AND p.utilisateur_id != $userID AND p.visibilite = 1
            ORDER BY p.nombre_likes DESC, p.id DESC";

    $result = $conn->query($sql);

    $posts = array();

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $posts[] = $row;
        }
    }

    return $posts;
}

//fontion pour recupere tous les posts qu a ete averti par admin
function postAvertir($userID) {
    global $conn;

    $sql = "SELECT p.*, u.id AS id_utilisateur, u.nom AS utilisateur_nom, u.prenom AS utilisateur_prenom, u.avatar AS utilisateur_avatar
            FROM poste AS p
            INNER JOIN utilisateurs AS u ON p.utilisateur_id = u.id
            WHERE p.averti = 1 AND p.visibilite = 1
            ORDER BY p.id DESC";

    $result = $conn->query($sql);

    $posts = array();

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $posts[] = $row;
        }
    }

    return $posts;
}


//fonction pour afficher tout les poste qui a ete retire par admin en ordre popularite
function postRetire($userID) {
    global $conn;

    $sql = "SELECT p.*, u.id AS id_utilisateur, u.nom AS utilisateur_nom, u.prenom AS utilisateur_prenom, u.avatar AS utilisateur_avatar
            FROM poste AS p
            INNER JOIN utilisateurs AS u ON p.utilisateur_id = u.id
            WHERE p.visibilite = 0
            ORDER BY p.id DESC";

    $result = $conn->query($sql);
    $posts = array();

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $posts[] = $row;
        }
    }

    return $posts;
}

function getLatestUsers($userID) {
    global $conn;

    $sql = "SELECT * FROM utilisateurs WHERE isadmin=0 AND id!=$userID ORDER BY id DESC LIMIT 3";

    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $users = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $users[] = $row;
        }

        return $users;
    } else {

        return false;
    }
}

function addAvertissement($avertiUser, $avertiPost) {
    global $conn;
    $updateSuccessful = false;
    $error = '';

    if(isset($_POST["avertissement"])) {
        // Utilisation d'une instruction préparée pour éviter les injections SQL
        $description = $_POST["avertissement"];
        $message = "Votre poste est inapproprié";
        
        // Préparation de la requête SQL avec une déclaration préparée
        $sql = "INSERT INTO avertissements (utilisateur_id, post_id, descriptions, date)
                VALUES (?, ?, ?, NOW())";
        
        // Préparation de la déclaration SQL
        $stmt = $conn->prepare($sql);
        
        // Liaison des paramètres à la déclaration SQL
        $stmt->bind_param("iis", $avertiUser, $avertiPost, $message);
        
        // Exécution de la déclaration SQL
        if ($stmt->execute()) {
            $updateSuccessful = true;
        } else {
            $error = "Erreur lors de l'insertion dans la base de données : " . $stmt->error;
        }
        
        // Fermeture de la déclaration SQL
        $stmt->close();
    }

    // Création d'un tableau contenant le statut de la mise à jour et un message d'erreur éventuel
    $resultArray = array(
        'Successful' => $updateSuccessful,
        'ErrorMessage' => $error,
    );

    return $resultArray;
}


?>







