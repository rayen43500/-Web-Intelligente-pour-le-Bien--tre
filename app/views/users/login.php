<?php require_once APP_DIR . '/views/includes/header.php'; ?>

<section class="page-header">
    <div class="container">
        <h1>Connexion</h1>
        <p>Connectez-vous pour accéder à votre espace personnel</p>
    </div>
</section>

<section class="auth-content">
    <div class="container">
        <div class="auth-form">
            <?php if (isset($errors['login'])) : ?>
                <div class="alert alert-danger">
                    <?php echo $errors['login']; ?>
                </div>
            <?php endif; ?>
            
            <form action="<?php echo URL_ROOT; ?>/users/login" method="POST">
                <input type="hidden" name="csrf_token" value="<?php echo generateCsrfToken(); ?>">
                
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
                    <?php if (isset($errors['password'])) : ?>
                        <span class="error-message"><?php echo $errors['password']; ?></span>
                    <?php endif; ?>
                </div>
                
                <div class="form-group checkbox">
                    <input type="checkbox" id="remember_me" name="remember_me" <?php echo isset($remember_me) && $remember_me ? 'checked' : ''; ?>>
                    <label for="remember_me">Se souvenir de moi</label>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn primary">Se connecter</button>
                </div>
                
                <div class="auth-links">
                    <p>Vous n'avez pas de compte ? <a href="<?php echo URL_ROOT; ?>/users/register">Inscrivez-vous</a></p>
                    <p><a href="<?php echo URL_ROOT; ?>/users/forgot-password">Mot de passe oublié ?</a></p>
                </div>
            </form>
        </div>
    </div>
</section>

<?php require_once APP_DIR . '/views/includes/footer.php'; ?> 