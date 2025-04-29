<?php
/**
 * Contrôleur pour le tableau de bord utilisateur
 */
class DashboardController extends Controller {
    private $userModel;
    
    /**
     * Constructeur
     */
    public function __construct() {
        // Vérifier si l'utilisateur est connecté
        if (!isLoggedIn()) {
            redirect('users/login');
        }
        
        $this->userModel = $this->model('UserModel');
    }
    
    /**
     * Page d'accueil du tableau de bord
     */
    public function index() {
        $userId = $_SESSION['user_id'];
        $user = $this->userModel->findUserById($userId);
        
        if (!$user) {
            setFlashMessage('Utilisateur introuvable', 'error');
            redirect('users/logout');
        }
        
        $data = [
            'title' => 'Tableau de bord - ' . APP_NAME,
            'user' => $user
        ];
        
        $this->view('dashboard/index', $data);
    }
    
    /**
     * Page de la bibliothèque
     */
    public function books() {
        // Créer un modèle pour les livres si nécessaire
        // $bookModel = $this->model('BookModel');
        // $books = $bookModel->getBooks();
        
        $data = [
            'title' => 'Bibliothèque - ' . APP_NAME,
            'books' => [] // Temporairement vide
        ];
        
        $this->view('dashboard/books', $data);
    }
    
    /**
     * Page de la musique
     */
    public function music() {
        // Créer un modèle pour la musique si nécessaire
        // $musicModel = $this->model('MusicModel');
        // $tracks = $musicModel->getTracks();
        
        $data = [
            'title' => 'Musique - ' . APP_NAME,
            'tracks' => [] // Temporairement vide
        ];
        
        $this->view('dashboard/music', $data);
    }
    
    /**
     * Page des vidéos
     */
    public function videos() {
        // Créer un modèle pour les vidéos si nécessaire
        // $videoModel = $this->model('VideoModel');
        // $videos = $videoModel->getVideos();
        
        $data = [
            'title' => 'Vidéos - ' . APP_NAME,
            'videos' => [] // Temporairement vide
        ];
        
        $this->view('dashboard/videos', $data);
    }
    
    /**
     * Page du chatbot (IA)
     */
    public function chatbot() {
        $data = [
            'title' => 'Assistant IA - ' . APP_NAME
        ];
        
        $this->view('dashboard/chatbot', $data);
    }
    
    /**
     * Page des notes personnelles
     */
    public function notes() {
        // Créer un modèle pour les notes si nécessaire
        // $noteModel = $this->model('NoteModel');
        // $notes = $noteModel->getNotesByUserId($_SESSION['user_id']);
        
        $data = [
            'title' => 'Mes notes - ' . APP_NAME,
            'notes' => [] // Temporairement vide
        ];
        
        $this->view('dashboard/notes', $data);
    }
} 