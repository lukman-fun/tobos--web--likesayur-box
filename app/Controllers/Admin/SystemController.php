<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use Xendit\Xendit;

class SystemController extends BaseController
{
    
    protected $path_system = 'files/system';
    function __construct()
    {
        if (!file_exists(FCPATH . $this->path_system)) {
            mkdir(FCPATH . $this->path_system);
        }
        Xendit::setApiKey("xnd_development_1c3tZ0pxJFaqWU6xyxJzryXhaV7e5aAV0Xr9cptOXi7h5B5SWxkJ2TdfFeYW59W");
    }

    public function index()
    {
        return view('admin/system/index', [
            'payment' => \Xendit\PaymentChannels::list(),
            'local_payment' => (file_exists(ROOTPATH . "public/files/system/" . "payment_channel.json") ? json_decode(file_get_contents(ROOTPATH . "public/files/system/" . "payment_channel.json")) : []),
            'api_setting' => (file_exists(ROOTPATH . "public/files/system/" . "api_setting.json") ? json_decode(file_get_contents(ROOTPATH . "public/files/system/" . "api_setting.json")) : [])
        ]);
    }

    public function storePaymentChannel(){
        file_put_contents(ROOTPATH . "public/files/system/" . "payment_channel.json", json_encode($this->request->getPost('bank')));
        return $this->response->setJSON(['status'=> 200]);
    }
    
    public function storeApiSetting(){
        file_put_contents(ROOTPATH . "public/files/system/" . "api_setting.json", json_encode($this->request->getPost()));
        return $this->response->setJSON(['status'=> 200]);
    }
}
