<?php

namespace App\Models;

use CodeIgniter\Model;

class BookModel extends Model
{
    protected $table            = 'livres';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['titre', 'auteur', 'isbn', 'annee', 'categorie', 'resume', 'nom_fichier_couverture', 'statut'];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    // Validation Rules
    protected $validationRules    = [
        'titre'     => 'required|min_length[3]',
        'auteur'    => 'required',
        'isbn'      => 'required|is_unique[livres.isbn,id,{id}]',
        'annee'     => 'required|numeric',
        'categorie' => 'permit_empty',
        'resume'    => 'permit_empty',
        'nom_fichier_couverture' => 'permit_empty',
        'statut'    => 'in_list[disponible,prete]',
    ];

    protected $validationMessages = [
        'titre' => [
            'required'    => 'Le titre est obligatoire.',
            'min_length'  => 'Le titre doit contenir au moins 3 caractères.',
        ],
        'auteur' => [
            'required' => 'L\'auteur est obligatoire.',
        ],
        'isbn' => [
            'required'   => 'L\'ISBN est obligatoire.',
            'is_unique'  => 'Cet ISBN existe déjà en base de données.',
        ],
        'annee' => [
            'required' => 'L\'année est obligatoire.',
            'numeric'  => 'L\'année doit être un nombre.',
        ],
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    /**
     * Valider que l'année de publication n'est pas dans le futur
     *
     * @param string $year
     * @return bool
     */
    public function isYearValid($year)
    {
        $currentYear = (int) date('Y');
        return (int) $year <= $currentYear;
    }

    /**
     * Rechercher les livres par mot-clé et/ou catégorie
     *
     * @param string|null $keyword
     * @param string|null $category
     * @param int $perPage
     * @return \Countable|array
     */
    public function searchByKeywordAndCategory($keyword = null, $category = null, $perPage = 10)
    {
        if (!empty($keyword)) {
            $this->like('titre', $keyword);
        }

        if (!empty($category)) {
            $this->where('categorie', $category);
        }

        return $this->paginate($perPage);
    }

    /**
     * Retourner les livres paginés
     *
     * @param int $perPage
     * @return \Countable|array
     */
    public function getPaginatedBooks($perPage = 10)
    {
        return $this->paginate($perPage);
    }

    /**
     * Retourner toutes les catégories uniques
     *
     * @return array
     */
    public function getCategories()
    {
        return $this->distinct()
            ->select('categorie')
            ->where('categorie !=', null)
            ->where('categorie !=', '')
            ->orderBy('categorie', 'ASC')
            ->findAll();
    }
}

