Job Portal – Application de gestion de candidatures

Ce projet est une application web de gestion de candidatures développée dans un contexte full-stack avec Angular pour le frontend et Spring Boot pour le backend. L’objectif est de mettre en relation des candidats et des recruteurs à travers un système de dépôt et de gestion de candidatures.

Les candidats peuvent créer un compte, se connecter, choisir un recruteur, déposer une candidature et envoyer leur CV. De leur côté, les recruteurs peuvent consulter les candidatures reçues, visualiser les détails et changer le statut des candidatures (EN_ATTENTE, ACCEPTE, REFUSE).

L’application est structurée selon une architecture en couches côté backend avec Spring Boot. Le Controller expose les API REST, le Service contient la logique métier et le Repository gère l’accès à la base de données via Spring Data JPA. Les données sont stockées dans une base PostgreSQL.

Technologies utilisées

Le backend est développé avec Java 17 et Spring Boot 3, en utilisant Spring Web pour la création des API REST, Spring Data JPA pour la gestion de la base de données, Spring Security pour l’authentification, Lombok pour réduire le code répétitif et Maven pour la gestion des dépendances et du build.

Le frontend est développé avec Angular, en utilisant TypeScript, Angular Material pour l’interface utilisateur et RxJS pour la gestion des appels asynchrones.

Lancement du projet

Pour lancer le backend, il faut se placer dans le dossier backend et exécuter la commande mvn spring-boot:run. L’application démarre sur le port 8080 avec un serveur Tomcat embarqué.

Pour le frontend, il faut installer les dépendances avec npm install puis lancer l’application avec ng serve. L’interface est ensuite accessible sur http://localhost:4200

.

Base de données et stockage

L’application utilise PostgreSQL comme base de données. Les fichiers CV sont stockés localement dans un dossier uploads côté backend et sont accessibles via une URL exposée par Spring Boot.

Fonctionnalités principales

Le système permet la gestion complète des candidatures entre candidats et recruteurs. Les candidats peuvent créer et envoyer des candidatures avec un CV, tandis que les recruteurs peuvent consulter les candidatures, voir les détails et mettre à jour leur statut. L’application gère également l’authentification avec des rôles utilisateurs (CANDIDAT et RECRUTEUR).

Architecture

Le backend suit une architecture en couches. Le Controller gère les requêtes HTTP, le Service contient la logique métier et le Repository gère l’accès à la base de données. Cette séparation permet un code structuré, maintenable et facilement testable.
