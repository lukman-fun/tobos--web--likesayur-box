<?php

namespace App\Controllers\Api;

use App\Models\Cart;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class CartController extends ResourceController
{
    use ResponseTrait;

    protected $model;
    function __construct()
    {
        $this->model = new Cart();
    }

    public function get($user_id)
    {
        $data = $this->model->select('cart.id as cartID, cart.*, product.*')->join('product', 'product.id=cart.product_id', 'left')->where('user_id', $user_id)->findAll();
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

    public function store($user_id){
        $data = $this->request->getJSON();
        $this->model->insert($data);
        return $this->respond([
            'status' => 200,
            'data' => $this->model->select('cart.id as cartID, cart.*, product.*')->join('product', 'product.id=cart.product_id', 'left')->where('user_id', $user_id)->where('cart.id', $this->model->getInsertID())->first()
        ]);
    }

    public function updated(){
        $data = $this->request->getJSON();
        $this->model->update($data->id, ['qty' => $data->qty]);
        return $this->respond([
            'status' => 200,
            'message' => 'Update Quantity Success'
        ]);
    }

    public function deleted(){
        $data = $this->request->getJSON();
        $this->model->delete($data->id);
        return $this->respond([
            'status' => 200,
            'message' => 'Delete Cart Item Success'
        ]);
    }

}
