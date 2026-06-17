<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?><?= esc($book['titre']) ?><?= $this->endSection() ?>

<?= $this->section('content') ?>
<style>
    .back-link {
        display: inline-block;
        margin-bottom: 1.5rem;
        color: #667eea;
        text-decoration: none;
        font-weight: 500;
    }

    .back-link:hover {
        text-decoration: underline;
    }

    .book-detail {
        background: white;
        padding: 2rem;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 2rem;
    }

    .book-cover {
        text-align: center;
    }

    .book-cover img {
        max-width: 100%;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        margin-bottom: 1rem;
    }

    .no-cover {
        width: 100%;
        height: 300px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 3rem;
        margin-bottom: 1rem;
    }

    .book-info h1 {
        font-size: 2rem;
        margin-bottom: 1rem;
        color: #333;
    }

    .book-meta {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .meta-item {
        background: #f9f9f9;
        padding: 1rem;
        border-radius: 4px;
    }

    .meta-label {
        font-weight: 600;
        color: #667eea;
        font-size: 0.9rem;
        text-transform: uppercase;
    }

    .meta-value {
        font-size: 1.1rem;
        color: #333;
        margin-top: 0.3rem;
    }

    .status-badge {
        display: inline-block;
        padding: 0.5rem 1rem;
        border-radius: 4px;
        font-weight: 500;
    }

    .status-disponible {
        background-color: #d4edda;
        color: #155724;
    }

    .status-prete {
        background-color: #f8d7da;
        color: #721c24;
    }

    .isbn-value {
        font-family: 'Courier New', monospace;
        font-weight: bold;
    }

    .book-resume {
        margin: 2rem 0;
        padding: 1.5rem;
        background: #f0f5ff;
        border-left: 4px solid #667eea;
        border-radius: 4px;
    }

    .book-resume h3 {
        margin-bottom: 1rem;
        color: #333;
    }

    .book-resume p {
        line-height: 1.6;
        color: #555;
    }

    .last-loan {
        margin: 2rem 0;
        padding: 1.5rem;
        background: #e8f4f8;
        border-left: 4px solid #17a2b8;
        border-radius: 4px;
    }

    .last-loan h3 {
        margin-bottom: 1rem;
        color: #0c5460;
    }

    .last-loan p {
        margin: 0.5rem 0;
        color: #0c5460;
    }

    .no-loan {
        color: #6c757d;
        font-style: italic;
    }

    .book-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
    }

    .btn {
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 4px;
        font-size: 1rem;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }

    .btn-primary {
        background-color: #667eea;
        color: white;
    }

    .btn-primary:hover {
        background-color: #5568d3;
    }

    .btn-danger {
        background-color: #dc3545;
        color: white;
    }

    .btn-danger:hover {
        background-color: #c82333;
    }

    .btn-warning {
        background-color: #ffc107;
        color: black;
    }

    .btn-warning:hover {
        background-color: #e0a800;
    }

    @media (max-width: 768px) {
        .book-detail {
            grid-template-columns: 1fr;
        }

        .book-meta {
            grid-template-columns: 1fr;
        }
    }
</style>

<a href="<?= base_url('/') ?>" class="back-link">← Retour au catalogue</a>

<div class="book-detail">
    <div class="book-cover">
        <?php if (!empty($book['nom_fichier_couverture'])): ?>
            <img src="<?= base_url('uploads/' . esc($book['nom_fichier_couverture'])) ?>" 
                 alt="Couverture de <?= esc($book['titre']) ?>">
        <?php else: ?>
            <div class="no-cover">📖</div>
        <?php endif; ?>
    </div>

    <div class="book-info">
        <h1><?= esc($book['titre']) ?></h1>

        <div class="book-meta">
            <div class="meta-item">
                <div class="meta-label">Auteur</div>
                <div class="meta-value"><?= esc($book['auteur']) ?></div>
            </div>

            <div class="meta-item">
                <div class="meta-label">Année</div>
                <div class="meta-value"><?= esc($book['annee']) ?></div>
            </div>

            <div class="meta-item">
                <div class="meta-label">ISBN</div>
                <div class="meta-value isbn-value"><?= esc($book['isbn']) ?></div>
            </div>

            <div class="meta-item">
                <div class="meta-label">Catégorie</div>
                <div class="meta-value"><?= !empty($book['categorie']) ? esc($book['categorie']) : 'Non spécifiée' ?></div>
            </div>

            <div class="meta-item">
                <div class="meta-label">Statut</div>
                <div class="meta-value">
                    <span class="status-badge status-<?= esc($book['statut']) ?>">
                        <?= ($book['statut'] === 'disponible') ? '✓ Disponible' : '✗ Prêté' ?>
                    </span>
                </div>
            </div>

            <div class="meta-item">
                <div class="meta-label">Ajouté le</div>
                <div class="meta-value"><?= esc($book['created_at']) ?></div>
            </div>
        </div>

        <?php if (!empty($book['resume'])): ?>
            <div class="book-resume">
                <h3>Résumé</h3>
                <p><?= esc($book['resume']) ?></p>
            </div>
        <?php endif; ?>

        <?php if ($lastLoan): ?>
            <div class="last-loan">
                <h3>📋 Dernier Emprunté</h3>
                <p><strong>Emprunteur :</strong> <?= esc($lastLoan['nom_emprunteur']) ?></p>
                <p><strong>Date d'emprunt :</strong> <?= esc($lastLoan['date_emprunt']) ?></p>
                <?php if (!empty($lastLoan['date_retour'])): ?>
                    <p><strong>Date de retour :</strong> <?= esc($lastLoan['date_retour']) ?></p>
                <?php else: ?>
                    <p><strong>Statut :</strong> <span style="color: #dc3545;">Non retourné</span></p>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="last-loan">
                <p class="no-loan">Aucun historique d'emprunt pour ce livre.</p>
            </div>
        <?php endif; ?>

        <div class="book-actions">
            <a href="<?= base_url('/') ?>" class="btn btn-primary">← Retour</a>
            
            <?php if ($book['statut'] === 'disponible'): ?>
                <form method="POST" action="<?= base_url('/livre/' . $book['id'] . '/emprunter') ?>" style="display: inline;">
                    <?= csrf_field() ?>
                    <input type="text" name="nom_emprunteur" placeholder="Nom de l'emprunteur" required 
                           style="padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; margin-right: 0.5rem;">
                    <button type="submit" class="btn" style="background-color: #28a745; color: white;">Prêter</button>
                </form>
            <?php else: ?>
                <form method="POST" action="<?= base_url('/livre/' . $book['id'] . '/retourner') ?>" style="display: inline;">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-warning">Retourner</button>
                </form>
            <?php endif; ?>

            <form method="POST" action="<?= base_url('/livre/' . $book['id'] . '/supprimer') ?>" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce livre ?');">
                <?= csrf_field() ?>
                <button type="submit" class="btn btn-danger">Supprimer</button>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
