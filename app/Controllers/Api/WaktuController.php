<?php

namespace App\Controllers\Api;

use App\Models\Waktu;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class WaktuController extends ResourceController
{
    use ResponseTrait;

    protected $model;

    function __construct()
    {
        $this->model = new Waktu();
    }

    public function get()
    {
        $data = $this->model->getWaktu()->get()->getResult();
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
