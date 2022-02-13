<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Waktu;
use Hermawan\DataTables\DataTable;

class WaktuController extends BaseController
{

    protected $model;

    function __construct()
    {
        $this->model = new Waktu();
    }

    public function index()
    {
        return view('admin/waktu/index');
    }

    public function get($id)
    {
        if ($id == 'all') {
            $data = $this->model->getWaktu();
            return DataTable::of($data)
                ->addNumbering('no')
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

        $valid = $this->validate([
            'name' => 'required',
            'start' => 'required',
            'end' => 'required'
        ]);

        if (!$valid) return $this->response->setJSON([
            'status' => 404,
            'errors' => \Config\Services::validation()->getErrors()
        ]);

        $this->model->save($data);
        return $this->response->setJSON(['status' => 200]);
    }

    public function update($id)
    {
        $data = $this->request->getPost();
        unset($data['type']);

        $valid = $this->validate([
            'name' => 'required',
            'start' => 'required',
            'end' => 'required'
        ]);

        if (!$valid) return $this->response->setJSON([
            'status' => 404,
            'errors' => \Config\Services::validation()->getErrors()
        ]);

        $this->model->update($id, $data);
        return $this->response->setJSON(['status' => 200]);
    }

    public function delete($id){
        $this->model->delete($id);
        return $this->response->setJSON(['status' => 200]);
    }
}
