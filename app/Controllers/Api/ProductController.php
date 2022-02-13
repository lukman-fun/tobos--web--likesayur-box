<?php

namespace App\Controllers\Api;

use App\Models\Product;
use App\Models\Supplier;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class ProductController extends ResourceController
{
    use ResponseTrait;

    protected $model;

    function __construct()
    {
        $this->model = new Product();
    }

    public function get()
    {
        $data = $this->model->getProduct()->get()->getResult();
        if($data){
            foreach($data as $iProduct){
                $iProduct->information = json_decode($iProduct->information);
                $iProduct->information->farmers_and_suppliers = (new Supplier())->whereIn('id', $iProduct->information->farmers_and_suppliers)->findAll();
            }
            return $this->respond([
                'status' => 200,
                'data' => $data
            ]);
        }else{
            return $this->respond([
                'status' => 404,
                'message' => 'Not Found'
            ]);
        }
    }

    public function getBy($user_id, $slug)
    {
        $data = $this->model->getProduct()->select("(SELECT cart.qty FROM cart WHERE cart.product_id=product.id AND cart.user_id='" .$user_id. "') as isCart")->where('product.slug', $slug)->get()->getRow();    
        if($data){
            $data->information = json_decode($data->information);
            $data->information->farmers_and_suppliers = (new Supplier())->whereIn('id', $data->information->farmers_and_suppliers)->findAll();
            return $this->respond([
                'status' => 200,
                'data' => $data
            ]);
        }else{
            return $this->respond([
                'status' => 404,
                'message' => 'Not Found'
            ]);
        }
    }

    public function getByCategory($user_id, $slug){
        $data = $this->model->getProduct()->select("(SELECT cart.qty FROM cart WHERE cart.product_id=product.id AND cart.user_id='" .$user_id. "') as isCart")->where('category.slug', $slug)->get()->getResult();
        foreach($data as $iProduct){
            $iProduct->information = json_decode($iProduct->information);
            $iProduct->information->farmers_and_suppliers = (new Supplier())->whereIn('id', $iProduct->information->farmers_and_suppliers)->findAll();
        }
        if($data){
            return $this->respond([
                'status' => 200,
                'data' => $data
            ]);
        }else{
            return $this->respond([
                'status' => 404,
                'message' => 'Not Found'
            ]);
        }
    }

    public function getByCatalog($user_id, $slug)
    {
        $data = $this->model->getProduct()
        ->select("(SELECT cart.qty FROM cart WHERE cart.product_id=product.id AND cart.user_id='" .$user_id. "') as isCart")
        ->join('item_catalog', 'item_catalog.product_id=product.id', 'inner')
        ->join('catalog', 'catalog.id=item_catalog.catalog_id')
        ->where('catalog.slug', $slug)->get()->getResult();

        if($data){
            foreach($data as $iProduct){
                $iProduct->information = json_decode($iProduct->information);
                $iProduct->information->farmers_and_suppliers = (new Supplier())->whereIn('id', $iProduct->information->farmers_and_suppliers)->findAll();
            }
            return $this->respond([
                'status' => 200,
                'data' => $data
            ]);
        }else{
            return $this->respond([
                'status' => 404,
                'message' => 'Not Found'
            ]);
        }
    }

    public function search($user_id, $q){
        $data = $this->model->getProduct()->select("(SELECT cart.qty FROM cart WHERE cart.product_id=product.id AND cart.user_id='" .$user_id. "') as isCart")->like('product.name', $q)->get()->getResult();
        foreach($data as $iProduct){
            $iProduct->information = json_decode($iProduct->information);
            $iProduct->information->farmers_and_suppliers = (new Supplier())->whereIn('id', $iProduct->information->farmers_and_suppliers)->findAll();
        }
        if($data){
            return $this->respond([
                'status' => 200,
                'data' => $data
            ]);
        }else{
            return $this->respond([
                'status' => 404,
                'message' => 'Not Found'
            ]);
        }
    }
    
}
