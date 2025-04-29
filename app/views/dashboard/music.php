<?php require_once APP_DIR . '/views/includes/header.php'; ?>

<section class="dashboard-header">
    <div class="container">
        <h1>Musique</h1>
        <p>Écoutez notre sélection de musiques relaxantes pour votre bien-être</p>
    </div>
</section>

<section class="music-content">
    <div class="container">
        <div class="music-filters">
            <div class="search-box">
                <input type="text" id="musicSearch" placeholder="Rechercher une musique...">
                <button id="searchBtn"><i class="fas fa-search"></i></button>
            </div>
            
            <div class="filters">
                <select id="moodFilter">
                    <option value="">Toutes les ambiances</option>
                    <option value="relaxation">Relaxation</option>
                    <option value="meditation">Méditation</option>
                    <option value="sleep">Sommeil</option>
                    <option value="focus">Concentration</option>
                    <option value="energy">Énergie</option>
                </select>
                
                <select id="sortMusic">
                    <option value="newest">Plus récentes</option>
                    <option value="oldest">Plus anciennes</option>
                    <option value="title-asc">Titre (A-Z)</option>
                    <option value="title-desc">Titre (Z-A)</option>
                </select>
            </div>
        </div>
        
        <div class="currently-playing">
            <h2>En écoute</h2>
            <div class="player-container">
                <div id="nowPlaying" class="now-playing">
                    <div class="track-info">
                        <p class="no-music">Aucune musique sélectionnée</p>
                    </div>
                    <div class="player-controls">
                        <audio id="audioPlayer" controls></audio>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="tracks-list">
            <?php if (empty($tracks)) : ?>
                <div class="empty-state">
                    <img src="<?php echo URL_ROOT; ?>/assets/images/empty-music.svg" alt="Aucune musique">
                    <h3>Aucune musique disponible pour le moment</h3>
                    <p>Notre collection musicale est en cours de constitution. Revenez bientôt pour découvrir nos morceaux relaxants.</p>
                </div>
            <?php else : ?>
                <?php foreach ($tracks as $track) : ?>
                    <div class="track-card" data-id="<?php echo $track['id']; ?>" data-src="<?php echo URL_ROOT; ?>/uploads/music/<?php echo $track['file']; ?>">
                        <div class="track-cover">
                            <img src="<?php echo URL_ROOT; ?>/uploads/music/covers/<?php echo $track['cover']; ?>" alt="<?php echo $track['title']; ?>">
                            <button class="play-btn"><i class="fas fa-play"></i></button>
                        </div>
                        <div class="track-info">
                            <h3 class="track-title"><?php echo $track['title']; ?></h3>
                            <p class="track-artist"><?php echo $track['artist']; ?></p>
                            <p class="track-mood"><?php echo $track['mood']; ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('musicSearch');
        const searchBtn = document.getElementById('searchBtn');
        const moodFilter = document.getElementById('moodFilter');
        const sortSelect = document.getElementById('sortMusic');
        const audioPlayer = document.getElementById('audioPlayer');
        const nowPlaying = document.getElementById('nowPlaying');
        
        // Fonctionnalité de recherche à implémenter
        if (searchBtn && searchInput) {
            searchBtn.addEventListener('click', function() {
                const searchTerm = searchInput.value.trim();
                console.log('Recherche:', searchTerm);
            });
            
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    searchBtn.click();
                }
            });
        }
        
        // Filtrage par ambiance à implémenter
        if (moodFilter) {
            moodFilter.addEventListener('change', function() {
                const mood = this.value;
                console.log('Filtrer par ambiance:', mood);
            });
        }
        
        // Tri des musiques à implémenter
        if (sortSelect) {
            sortSelect.addEventListener('change', function() {
                const sortOrder = this.value;
                console.log('Trier par:', sortOrder);
            });
        }
        
        // Lecteur audio (à implémenter quand il y aura des pistes)
        const playButtons = document.querySelectorAll('.play-btn');
        playButtons.forEach(button => {
            button.addEventListener('click', function() {
                const trackCard = this.closest('.track-card');
                const trackSrc = trackCard.dataset.src;
                const trackTitle = trackCard.querySelector('.track-title').textContent;
                const trackArtist = trackCard.querySelector('.track-artist').textContent;
                const trackCover = trackCard.querySelector('.track-cover img').src;
                
                // Mettre à jour le lecteur
                audioPlayer.src = trackSrc;
                audioPlayer.play();
                
                // Mettre à jour les informations de la piste en cours
                nowPlaying.querySelector('.track-info').innerHTML = `
                    <div class="track-cover-mini">
                        <img src="${trackCover}" alt="${trackTitle}">
                    </div>
                    <div class="track-details">
                        <h3>${trackTitle}</h3>
                        <p>${trackArtist}</p>
                    </div>
                `;
            });
        });
    });
</script>

<?php require_once APP_DIR . '/views/includes/footer.php'; ?> 