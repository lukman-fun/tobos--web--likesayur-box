<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Hermawan\DataTables\DataTable;

class ProductController extends BaseController
{
    protected $model;
    protected $path_product = 'files/product';

    function __construct()
    {
        $this->model = new Product();
        if (!file_exists(FCPATH . $this->path_product)) {
            mkdir(FCPATH . $this->path_product);
        }
    }

    public function index()
    {
        // $v['product'] = $this->model->findAll();
        return view('admin/product/index', [
            'supplier' => (new Supplier())->findAll()
        ]);
    }

    public function get($id)
    {
        if($id == 'all'){
            $data = $this->model->getProduct();
            return DataTable::of($data)
                ->addNumbering('no')
                ->edit('image', function ($row) {
                    return '<img src="' . base_url() . '/' . $row->image . '" alt="" class="rounded-lg" style="width: 70px; height: 70px;">';
                })
                ->edit('stock', function ($row) {
                    if ($row->stock > 5) {
                        return '<span class="badge badge-success text-white">' . number_format($row->stock) . '</span>';
                    } else if ($row->stock <= 5 && $row->stock >= 1) {
                        return '<span class="badge badge-warning text-white">' . number_format($row->stock) . '</span>';
                    } else {
                        return '<span class="badge badge-danger text-white">' . number_format($row->stock) . '</span>';
                    }
                })
                ->edit('discon', function ($row) {
                    if(!in_array($row->discon, ['', '0', '%'])){
                        return 'Rp. ' . number_format($row->price) . '/' . '<span class="text-danger" style="font-size: 0.7rem;">' . (($row->discon[strlen($row->discon) - 1] == '%') ? $row->discon : 'Rp. ' . number_format($row->discon)) . '</span>';
                    }else{
                        return 'Rp. ' . number_format($row->price) . '/' . '<span class="text-danger" style="font-size: 0.7rem;">-</span>';
                    }
                })
                ->edit('price', function ($row) {
                    if(!in_array($row->discon, ['', '0', '%'])){
                        return 'Rp. ' . number_format(($row->discon[strlen($row->discon) - 1] == '%') ? ($row->price - (($row->price * str_replace(['%'], '', $row->discon)) / 100)) : ($row->price - $row->discon));
                    }else{
                        return 'Rp. ' . number_format($row->price);
                    }
                })
                ->edit('max_buy_discon', function ($row) {
                    if (str_replace(['%'], '', $row->discon) > 0 && $row->max_buy_discon > 0) {
                        return '<span class="text-danger" style="font-size: 0.7rem;">Promo!! maksimal ' . $row->max_buy_discon . '</span>';
                    } else {
                        return '<span class="text-success" style="font-size: 1.3rem;">~</span>';
                    }
                })
                ->add('action', function ($row) {
                    return '<div class="d-flex justify-content-center">
                    <button type="button" class="btn btn-info btn-sm" onclick="onEdit(`' . $row->id . '`)"><i class="fe fe-edit"></i></button>
                    <button type="button" class="btn btn-danger btn-sm" onclick="onDelete(`' . $row->id . '`)"><i class="fe fe-trash"></i></button>
                </div>';
                })
                ->toJson(true);
        }else{
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
            'name' => 'required',
            'category_id' => 'required',
            'description' => 'required',
            'price' => 'required',
            'discon' => 'required',
            'stock' => 'required',
            'per' => 'required'
        ]);

        if (!$valid) return $this->response->setJSON([
            'status' => 404,
            'errors' => \Config\Services::validation()->getErrors()
        ]);

        if ($file->isValid()) {
            $fileName = $file->getRandomName();
            $data = array_merge($data, ['image' => $this->path_product . '/' . $fileName]);
            $file->move($this->path_product, $fileName);
        }

        // $data = array_merge($data, ['information' => json_encode($data['information'])]);
        $data = array_merge($data, ['slug' => url_title($data['name'], '-', true), 'information' => json_encode($data['information'])]);
        $this->model->save($data);
        return $this->response->setJSON(['status' => 200]);
    }

    public function getCategory(){
        $model = new Category();
        if(count($model->findAll()) > 0){
            $r['status'] = 200;
            $r['data'] = $model->findAll();
        }else{
            $r['status'] = 404;
        }

        return $this->response->setJSON($r);
    }

    public function update($id){
        $data = $this->request->getPost();
        unset($data['type']);
        $file = $this->request->getFile('image');

        $valid = $this->validate([
            'name' => 'required',
            'category_id' => 'required',
            'description' => 'required',
            'price' => 'required',
            'discon' => 'required',
            'stock' => 'required',
            'per' => 'required'
        ]);

        if (!$valid) return $this->response->setJSON([
            'status' => 404,
            'errors' => \Config\Services::validation()->getErrors()
        ]);

        if ($file->isValid()) {
            $this->del_image($id);
            $fileName = $file->getRandomName();
            $data = array_merge($data, ['image' => $this->path_product . '/' . $fileName]);
            $file->move($this->path_product, $fileName);
        }

        // $data = array_merge($data, ['information' => json_encode($data['information'])]);
        $data = array_merge($data, ['slug' => url_title($data['name'], '-', true), 'information' => json_encode($data['information'])]);
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
        if($img != '' && file_exists(FCPATH . $img)) unlink(FCPATH . $this->model->find($id)['image']);
    }
}
