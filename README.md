# Plateforme Web de Bien-être Mental et Culturel

Une application web complète pour le bien-être mental offrant consultation IA, bibliothèque numérique et bloc-notes personnel.

## Présentation du Projet

Cette plateforme web permet aux utilisateurs de :
- Dialoguer avec un assistant virtuel (IA) pour des consultations pseudo-psychiatriques
- Accéder à une bibliothèque numérique (livres, musiques, vidéos)
- Prendre et gérer des notes personnelles
- Le tout dans un environnement sécurisé avec système d'authentification

## Structure du Projet

```
├── index.php            # Page d'accueil
├── login.php            # Page de connexion
├── register.php         # Page d'inscription
├── logout.php           # Script de déconnexion
├── db.sql               # Structure de la base de données
│
├── admin/               # Interface administrateur
│   ├── index.php        # Tableau de bord admin
│   ├── books.php        # Gestion des livres
│   ├── music.php        # Gestion des musiques
│   ├── videos.php       # Gestion des vidéos
│   └── users.php        # Gestion des utilisateurs
│
├── client/              # Interface utilisateur
│   ├── dashboard.php    # Tableau de bord utilisateur
│   ├── ai-chat.php      # Consultation IA
│   ├── notes.php        # Bloc-notes personnel
│   ├── books.php        # Bibliothèque de livres
│   ├── music.php        # Espace musique
│   ├── profile.php      # Profil utilisateur
│   └── ...
│
├── includes/            # Fichiers système
│   ├── config.php       # Configuration DB et fonctions globales
│   └── functions.php    # Fonctions principales de l'application
│
├── assets/              # Ressources statiques
│   ├── css/             # Fichiers CSS
│   └── js/              # Fichiers JavaScript
│
└── uploads/             # Fichiers téléchargés
    ├── books/           # Livres PDF/EPUB
    ├── music/           # Fichiers audio MP3
    ├── videos/          # Fichiers vidéo
    └── covers/          # Images de couverture
```

## Installation

### Prérequis
- PHP 7.4 ou supérieur
- MySQL 5.7 ou supérieur
- Serveur web (Apache/Nginx)

### Étapes d'Installation
1. Clonez le dépôt sur votre serveur web
2. Créez une base de données MySQL
3. Importez le fichier `db.sql` dans votre base de données
4. Configurez le fichier `includes/config.php` avec vos informations de connexion à la base de données
5. Assurez-vous que les dossiers d'upload ont les permissions en écriture appropriées

```bash
# Exemple de commande pour les permissions
chmod -R 755 uploads/
```

## Fonctionnalités

### Système d'Authentification
- Inscription avec nom, email et mot de passe (haché en Bcrypt)
- Connexion sécurisée avec sessions PHP
- Protection contre les attaques CSRF
- Différenciation des rôles utilisateur/administrateur

### Interface Administrateur
- Tableau de bord avec statistiques
- Gestion des livres (ajout, modification, suppression)
- Gestion des musiques (upload MP3)
- Gestion des vidéos
- Gestion des utilisateurs

### Interface Utilisateur
- Consultation IA (chat en temps réel)
- Bibliothèque numérique avec recherche
- Lecteur audio intégré
- Bloc-notes personnel avec sauvegarde

## Technologies Utilisées
- **Frontend**: HTML, CSS, JavaScript natif
- **Backend**: PHP avec PDO pour les requêtes de base de données
- **Sécurité**: Hachage Bcrypt, sessions PHP, protection CSRF
- **Base de données**: MySQL

## Compte Administrateur Par Défaut
- **Email**: admin@example.com
- **Mot de passe**: admin123

## License
Ce projet est sous licence MIT.