<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Supplier;
use Hermawan\DataTables\DataTable;

class SupplierController extends BaseController
{
    protected $model;
    protected $path_supplier = 'files/supplier';

    function __construct()
    {
        $this->model = new Supplier();
        if (!file_exists(FCPATH . $this->path_supplier)) {
            mkdir(FCPATH . $this->path_supplier);
        }
    }

    public function index()
    {
        return view('admin/supplier/index');
    }

    public function get($id)
    {
        if ($id == 'all') {
            $data = $this->model->getSupplier();
            return DataTable::of($data)
                ->addNumbering('no')
                ->edit('image', function ($row) {
                    return '<img src="' . base_url() . '/' . $row->image . '" alt="" style="width: 50px; height: 50px; border-radius: 1000px;">';
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
            'image' => 'uploaded[image]|mime_in[image,image/png,image/jpg,image/jpeg]|max_size[image,2048]',
            'name' => 'required'
        ]);

        if (!$valid) return $this->response->setJSON([
            'status' => 404,
            'errors' => \Config\Services::validation()->getErrors()
        ]);

        if ($file->isValid()) {
            $fileName = $file->getRandomName();
            $data = array_merge($data, ['image' => $this->path_supplier . '/' . $fileName]);
            $file->move($this->path_supplier, $fileName);
        }

        $this->model->save($data);
        return $this->response->setJSON(['status' => 200]);
    }

    public function update($id)
    {
        $data = $this->request->getPost();
        unset($data['type']);
        $file = $this->request->getFile('image');

        $valid = $this->validate([
            'name' => 'required'
        ]);

        if (!$valid) return $this->response->setJSON([
            'status' => 404,
            'errors' => \Config\Services::validation()->getErrors()
        ]);

        if ($file->isValid()) {
            $this->del_image($id);
            $fileName = $file->getRandomName();
            $data = array_merge($data, ['image' => $this->path_supplier . '/' . $fileName]);
            $file->move($this->path_supplier, $fileName);
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
