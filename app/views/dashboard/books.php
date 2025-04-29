<?php require_once APP_DIR . '/views/includes/header.php'; ?>

<section class="dashboard-header">
    <div class="container">
        <h1>Bibliothèque</h1>
        <p>Explorez notre collection de livres pour votre bien-être mental</p>
    </div>
</section>

<section class="books-content">
    <div class="container">
        <div class="books-filters">
            <div class="search-box">
                <input type="text" id="bookSearch" placeholder="Rechercher un livre...">
                <button id="searchBtn"><i class="fas fa-search"></i></button>
            </div>
            
            <div class="filters">
                <select id="categoryFilter">
                    <option value="">Toutes les catégories</option>
                    <option value="meditation">Méditation</option>
                    <option value="stress">Gestion du stress</option>
                    <option value="personal-dev">Développement personnel</option>
                    <option value="psychology">Psychologie</option>
                    <option value="philosophy">Philosophie</option>
                </select>
                
                <select id="sortBooks">
                    <option value="newest">Plus récents</option>
                    <option value="oldest">Plus anciens</option>
                    <option value="title-asc">Titre (A-Z)</option>
                    <option value="title-desc">Titre (Z-A)</option>
                </select>
            </div>
        </div>
        
        <div class="books-grid">
            <?php if (empty($books)) : ?>
                <div class="empty-state">
                    <img src="<?php echo URL_ROOT; ?>/assets/images/empty-books.svg" alt="Aucun livre">
                    <h3>Aucun livre disponible pour le moment</h3>
                    <p>Notre bibliothèque est en cours de constitution. Revenez bientôt pour découvrir nos recommandations de lecture.</p>
                </div>
            <?php else : ?>
                <?php foreach ($books as $book) : ?>
                    <div class="book-card">
                        <div class="book-cover">
                            <img src="<?php echo URL_ROOT; ?>/uploads/books/covers/<?php echo $book['cover']; ?>" alt="<?php echo $book['title']; ?>">
                        </div>
                        <div class="book-info">
                            <h3 class="book-title"><?php echo $book['title']; ?></h3>
                            <p class="book-author">Par <?php echo $book['author']; ?></p>
                            <p class="book-category"><?php echo $book['category']; ?></p>
                            <div class="book-actions">
                                <a href="<?php echo URL_ROOT; ?>/dashboard/view-book/<?php echo $book['id']; ?>" class="btn primary">Lire</a>
                                <a href="<?php echo URL_ROOT; ?>/uploads/books/<?php echo $book['file']; ?>" class="btn secondary" download>Télécharger</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('bookSearch');
        const searchBtn = document.getElementById('searchBtn');
        const categoryFilter = document.getElementById('categoryFilter');
        const sortSelect = document.getElementById('sortBooks');
        
        // Fonctionnalité de recherche à implémenter
        if (searchBtn && searchInput) {
            searchBtn.addEventListener('click', function() {
                const searchTerm = searchInput.value.trim();
                // Ici, vous pourriez rediriger vers une URL de recherche ou filtrer via JavaScript
                console.log('Recherche:', searchTerm);
            });
            
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    searchBtn.click();
                }
            });
        }
        
        // Filtrage par catégorie à implémenter
        if (categoryFilter) {
            categoryFilter.addEventListener('change', function() {
                const category = this.value;
                console.log('Filtrer par catégorie:', category);
            });
        }
        
        // Tri des livres à implémenter
        if (sortSelect) {
            sortSelect.addEventListener('change', function() {
                const sortOrder = this.value;
                console.log('Trier par:', sortOrder);
            });
        }
    });
</script>

<?php require_once APP_DIR . '/views/includes/footer.php'; ?> 