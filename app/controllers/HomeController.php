<?php
/**
 * Contrôleur de la page d'accueil
 */
class HomeController extends Controller {
    /**
     * Afficher la page d'accueil
     */
    public function index() {
        $data = [
            'title' => 'Accueil - ' . APP_NAME,
            'description' => 'Plateforme de bien-être mental et culturel'
        ];
        
        $this->view('pages/home', $data);
    }
    
    /**
     * Afficher la page À propos
     */
    public function about() {
        $data = [
            'title' => 'À propos - ' . APP_NAME,
            'description' => 'À propos de notre plateforme'
        ];
        
        $this->view('pages/about', $data);
    }
    
    /**
     * Afficher la page de contact
     */
    public function contact() {
        // Vérifier si le formulaire a été soumis
        if ($this->isPostRequest()) {
            // Traiter le formulaire de contact
            $data = [
                'title' => 'Contact - ' . APP_NAME,
                'description' => 'Contactez-nous',
                'name' => sanitize($_POST['name'] ?? ''),
                'email' => sanitize($_POST['email'] ?? ''),
                'subject' => sanitize($_POST['subject'] ?? ''),
                'message' => sanitize($_POST['message'] ?? ''),
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
            }
            
            if (empty($data['subject'])) {
                $data['errors']['subject'] = 'Veuillez entrer un sujet';
            }
            
            if (empty($data['message'])) {
                $data['errors']['message'] = 'Veuillez entrer votre message';
            }
            
            // Si aucune erreur, envoyer l'email (simulation)
            if (empty($data['errors'])) {
                // Dans un environnement réel, on enverrait un email ici
                // Pour cette démonstration, on simule l'envoi réussi
                
                setFlashMessage('Votre message a été envoyé avec succès. Nous vous répondrons dans les plus brefs délais.', 'success');
                redirect('home/contact');
            }
            
            // Si on arrive ici, il y a eu des erreurs
            $this->view('pages/contact', $data);
        } else {
            // Afficher le formulaire de contact
            $data = [
                'title' => 'Contact - ' . APP_NAME,
                'description' => 'Contactez-nous',
                'name' => '',
                'email' => '',
                'subject' => '',
                'message' => '',
                'errors' => []
            ];
            
            $this->view('pages/contact', $data);
        }
    }
} 