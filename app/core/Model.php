<?php
/**
 * Classe de base pour tous les modèles
 */
class Model {
    protected $db;
    
    /**
     * Constructeur - établit la connexion à la base de données
     */
    public function __construct() {
        $this->connectDatabase();
    }
    
    /**
     * Se connecter à la base de données
     */
    protected function connectDatabase() {
        try {
            // Récupérer les paramètres de configuration
            require_once 'app/config/database.php';
            
            // Créer une connexion PDO
            $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8';
            $options = [
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ];
            
            $this->db = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            die('Erreur de connexion à la base de données : ' . $e->getMessage());
        }
    }
    
    /**
     * Préparer et exécuter une requête
     * 
     * @param string $sql Requête SQL
     * @param array $params Paramètres pour la requête préparée
     * @return PDOStatement
     */
    protected function query($sql, $params = []) {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
    
    /**
     * Récupérer tous les enregistrements
     * 
     * @param string $sql Requête SQL
     * @param array $params Paramètres pour la requête préparée
     * @return array
     */
    protected function getAll($sql, $params = []) {
        return $this->query($sql, $params)->fetchAll();
    }
    
    /**
     * Récupérer un seul enregistrement
     * 
     * @param string $sql Requête SQL
     * @param array $params Paramètres pour la requête préparée
     * @return array|null
     */
    protected function getOne($sql, $params = []) {
        return $this->query($sql, $params)->fetch();
    }
    
    /**
     * Insérer des données dans une table
     * 
     * @param string $table Nom de la table
     * @param array $data Données à insérer
     * @return int ID de la ligne insérée
     */
    protected function insert($table, $data) {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        
        $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";
        $this->query($sql, array_values($data));
        
        return $this->db->lastInsertId();
    }
    
    /**
     * Mettre à jour des données dans une table
     * 
     * @param string $table Nom de la table
     * @param array $data Données à mettre à jour
     * @param array $where Condition WHERE
     * @return int Nombre de lignes affectées
     */
    protected function update($table, $data, $where) {
        $setPart = [];
        foreach ($data as $key => $value) {
            $setPart[] = "{$key} = ?";
        }
        $setPart = implode(', ', $setPart);
        
        $wherePart = [];
        foreach ($where as $key => $value) {
            $wherePart[] = "{$key} = ?";
        }
        $wherePart = implode(' AND ', $wherePart);
        
        $sql = "UPDATE {$table} SET {$setPart} WHERE {$wherePart}";
        $params = array_merge(array_values($data), array_values($where));
        
        $stmt = $this->query($sql, $params);
        return $stmt->rowCount();
    }
    
    /**
     * Supprimer des données d'une table
     * 
     * @param string $table Nom de la table
     * @param array $where Condition WHERE
     * @return int Nombre de lignes affectées
     */
    protected function delete($table, $where) {
        $wherePart = [];
        foreach ($where as $key => $value) {
            $wherePart[] = "{$key} = ?";
        }
        $wherePart = implode(' AND ', $wherePart);
        
        $sql = "DELETE FROM {$table} WHERE {$wherePart}";
        
        $stmt = $this->query($sql, array_values($where));
        return $stmt->rowCount();
    }
} 