<?php require_once APP_DIR . '/views/includes/header.php'; ?>

<section class="page-header">
    <div class="container">
        <h1>Mon profil</h1>
        <p>Gérez vos informations personnelles</p>
    </div>
</section>

<section class="profile-content">
    <div class="container">
        <div class="profile-form">
            <form action="<?php echo URL_ROOT; ?>/users/profile" method="POST">
                <input type="hidden" name="csrf_token" value="<?php echo generateCsrfToken(); ?>">
                
                <div class="form-group">
                    <label for="name">Nom complet <span class="required">*</span></label>
                    <input type="text" id="name" name="name" value="<?php echo $name; ?>" required>
                    <?php if (isset($errors['name'])) : ?>
                        <span class="error-message"><?php echo $errors['name']; ?></span>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label for="email">Adresse email <span class="required">*</span></label>
                    <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
                    <?php if (isset($errors['email'])) : ?>
                        <span class="error-message"><?php echo $errors['email']; ?></span>
                    <?php endif; ?>
                </div>
                
                <h3>Changer le mot de passe</h3>
                <p class="form-info">Laissez ces champs vides si vous ne souhaitez pas changer votre mot de passe.</p>
                
                <div class="form-group">
                    <label for="current_password">Mot de passe actuel</label>
                    <input type="password" id="current_password" name="current_password">
                    <?php if (isset($errors['current_password'])) : ?>
                        <span class="error-message"><?php echo $errors['current_password']; ?></span>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label for="new_password">Nouveau mot de passe</label>
                    <input type="password" id="new_password" name="new_password">
                    <small class="form-text">Le mot de passe doit contenir au moins 6 caractères</small>
                    <?php if (isset($errors['new_password'])) : ?>
                        <span class="error-message"><?php echo $errors['new_password']; ?></span>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label for="confirm_password">Confirmer le nouveau mot de passe</label>
                    <input type="password" id="confirm_password" name="confirm_password">
                    <?php if (isset($errors['confirm_password'])) : ?>
                        <span class="error-message"><?php echo $errors['confirm_password']; ?></span>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn primary">Mettre à jour le profil</button>
                </div>
            </form>
        </div>
        
        <div class="account-info">
            <h3>Informations du compte</h3>
            <ul>
                <li><strong>Date d'inscription :</strong> <?php echo isset($user['created_at']) ? date('d/m/Y', strtotime($user['created_at'])) : 'Non disponible'; ?></li>
                <li><strong>Dernière connexion :</strong> <?php echo isset($user['last_login']) ? date('d/m/Y H:i', strtotime($user['last_login'])) : 'Non disponible'; ?></li>
                <li><strong>Rôle :</strong> <?php echo isset($user['role']) ? ucfirst($user['role']) : 'Utilisateur'; ?></li>
            </ul>
            
            <div class="danger-zone">
                <h3>Zone de danger</h3>
                <p>Attention, cette action est irréversible.</p>
                <button type="button" class="btn danger" id="deleteAccount">Supprimer mon compte</button>
            </div>
        </div>
    </div>
</section>

<div id="deleteModal" class="modal">
    <div class="modal-content">
        <h2>Confirmation de suppression</h2>
        <p>Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible et toutes vos données seront perdues.</p>
        
        <form action="<?php echo URL_ROOT; ?>/users/delete" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo generateCsrfToken(); ?>">
            
            <div class="form-group">
                <label for="confirm_delete">Veuillez entrer votre mot de passe pour confirmer</label>
                <input type="password" id="confirm_delete" name="password" required>
            </div>
            
            <div class="modal-buttons">
                <button type="button" id="cancelDelete" class="btn secondary">Annuler</button>
                <button type="submit" class="btn danger">Confirmer la suppression</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteBtn = document.getElementById('deleteAccount');
        const deleteModal = document.getElementById('deleteModal');
        const cancelDelete = document.getElementById('cancelDelete');
        
        if (deleteBtn && deleteModal && cancelDelete) {
            deleteBtn.addEventListener('click', function() {
                deleteModal.style.display = 'flex';
            });
            
            cancelDelete.addEventListener('click', function() {
                deleteModal.style.display = 'none';
            });
            
            window.addEventListener('click', function(event) {
                if (event.target === deleteModal) {
                    deleteModal.style.display = 'none';
                }
            });
        }
    });
</script>

<?php require_once APP_DIR . '/views/includes/footer.php'; ?> 