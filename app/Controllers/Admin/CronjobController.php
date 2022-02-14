<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CronjobKurir;
use App\Models\Transaction;

class CronjobController extends BaseController
{

    protected $cronKurir;
    protected $curl;
    protected $apiSetting;

    function __construct()
    {
        $this->cronKurir = new CronjobKurir();
        $this->curl = service('curlrequest');
        $this->apiSetting = (file_exists(ROOTPATH . "public/files/system/" . "api_setting.json") ? json_decode(file_get_contents(ROOTPATH . "public/files/system/" . "api_setting.json")) : []);
    }

    public function kurirExp()
    {
        foreach ($this->cronKurir->select('cronjob_kurir.*, kurir.phone')->where(["date <=" => date('Y-m-d H:i:s')])->join('transaction', 'transaction.id=cronjob_kurir.transaction_id', 'inner')->join('kurir', 'kurir.id=transaction.kurir_id', 'inner')->findAll() as $item) {
            $this->curl->request('post', (isset($this->apiSetting->wa_url) ? $this->apiSetting->wa_url : ''), [
                'json' => [
                    'api_key' => (isset($this->apiSetting->wa_api_key) ? $this->apiSetting->wa_api_key : ''),
                    'sender' => (isset($this->apiSetting->wa_number) ? $this->apiSetting->wa_number : ''),
                    'number' => $item['phone'],
                    'message' => 'Waktu sudah melebihi batas konfirmasi, mungkin lain kali'
                ]
            ]);
            (new Transaction())->where('id', $item['transaction_id'])->replace(['kurir_status' => '-1']);
            $this->cronKurir->where('id', $item['id'])->delete();
        }
        return $this->response->setJSON(['status' => 200]);
        // return $this->response->setJSON($this->cronKurir->select('cronjob_kurir.*, kurir.phone')->where(["date <=" => "2022-02-13 06:00:00"])->join('transaction', 'transaction.id=cronjob_kurir.transaction_id', 'inner')->join('kurir', 'kurir.id=transaction.kurir_id', 'inner')->findAll());
    }
}
