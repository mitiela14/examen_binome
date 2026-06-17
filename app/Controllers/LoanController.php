<?php

namespace App\Controllers;

use App\Models\BookModel;
use App\Models\LoanModel;

class LoanController extends BaseController
{
    /**
     * 6.1 - Emprunter un livre
     */
    public function borrow($bookId)
    {
        $bookModel = new BookModel();
        $loanModel = new LoanModel();
        
        $book = $bookModel->find($bookId);

        // Vérifier que le livre existe
        if (!$book) {
            return redirect()->back()
                ->with('error', 'Le livre n\'existe pas.');
        }

        // Vérifier que le livre est disponible
        if ($book['statut'] !== 'disponible') {
            return redirect()->back()
                ->with('error', 'Ce livre n\'est pas disponible. Il est actuellement prêté.');
        }

        // Récupérer le nom de l'emprunteur
        $borrowerName = $this->request->getPost('nom_emprunteur');
        if (empty($borrowerName)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Veuillez entrer le nom de l\'emprunteur.');
        }

        // Enregistrer l'emprunt
        $loanData = [
            'livre_id'       => $bookId,
            'nom_emprunteur' => $borrowerName,
            'date_emprunt'   => date('Y-m-d'),
        ];

        if (!$loanModel->save($loanData)) {
            return redirect()->back()
                ->with('error', 'Une erreur s\'est produite lors de l\'enregistrement de l\'emprunt.');
        }

        // Mettre à jour le statut du livre à "prêté"
        $bookModel->update($bookId, ['statut' => 'prete']);

        return redirect()->back()
            ->with('success', 'Le livre a été emprunté avec succès.');
    }

    /**
     * 6.2 - Retourner un livre
     */
    public function return($bookId)
    {
        $bookModel = new BookModel();
        $loanModel = new LoanModel();
        
        $book = $bookModel->find($bookId);

        // Vérifier que le livre existe
        if (!$book) {
            return redirect()->back()
                ->with('error', 'Le livre n\'existe pas.');
        }

        // Retrouver l'emprunt actif (sans date de retour)
        $activeLoan = $loanModel->getActiveLoanForBook($bookId);

        if (!$activeLoan) {
            return redirect()->back()
                ->with('error', 'Aucun emprunt actif trouvé pour ce livre.');
        }

        // Renseigner la date de retour
        $activeLoan['date_retour'] = date('Y-m-d');
        $loanModel->update($activeLoan['id'], ['date_retour' => $activeLoan['date_retour']]);

        // Mettre à jour le statut du livre à "disponible"
        $bookModel->update($bookId, ['statut' => 'disponible']);

        return redirect()->back()
            ->with('success', 'Le livre a été retourné avec succès.');
    }
}
