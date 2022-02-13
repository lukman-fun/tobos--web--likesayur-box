<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DetailTransaction;
use App\Models\Kurir;
use App\Models\Transaction;
use Hermawan\DataTables\DataTable;

class TransactionController extends BaseController
{

    protected $mode;
    protected $curl;
    protected $apiSetting;

    function __construct()
    {
        $this->model = new Transaction();
        $this->curl = service('curlrequest');
        $this->apiSetting = (file_exists(ROOTPATH . "public/files/system/" . "api_setting.json") ? json_decode(file_get_contents(ROOTPATH . "public/files/system/" . "api_setting.json")) : []);
    }

    public function index()
    {
        return view('admin/transaction/index', [
            'kurir' => (new Kurir())->findAll()
        ]);
    }

    public function get($id)
    {
        if ($id == 'all') {
            $data = $this->model->getTransaction();
            return DataTable::of($data)
                ->addNumbering('no')
                ->edit('process', function ($row) {
                    switch ($row->process) {
                        case '0':
                            $sts = 'Menunggu Pembayaran';
                            break;
                        case '1':
                            $sts = 'Pesanan Dikemas';
                            break;
                        case '2':
                            $sts = 'Pesanan Dikirim';
                            break;
                        case '3':
                            $sts = 'Pesanan Diterima';
                            break;
                    }
                    return $sts;
                })
                ->edit('status', function ($row) {
                    switch ($row->status) {
                        case '0':
                            $sts = '<span class="text-warning font-weight-bold">Proses</span>';
                            break;
                        case '1':
                            $sts = '<span class="text-success font-weight-bold">Selesai</span>';
                            break;
                        case '-1':
                            $sts = '<span class="text-danger font-weight-bold">Gagal</span>';
                            break;
                    }
                    return $sts;
                })
                ->add('kurir', function ($row) {
                    switch ($row->kurir_status) {
                        case '0':
                            $stskr = '<span class="badge badge-warning">Menunggu ' . $row->kurir_name . '</span>';
                            break;
                        case '1':
                            $stskr = '<span class="badge badge-success">' . $row->kurir_name . ' Setuju<span class="badge badge-warning">';
                            break;
                        case '-1':
                            $stskr = '<span class="badge badge-danger">' . $row->kurir_name . ' Menolak<span class="badge badge-warning">';
                            break;
                    }
                    return $row->kurir_name == null ? '<span class="text-warning font-weight-bold">Silahkan Pilih Kurir</span>' : $stskr;
                })
                ->add('total', function($row){
                    $total = 0;
                    foreach((new DetailTransaction())->where('transaction_id', $row->id)->findAll() as $item){
                        $total += (json_decode($item['product_data'])->product_price * $item['qty']);
                    }
                    return 'Rp. ' . $total;
                })
                ->add('action', function ($row) {
                    $action = '<div class="d-flex justify-content-center">';
                    if( ($row->process == 1 &&  $row->kurir_name == null) || ($row->process == 1 &&  $row->kurir_status == '-1') ){
                        $action .= '<button type="button" class="btn btn-secondary btn-sm" onclick="onKurir(`' . $row->id . '`)"><i class="fe fe-truck"></i></button>';
                    }
                    $action .= '<button type="button" class="btn btn-info btn-sm" onclick="onDataView(this)" data-transaction_id="' . $row->id . '" data-delivery="' . base64_encode($row->data_delivery) . '" data-proses="' . $row->process . '" data-status="' . $row->status . '"><i class="fe fe-database"></i></button>';
                    $action .= '<button type="button" class="btn btn-danger btn-sm" onclick="onDelete(`' . $row->id . '`)"><i class="fe fe-trash"></i></button>';
                    $action .= '</div>';
                    return $action;
                })
                ->toJson(true);
        } else {
            return $this->response->setJSON([
                'status' => 200,
                'data' => $this->model->find($id)
            ]);
        }
    }

    public function delete($id)
    {
        (new DetailTransaction())->where('transaction_id', $id)->delete();
        $this->model->delete($id);
        return $this->response->setJSON(['status' => 200]);
    }

