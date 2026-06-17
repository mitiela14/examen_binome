<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?> - Gestion de Bibliothèque</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            color: #333;
        }

        header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        header h1 {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        nav {
            background-color: #f9f9f9;
            border-bottom: 1px solid #e0e0e0;
            padding: 0 1.5rem;
            display: flex;
            gap: 2rem;
        }

        nav a {
            display: block;
            padding: 1rem;
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        nav a:hover {
            background-color: #e8f0fe;
            border-bottom: 3px solid #667eea;
        }

        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1.5rem;
        }

        .alert {
            padding: 1rem;
            margin-bottom: 1.5rem;
            border-radius: 4px;
            border-left: 4px solid;
        }

        .alert-success {
            background-color: #d4edda;
            border-color: #28a745;
            color: #155724;
        }

        .alert-error,
        .alert-danger {
            background-color: #f8d7da;
            border-color: #dc3545;
            color: #721c24;
        }

        .alert-warning {
            background-color: #fff3cd;
            border-color: #ffc107;
            color: #856404;
        }

        .alert-info {
            background-color: #d1ecf1;
            border-color: #17a2b8;
            color: #0c5460;
        }

        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 2rem;
            margin-top: 3rem;
        }

        footer p {
            margin: 0.5rem 0;
        }
    </style>
</head>
<body>
    <header>
        <h1>📚 Gestion de Bibliothèque</h1>
        <p>Gérez votre catalogue de livres et les emprunts</p>
    </header>

    <nav>
        <a href="<?= base_url('/') ?>">Accueil</a>
        <a href="<?= base_url('/livre/creer') ?>">Ajouter un livre</a>
    </nav>

    <div class="container">
        <!-- Messages Flash -->
        <?php if (session()->has('success')): ?>
            <div class="alert alert-success">
                ✓ <?= esc(session('success')) ?>
            </div>
        <?php endif; ?>

        <?php if (session()->has('error')): ?>
            <div class="alert alert-error">
                ✗ <?= esc(session('error')) ?>
            </div>
        <?php endif; ?>

        <?php if (session()->has('errors') && is_array(session('errors'))): ?>
            <div class="alert alert-error">
                <strong>Erreurs de validation :</strong>
                <ul>
                    <?php foreach (session('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Contenu principal -->
        <?= $this->renderSection('content') ?>
    </div>

    <footer>
        <p>&copy; 2026 Gestion de Bibliothèque - CodeIgniter 4</p>
        <p class="text-muted">Tous droits réservés</p>
    </footer>
</body>
</html>
