/**
 * Fichier JavaScript principal pour la Plateforme de Bien-être Mental et Culturel
 */

document.addEventListener('DOMContentLoaded', function() {
    // Gestion des formulaires avec confirmation
    const confirmForms = document.querySelectorAll('form[data-confirm]');
    confirmForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const confirmMessage = this.getAttribute('data-confirm');
            if (!confirm(confirmMessage)) {
                e.preventDefault();
            }
        });
    });

    // Gestion du lecteur audio pour la section musique
    const audioPlayer = document.getElementById('audioPlayer');
    const musicList = document.querySelectorAll('.music-item');
    
    if (audioPlayer && musicList.length > 0) {
        musicList.forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Récupérer les informations de la musique
                const musicUrl = this.getAttribute('data-src');
                const musicTitle = this.getAttribute('data-title');
                const musicArtist = this.getAttribute('data-artist');
                
                // Mettre à jour le lecteur
                audioPlayer.setAttribute('src', musicUrl);
                audioPlayer.play();
                
                // Mettre à jour l'interface
                const nowPlaying = document.getElementById('nowPlaying');
                if (nowPlaying) {
                    nowPlaying.textContent = `${musicTitle} - ${musicArtist}`;
                }
                
                // Marquer l'élément actif
                musicList.forEach(music => music.classList.remove('active'));
                this.classList.add('active');
            });
        });
    }
    
    // Gestion des alertes temporaires
    const alerts = document.querySelectorAll('.alert.temporary');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => {
                alert.remove();
            }, 500);
        }, 5000);
    });
    
    // Gestion de la hauteur du chat pour qu'il s'adapte à l'écran
    const chatMessages = document.getElementById('chatMessages');
    if (chatMessages) {
        adjustChatHeight();
        window.addEventListener('resize', adjustChatHeight);
    }
    
    // Gestion du formulaire de recherche
    const searchForm = document.getElementById('searchForm');
    const searchResults = document.getElementById('searchResults');
    
    if (searchForm && searchResults) {
        searchForm.addEventListener('submit', function(e) {
            // Ici, vous pourriez implémenter une recherche AJAX
            // Pour l'instant, nous ne faisons rien de spécial
        });
    }
    
    // Fonction pour ajuster la hauteur du chat
    function adjustChatHeight() {
        const windowHeight = window.innerHeight;
        const chatContainer = document.querySelector('.chat-container');
        const chatInput = document.querySelector('.chat-input');
        
        if (chatContainer && chatInput) {
            const chatContainerTop = chatContainer.getBoundingClientRect().top;
            const chatInputHeight = chatInput.offsetHeight;
            const padding = 30; // Espace supplémentaire
            
            const newHeight = windowHeight - chatContainerTop - chatInputHeight - padding;
            chatMessages.style.height = `${newHeight}px`;
        }
    }
    
    // Faire défiler automatiquement vers le bas dans le chat
    if (chatMessages) {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
    
    // Prévisualisation des fichiers images téléchargés
    const fileInputs = document.querySelectorAll('input[type="file"][data-preview]');
    fileInputs.forEach(input => {
        const previewElementId = input.getAttribute('data-preview');
        const previewElement = document.getElementById(previewElementId);
        
        if (previewElement) {
            input.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        previewElement.src = e.target.result;
                        previewElement.style.display = 'block';
                    };
                    
                    reader.readAsDataURL(this.files[0]);
                }
            });
        }
    });
}); 