<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Slider;

class SliderController extends BaseController
{
    protected $model;
    protected $path_slider = 'files/slider';

    function __construct()
    {
        $this->model = new Slider();
        if (!file_exists(FCPATH . $this->path_slider)) {
            mkdir(FCPATH . $this->path_slider);
        }
    }

    public function index()
    {
        return view('admin/slider/index');
    }

    public function get($id)
    {
        $data = ($id == 'all') ? $this->model->orderBy('id', 'desc')->findAll() : $this->model->find($id);
        if (count($data) > 0) {
            $r['status'] = 200;
            $r['data'] = $data;
        } else {
            $r['status'] = 404;
            $r['data'] = null;
        }
        return $this->response->setJSON($r);
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

        if(!$valid) return $this->response->setJSON([
            'status' => 404,
            'errors' => \Config\Services::validation()->getErrors()
        ]);

        if($file->isValid()){
            $fileName = $file->getRandomName();
            $data = array_merge($data, ['image' => $this->path_slider . '/' . $fileName]);
            $file->move($this->path_slider, $fileName);
        }

        $data = array_merge($data, ['slug' => url_title($data['name'], '-', true)]);
        $this->model->save($data);
        return $this->response->setJSON(['status' => 200]);
    }

    public function update($id){
        $data = $this->request->getPost();
        unset($data['type']);
        $file = $this->request->getFile('image');

        $valid = $this->validate([
            'name' => 'required'
        ]);

        if(!$valid) return $this->response->setJSON([
            'status' => 404,
            'errors' => \Config\Services::validation()->getErrors()
        ]);

        if($file->isValid()){
            $this->del_image($id);
            $fileName = $file->getRandomName();
            $data = array_merge($data, ['image' => $this->path_slider . '/' . $fileName]);
            $file->move($this->path_slider, $fileName);
        }

        $data = array_merge($data, ['slug' => url_title($data['name'], '-', true)]);
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
