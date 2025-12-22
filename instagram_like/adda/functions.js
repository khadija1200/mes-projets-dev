//Fonction suivre
function suivie(followerID, followedID) {
    var button = document.querySelector('.edit-btn'); // Sélectionne le bouton avec la classe 'edit-btn'
    var action = (button.innerHTML === 'suivre') ? 'suivre' : 'Ne plus suivre';

    // Appel AJAX pour appeler la fonction PHP appropriée en fonction de l'action
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'suivie.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status === 200) {
            if (action === 'suivre') {
                location.reload();
                document.getElementById('followersCount').textContent++;
                button.innerHTML = 'Ne plus suivre';

            } else {
                
                // Vérifier que le nombre d'abonnés est supérieur à zéro avant de le décrémenter
                var followersCount = parseInt(document.getElementById('followersCount').textContent);
                    document.getElementById('followersCount').textContent--;
                    button.innerHTML = 'suivre';

            }
        } else {
            console.error('Erreur lors de la requête AJAX : ' + xhr.statusText);
        }
    };
    xhr.send('followerID=' + followerID + '&followedID=' + followedID + '&action=' + action);
}


//Fonction like
function onlike(userID, postID , userId) {
    var buttonID = 'likeButton'+ postID;
    var button = document.getElementById(buttonID);
    var icon = button.getElementsByTagName('i')[0];
    var countID = 'likesCount'+ postID;
    var likesSpan = document.getElementById(countID);
    var currentLikes = parseInt(likesSpan.textContent);

    // Changer la couleur de l'icône
    if (icon.style.color === 'red') {
        icon.style.color = '';
         likesSpan.textContent = currentLikes - 1;
    } else {
        icon.style.color = 'red';
        likesSpan.textContent = currentLikes + 1;
    }

    // Envoyer une requête AJAX
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'like.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status === 200) {
        } else {
            console.error('Erreur lors de la requête AJAX : ' + xhr.statusText);
        }
    };
    xhr.send('userID=' + userID + '&postID=' + postID + '&userId=' + userId);
}
//Fonction pour ajouter un commentaire

function sendcomment(userID, postID,emetteur) {

    var commentInput = 'commentInput'+ postID;
    var inputValue = document.getElementById(commentInput).value;
    var countID = 'commentsCount'+ postID;
    var commentsSpan = document.getElementById(countID);
    var currentComments = parseInt(commentsSpan.textContent);


    if (inputValue.trim() !== '') {
        commentsSpan.textContent = currentComments + 1;
        $.ajax({
            url: "comment.php", 
            type: "POST", 
            data: {
                userID: userID, 
                postID: postID,
                inputValue: inputValue,
                emetteur:emetteur,

            },
            success: function(response) {
                console.log("Données envoyées avec succès !");
                console.log("Réponse du serveur : " + response);
                document.getElementById(commentInput).value = '';
                location.reload();

            },
            error: function(xhr, status, error) {
                console.error("Erreur lors de l'envoi des données : " + error);
            }
        });
    } 
}


function searchFriends() {
    var searchTerm = document.getElementById("searchInput").value;
    var suggestionsContainer = document.getElementById("suggestions");
    console.log("ca marche");
    // Effacer les anciennes suggestions
    suggestionsContainer.innerHTML = '';

    // Envoyer une requête AJAX pour récupérer les suggestions de noms d'utilisateur
    if (searchTerm.length > 0) {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "get_suggestions.php?searchTerm=" + searchTerm, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var suggestions = JSON.parse(xhr.responseText);
                console.log("ca marche encore");

                suggestions.forEach(function(suggestion) {
                    console.log("ca marche encore");

                    // Créer un élément de suggestion avec une mise en forme personnalisée
                    var suggestionElement = document.createElement("li");
                    suggestionElement.classList.add("d-flex", "align-items-center", "profile-active");
                    console.log("ca marche encore");

                    // Profile picture
                    var profilePicture = document.createElement("div");
                    profilePicture.classList.add("profile-thumb", "active");
                    profilePicture.innerHTML = '<a href="profile1.php?id=' + suggestion.id + '"><figure class="profile-thumb-small"><img src="' + suggestion.avatar + '" alt="profile picture"></figure></a>';

                    // Posted author info
                    var postedAuthor = document.createElement("div");
                    postedAuthor.classList.add("posted-author");
                    postedAuthor.innerHTML = '<a href="profile1.php?id=' + suggestion.id + '"><h6 class="author">' + suggestion.name + '</h6></a>';

                    // Ajouter les éléments à suggestionElement
                    suggestionElement.appendChild(profilePicture);
                    suggestionElement.appendChild(postedAuthor);

                    // Ajouter suggestionElement à suggestionsContainer
                    suggestionsContainer.appendChild(suggestionElement);
                });
            }
        };
        xhr.send();
    }
}

// Récupérer tous les boutons d'avatar
function loadConversation(userId) {
    fetch('load-comments.php?userId=' + userId)
        .then(response => response.text())
        .then(data => {
            document.querySelector('.message-list-inner').innerHTML = data;
        })
        .catch(error => {
            console.error('Erreur lors du chargement de la conversation :', error);
        });
}

// Récupérer tous les boutons d'avatar
var avatarButtons = document.querySelectorAll('.profile-thumb-small');

avatarButtons.forEach(function(button) {
    button.addEventListener('click', function(event) {
        event.preventDefault();

        var userId = button.getAttribute('data-user-id');

        loadConversation(userId);
    });
});

function deletePost(post_id) {
    // Envoi de la requête AJAX au serveur
    $.ajax({
        url: 'suppression_poste.php', // URL du script PHP qui contient la fonction deleteposte
        type: 'POST',
        data: {post_id: post_id},
        success: function(response){
            // Afficher un message ou effectuer d'autres actions si nécessaire
            console.log(response);
            location.reload();

        },
        error: function(xhr, status, error){
            // Gérer les erreurs si la requête échoue
            console.error("Erreur lors de la requête AJAX : " + error);
        }
    });
}


