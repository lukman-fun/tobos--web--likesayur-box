<?php

namespace App\Controllers\Api;

use App\Models\Catalog;
use App\Models\Category;
use App\Models\ItemCatalog;
use App\Models\Slider;
use App\Models\Supplier;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class HomeController extends ResourceController
{
    use ResponseTrait;

    public function slider()
    {
        $slider = new Slider();
        $data = $slider->orderBy('id', 'desc')->findAll(3);
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

    public function category()
    {
        $slider = new Category();
        $data = $slider->orderBy('id', 'desc')->findAll();
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

    public function catalog($user_id)
    {
        $slider = new Catalog();
        $data = $slider->orderBy('id', 'desc')->findAll();
        if ($data) {
            $datas = [];
            foreach ($data as $iContent) {
                $iContent['product'] = (new ItemCatalog())->select("item_catalog.*, product.*, (SELECT cart.qty FROM cart WHERE cart.product_id=product.id AND cart.user_id='" . $user_id ."') as isCart")->join('product', 'product.id=item_catalog.product_id', 'inner')->where('catalog_id', $iContent['id'])->get()->getResult();
                foreach($iContent['product'] as $iProduct){
                    $iProduct->information = json_decode($iProduct->information);
                    $iProduct->information->farmers_and_suppliers = (new Supplier())->whereIn('id', $iProduct->information->farmers_and_suppliers)->findAll();
                }
                array_push($datas, $iContent);
            }
            return $this->respond([
                'status' => 200,
                'data' => $datas
            ]);
        } else {
            return $this->respond([
                'status' => 404,
                'message' => 'Not Found'
            ]);
        }
    }

    public function promo(){
        $slider = new Slider();
        $data = $slider->orderBy('id', 'desc')->findAll();
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
}
