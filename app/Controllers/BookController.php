<?php

namespace App\Controllers;

use App\Models\BookModel;
use App\Models\LoanModel;

class BookController extends BaseController
{
    protected $bookModel;
    protected $loanModel;

    public function __construct()
    {
        // Initialiser les modèles lazily dans les méthodes
    }

    /**
     * 5.1 - Liste des livres avec recherche/filtrage
     */
    public function index()
    {
        $bookModel = new BookModel();
        
        $keyword  = $this->request->getGet('keyword');
        $category = $this->request->getGet('category');

        // Récupérer les livres
        if ($keyword || $category) {
            $books = $bookModel->searchByKeywordAndCategory($keyword, $category, 10);
        } else {
            $books = $bookModel->getPaginatedBooks(10);
        }

        // Récupérer les catégories pour le formulaire
        $allCategories = $bookModel->getCategories();
        $categories = [];
        foreach ($allCategories as $cat) {
            if (!empty($cat['categorie'])) {
                $categories[] = $cat['categorie'];
            }
        }

        return view('books/index', [
            'books'      => $books,
            'categories' => $categories,
            'keyword'    => $keyword,
            'category'   => $category,
            'pager'      => $bookModel->pager,
        ]);
    }

    /**
     * 5.2 - Afficher la fiche détaillée d'un livre
     */
    public function show($id)
    {
        $bookModel = new BookModel();
        $loanModel = new LoanModel();
        
        $book = $bookModel->find($id);

        if (!$book) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Récupérer le dernier emprunteur
        $lastLoan = $loanModel->getLastLoanForBook($id);

        return view('books/show', [
            'book'     => $book,
            'lastLoan' => $lastLoan,
        ]);
    }

    /**
     * 5.3 - Afficher le formulaire d'ajout
     */
    public function create()
    {
        $bookModel = new BookModel();
        
        $allCategories = $bookModel->getCategories();
        $categories = [];
        foreach ($allCategories as $cat) {
            if (!empty($cat['categorie'])) {
                $categories[] = $cat['categorie'];
            }
        }

        return view('books/form', [
            'book'       => null,
            'categories' => $categories,
        ]);
    }

    /**
     * 5.4 - Enregistrer un nouveau livre
     */
    public function store()
    {
        $bookModel = new BookModel();
        
        // Validation de l'année (règle métier)
        $year = $this->request->getPost('annee');
        if (!$bookModel->isYearValid($year)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'L\'année de publication ne peut pas être dans le futur.');
        }

        // Récupérer les données POST
        $data = [
            'titre'    => $this->request->getPost('titre'),
            'auteur'   => $this->request->getPost('auteur'),
            'isbn'     => $this->request->getPost('isbn'),
            'annee'    => $this->request->getPost('annee'),
            'categorie' => $this->request->getPost('categorie'),
            'resume'   => $this->request->getPost('resume'),
            'statut'   => 'disponible',
        ];

        // Gestion du fichier de couverture
        $file = $this->request->getFile('couverture');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Vérifier le type de fichier
            $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
            if (!in_array($file->getMimeType(), $allowedTypes)) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Le fichier de couverture doit être une image (JPEG, PNG ou WebP).');
            }

            // Vérifier la taille (2 Mo max)
            $maxSize = 2097152; // 2 Mo en bytes
            if ($file->getSize() > $maxSize) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'La taille du fichier ne doit pas dépasser 2 Mo.');
            }

            // Enregistrer le fichier
            $newName = $file->getRandomName();
            $file->move('uploads', $newName);
            $data['nom_fichier_couverture'] = $newName;
        }

        // Valider et enregistrer
        if (!$bookModel->validate($data)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $bookModel->errors());
        }

        $bookModel->save($data);

        return redirect()->to('/')
            ->with('success', 'Le livre a été ajouté avec succès.');
    }

    /**
     * 5.5 - Supprimer un livre
     */
    public function delete($id)
    {
        $bookModel = new BookModel();
        
        $book = $bookModel->find($id);

        if (!$book) {
            return redirect()->to('/')
                ->with('error', 'Le livre n\'existe pas.');
        }

        // Supprimer le fichier de couverture s'il existe
        if (!empty($book['nom_fichier_couverture'])) {
            $filePath = 'uploads/' . $book['nom_fichier_couverture'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $bookModel->delete($id);

        return redirect()->to('/')
            ->with('success', 'Le livre a été supprimé avec succès.');
    }
}
