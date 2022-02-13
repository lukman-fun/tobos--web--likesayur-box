<?php

namespace App\Models;

use CodeIgniter\Model;

class Catalog extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'catalog';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['title', 'sub_title', 'slug', 'image'];

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

    public function getCatalog(){
        return $this->db->table($this->table)->select('catalog.id, catalog.title, catalog.sub_title, catalog.slug, catalog.image, COUNT(item_catalog.catalog_id) as total_items,  catalog.created_at, catalog.updated_at')->join('item_catalog', 'item_catalog.catalog_id=catalog.id', 'left')->groupBy('catalog.id');
    }
}
