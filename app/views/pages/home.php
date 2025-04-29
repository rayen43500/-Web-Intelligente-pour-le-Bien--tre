<?php require_once APP_DIR . '/views/includes/header.php'; ?>

<section class="hero">
    <div class="container">
        <h2>Bienvenue sur notre plateforme de bien-être</h2>
        <p>Un espace personnel pour dialoguer avec un assistant virtuel, accéder à une bibliothèque numérique et prendre des notes personnelles.</p>
        <div class="cta-buttons">
            <a href="<?php echo URL_ROOT; ?>/users/register" class="btn primary">S'inscrire</a>
            <a href="<?php echo URL_ROOT; ?>/users/login" class="btn secondary">Se connecter</a>
        </div>
    </div>
</section>

<section class="features">
    <div class="container">
        <h2>Nos services</h2>
        <div class="feature-grid">
            <div class="feature-card">
                <h3>Consultation IA</h3>
                <p>Dialoguez avec notre assistant virtuel intelligent pour des conseils personnalisés en matière de bien-être mental.</p>
                <p>Notre IA peut vous aider à mieux comprendre vos émotions, vous suggérer des exercices de relaxation adaptés et vous guider vers un meilleur équilibre émotionnel.</p>
            </div>
            <div class="feature-card">
                <h3>Bibliothèque numérique</h3>
                <p>Accédez à une collection soigneusement sélectionnée de livres, musiques et vidéos pour nourrir votre esprit et favoriser votre bien-être.</p>
                <p>Des contenus sur la méditation, la gestion du stress, le développement personnel et bien plus encore, accessibles à tout moment.</p>
            </div>
            <div class="feature-card">
                <h3>Bloc-notes personnel</h3>
                <p>Prenez des notes, suivez vos progrès, documentez vos réflexions et conservez-les dans un espace privé et sécurisé.</p>
                <p>Un outil pratique pour mettre en place des routines de bien-être, suivre votre parcours émotionnel ou simplement organiser vos pensées.</p>
            </div>
        </div>
    </div>
</section>

<section class="about">
    <div class="container">
        <h2>À propos de notre plateforme</h2>
        <p>Notre plateforme de bien-être mental et culturel a été conçue pour offrir un environnement numérique complet dédié à votre santé mentale et à votre développement personnel.</p>
        <p>Nous croyons que chacun mérite d'avoir accès à des ressources de qualité pour prendre soin de son esprit, tout comme nous prenons soin de notre corps. Notre plateforme combine technologie, contenu culturel et outils personnels pour vous accompagner dans cette démarche.</p>
        <p>Rejoignez notre communauté dès aujourd'hui et commencez votre parcours vers un meilleur équilibre émotionnel et mental !</p>
    </div>
</section>

<?php require_once APP_DIR . '/views/includes/footer.php'; ?> 