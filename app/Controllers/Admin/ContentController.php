<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Catalog;
use App\Models\Category;
use App\Models\ItemCatalog;
use App\Models\Product;
use App\Models\Slider;
use Hermawan\DataTables\DataTable;

class ContentController extends BaseController
{
    protected $model;
    protected $path_content = 'files/content';

    function __construct()
    {
        $this->model = new Catalog();
        if (!file_exists(FCPATH . $this->path_content)) {
            mkdir(FCPATH . $this->path_content);
        }
    }

    public function index()
    {
        return view('admin/content/index');
    }

    public function get($id)
    {
        if ($id == 'all') {
            $data = $this->model->getCatalog();
            return DataTable::of($data)
                ->addNumbering('no')
                ->edit('image', function ($row) {
                    return ($row->image != '') ? '<img src="' . base_url() . '/' . $row->image . '" alt="" class="img-fluid rounded-lg shadow" style="height: 40px; width: 120px;">' : 'NO IMAGE';
                })
                ->add('action', function ($row) {
                    return '<div class="d-flex justify-content-center">
                <a href="' . base_url('admin/content-items/' . $row->id) . '" class="btn btn-success btn-sm mr-1"><i class="fe fe-database"></i></a>
                <button type="button" class="btn btn-info btn-sm mr-1" onclick="onEdit(`' . $row->id . '`)"><i class="fe fe-edit"></i></button>
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
            'title' => 'required',
            'sub_title' => 'required'
        ]);

        if (!$valid) return $this->response->setJSON([
            'status' => 404,
            'errors' => \Config\Services::validation()->getErrors()
        ]);

        if ($file->isValid()) {
            $fileName = $file->getRandomName();
            $data = array_merge($data, ['image' => $this->path_content . '/' . $fileName]);
            $file->move($this->path_content, $fileName);
        }

        $data = array_merge($data, ['slug' => url_title($data['title'], '-', true)]);
        $this->model->save($data);
        return $this->response->setJSON(['status' => 200]);
    }

    public function update($id)
    {
        $data = $this->request->getPost();
        unset($data['type']);
        $file = $this->request->getFile('image');

        $valid = $this->validate([
            'title' => 'required',
            'sub_title' => 'required'
        ]);

        if (!$valid) return $this->response->setJSON([
            'status' => 404,
            'errors' => \Config\Services::validation()->getErrors()
        ]);

        if ($file->isValid()) {
            $this->del_image($id);
            $fileName = $file->getRandomName();
            $data = array_merge($data, ['image' => $this->path_content . '/' . $fileName]);
            $file->move($this->path_content, $fileName);
        }

        $data = array_merge($data, ['slug' => url_title($data['title'], '-', true)]);
        $this->model->update($id, $data);
        return $this->response->setJSON(['status' => 200]);
    }

    public function delete($id)
    {
        $this->del_image($id);
        $this->model->delete($id);
        (new ItemCatalog())->where('catalog_id', $id)->delete();
        return $this->response->setJSON(['status' => 200]);
    }

    public function preview()
    {
        $data = [];
        foreach ($this->model->getCatalog()->orderBy('id', 'desc')->get()->getResult() as $iContent) {
            $iContent->product = (new ItemCatalog())->join('product', 'product.id=item_catalog.product_id', 'inner')->where('catalog_id', $iContent->id)->get()->getResult();
            array_push($data, $iContent);
        }

        return view('admin/content/preview', [
            'slider' => (new Slider())->findAll(),
            'category' => (new Category())->findAll(),
            'content' => $data
        ]);
    }

    public function items($catalog_id)
    {
        return view('admin/content/content_items', [
            'catalog_id' => $catalog_id
        ]);
    }

    public function getItems($catalog_id, $category_id)
    {
        $data = (new ItemCatalog())->getContentItems($catalog_id, $category_id);
        return DataTable::of($data)
            ->addNumbering("no")
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
                if (!in_array($row->discon, ['', '0', '%'])) {
                    return 'Rp. ' . number_format($row->price) . '/' . '<span class="text-danger" style="font-size: 0.7rem;">' . (($row->discon[strlen($row->discon) - 1] == '%') ? $row->discon : 'Rp. ' . number_format($row->discon)) . '</span>';
                } else {
                    return 'Rp. ' . number_format($row->price) . '/' . '<span class="text-danger" style="font-size: 0.7rem;">-</span>';
                }
            })
            ->edit('price', function ($row) {
                if (!in_array($row->discon, ['', '0', '%'])) {
                    return 'Rp. ' . number_format(($row->discon[strlen($row->discon) - 1] == '%') ? ($row->price - (($row->price * str_replace(['%'], '', $row->discon)) / 100)) : ($row->price - $row->discon));
                } else {
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
                return '<div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="check-' . $row->id . '" value="' . $row->id . '" onchange="onPilih(this)" ' . ($row->isItemCatalog != null ? 'checked' : '') . '>
                <label class="custom-control-label" for="check-' . $row->id . '"></label>
              </div>';
                // return '<div class="form-group"><input type="checkbox" class="form-control" ' .($row->isItemCatalog != null ? 'checked' : ''). ' ></div>';
            })
            ->toJson(true);
    }

    public function updateItems($catalog_id, $product_id)
    {
        $model = new ItemCatalog();
        if ($model->where(['catalog_id' => $catalog_id, 'product_id' => $product_id])->first()) {
            $model->where(['catalog_id' => $catalog_id, 'product_id' => $product_id])->delete();
        } else {
            $model->save(['catalog_id' => $catalog_id, 'product_id' => $product_id]);
        }
        return $this->response->setJSON(['status' => 200]);
    }

    public function del_image($id)
    {
        $img = $this->model->find($id)['image'];
        if ($img != '' && file_exists(FCPATH . $img)) unlink(FCPATH . $this->model->find($id)['image']);
    }
}
