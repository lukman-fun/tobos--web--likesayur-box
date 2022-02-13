<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Admin;

class ProfileController extends BaseController
{
    protected $model;

    function __construct()
    {
        $this->model = new Admin();
    }

    public function index()
    {
        return view('admin/profile/index');
    }

    public function get(){
        $data = $this->model->find('1');
        unset($data['password']);
        return $this->response->setJSON([
            'status' => 200,
            'data' => $data
        ]);
    }

    public function update(){
        $data = $this->request->getPost();
        if($data['password'] != ''){
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }else{
            unset($data['password']);
        }
        $this->model->update('1', $data);
        unset($data['password']);
        
        return $this->response->setJSON([
            'status' => 200,
            'data' => $data
        ]);
    }
}
