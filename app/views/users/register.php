<?php require_once APP_DIR . '/views/includes/header.php'; ?>

<section class="page-header">
    <div class="container">
        <h1>Inscription</h1>
        <p>Créez votre compte pour accéder à notre plateforme de bien-être</p>
    </div>
</section>

<section class="auth-content">
    <div class="container">
        <div class="auth-form">
            <form action="<?php echo URL_ROOT; ?>/users/register" method="POST">
                <input type="hidden" name="csrf_token" value="<?php echo generateCsrfToken(); ?>">
                
                <div class="form-group">
                    <label for="name">Nom complet <span class="required">*</span></label>
                    <input type="text" id="name" name="name" value="<?php echo isset($name) ? $name : ''; ?>" required>
                    <?php if (isset($errors['name'])) : ?>
                        <span class="error-message"><?php echo $errors['name']; ?></span>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label for="email">Adresse email <span class="required">*</span></label>
                    <input type="email" id="email" name="email" value="<?php echo isset($email) ? $email : ''; ?>" required>
                    <?php if (isset($errors['email'])) : ?>
                        <span class="error-message"><?php echo $errors['email']; ?></span>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label for="password">Mot de passe <span class="required">*</span></label>
                    <input type="password" id="password" name="password" required>
                    <small class="form-text">Le mot de passe doit contenir au moins 6 caractères</small>
                    <?php if (isset($errors['password'])) : ?>
                        <span class="error-message"><?php echo $errors['password']; ?></span>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label for="confirm_password">Confirmer le mot de passe <span class="required">*</span></label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                    <?php if (isset($errors['confirm_password'])) : ?>
                        <span class="error-message"><?php echo $errors['confirm_password']; ?></span>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn primary">S'inscrire</button>
                </div>
                
                <div class="auth-links">
                    <p>Vous avez déjà un compte ? <a href="<?php echo URL_ROOT; ?>/users/login">Connectez-vous</a></p>
                </div>
            </form>
        </div>
    </div>
</section>

<?php require_once APP_DIR . '/views/includes/footer.php'; ?> 