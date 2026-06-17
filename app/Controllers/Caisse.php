<?php

namespace App\Controllers;

use App\Models\CaisseModel;

class Caisse extends BaseController
{
    public function index()
    {
        $model = new CaisseModel();
        $data['caisses'] = $model->findAll();

        echo view('template/header');
        echo view('choix_caisse', $data);
        echo view('template/footer');
    }

    public function select()
    {
        $id = $this->request->getPost('idCaisse');
        $model = new CaisseModel();
        $caisse = $model->find($id);
        if ($caisse) {
            session()->set('idCaisse', $caisse['idCaisse']);
            session()->set('numeroCaisse', $caisse['numeroCaisse']);
            return redirect()->to('/achat');
        }
        return redirect()->back()->with('error', 'Caisse invalide');
    }
}
