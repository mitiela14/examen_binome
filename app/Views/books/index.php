<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>Catalogue des Livres<?= $this->endSection() ?>

<?= $this->section('content') ?>
<style>
    .search-form {
        background: white;
        padding: 1.5rem;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
    }

    .search-form h2 {
        margin-bottom: 1rem;
        color: #333;
        font-size: 1.3rem;
    }

    .form-group {
        margin-bottom: 1rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: #555;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 1rem;
    }

    .form-group input:focus,
    .form-group select:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .search-buttons {
        display: flex;
        gap: 1rem;
    }

    .btn {
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 4px;
        font-size: 1rem;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background-color: #667eea;
        color: white;
    }

    .btn-primary:hover {
        background-color: #5568d3;
    }

    .btn-secondary {
        background-color: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
    }

    .btn-danger {
        background-color: #dc3545;
        color: white;
    }

    .btn-danger:hover {
        background-color: #c82333;
    }

    .btn-success {
        background-color: #28a745;
        color: white;
    }

    .btn-success:hover {
        background-color: #218838;
    }

    .btn-warning {
        background-color: #ffc107;
        color: black;
    }

    .btn-warning:hover {
        background-color: #e0a800;
    }

    .btn-sm {
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
    }

    .books-table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        overflow: hidden;
    }

    .books-table thead {
        background-color: #667eea;
        color: white;
    }

    .books-table th {
        padding: 1rem;
        text-align: left;
        font-weight: 600;
    }

    .books-table td {
        padding: 1rem;
        border-bottom: 1px solid #e0e0e0;
    }

    .books-table tbody tr:hover {
        background-color: #f9f9f9;
    }

    .books-table a {
        color: #667eea;
        text-decoration: none;
        font-weight: 500;
    }

    .books-table a:hover {
        text-decoration: underline;
    }

    .status-badge {
        display: inline-block;
        padding: 0.5rem 1rem;
        border-radius: 4px;
        font-weight: 500;
        font-size: 0.9rem;
    }

    .status-disponible {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .status-prete {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .book-actions {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .loan-form {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }

    .loan-form input {
        padding: 0.4rem 0.6rem;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 0.9rem;
        flex: 1;
        min-width: 150px;
    }

    .pagination {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        margin-top: 2rem;
    }

    .pagination a,
    .pagination strong {
        padding: 0.5rem 0.75rem;
        border: 1px solid #667eea;
        border-radius: 4px;
        text-decoration: none;
        color: #667eea;
    }

    .pagination a:hover {
        background-color: #667eea;
        color: white;
    }

    .pagination strong {
        background-color: #667eea;
        color: white;
        border-color: #667eea;
    }

    .empty-message {
        background: white;
        padding: 2rem;
        border-radius: 8px;
        text-align: center;
        color: #999;
        font-size: 1.1rem;
    }
</style>

<div class="search-form">
    <h2>🔍 Rechercher un livre</h2>
    <form method="GET" action="<?= base_url('/') ?>">
        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
            <div class="form-group">
                <label for="keyword">Mot-clé (titre)</label>
                <input type="text" id="keyword" name="keyword" 
                       value="<?= esc($keyword) ?>" 
                       placeholder="Chercher par titre...">
            </div>
            <div class="form-group">
                <label for="category">Catégorie</label>
                <select id="category" name="category">
                    <option value="">-- Toutes les catégories --</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= esc($cat) ?>" 
                            <?= ($category === $cat) ? 'selected' : '' ?>>
                            <?= esc($cat) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>&nbsp;</label>
                <div class="search-buttons">
                    <button type="submit" class="btn btn-primary">Rechercher</button>
                    <a href="<?= base_url('/') ?>" class="btn btn-secondary" style="text-decoration: none; display: inline-block;">Réinitialiser</a>
                </div>
            </div>
        </div>
    </form>
</div>

<?php if (empty($books)): ?>
    <div class="empty-message">
        📭 Aucun livre trouvé.
    </div>
<?php else: ?>
    <table class="books-table">
        <thead>
            <tr>
                <th>Titre</th>
                <th>Auteur</th>
                <th>Année</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($books as $book): ?>
                <tr>
                    <td>
                        <a href="<?= base_url('/livre/' . $book['id']) ?>">
                            <?= esc($book['titre']) ?>
                        </a>
                    </td>
                    <td><?= esc($book['auteur']) ?></td>
                    <td><?= esc($book['annee']) ?></td>
                    <td>
                        <span class="status-badge status-<?= esc($book['statut']) ?>">
                            <?= ($book['statut'] === 'disponible') ? '✓ Disponible' : '✗ Prêté' ?>
                        </span>
                    </td>
                    <td>
                        <div class="book-actions">
                            <a href="<?= base_url('/livre/' . $book['id']) ?>" class="btn btn-primary btn-sm">Voir détails</a>

                            <?php if ($book['statut'] === 'disponible'): ?>
                                <form method="POST" action="<?= base_url('/livre/' . $book['id'] . '/emprunter') ?>" class="loan-form">
                                    <?= csrf_field() ?>
                                    <input type="text" name="nom_emprunteur" placeholder="Nom de l'emprunteur" required>
                                    <button type="submit" class="btn btn-success btn-sm">Prêter</button>
                                </form>
                            <?php else: ?>
                                <form method="POST" action="<?= base_url('/livre/' . $book['id'] . '/retourner') ?>" style="display: inline;">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-warning btn-sm">Retourner</button>
                                </form>
                            <?php endif; ?>

                            <form method="POST" action="<?= base_url('/livre/' . $book['id'] . '/supprimer') ?>" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce livre ?');">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <?php if ($pager): ?>
        <div class="pagination">
            <?= $pager->links('default', 'default_full') ?>
        </div>
    <?php endif; ?>
<?php endif; ?>

<?= $this->endSection() ?>
