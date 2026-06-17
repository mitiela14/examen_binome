<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>Ajouter un Livre<?= $this->endSection() ?>

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

    .form-container {
        background: white;
        padding: 2rem;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        max-width: 700px;
        margin: 0 auto;
    }

    .form-container h1 {
        margin-bottom: 1.5rem;
        color: #333;
        font-size: 1.8rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: #333;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 1rem;
        font-family: inherit;
    }

    .form-group textarea {
        resize: vertical;
        min-height: 100px;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .form-group.error input,
    .form-group.error select,
    .form-group.error textarea {
        border-color: #dc3545;
        background-color: #fff5f5;
    }

    .error-message {
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 0.3rem;
        display: block;
    }

    .required {
        color: #dc3545;
        font-weight: bold;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
    }

    .btn {
        padding: 0.75rem 2rem;
        border: none;
        border-radius: 4px;
        font-size: 1rem;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }

    .btn-primary {
        background-color: #667eea;
        color: white;
        flex: 1;
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

    .file-input-wrapper {
        position: relative;
        display: inline-block;
        width: 100%;
    }

    .file-input-wrapper input[type="file"] {
        position: absolute;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }

    .file-input-label {
        display: block;
        padding: 0.75rem;
        background-color: #f9f9f9;
        border: 2px dashed #667eea;
        border-radius: 4px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .file-input-wrapper:hover .file-input-label {
        background-color: #f0f5ff;
        border-color: #5568d3;
    }

    .help-text {
        font-size: 0.875rem;
        color: #666;
        margin-top: 0.3rem;
    }

    @media (max-width: 600px) {
        .form-row {
            grid-template-columns: 1fr;
        }

        .form-actions {
            flex-direction: column;
        }
    }
</style>

<a href="<?= base_url('/') ?>" class="back-link">← Retour au catalogue</a>

<div class="form-container">
    <h1>📚 Ajouter un Nouveau Livre</h1>

    <form method="POST" action="<?= base_url('/livre') ?>" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="form-row">
            <div class="form-group <?= (session('errors') && isset(session('errors')['titre'])) ? 'error' : '' ?>">
                <label for="titre">Titre <span class="required">*</span></label>
                <input type="text" id="titre" name="titre" value="<?= old('titre') ?>" 
                       placeholder="Ex: Le Seigneur des Anneaux" required>
                <?php if (session('errors') && isset(session('errors')['titre'])): ?>
                    <span class="error-message"><?= session('errors')['titre'] ?></span>
                <?php endif; ?>
            </div>

            <div class="form-group <?= (session('errors') && isset(session('errors')['auteur'])) ? 'error' : '' ?>">
                <label for="auteur">Auteur <span class="required">*</span></label>
                <input type="text" id="auteur" name="auteur" value="<?= old('auteur') ?>" 
                       placeholder="Ex: J.R.R. Tolkien" required>
                <?php if (session('errors') && isset(session('errors')['auteur'])): ?>
                    <span class="error-message"><?= session('errors')['auteur'] ?></span>
                <?php endif; ?>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group <?= (session('errors') && isset(session('errors')['isbn'])) ? 'error' : '' ?>">
                <label for="isbn">ISBN <span class="required">*</span></label>
                <input type="text" id="isbn" name="isbn" value="<?= old('isbn') ?>" 
                       placeholder="Ex: 978-2253048244" required>
                <?php if (session('errors') && isset(session('errors')['isbn'])): ?>
                    <span class="error-message"><?= session('errors')['isbn'] ?></span>
                <?php endif; ?>
                <span class="help-text">Identifiant unique du livre</span>
            </div>

            <div class="form-group <?= (session('errors') && isset(session('errors')['annee'])) ? 'error' : '' ?>">
                <label for="annee">Année de Publication <span class="required">*</span></label>
                <input type="number" id="annee" name="annee" value="<?= old('annee') ?>" 
                       min="1000" max="<?= date('Y') ?>" placeholder="Ex: 2020" required>
                <?php if (session('errors') && isset(session('errors')['annee'])): ?>
                    <span class="error-message"><?= session('errors')['annee'] ?></span>
                <?php endif; ?>
                <span class="help-text">Maximum : <?= date('Y') ?></span>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="categorie">Catégorie</label>
                <select id="categorie" name="categorie">
                    <option value="">-- Non spécifiée --</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= esc($cat) ?>" 
                            <?= (old('categorie') === $cat) ? 'selected' : '' ?>>
                            <?= esc($cat) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="resume">Résumé</label>
            <textarea id="resume" name="resume" 
                      placeholder="Décrivez brièvement le contenu du livre..."><?= old('resume') ?></textarea>
        </div>

        <div class="form-group">
            <label for="couverture">Couverture (Image)</label>
            <div class="file-input-wrapper">
                <input type="file" id="couverture" name="couverture" accept="image/jpeg,image/png,image/webp">
                <label for="couverture" class="file-input-label">
                    📁 Cliquez ou glissez une image (JPEG, PNG ou WebP - Max 2 Mo)
                </label>
            </div>
            <span class="help-text">Format accepté : JPEG, PNG, WebP | Taille maximale : 2 Mo</span>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">✓ Ajouter le Livre</button>
            <a href="<?= base_url('/') ?>" class="btn btn-secondary" style="text-align: center;">Annuler</a>
        </div>
    </form>
</div>

<script>
    // Limiter l'année maximale au côté client
    document.getElementById('annee').max = new Date().getFullYear();

    // Affichage du nom du fichier sélectionné
    document.getElementById('couverture').addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name || 'Aucun fichier sélectionné';
        const label = this.nextElementSibling;
        if (e.target.files.length > 0) {
            label.textContent = '✓ ' + fileName;
        } else {
            label.textContent = '📁 Cliquez ou glissez une image (JPEG, PNG ou WebP - Max 2 Mo)';
        }
    });
</script>

<?= $this->endSection() ?>
