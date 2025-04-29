<?php
/**
 * Classe Database PDO
 * 
 * Connecte à la base de données et crée des requêtes préparées
 */
class Database {
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;

    private $dbh;        // Instance de connexion PDO
    private $stmt;       // Déclaration préparée
    private $error;      // Message d'erreur

    /**
     * Connecte à la base de données
     */
    public function __construct() {
        // Configuration DSN
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname . ';charset=utf8';
        $options = [
            PDO::ATTR_PERSISTENT => true,          // Connexion persistante 
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,   // Gestion d'erreurs via exceptions
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, // Résultats sous forme d'objets
            PDO::ATTR_EMULATE_PREPARES => false    // Utiliser de vraies requêtes préparées
        ];

        // Créer une nouvelle instance PDO
        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        } catch(PDOException $e) {
            $this->error = $e->getMessage();
            echo 'Erreur de connexion: ' . $this->error;
        }
    }

    /**
     * Prépare une déclaration avec une requête
     * 
     * @param string $sql Requête SQL à préparer
     */
    public function query($sql) {
        $this->stmt = $this->dbh->prepare($sql);
    }

    /**
     * Lie une valeur à un paramètre
     * 
     * @param mixed $param Paramètre à lier
     * @param mixed $value Valeur à assigner
     * @param mixed $type Type de données (optionnel)
     */
    public function bind($param, $value, $type = null) {
        if(is_null($type)) {
            switch(true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }

        $this->stmt->bindValue($param, $value, $type);
    }

    /**
     * Exécute la requête préparée
     * 
     * @return bool Succès ou échec
     */
    public function execute() {
        return $this->stmt->execute();
    }

    /**
     * Obtient un tableau d'objets 
     * 
     * @return array Résultats sous forme d'objets
     */
    public function resultSet() {
        $this->execute();
        return $this->stmt->fetchAll();
    }

    /**
     * Obtient un seul enregistrement
     * 
     * @return object Résultat sous forme d'objet
     */
    public function single() {
        $this->execute();
        return $this->stmt->fetch();
    }

    /**
     * Obtient le nombre de lignes affectées
     * 
     * @return int Nombre de lignes
     */
    public function rowCount() {
        return $this->stmt->rowCount();
    }

    /**
     * Obtient le dernier ID inséré
     * 
     * @return int ID de la dernière insertion
     */
    public function lastInsertId() {
        return $this->dbh->lastInsertId();
    }
}
?> 