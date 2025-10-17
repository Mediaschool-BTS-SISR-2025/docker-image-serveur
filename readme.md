Projet MediaSchool - Environnement de Développement

Bienvenue ! Ce guide vous explique comment lancer l'environnement de développement complet sur votre machine.

Grâce à Docker, vous n'avez pas besoin d'installer de serveur web ou de base de données. Tout est inclus et se lance avec une seule commande.

📋 Prérequis

Avant de commencer, assurez-vous d'avoir :

    Docker Desktop installé et en cours d'exécution.

🚀 Démarrage Rapide (3 Étapes)

Suivez ces étapes pour lancer le projet.

1. Récupérez le Projet

Clonez ou téléchargez ce projet sur votre ordinateur.

2. Ajoutez Votre Code (Étape Cruciale)

Avant de lancer quoi que ce soit, vous devez placer vos fichiers de code dans les bons dossiers. La structure est la suivante :

/mediaschoold-project/
├── backend/
│   └── src/          <-- 💻 METTEZ TOUT VOTRE CODE BACKEND ICI
│
├── frontend/
│   └── src/          <-- 🎨 METTEZ TOUT VOTRE CODE FRONTEND ICI
│
├── docker-compose.yml
└── README.md

    Pour le Backend (PHP, Node.js, etc.) : placez tous vos fichiers dans le dossier ./backend/src/.

    Pour le Frontend (React, Vue, HTML/CSS) : placez tous vos fichiers dans le dossier ./frontend/src/.

3. Lancez l'Environnement

Ouvrez un terminal à la racine du projet (là où se trouve ce README) et lancez cette unique commande :
Bash

docker-compose up -d --build

Cette commande va construire vos applications et démarrer tous les services en arrière-plan. La première fois, cela peut prendre quelques minutes.

✨ Workflow de Développement

Une fois l'environnement lancé, votre travail est simple :

    Modifiez votre code dans les dossiers backend/src ou frontend/src.

    Enregistrez vos fichiers.

    Rafraîchissez votre navigateur.

Vos changements apparaissent instantanément ! Pas besoin de redémarrer quoi que ce soit.

🌐 Accès aux Services

Voici les adresses pour accéder à l'application et aux outils depuis votre navigateur :
Service	Adresse Locale (URL)	Identifiants / Notes
Site Web (Frontend)	http://localhost:3000	C'est ici que vous verrez le résultat de votre code.
phpMyAdmin	http://localhost:8080	Pour gérer la base de données.
Base de Données (Direct)	Hôte: localhost Port: 3306	Pour un logiciel comme DBeaver ou TablePlus.

Identifiants pour la base de données (et phpMyAdmin) :

    Utilisateur : mediaschooluser

    Mot de passe : mediaschoolpass

    Base de données : mediaschooldb

🛠️ Commandes Docker Utiles

    Pour arrêter proprement tous les services :
    Bash

docker-compose down

Pour vérifier l'état des services (s'ils tournent bien) :
Bash

docker-compose ps

Pour voir les logs d'un service en cas de bug (par exemple, le backend) :
Bash

docker-compose logs -f backend