    public function transactionKurir()
    {
        $data = $this->request->getPost();

        $transaksi = $this->model->find($data['transaction_id']);
        $data_delivery = json_decode($transaksi['data_delivery']);

        $kurir = (new Kurir())->find($data['kurir_id']);

        $detail_transaction = (new DetailTransaction())->where('transaction_id', $data['transaction_id'])->findAll();
        $total = 0;
        $listPesanan = "*List Pesanan :*\n";
        foreach($detail_transaction as $i => $detail){
            $productData = json_decode($detail['product_data']);
            $listPesanan .= ($i+1) . ". _(" . $productData->product_name . " x" . $detail['qty'] . " = Rp." . ($productData->product_price * $detail['qty']) . ")_\n" ;
            $total += ($productData->product_price * $detail['qty']);
        }

        $pesanKurir = "Pesanan Baru TOBOS\n\n";
        $pesanKurir .= "*Alamat Pengiriman :*\n";
        $pesanKurir .= $data_delivery->fullname . "\n";
        $pesanKurir .= $data_delivery->address . "\n";
        $pesanKurir .= $data_delivery->phone . "\n\n";
        $pesanKurir .= "*Catatan :*\n";
        $pesanKurir .= $data_delivery->catatan . "\n";
        $pesanKurir .= "*Waktu Pengiriman :*\n";
        $pesanKurir .= $data_delivery->waktu . "\n\n\n";
        $pesanKurir .= "========\n";
        $pesanKurir .= $listPesanan;
        $pesanKurir .= "\n";
        $pesanKurir .= "Total : Rp. " . $total . "\n";
        $pesanKurir .= "======\n\n\n";
        $pesanKurir .= "Jika Setuju Balas => *" . $transaksi['no_transaction'] . "|" . $data['kurir_id']. "|setuju*\n";
        $pesanKurir .= "Jika Menolak Balas => *" . $transaksi['no_transaction'] . "|" . $data['kurir_id']. "|tolak*";

        $wa = $this->curl->request('post', 'https://whatsapp.juraganitweb.com/send-message', [
            'json' => [
                'api_key' => (isset($this->apiSetting->wa_api_key) ? $this->apiSetting->wa_api_key : ''),
                'sender' => (isset($this->apiSetting->wa_number) ? $this->apiSetting->wa_number : ''),
                'number' => $kurir['phone'],
                'message' => $pesanKurir
            ]
        ]);
        if(json_decode($wa->getBody())->status == 1){
            $this->model->update($data['transaction_id'], ['kurir_id' => $kurir['id'], 'kurir_status' => '0']);
            return $this->response->setJSON(['status' => 200]);
        }else{
            return $this->response->setJSON(['status' => 404]);
        }
    }

    public function transactionConfirm(){
        $data = explode('|', $this->request->getJSON()->message);
        if(count($data) == 2){
            $ts = $this->model->where([
                'no_transaction' => $data[1],
                'kurir_status' => '1'
            ])->first();
            if($ts){
                if($data[0] == 'diterima' || $data[0] == 'Diterima'){
                    $this->model->update($ts['id'], ['status' => '1']);
                    $pesanClient = "Terimakasih sudah berbelanja dengan TOBOS";
                }else{
                    $pesanClient = "Format pesan salah, silahkan ulangi dengan format yang sesuai";
                }
            }else{
                $pesanClient = "Maaf Data Tidak ditermukan";
            }
            $wc = $this->curl->request('post', 'https://whatsapp.juraganitweb.com/send-message', [
                'json' => [
                    'api_key' => (isset($this->apiSetting->wa_api_key) ? $this->apiSetting->wa_api_key : ''),
                    'sender' => (isset($this->apiSetting->wa_number) ? $this->apiSetting->wa_number : ''),
                    'number' => str_replace(['@c.us', '@s.whatsapp.net'], '', $this->request->getJSON()->sender),
                    'message' => $pesanClient
                ]
            ]);
            if(json_decode($wc->getBody())->status == 1){
                return $this->response->setJSON(['status' => 200]);
            }else{
                return $this->response->setJSON(['status' => 404]);
            }
        }else if(count($data) == 3){
            $tr = $this->model->where([
                'no_transaction' => $data[0],
                'kurir_id' => $data[1],
                'kurir_status' => '0'
            ])->first();
            if($tr){
                if($data[2] == 'setuju'){
                    $this->model->update($tr['id'], ['kurir_status' => '1']);
                    $pesanKurir = "Terimakasih sudah menerima tawaran ini, silahkan datang ke kantor";
                }else if($data[2] == 'tolak'){
                    $this->model->update($tr['id'], ['kurir_status' => '-1']);
                    $pesanKurir = "Terimakasih sudah merespon pesan ini, mungkin lain kali";
                }else{
                    $pesanKurir = "Format pesan salah, silahkan ulangi dengan format yang sesuai";
                }
            }else{
                $pesanKurir = "Maaf Data Tidak ditermukan";
            }
            $wa = $this->curl->request('post', 'https://whatsapp.juraganitweb.com/send-message', [
                'json' => [
                    'api_key' => (isset($this->apiSetting->wa_api_key) ? $this->apiSetting->wa_api_key : ''),
                    'sender' => (isset($this->apiSetting->wa_number) ? $this->apiSetting->wa_number : ''),
                    'number' => str_replace(['@c.us', '@s.whatsapp.net'], '', $this->request->getJSON()->sender),
                    'message' => $pesanKurir
                ]
            ]);
            if(json_decode($wa->getBody())->status == 1){
                return $this->response->setJSON(['status' => 200]);
            }else{
                return $this->response->setJSON(['status' => 404]);
            }
        }
    }

