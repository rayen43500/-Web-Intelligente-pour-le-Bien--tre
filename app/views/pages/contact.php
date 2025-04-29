<?php require_once APP_DIR . '/views/includes/header.php'; ?>

<section class="page-header">
    <div class="container">
        <h1>Contactez-nous</h1>
        <p>Nous sommes à votre écoute. N'hésitez pas à nous envoyer un message.</p>
    </div>
</section>

<section class="contact-content">
    <div class="container">
        <div class="contact-info">
            <h2>Informations de contact</h2>
            <p>Vous pouvez nous contacter directement en utilisant les coordonnées ci-dessous ou en remplissant le formulaire.</p>
            
            <div class="contact-details">
                <div class="contact-item">
                    <h3>Adresse</h3>
                    <p>123 Avenue du Bien-être<br>75000 Paris<br>France</p>
                </div>
                
                <div class="contact-item">
                    <h3>Email</h3>
                    <p>contact@bien-etre-mental.fr</p>
                </div>
                
                <div class="contact-item">
                    <h3>Téléphone</h3>
                    <p>+33 (0)1 23 45 67 89</p>
                </div>
                
                <div class="contact-item">
                    <h3>Horaires</h3>
                    <p>Lundi - Vendredi : 9h00 - 18h00<br>Samedi : 10h00 - 15h00<br>Dimanche : Fermé</p>
                </div>
            </div>
        </div>
        
        <div class="contact-form">
            <h2>Formulaire de contact</h2>
            <form action="<?php echo URL_ROOT; ?>/home/contact" method="POST">
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
                    <label for="subject">Sujet <span class="required">*</span></label>
                    <input type="text" id="subject" name="subject" value="<?php echo isset($subject) ? $subject : ''; ?>" required>
                    <?php if (isset($errors['subject'])) : ?>
                        <span class="error-message"><?php echo $errors['subject']; ?></span>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label for="message">Message <span class="required">*</span></label>
                    <textarea id="message" name="message" rows="5" required><?php echo isset($message) ? $message : ''; ?></textarea>
                    <?php if (isset($errors['message'])) : ?>
                        <span class="error-message"><?php echo $errors['message']; ?></span>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn primary">Envoyer le message</button>
                </div>
            </form>
        </div>
    </div>
</section>

<?php require_once APP_DIR . '/views/includes/footer.php'; ?> 