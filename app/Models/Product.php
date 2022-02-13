<?php

namespace App\Models;

use CodeIgniter\Model;

class Product extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'product';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'category_id', 'name', 'slug', 'description', 'price', 'discon', 'max_buy_discon', 'stock', 'information', 'image', 'per'];

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

    function getProduct(){
        // product.id, category_id, category.name as ctgName, product.name, slug, desctiption, price, discon, min_buy_discon, stock, information, image
        return $this->db->table($this->table)->select('product.id, category_id, category.name as ctgName, product.name, product.slug, product.description, product.price, product.discon, product.max_buy_discon, product.stock, product.information, product.image, product.per')
        ->join('category', 'product.category_id=category.id', 'left');
    }

}
