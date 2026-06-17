<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'utilisateur';
    protected $primaryKey = 'idUser';
    protected $returnType = 'array';
    protected $allowedFields = ['login', 'password'];
    protected $useTimestamps = false;

    public function findByCredentials($login, $password)
    {
        return $this->where('login', $login)
                    ->where('password', $password)
                    ->first();
    }
}
