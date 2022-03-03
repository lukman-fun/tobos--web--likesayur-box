<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Kurir;
use Hermawan\DataTables\DataTable;

class KurirController extends BaseController
{
    protected $model;
    function __construct()
    {
        $this->model = new Kurir();
    }

    public function index()
    {
        return view('admin/kurir/index');
    }

    public function get($id)
    {
        if ($id == 'all') {
            $data = $this->model->getKurir();
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
            'fullname' => 'required',
            'phone' => 'required|regex_match[/^(\+62|62|0)/]|is_unique[kurir.phone]',
            'address' => 'required',
        ],[
            'phone' => [
                'regex_match' => 'The phone field is not in the correct format, starting with (0, 62, +62).'
            ]
        ]);

        if(!$valid) return $this->response->setJSON([
            'status' => 404,
            'errors' => \Config\Services::validation()->getErrors()
        ]);

        $this->model->save(array_merge($data, [ 'phone' => preg_replace('/^(\+62|62|0)/', '62', $data['phone']) ]));
        return $this->response->setJSON([
            'status' => 200,
        ]);
    }

    public function update($id)
    {
        $data = $this->request->getPost();
        unset($data['type']);

        $valid = $this->validate([
            'fullname' => 'required',
            'address' => 'required',
            'phone' => 'required|regex_match[/^(\+62|62|0)/]|is_unique[kurir.phone,id,' . $id . ']'
        ],[
            'phone' => [
                'regex_match' => 'The phone field is not in the correct format, starting with (0, 62, +62).'
            ]
        ]);

        if(!$valid) return $this->response->setJSON([
            'status' => 404,
            'errors' => \Config\Services::validation()->getErrors()
        ]);

        $this->model->update($id, array_merge($data, [ 'phone' => preg_replace('/^(\+62|62|0)/', '62', $data['phone']) ]));
        return $this->response->setJSON(['status' => 200]);
    }

    public function delete($id){
        $this->model->delete($id);
        return $this->response->setJSON(['status' => 200]);
    }
}
