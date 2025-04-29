<?php require_once APP_DIR . '/views/includes/header.php'; ?>

<section class="dashboard-header">
    <div class="container">
        <h1>Mes notes</h1>
        <p>Créez et organisez vos notes personnelles</p>
    </div>
</section>

<section class="notes-content">
    <div class="container">
        <div class="notes-actions">
            <button id="createNoteBtn" class="btn primary">
                <i class="fas fa-plus"></i> Nouvelle note
            </button>
            
            <div class="search-box">
                <input type="text" id="noteSearch" placeholder="Rechercher dans vos notes...">
                <button id="searchBtn"><i class="fas fa-search"></i></button>
            </div>
            
            <div class="filters">
                <select id="sortNotes">
                    <option value="newest">Plus récentes</option>
                    <option value="oldest">Plus anciennes</option>
                    <option value="title-asc">Titre (A-Z)</option>
                    <option value="title-desc">Titre (Z-A)</option>
                </select>
            </div>
        </div>
        
        <div class="notes-grid" id="notesGrid">
            <?php if (empty($notes)) : ?>
                <div class="empty-state">
                    <img src="<?php echo URL_ROOT; ?>/assets/images/empty-notes.svg" alt="Aucune note">
                    <h3>Vous n'avez pas encore de notes</h3>
                    <p>Commencez à organiser vos pensées, idées et réflexions en créant votre première note.</p>
                    <button class="btn primary new-note-btn">Créer ma première note</button>
                </div>
            <?php else : ?>
                <?php foreach ($notes as $note) : ?>
                    <div class="note-card" data-id="<?php echo $note['id']; ?>">
                        <div class="note-header">
                            <h3 class="note-title"><?php echo $note['title']; ?></h3>
                            <span class="note-date"><?php echo date('d/m/Y', strtotime($note['created_at'])); ?></span>
                        </div>
                        <div class="note-content">
                            <p><?php echo substr($note['content'], 0, 150); ?><?php echo strlen($note['content']) > 150 ? '...' : ''; ?></p>
                        </div>
                        <div class="note-actions">
                            <button class="edit-note" data-id="<?php echo $note['id']; ?>"><i class="fas fa-edit"></i></button>
                            <button class="delete-note" data-id="<?php echo $note['id']; ?>"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Modal pour créer/éditer une note -->
