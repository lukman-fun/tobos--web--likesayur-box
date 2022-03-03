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
        if ($valid) {
            $pw = $valid['password'];
            if (password_verify($data->password, $pw)) {
                unset($valid['password']);
                return $this->respond([
                    'status' => 200,
                    'data' => $valid
                ]);
            } else {
                return $this->respond([
                    'status' => 404,
                    'message' => "Password anda salah"
                ]);
            }
        } else {
            return $this->respond([
                'status' => 404,
                'message' => "Nomor belum terdaftar"
            ]);
        }
    }

    public function daftar()
    {
        $data = $this->request->getJSON();

        if ($this->model->where(['phone' => $data->phone])->first()) {
            return $this->respond([
                'status' => 404,
                'message' => "Nomor sudah digunakan"
            ]);
        } else {
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

    public function getProfile($id){
        $data = $this->model->where(['id' => $id])->first();
        if ($data) {
            return $this->respond([
                'status' => 200,
                'data' => $data
            ]);
        } else {
            return $this->respond([
                'status' => 404,
                'message' => 'Not Found'
            ]);
        }
    }

    public function updateFotoProfile()
    {
        $data = $this->request->getJSON();
        $img = str_replace(['data:image/png;base64,', 'data:image/jpg;base64,', 'data:image/jpeg;base64,'], '', $data->image);
        $img = str_replace(' ', '+', $img);
        $imgdata = base64_decode($img);
        $filename = 'files/users/' . uniqid() . '.jpg';
        if (file_put_contents(FCPATH . $filename, $imgdata)) {
            if ($this->model->find($data->id)['image'] != '' && file_exists(FCPATH . $this->model->find($data->id)['image'])){
                unlink(FCPATH . $this->model->find($data->id)['image']);
            }
            $this->model->update($data->id, [
                'image' => $filename
            ]);
            return $this->respond([
                'status' => 200,
                'message' => $filename
            ]);
        } else {
            return $this->respond([
                'status' => 404,
                'message' => "Upload Gambar Gagal"
            ]);
        }
    }

    public function updateProfile($user_id)
    {
        $data = $this->request->getJSON();

        if ($data->password != '') {
            $data->password = password_hash($data->password, PASSWORD_DEFAULT);
        } else {
            unset($data->password);
        }

        $this->model->update($user_id, ((array)$data));
        return $this->respond([
            'status' => 200,
            'message' => 'Update Profile Success'
        ]);
    }
}
