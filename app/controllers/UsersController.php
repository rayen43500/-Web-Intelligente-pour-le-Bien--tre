<?php
/**
 * Contrôleur pour gérer les actions liées aux utilisateurs
 */
class UsersController extends Controller {
    private $userModel;
    
    /**
     * Constructeur
     */
    public function __construct() {
        $this->userModel = $this->model('UserModel');
    }
    
    /**
     * Page d'inscription
     */
    public function register() {
        // Si l'utilisateur est déjà connecté, rediriger vers le tableau de bord
        if (isLoggedIn()) {
            redirect('dashboard');
        }
        
        // Vérifier si le formulaire a été soumis
        if ($this->isPostRequest()) {
            // Traiter le formulaire d'inscription
            $data = [
                'name' => sanitize($_POST['name'] ?? ''),
                'email' => sanitize($_POST['email'] ?? ''),
                'password' => $_POST['password'] ?? '',
                'confirm_password' => $_POST['confirm_password'] ?? '',
                'errors' => []
            ];
            
            // Valider les données
            if (empty($data['name'])) {
                $data['errors']['name'] = 'Veuillez entrer votre nom';
            }
            
            if (empty($data['email'])) {
                $data['errors']['email'] = 'Veuillez entrer votre adresse email';
            } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $data['errors']['email'] = 'Adresse email invalide';
            } elseif ($this->userModel->findUserByEmail($data['email'])) {
                $data['errors']['email'] = 'Cette adresse email est déjà utilisée';
            }
            
            if (empty($data['password'])) {
                $data['errors']['password'] = 'Veuillez entrer un mot de passe';
            } elseif (strlen($data['password']) < 6) {
                $data['errors']['password'] = 'Le mot de passe doit contenir au moins 6 caractères';
            }
            
            if ($data['password'] !== $data['confirm_password']) {
                $data['errors']['confirm_password'] = 'Les mots de passe ne correspondent pas';
            }
            
            // Si aucune erreur, créer l'utilisateur
            if (empty($data['errors'])) {
                // Créer l'utilisateur
                $userData = [
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => $data['password'],
                    'role' => 'user' // Rôle par défaut
                ];
                
                $userId = $this->userModel->createUser($userData);
                
                if ($userId) {
                    // Définir un message flash
                    setFlashMessage('Inscription réussie ! Vous pouvez maintenant vous connecter.', 'success');
                    
                    // Rediriger vers la page de connexion
                    redirect('users/login');
                } else {
                    setFlashMessage('Une erreur est survenue lors de l\'inscription.', 'error');
                }
            }
            
            // Si on arrive ici, il y a eu des erreurs ou l'inscription a échoué
            $this->view('users/register', $data);
        } else {
            // Afficher le formulaire d'inscription
            $data = [
                'name' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'errors' => []
            ];
            
            $this->view('users/register', $data);
        }
    }
    
    /**
     * Page de connexion
     */
    public function login() {
        // Si l'utilisateur est déjà connecté, rediriger vers le tableau de bord
        if (isLoggedIn()) {
            redirect('dashboard');
        }
        
        // Vérifier si le formulaire a été soumis
        if ($this->isPostRequest()) {
            // Traiter le formulaire de connexion
            $data = [
                'email' => sanitize($_POST['email'] ?? ''),
                'password' => $_POST['password'] ?? '',
                'remember_me' => isset($_POST['remember_me']),
                'errors' => []
            ];
            
            // Valider les données
            if (empty($data['email'])) {
                $data['errors']['email'] = 'Veuillez entrer votre adresse email';
            }
            
            if (empty($data['password'])) {
                $data['errors']['password'] = 'Veuillez entrer votre mot de passe';
            }
            
            // Si aucune erreur, vérifier les identifiants
            if (empty($data['errors'])) {
                $user = $this->userModel->checkLogin($data['email'], $data['password']);
                
                if ($user) {
                    // Créer la session utilisateur
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_email'] = $user['email'];
                    $_SESSION['user_name'] = $user['name'];
                    $_SESSION['user_role'] = $user['role'];
                    
                    // Rediriger vers le tableau de bord
                    redirect('dashboard');
                } else {
                    $data['errors']['login'] = 'Email ou mot de passe incorrect';
                }
            }
            
            // Si on arrive ici, il y a eu des erreurs ou la connexion a échoué
            $this->view('users/login', $data);
        } else {
            // Afficher le formulaire de connexion
            $data = [
                'email' => '',
                'password' => '',
                'remember_me' => false,
                'errors' => []
            ];
            
            $this->view('users/login', $data);
        }
    }
    
    /**
     * Déconnexion
     */
    public function logout() {
        // Détruire la session
        session_unset();
        session_destroy();
        
        // Rediriger vers la page d'accueil
        redirect('');
    }
    
    /**
     * Profil utilisateur
     */
    public function profile() {
        // Vérifier si l'utilisateur est connecté
        if (!isLoggedIn()) {
            redirect('users/login');
        }
        
        $userId = $_SESSION['user_id'];
        $user = $this->userModel->findUserById($userId);
        
        if (!$user) {
            setFlashMessage('Utilisateur introuvable', 'error');
            redirect('');
        }
        
        // Vérifier si le formulaire a été soumis
        if ($this->isPostRequest()) {
            // Traiter la mise à jour du profil
            $data = [
                'id' => $userId,
                'name' => sanitize($_POST['name'] ?? ''),
                'email' => sanitize($_POST['email'] ?? ''),
                'current_password' => $_POST['current_password'] ?? '',
                'new_password' => $_POST['new_password'] ?? '',
                'confirm_password' => $_POST['confirm_password'] ?? '',
                'user' => $user,
                'errors' => []
            ];
            
            // Valider les données
            if (empty($data['name'])) {
                $data['errors']['name'] = 'Veuillez entrer votre nom';
            }
            
            if (empty($data['email'])) {
                $data['errors']['email'] = 'Veuillez entrer votre adresse email';
            } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $data['errors']['email'] = 'Adresse email invalide';
            } elseif ($data['email'] !== $user['email'] && $this->userModel->findUserByEmail($data['email'])) {
                $data['errors']['email'] = 'Cette adresse email est déjà utilisée';
            }
            
            // Si un nouveau mot de passe est fourni
            if (!empty($data['new_password'])) {
                if (empty($data['current_password'])) {
                    $data['errors']['current_password'] = 'Veuillez entrer votre mot de passe actuel';
                } elseif (!password_verify($data['current_password'], $user['password'])) {
                    $data['errors']['current_password'] = 'Mot de passe incorrect';
                }
                
                if (strlen($data['new_password']) < 6) {
                    $data['errors']['new_password'] = 'Le nouveau mot de passe doit contenir au moins 6 caractères';
                }
                
                if ($data['new_password'] !== $data['confirm_password']) {
                    $data['errors']['confirm_password'] = 'Les mots de passe ne correspondent pas';
                }
            }
            
            // Si aucune erreur, mettre à jour le profil
            if (empty($data['errors'])) {
                $userData = [
                    'name' => $data['name'],
                    'email' => $data['email']
                ];
                
                // Mettre à jour le mot de passe si fourni
                if (!empty($data['new_password'])) {
                    $userData['password'] = $data['new_password'];
                }
                
                if ($this->userModel->updateUser($userId, $userData)) {
                    // Mettre à jour les données de session
                    $_SESSION['user_email'] = $data['email'];
                    $_SESSION['user_name'] = $data['name'];
                    
                    setFlashMessage('Votre profil a été mis à jour avec succès', 'success');
                    redirect('users/profile');
                } else {
                    setFlashMessage('Une erreur est survenue lors de la mise à jour du profil', 'error');
                }
            }
            
            // Si on arrive ici, il y a eu des erreurs ou la mise à jour a échoué
            $this->view('users/profile', $data);
        } else {
            // Afficher le formulaire de profil
            $data = [
                'id' => $userId,
                'name' => $user['name'],
                'email' => $user['email'],
                'current_password' => '',
                'new_password' => '',
                'confirm_password' => '',
                'user' => $user,
                'errors' => []
            ];
            
            $this->view('users/profile', $data);
        }
    }
} 