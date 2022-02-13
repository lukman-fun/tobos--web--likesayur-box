<?php

namespace App\Controllers;

use App\Models\Catalog;
use App\Models\ItemCatalog;

class Home extends BaseController
{
    public function index()
    {
        $model = new ItemCatalog();
        $m = new Catalog();
        $data = [];
        foreach($m->findAll() as $mc){
            $mc['items'] = $model->select('product.*')->join('product', 'item_catalog.product_id=product.id', 'left')->findAll();
            array_push($data, $mc);
        }

        if(count($data) == 0) return $this->response->setJSON(['status' => 404, 'msg' => 'data not found']);
        return $this->response->setJSON(['status' => 200, 'data' => $data]);
        // return view('welcome_message');
    }
    
}