    public function getPesanan($transaction_id){
        $data = (new DetailTransaction())->where('transaction_id', $transaction_id)->findAll();
        if($data){
            $datas = [];
            foreach($data as $item){
                $item['product_data'] = json_decode($item['product_data']);
                array_push($datas, $item);
            }
            return $this->response->setJSON([
                'status' => 200,
                'data' => $datas
            ]);
        }else{
            return $this->response->setJSON([
                'status' => 404,
                'message' => 'Not Found'
            ]);
        }
    }

    public function upPesanan(){
        $data = $this->request->getPost();
        $trans = $this->model->where('id', $data['transaction_id'])->first();
        $data_delivery = json_decode($trans['data_delivery']);

        if($data['process'] == '2'){
            $this->curl->request('post', 'https://whatsapp.juraganitweb.com/send-message', [
                'json' => [
                    'api_key' => (isset($this->apiSetting->wa_api_key) ? $this->apiSetting->wa_api_key : ''),
                    'sender' => (isset($this->apiSetting->wa_number) ? $this->apiSetting->wa_number : ''),
                    'number' => $data_delivery->phone,
                    'message' => 'Pesanan *' . $trans['no_transaction'] . '* sedang dikirim,' . "\n" . 'Jika barang sudah diterima segera balas => *Diterima|' . $trans['no_transaction'] . '*'
                ]
            ]);
        }

        if($data['status'] == '-1'){
            $this->curl->request('post', 'https://whatsapp.juraganitweb.com/send-message', [
                'json' => [
                    'api_key' => (isset($this->apiSetting->wa_api_key) ? $this->apiSetting->wa_api_key : ''),
                    'sender' => (isset($this->apiSetting->wa_number) ? $this->apiSetting->wa_number : ''),
                    'number' => $data_delivery->phone,
                    'message' => 'Pesanan *' . $trans['no_transaction'] . '* dibatalkan'
                ]
            ]);
        }
        
        $this->model->update($data['transaction_id'], [
            'process' => $data['process'],
            'status' => $data['status']
        ]);
        return $this->response->setJSON(['status' => 200]);
    }

    public function confirmPayment(){
        $data = $this->request->getJSON();
        $status = $data->status;
        $noTrans = $data->external_id;
        
        $trans = $this->model->where([ 'no_transaction' => $noTrans ])->first();
        $data_delivery = json_decode($trans['data_delivery']);

        switch($status){
            case "PAID":
                $this->curl->request('post', 'https://whatsapp.juraganitweb.com/send-message', [
                    'json' => [
                        'api_key' => (isset($this->apiSetting->wa_api_key) ? $this->apiSetting->wa_api_key : ''),
                        'sender' => (isset($this->apiSetting->wa_number) ? $this->apiSetting->wa_number : ''),
                        'number' => $data_delivery->phone,
                        'message' => 'Pembayaran berhasil, Pesanan *' . $noTrans . '* Sedang dikemas'
                    ]
                ]);
                $this->model->where([ 'no_transaction' => $noTrans ])->set([
                    'process' => '1',
                    'payment_id' => ''
                ])->update();
                break;
            case "EXPIRED":
                $this->curl->request('post', 'https://whatsapp.juraganitweb.com/send-message', [
                    'json' => [
                        'api_key' => (isset($this->apiSetting->wa_api_key) ? $this->apiSetting->wa_api_key : ''),
                        'sender' => (isset($this->apiSetting->wa_number) ? $this->apiSetting->wa_number : ''),
                        'number' => $data_delivery->phone,
                        'message' => 'Pembayaran sudah kadaluarsa, Pesanan *' . $noTrans . '* dibatalkan'
                    ]
                ]);
                $this->model->where([ 'no_transaction' => $noTrans ])->set([
                    'status' => '-1',
                    'payment_id' => ''
                ])->update();
                break;
        }
        return $this->response->setJSON(['status' => 200]);
    }


}
