<?php

namespace App\Models;

use CodeIgniter\Model;


class ProduitModel extends Model 
{
    protected $table = 'produits';

    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType = 'array';

    protected $useSoftDeletes = false;

    protected $allowedFields = ['designation', 'prix', 'quantiteStock'];

    protected $useTimestamps = true;

    protected $createdField  = 'created_at';

    protected $updatedField  = 'updated_at';


}