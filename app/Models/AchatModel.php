<?php

namespace App\Models;

use CodeIgniter\Model;

class AchatModel extends Model 
{
    protected $table = 'achats';

    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType = 'array';

    protected $useSoftDeletes = false;

    protected $allowedFields = ['dateAchat', 'quantite', 'prix_total'];

}