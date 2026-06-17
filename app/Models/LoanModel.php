<?php

namespace App\Models;

use CodeIgniter\Model;

class LoanModel extends Model
{
    protected $table            = 'emprunts';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['livre_id', 'nom_emprunteur', 'date_emprunt', 'date_retour'];
    protected $useTimestamps    = false;

    protected $validationRules    = [
        'livre_id'       => 'required|numeric',
        'nom_emprunteur' => 'required',
        'date_emprunt'   => 'required|valid_date',
        'date_retour'    => 'permit_empty|valid_date',
    ];

    protected $validationMessages = [
        'livre_id' => [
            'required' => 'Le livre est requis.',
            'numeric'  => 'L\'ID du livre doit être un nombre.',
        ],
        'nom_emprunteur' => [
            'required' => 'Le nom de l\'emprunteur est requis.',
        ],
        'date_emprunt' => [
            'required'   => 'La date d\'emprunt est requise.',
            'valid_date' => 'La date d\'emprunt doit être une date valide.',
        ],
        'date_retour' => [
            'valid_date' => 'La date de retour doit être une date valide.',
        ],
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    /**
     * Retourner le dernier emprunt enregistré pour un livre donné
     *
     * @param int $bookId
     * @return array|null
     */
    public function getLastLoanForBook($bookId)
    {
        return $this->where('livre_id', $bookId)
            ->orderBy('date_emprunt', 'DESC')
            ->first();
    }

    /**
     * Retourner l'emprunt actif (sans date de retour) pour un livre
     *
     * @param int $bookId
     * @return array|null
     */
    public function getActiveLoanForBook($bookId)
    {
        return $this->where('livre_id', $bookId)
            ->where('date_retour', null)
            ->first();
    }
}
