<?php

namespace App\Models;

use CodeIgniter\Model;

class Transaction extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'transaction';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'no_transaction', 'data_delivery', 'process', 'status', 'kurir_id', 'kurir_status', 'payment_id', 'created_at', 'updated_at'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    function getTransaction()
    {
        return $this->db->table($this->table)
        ->select('transaction.id, user_id, no_transaction, data_delivery, process, status, kurir_id, kurir.fullname as kurir_name, kurir_status, users.fullname as userName, transaction.created_at, transaction.updated_at')
        ->join('kurir', 'kurir.id=transaction.kurir_id', 'left')
        ->join('users', 'users.id=transaction.user_id', 'left');
    }

}
