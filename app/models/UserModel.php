<?php
/**
 * Modèle pour la gestion des utilisateurs
 */
class UserModel {
    private $db;

    /**
     * Constructeur
     */
    public function __construct() {
        global $pdo;
        $this->db = $pdo;
    }

    /**
     * Trouver un utilisateur par son email
     */
    public function findUserByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    /**
     * Trouver un utilisateur par son ID
     */
    public function findUserById($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Créer un nouvel utilisateur
     */
    public function createUser($data) {
        // Hachage du mot de passe
        $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);
        
        $stmt = $this->db->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
        
        try {
            $stmt->execute([
                $data['name'],
                $data['email'],
                $hashedPassword,
                $data['role']
            ]);
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Vérifier les identifiants de connexion
     */
    public function checkLogin($email, $password) {
        $user = $this->findUserByEmail($email);
        
        if (!$user) {
            return false;
        }
        
        if (password_verify($password, $user['password'])) {
            return $user;
        }
        
        return false;
    }

    /**
     * Mettre à jour les informations d'un utilisateur
     */
    public function updateUser($id, $data) {
        $query = "UPDATE users SET name = ?, email = ?";
        $params = [$data['name'], $data['email']];
        
        // Si un nouveau mot de passe est fourni
        if (isset($data['password']) && !empty($data['password'])) {
            $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);
            $query .= ", password = ?";
            $params[] = $hashedPassword;
        }
        
        $query .= " WHERE id = ?";
        $params[] = $id;
        
        $stmt = $this->db->prepare($query);
        
        try {
            $stmt->execute($params);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Supprimer un utilisateur
     * 
     * @param int $id ID de l'utilisateur
     * @return bool Succès de la suppression
     */
    public function deleteUser($id) {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }
} 