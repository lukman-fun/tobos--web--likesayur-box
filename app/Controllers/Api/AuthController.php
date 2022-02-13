<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\Users;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class AuthController extends ResourceController
{
    use ResponseTrait;

    protected $model;
    function __construct()
    {
        $this->model = new Users();
    }

    public function login()
    {
        $data = $this->request->getJSON();
        $valid = $this->model->where(['phone' => $data->phone])->first();
        if($valid){
            $pw = $valid['password'];
            if(password_verify($data->password, $pw)){
                unset($valid['password']);
                return $this->respond([
                    'status' => 200,
                    'data' => $valid
                ]);
            }else{
                return $this->respond([
                    'status' => 404,
                    'message' => "Password anda salah"
                ]);
            }
        }else{
            return $this->respond([
                'status' => 404,
                'message' => "Nomor belum terdaftar"
            ]);
        }
    }

    public function daftar(){
        $data = $this->request->getJSON();

        if($this->model->where(['phone' => $data->phone])->first()){
            return $this->respond([
                'status' => 404,
                'message' => "Nomor sudah digunakan"
            ]);
        }else{
            $data = array_merge((array)$data, ['password' => password_hash($data->password, PASSWORD_DEFAULT)]);
            $id = $this->model->insert($data);
            $val = $this->model->where(['id' => $id])->first();
            unset($val['password']);
            return $this->respond([
                'status' => 200,
                'data' => $val
            ]);
        }
    }

    public function updateFotoProfile(){
        
    }

    public function updateProfile($user_id){
        $data = $this->request->getJSON();
        
        if($data->password != ''){
            $data->password = password_hash($data->password, PASSWORD_DEFAULT);
        }else{
            unset($data->password);
        }

        $this->model->update($user_id, ((array)$data) );
        return $this->respond([
            'status' => 200,
            'message' => 'Update Profile Success'
        ]);
    }
}
