<?php require_once APP_DIR . '/views/includes/header.php'; ?>

<section class="dashboard-header">
    <div class="container">
        <h1>Tableau de bord</h1>
        <p>Bienvenue, <?php echo $_SESSION['user_name']; ?> !</p>
    </div>
</section>

<section class="dashboard-content">
    <div class="container">
        <div class="dashboard-stats">
            <div class="stats-card">
                <h3>Bibliothèque</h3>
                <div class="stats-value">0</div>
                <p>livres disponibles</p>
                <a href="<?php echo URL_ROOT; ?>/dashboard/books" class="btn secondary">Accéder</a>
            </div>
            
            <div class="stats-card">
                <h3>Musique</h3>
                <div class="stats-value">0</div>
                <p>pistes disponibles</p>
                <a href="<?php echo URL_ROOT; ?>/dashboard/music" class="btn secondary">Accéder</a>
            </div>
            
            <div class="stats-card">
                <h3>Vidéos</h3>
                <div class="stats-value">0</div>
                <p>vidéos disponibles</p>
                <a href="<?php echo URL_ROOT; ?>/dashboard/videos" class="btn secondary">Accéder</a>
            </div>
            
            <div class="stats-card">
                <h3>Notes</h3>
                <div class="stats-value">0</div>
                <p>notes personnelles</p>
                <a href="<?php echo URL_ROOT; ?>/dashboard/notes" class="btn secondary">Accéder</a>
            </div>
        </div>
        
        <div class="dashboard-features">
            <div class="feature-box">
                <h2>Consultation IA</h2>
                <p>Notre assistant virtuel est disponible 24/7 pour vous aider dans votre bien-être mental.</p>
                <p>Posez vos questions, partagez vos préoccupations ou demandez simplement des conseils de relaxation.</p>
                <a href="<?php echo URL_ROOT; ?>/dashboard/chatbot" class="btn primary">Démarrer une conversation</a>
            </div>
            
            <div class="feature-box">
                <h2>Ressources récentes</h2>
                <div class="recent-items">
                    <p>Aucune ressource disponible pour le moment.</p>
                </div>
            </div>
        </div>
        
        <div class="dashboard-quote">
            <blockquote>
                "Prendre soin de votre esprit est aussi important que prendre soin de votre corps."
            </blockquote>
            <p class="quote-author">— Équipe <?php echo APP_NAME; ?></p>
        </div>
    </div>
</section>

<?php require_once APP_DIR . '/views/includes/footer.php'; ?> 