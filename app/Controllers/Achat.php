<?php

namespace App\Controllers;

use App\Models\AchatModel;
use App\Models\DetailAchatModel;
use App\Models\ProduitModel;

class Achat extends BaseController 
{

    public function index()
    {
        // vérifier session utilisateur et caisse
        if (!session('user')) {
            return redirect()->to('/login');
        }
        if (!session('idCaisse')) {
            return redirect()->to('/caisse');
        }

        $produitModel = new ProduitModel();
        $data['produits'] = $produitModel->findAll();
        $data['panier'] = session('panier') ?? [];

        echo view('template/header');
        echo view('achat', $data);
        echo view('template/footer');
    }

    public function add()
    {
        $idProduit = $this->request->getPost('idProduit');
        $quantite = (int) $this->request->getPost('quantite');

        $produitModel = new ProduitModel();
        $produit = $produitModel->find($idProduit);
        if (!$produit) {
            return redirect()->back()->with('error', 'Produit introuvable');
        }

        if ($quantite <= 0 || $quantite > $produit['quantiteStock']) {
            return redirect()->back()->with('error', 'Quantité invalide ou supérieure au stock');
        }

        $panier = session('panier') ?? [];
        $panier[] = [
            'idProduit' => $produit['idProduit'],
            'designation' => $produit['designation'],
            'prix' => $produit['prix'],
            'quantite' => $quantite,
        ];
        session()->set('panier', $panier);

        return redirect()->to('/achat');
    }

       public function remove($index)
    {
        $panier = session('panier') ?? [];
        if (isset($panier[$index])) {
            array_splice($panier, $index, 1);
            session()->set('panier', $panier);
        }
        return redirect()->to('/achat');
    }

    public function close()
    {
        $panier = session('panier') ?? [];
        if (empty($panier)) {
            return redirect()->back()->with('error', 'Le panier est vide');
        }

        $total = 0;
        foreach ($panier as $line) {
            $total += $line['prix'] * $line['quantite'];
        }

        $achatModel = new AchatModel();
        $detailModel = new DetailAchatModel();
        $produitModel = new ProduitModel();

        $idCaisse = session('idCaisse');
        $idAchat = $achatModel->insert([
            'dateAchat' => date('Y-m-d H:i:s'),
            'total' => $total,
            'idCaisse' => $idCaisse,
        ], true);

        foreach ($panier as $line) {
            $detailModel->insert([
                'quantite' => $line['quantite'],
                'prixUnitaire' => $line['prix'],
                'idAchat' => $idAchat,
                'idProduit' => $line['idProduit'],
            ]);

            // mise à jour du stock
            $produit = $produitModel->find($line['idProduit']);
            $nouveau = $produit['quantiteStock'] - $line['quantite'];
            if ($nouveau < 0) $nouveau = 0;
            $produitModel->update($line['idProduit'], ['quantiteStock' => $nouveau]);
        }

        // vider le panier
        session()->remove('panier');

        return redirect()->to('/achat')->with('message', 'Achat clôturé avec succès');
    }
}