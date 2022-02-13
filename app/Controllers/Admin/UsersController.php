<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Users;
use Hermawan\DataTables\DataTable;

class UsersController extends BaseController
{
    protected $model;
    protected $path_users = 'files/users';

    function __construct()
    {
        $this->model = new Users();
        if (!file_exists(FCPATH . $this->path_users)) {
            mkdir(FCPATH . $this->path_users);
        }
    }

    public function index()
    {
        return view('admin/users/index');
    }

    public function get($id)
    {
        if ($id == 'all') {
            $data = $this->model->getUsers();
            return DataTable::of($data)
                ->addNumbering('no')
                ->edit('image', function ($row) {
                    return '<img src="' . base_url() . '/' . $row->image . '" onerror="this.src=`' . base_url('/dist/img/default-profile.jpg') . '`" alt="" style="width: 50px; height: 50px; border-radius: 1000px;">';
                })
                ->add('action', function ($row) {
                    return '<div class="d-flex justify-content-center">
                                <button type="button" class="btn btn-info btn-sm" onclick="onEdit(`' . $row->id . '`)"><i class="fe fe-edit"></i></button>
                                <button type="button" class="btn btn-danger btn-sm" onclick="onDelete(`' . $row->id . '`)"><i class="fe fe-trash"></i></button>
                            </div>';
                })
                ->toJson(true);
        } else {
            return $this->response->setJSON([
                'status' => 200,
                'data' => $this->model->find($id)
            ]);
        }
    }

    public function store()
    {
        $data = $this->request->getPost();
        unset($data['type']);
        $file = $this->request->getFile('image');

        $valid = $this->validate([
            'fullname' => 'required',
            'phone' => 'required|is_unique[users.phone]',
            'address' => 'required',
            'password' => 'required'
        ]);

        if(!$valid) return $this->response->setJSON([
            'status' => 404,
            'errors' => \Config\Services::validation()->getErrors()
        ]);

        if ($file->isValid()) {
            $fileName = $file->getRandomName();
            $data = array_merge($data, ['image' => $this->path_users . '/' . $fileName]);
            $file->move($this->path_users, $fileName);
        }

        $data = array_merge($data, ['password' => password_hash($data['password'], PASSWORD_DEFAULT)]);
        $this->model->save($data);
        return $this->response->setJSON([
            'status' => 200,
        ]);
    }

    public function update($id)
    {
        $data = $this->request->getPost();
        unset($data['type']);
        $file = $this->request->getFile('image');

        $valid = $this->validate([
            'fullname' => 'required',
            'phone' => 'required|is_unique[users.phone,id,' . $id . ']',
            'address' => 'required',
        ]);

        if(!$valid) return $this->response->setJSON([
            'status' => 404,
            'errors' => \Config\Services::validation()->getErrors()
        ]);

        if ($file->isValid()) {
            $this->del_image($id);
            $fileName = $file->getRandomName();
            $data = array_merge($data, ['image' => $this->path_users . '/' . $fileName]);
            $file->move($this->path_users, $fileName);
        }

        if ($data['password'] != '') {
            $data = array_merge($data, ['password' => password_hash($data['password'], PASSWORD_DEFAULT)]);
        } else {
            unset($data['password']);
        }

        $this->model->update($id, $data);
        return $this->response->setJSON(['status' => 200]);
    }

    public function delete($id){
        $this->del_image($id);
        $this->model->delete($id);
        return $this->response->setJSON(['status' => 200]);
    }

    public function del_image($id){
        $img = $this->model->find($id)['image'];
        if($img != '') unlink(FCPATH . $this->model->find($id)['image']);
    }
}