<div id="noteModal" class="modal">
    <div class="modal-content note-editor">
        <div class="modal-header">
            <h2 id="modalTitle">Nouvelle note</h2>
            <button id="closeModal" class="close-btn">&times;</button>
        </div>
        
        <form id="noteForm">
            <input type="hidden" id="noteId" name="id" value="">
            <input type="hidden" name="csrf_token" value="<?php echo generateCsrfToken(); ?>">
            
            <div class="form-group">
                <label for="noteTitle">Titre</label>
                <input type="text" id="noteTitle" name="title" required>
            </div>
            
            <div class="form-group">
                <label for="noteContent">Contenu</label>
                <textarea id="noteContent" name="content" rows="10" required></textarea>
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn primary">Enregistrer</button>
                <button type="button" id="cancelNote" class="btn secondary">Annuler</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal de confirmation pour la suppression -->
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Confirmation de suppression</h2>
            <button class="close-btn">&times;</button>
        </div>
        
        <p>Êtes-vous sûr de vouloir supprimer cette note ? Cette action est irréversible.</p>
        
        <div class="modal-buttons">
            <button id="confirmDelete" class="btn danger">Supprimer</button>
            <button id="cancelDelete" class="btn secondary">Annuler</button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const noteModal = document.getElementById('noteModal');
        const deleteModal = document.getElementById('deleteModal');
        const noteForm = document.getElementById('noteForm');
        const createNoteBtn = document.getElementById('createNoteBtn');
        const closeModal = document.getElementById('closeModal');
        const cancelNote = document.getElementById('cancelNote');
        const modalTitle = document.getElementById('modalTitle');
        const noteIdInput = document.getElementById('noteId');
        const noteTitleInput = document.getElementById('noteTitle');
        const noteContentInput = document.getElementById('noteContent');
        const confirmDelete = document.getElementById('confirmDelete');
        const cancelDelete = document.getElementById('cancelDelete');
        const searchInput = document.getElementById('noteSearch');
        const searchBtn = document.getElementById('searchBtn');
        const sortSelect = document.getElementById('sortNotes');
        const notesGrid = document.getElementById('notesGrid');
        
        let currentNoteId = null;
        
        // Ouvrir le modal pour une nouvelle note
        function openNewNoteModal() {
            modalTitle.textContent = 'Nouvelle note';
            noteIdInput.value = '';
            noteTitleInput.value = '';
            noteContentInput.value = '';
            noteModal.style.display = 'flex';
            noteTitleInput.focus();
        }
        
        // Ouvrir le modal pour éditer une note existante
        function openEditNoteModal(noteId, title, content) {
            modalTitle.textContent = 'Modifier la note';
            noteIdInput.value = noteId;
            noteTitleInput.value = title;
            noteContentInput.value = content;
            noteModal.style.display = 'flex';
            noteTitleInput.focus();
        }
        
        // Fermer le modal de note
        function closeNoteModal() {
            noteModal.style.display = 'none';
        }
        
        // Ouvrir le modal de confirmation de suppression
        function openDeleteModal(noteId) {
            currentNoteId = noteId;
            deleteModal.style.display = 'flex';
        }
        
        // Fermer le modal de confirmation de suppression
        function closeDeleteModal() {
            deleteModal.style.display = 'none';
            currentNoteId = null;
        }
        
        // Bouton pour créer une nouvelle note
        if (createNoteBtn) {
            createNoteBtn.addEventListener('click', openNewNoteModal);
        }
        
        // Bouton pour créer une première note (dans l'état vide)
        const newNoteBtn = document.querySelector('.new-note-btn');
        if (newNoteBtn) {
            newNoteBtn.addEventListener('click', openNewNoteModal);
        }
        
        // Fermer le modal de note
        if (closeModal) {
            closeModal.addEventListener('click', closeNoteModal);
        }
        
        if (cancelNote) {
            cancelNote.addEventListener('click', closeNoteModal);
        }
        
        // Gérer les clics sur les boutons d'édition et de suppression
        document.querySelectorAll('.edit-note').forEach(button => {
            button.addEventListener('click', function() {
                const noteId = this.dataset.id;
                const noteCard = this.closest('.note-card');
                const title = noteCard.querySelector('.note-title').textContent;
                const content = ""; // Dans un vrai projet, on récupérerait le contenu complet via AJAX
                
                // Simuler pour la démo - dans un vrai projet, on ferait un appel AJAX
                fetch(`${URL_ROOT}/notes/get/${noteId}`)
                    .then(response => response.json())
                    .then(data => {
                        openEditNoteModal(noteId, title, data.content);
                    })
                    .catch(() => {
                        // Fallback pour la démo
                        const previewContent = noteCard.querySelector('.note-content p').textContent;
                        openEditNoteModal(noteId, title, previewContent);
                    });
            });
        });
        
        document.querySelectorAll('.delete-note').forEach(button => {
            button.addEventListener('click', function() {
                const noteId = this.dataset.id;
                openDeleteModal(noteId);
            });
        });
        
        // Gérer la confirmation de suppression
        if (confirmDelete) {
            confirmDelete.addEventListener('click', function() {
                if (currentNoteId) {
                    // Dans un vrai projet, on ferait un appel AJAX pour supprimer la note
                    // fetch(`${URL_ROOT}/notes/delete/${currentNoteId}`, { method: 'POST' })
                    //     .then(response => response.json())
                    //     .then(data => {
                    //         if (data.success) {
                    //             const noteToRemove = document.querySelector(`.note-card[data-id="${currentNoteId}"]`);
                    //             if (noteToRemove) {
                    //                 noteToRemove.remove();
                    //             }
                    //             closeDeleteModal();
                    //         }
                    //     });
                    
                    // Simulation pour la démo
                    const noteToRemove = document.querySelector(`.note-card[data-id="${currentNoteId}"]`);
                    if (noteToRemove) {
                        noteToRemove.remove();
                    }
                    closeDeleteModal();
                    
                    // Vérifier s'il reste des notes
                    if (notesGrid.children.length === 0) {
                        notesGrid.innerHTML = `
                            <div class="empty-state">
                                <img src="${URL_ROOT}/assets/images/empty-notes.svg" alt="Aucune note">
                                <h3>Vous n'avez pas encore de notes</h3>
                                <p>Commencez à organiser vos pensées, idées et réflexions en créant votre première note.</p>
                                <button class="btn primary new-note-btn">Créer ma première note</button>
                            </div>
                        `;
                        
                        document.querySelector('.new-note-btn').addEventListener('click', openNewNoteModal);
                    }
                }
            });
        }
        
        if (cancelDelete) {
            cancelDelete.addEventListener('click', closeDeleteModal);
        }
        
        // Gérer la soumission du formulaire de note
        if (noteForm) {
            noteForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const noteId = noteIdInput.value;
                const title = noteTitleInput.value;
                const content = noteContentInput.value;
                
                // Dans un vrai projet, on enverrait les données via AJAX
                // Simulation pour la démo
                if (noteId) {
                    // Mise à jour d'une note existante
                    const noteCard = document.querySelector(`.note-card[data-id="${noteId}"]`);
                    if (noteCard) {
                        noteCard.querySelector('.note-title').textContent = title;
                        const contentPreview = content.length > 150 ? content.substring(0, 150) + '...' : content;
                        noteCard.querySelector('.note-content p').textContent = contentPreview;
                    }
                } else {
                    // Création d'une nouvelle note
                    const newNoteId = Date.now(); // Simuler un ID
                    const currentDate = new Date().toLocaleDateString('fr-FR');
                    const contentPreview = content.length > 150 ? content.substring(0, 150) + '...' : content;
                    
                    // Vérifier s'il y a un état vide
                    const emptyState = notesGrid.querySelector('.empty-state');
                    if (emptyState) {
                        notesGrid.innerHTML = '';
                    }
                    
                    // Créer une nouvelle carte de note
                    const newNoteCard = document.createElement('div');
                    newNoteCard.className = 'note-card';
                    newNoteCard.dataset.id = newNoteId;
                    newNoteCard.innerHTML = `
                        <div class="note-header">
                            <h3 class="note-title">${title}</h3>
                            <span class="note-date">${currentDate}</span>
                        </div>
                        <div class="note-content">
                            <p>${contentPreview}</p>
                        </div>
                        <div class="note-actions">
                            <button class="edit-note" data-id="${newNoteId}"><i class="fas fa-edit"></i></button>
                            <button class="delete-note" data-id="${newNoteId}"><i class="fas fa-trash"></i></button>
                        </div>
                    `;
                    
                    notesGrid.prepend(newNoteCard);
                    
                    // Ajouter les événements aux nouveaux boutons
                    newNoteCard.querySelector('.edit-note').addEventListener('click', function() {
                        openEditNoteModal(newNoteId, title, content);
                    });
                    
                    newNoteCard.querySelector('.delete-note').addEventListener('click', function() {
                        openDeleteModal(newNoteId);
                    });
                }
                
                closeNoteModal();
            });
        }
        
        // Recherche de notes
        if (searchBtn && searchInput) {
            searchBtn.addEventListener('click', function() {
                const searchTerm = searchInput.value.trim().toLowerCase();
                const notes = document.querySelectorAll('.note-card');
                
                notes.forEach(note => {
                    const title = note.querySelector('.note-title').textContent.toLowerCase();
                    const content = note.querySelector('.note-content p').textContent.toLowerCase();
                    
                    if (title.includes(searchTerm) || content.includes(searchTerm)) {
                        note.style.display = 'block';
                    } else {
                        note.style.display = 'none';
                    }
                });
            });
            
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    searchBtn.click();
                }
            });
        }
        
        // Tri des notes
        if (sortSelect) {
            sortSelect.addEventListener('change', function() {
                const sortOrder = this.value;
                const notes = Array.from(document.querySelectorAll('.note-card'));
                
                // Trier les notes selon différents critères
                notes.sort((a, b) => {
                    if (sortOrder === 'newest') {
                        return parseInt(b.dataset.id) - parseInt(a.dataset.id);
                    } else if (sortOrder === 'oldest') {
                        return parseInt(a.dataset.id) - parseInt(b.dataset.id);
                    } else if (sortOrder === 'title-asc') {
                        return a.querySelector('.note-title').textContent.localeCompare(b.querySelector('.note-title').textContent);
                    } else if (sortOrder === 'title-desc') {
                        return b.querySelector('.note-title').textContent.localeCompare(a.querySelector('.note-title').textContent);
                    }
                });
                
                // Réorganiser les notes dans le DOM
                notes.forEach(note => {
                    notesGrid.appendChild(note);
                });
            });
        }
        
        // Fermer les modals en cliquant en dehors
        window.addEventListener('click', function(event) {
            if (event.target === noteModal) {
                closeNoteModal();
            }
            
            if (event.target === deleteModal) {
                closeDeleteModal();
            }
        });
    });
</script>

<?php require_once APP_DIR . '/views/includes/footer.php'; ?> 