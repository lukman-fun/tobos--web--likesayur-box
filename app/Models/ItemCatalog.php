<?php

namespace App\Models;

use CodeIgniter\Model;

class ItemCatalog extends Model
{
    protected $DBGroup          = 'default';
    public $table            = 'item_catalog';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['catalog_id', 'product_id'];

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

    // function getContentItems(){
    //     return $this->db->table('product')->select('product.id, category_id, category.name as ctgName, item_catalog.id as ctlgId, product.name, product.slug, product.description, product.price, product.discon, product.max_buy_discon, product.stock, product.information, product.image')
    //     ->join('category', 'product.category_id=category.id', 'left')
    //     ->join($this->table, 'item_catalog.product_id=product.id', 'left')
    //     ->where('category.id', '4');
    // }

    function getContentItems($catalog_id, $category_id){
        // return $this->db->query("SELECT product.*, (SELECT item_catalog.catalog_id FROM item_catalog WHERE item_catalog.product_id=product.id AND item_catalog.catalog_id='" .$catalog_id. "') as isItemCatalog FROM product WHERE category_id='" .$category_id. "'");
        return $this->db->table('product')
        ->select('product.id, category_id, category.name as ctgName, product.name, product.slug, product.description, product.price, product.discon, product.max_buy_discon, product.stock, product.information, product.image')
        ->select("(SELECT item_catalog.catalog_id FROM item_catalog WHERE item_catalog.product_id=product.id AND item_catalog.catalog_id='" .$catalog_id. "') as isItemCatalog")
        ->join('category', 'product.category_id=category.id', 'left')
        ->where('product.category_id', $category_id);
    }

}
