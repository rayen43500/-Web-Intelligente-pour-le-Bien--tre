<?php require_once APP_DIR . '/views/includes/header.php'; ?>

<section class="dashboard-header">
    <div class="container">
        <h1>Assistant IA</h1>
        <p>Discutez avec notre assistant virtuel pour obtenir du soutien et des conseils</p>
    </div>
</section>

<section class="chatbot-content">
    <div class="container">
        <div class="chat-container">
            <div class="chat-header">
                <div class="chat-avatar">
                    <img src="<?php echo URL_ROOT; ?>/assets/images/chatbot-avatar.png" alt="Assistant IA">
                </div>
                <div class="chat-info">
                    <h3>Assistant bien-être</h3>
                    <p class="status online">En ligne</p>
                </div>
            </div>
            
            <div class="chat-messages" id="chatMessages">
                <div class="message bot">
                    <div class="message-content">
                        <p>Bonjour ! Je suis votre assistant virtuel pour le bien-être mental. Comment puis-je vous aider aujourd'hui ?</p>
                    </div>
                    <div class="message-time">
                        <?php echo date('H:i'); ?>
                    </div>
                </div>
                
                <div class="message bot">
                    <div class="message-content">
                        <p>Vous pouvez me parler de ce que vous ressentez, me demander des conseils sur la gestion du stress, la méditation, ou simplement discuter de ce qui vous préoccupe.</p>
                    </div>
                    <div class="message-time">
                        <?php echo date('H:i'); ?>
                    </div>
                </div>
                
                <!-- Les messages s'afficheront ici dynamiquement -->
            </div>
            
            <div class="chat-input">
                <form id="chatForm">
                    <textarea id="userMessage" placeholder="Tapez votre message ici..." required></textarea>
                    <button type="submit" id="sendBtn">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
                
                <div class="chat-suggestions">
                    <button class="suggestion-btn" data-message="Comment gérer le stress ?">Comment gérer le stress ?</button>
                    <button class="suggestion-btn" data-message="Je me sens anxieux(se)">Je me sens anxieux(se)</button>
                    <button class="suggestion-btn" data-message="Conseils pour mieux dormir">Conseils pour mieux dormir</button>
                    <button class="suggestion-btn" data-message="Exercices de respiration">Exercices de respiration</button>
                </div>
            </div>
        </div>
        
        <div class="chat-sidebar">
            <div class="sidebar-section">
                <h3>À propos de l'assistant</h3>
                <p>Notre assistant IA est conçu pour vous fournir du soutien et des conseils en matière de bien-être mental. Il peut vous aider avec :</p>
                <ul>
                    <li>Gestion du stress et de l'anxiété</li>
                    <li>Techniques de méditation et de respiration</li>
                    <li>Conseils pour améliorer votre sommeil</li>
                    <li>Exercices de relaxation</li>
                    <li>Réflexion positive</li>
                </ul>
            </div>
            
            <div class="sidebar-section disclaimer">
                <h3>Important</h3>
                <p>L'assistant n'est pas un professionnel de la santé mentale et ne remplace pas une consultation avec un médecin ou un psychologue. Si vous traversez une crise ou avez besoin d'une aide immédiate, veuillez contacter un professionnel de la santé.</p>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const chatForm = document.getElementById('chatForm');
        const userMessageInput = document.getElementById('userMessage');
        const chatMessages = document.getElementById('chatMessages');
        const suggestionButtons = document.querySelectorAll('.suggestion-btn');
        
        // Fonction pour ajouter un message à la conversation
        function addMessage(message, isUser = false) {
            const messageDiv = document.createElement('div');
            messageDiv.className = isUser ? 'message user' : 'message bot';
            
            const currentTime = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            
            messageDiv.innerHTML = `
                <div class="message-content">
                    <p>${message}</p>
                </div>
                <div class="message-time">
                    ${currentTime}
                </div>
            `;
            
            chatMessages.appendChild(messageDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }
        
        // Fonction pour envoyer un message à l'API (à implémenter réellement)
        async function sendToChatbot(message) {
            // Simuler un délai de réponse
            const typingDiv = document.createElement('div');
            typingDiv.className = 'message bot typing';
            typingDiv.innerHTML = '<div class="typing-indicator"><span></span><span></span><span></span></div>';
            chatMessages.appendChild(typingDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;
            
            // Dans un projet réel, cette partie serait remplacée par un appel à une API IA
            // comme OpenAI GPT-3 ou une autre API de chatbot
            setTimeout(() => {
                chatMessages.removeChild(typingDiv);
                
                // Réponses prédéfinies simples pour la démonstration
                let response = '';
                
                if (message.toLowerCase().includes('bonjour') || message.toLowerCase().includes('salut')) {
                    response = 'Bonjour ! Comment puis-je vous aider aujourd\'hui ?';
                } else if (message.toLowerCase().includes('stress') || message.toLowerCase().includes('stressé')) {
                    response = 'La gestion du stress est essentielle pour le bien-être mental. Voici quelques techniques que vous pourriez essayer :<br>1. Respirez profondément pendant 5 minutes<br>2. Faites une promenade dans la nature<br>3. Pratiquez la pleine conscience<br>4. Écoutez une musique relaxante';
                } else if (message.toLowerCase().includes('dormir') || message.toLowerCase().includes('sommeil')) {
                    response = 'Pour améliorer votre sommeil, essayez ces conseils :<br>1. Maintenez un horaire de sommeil régulier<br>2. Créez une routine de coucher relaxante<br>3. Évitez les écrans avant de dormir<br>4. Assurez-vous que votre chambre est calme, sombre et fraîche';
                } else if (message.toLowerCase().includes('anxieux') || message.toLowerCase().includes('anxiété')) {
                    response = 'L\'anxiété est une réaction normale face à certaines situations. Pour vous aider à la gérer, vous pouvez :<br>1. Pratiquer des exercices de respiration (4-7-8)<br>2. Identifier vos déclencheurs d\'anxiété<br>3. Établir une routine d\'exercice physique régulière<br>4. Considérer la méditation guidée';
                } else if (message.toLowerCase().includes('respiration') || message.toLowerCase().includes('respirer')) {
                    response = 'Voici un exercice de respiration simple que vous pouvez essayer :<br>1. Inspirez lentement par le nez pendant 4 secondes<br>2. Retenez votre respiration pendant 7 secondes<br>3. Expirez lentement par la bouche pendant 8 secondes<br>4. Répétez ce cycle 5 fois';
                } else {
                    response = 'Merci de partager cela avec moi. Comment vous sentez-vous par rapport à cette situation ? Y a-t-il quelque chose de spécifique sur lequel vous aimeriez des conseils ?';
                }
                
                addMessage(response);
            }, 1500);
        }
        
        // Gérer l'envoi du formulaire
        chatForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const userMessage = userMessageInput.value.trim();
            if (!userMessage) return;
            
            // Ajouter le message de l'utilisateur à la conversation
            addMessage(userMessage, true);
            
            // Envoyer le message au chatbot
            sendToChatbot(userMessage);
            
            // Vider le champ de saisie
            userMessageInput.value = '';
        });
        
        // Gérer les boutons de suggestion
        suggestionButtons.forEach(button => {
            button.addEventListener('click', function() {
                const suggestionText = this.dataset.message;
                userMessageInput.value = suggestionText;
                chatForm.dispatchEvent(new Event('submit'));
            });
        });
        
        // Permettre à l'utilisateur d'envoyer un message en appuyant sur Entrée
        userMessageInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                chatForm.dispatchEvent(new Event('submit'));
            }
        });
    });
</script>

<?php require_once APP_DIR . '/views/includes/footer.php'; ?> 