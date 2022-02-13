<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Admin;

class AuthController extends BaseController
{
    protected $model;

    function __construct()
    {
        $this->model = new Admin();
    }

    public function login()
    {
        return view('admin/login');
    }

    public function act_login(){
        $data = $this->request->getPost();
        $sql = $this->model->where('email', $data['email'])->first();
        if($sql){
            if(password_verify($data['password'], $sql['password'])){
                session()->set('login_data', $sql);
                return $this->response->setJSON([
                    'status' => 200,
                    'message' => 'Login berhasil'
                ]);
            }else{
                return $this->response->setJSON([
                    'status' => 404,
                    'message' => 'Password anda salah'
                ]);
            }
        }else{
            return $this->response->setJSON([
                'status' => 404,
                'message' => 'Email dan Password tidak terdaftar'
            ]);
        }
    }

    public function logout(){
        session()->remove('data_login');
        return redirect()->to(base_url('login'));
    }
}
