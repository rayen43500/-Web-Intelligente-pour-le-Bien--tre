-- Base de données: bien_etre_db

-- Supprimer la base de données si elle existe déjà
DROP DATABASE IF EXISTS bien_etre_db;

-- Créer la base de données
CREATE DATABASE bien_etre_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Utiliser la base de données
USE bien_etre_db;

-- Table des utilisateurs
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    is_admin BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table des notes personnelles
CREATE TABLE notes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    content TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Table des conversations IA
CREATE TABLE ai_conversations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    conversation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Table des messages de conversation
CREATE TABLE ai_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    conversation_id INT NOT NULL,
    is_user BOOLEAN DEFAULT TRUE,
    message TEXT NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (conversation_id) REFERENCES ai_conversations(id) ON DELETE CASCADE
);

-- Table des livres
CREATE TABLE books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255),
    description TEXT,
    file_path VARCHAR(255) NOT NULL,
    cover_path VARCHAR(255),
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table des musiques
CREATE TABLE music (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    artist VARCHAR(255),
    file_path VARCHAR(255) NOT NULL,
    cover_path VARCHAR(255),
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table des vidéos
CREATE TABLE videos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    file_path VARCHAR(255) NOT NULL,
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table des préférences utilisateurs
CREATE TABLE user_preferences (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    theme VARCHAR(50) DEFAULT 'light',
    notifications BOOLEAN DEFAULT TRUE,
    language VARCHAR(10) DEFAULT 'fr',
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Création d'un utilisateur administrateur par défaut
-- Mot de passe: admin123 (haché avec Bcrypt)
INSERT INTO users (name, email, password, is_admin) VALUES 
('Administrateur', 'admin@example.com', '$2y$10$X5C1jZfFWWvjqJmfbZdF8.Tc22nSB0I1kc9Hnmbny/LpK1.PI4k/u', TRUE);

-- Quelques exemples de livres pour démarrer
INSERT INTO books (title, author, description, file_path, cover_path) VALUES
('Méditer jour après jour', 'Christophe André', 'Un guide pour apprendre à méditer et développer la pleine conscience dans votre quotidien.', 'uploads/books/mediter.pdf', 'uploads/covers/mediter.jpg'),
('La confiance en soi', 'Charles Pépin', 'Une réflexion philosophique sur la confiance en soi et des conseils pratiques pour la développer.', 'uploads/books/confiance.pdf', 'uploads/covers/confiance.jpg'),
('L\'art du bonheur', 'Dalaï Lama', 'Un ouvrage qui partage la sagesse bouddhiste pour cultiver le bonheur intérieur.', 'uploads/books/bonheur.pdf', 'uploads/covers/bonheur.jpg');

-- Quelques exemples de musiques pour démarrer
INSERT INTO music (title, artist, file_path, cover_path) VALUES
('Méditation matinale', 'Sounds of Nature', 'uploads/music/meditation_matinale.mp3', 'uploads/covers/meditation_matinale.jpg'),
('Relaxation profonde', 'Healing Sounds', 'uploads/music/relaxation_profonde.mp3', 'uploads/covers/relaxation_profonde.jpg'),
('Sommeil paisible', 'Dream Therapy', 'uploads/music/sommeil_paisible.mp3', 'uploads/covers/sommeil_paisible.jpg');

-- Quelques exemples de vidéos pour démarrer
INSERT INTO videos (title, description, file_path) VALUES
('Introduction à la méditation', 'Une vidéo d\'introduction aux bases de la méditation.', 'uploads/videos/intro_meditation.mp4'),
('Exercices de respiration', 'Techniques de respiration pour réduire le stress et l\'anxiété.', 'uploads/videos/exercices_respiration.mp4'),
('Yoga doux pour débutants', 'Une séance de yoga douce accessible à tous.', 'uploads/videos/yoga_debutants.mp4');
