<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailAchatModel extends Model 
{
    protected $table = 'detail_achat';

    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType = 'array';

    protected $useSoftDeletes = false;

    protected $allowedFields = [ 'quantite', 'prix_unitaire', 'idAchat' , 'idProduit'];

    protected $useTimestamps = true;

    protected $createdField  = 'created_at';

    protected $updatedField  = 'updated_at';
    
}