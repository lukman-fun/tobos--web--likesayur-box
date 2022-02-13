<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\Cart;
use App\Models\DetailTransaction;
use App\Models\Transaction;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;
use Xendit\Xendit;

class TransactionController extends ResourceController
{
    use ResponseTrait;
    protected $model;
    protected $detailModel;
    protected $curl;
    function __construct()
    {
        $this->model = new Transaction();
        $this->detailModel = new DetailTransaction();
        $apiSetting = (file_exists(ROOTPATH . "public/files/system/" . "api_setting.json") ? json_decode(file_get_contents(ROOTPATH . "public/files/system/" . "api_setting.json")) : []);
        Xendit::setApiKey(isset($apiSetting->xendit_api_key) ? $apiSetting->xendit_api_key : '');
        $this->curl = service('curlrequest');
    }

    public function get($user_id, $status)
    {
        if ($status == '0') {
            $data = $this->model->where('user_id', $user_id)->where('status', '0')->get()->getResult();
        } else {
            $data = $this->model->where('user_id', $user_id)->whereIn('status', ['1', '-1'])->get()->getResult();
        }
        if ($data) {
            foreach ($data as $iTrans) {
                $iTrans->data_delivery = json_decode($iTrans->data_delivery);
                $tagihan = 0;
                foreach ($this->detailModel->where('transaction_id', $iTrans->id)->get()->getResult() as $detail) {
                    $tagihan += ($detail->qty * json_decode($detail->product_data)->product_price);
                }
                $iTrans->totalTagihan = $tagihan;
            }
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

    public function getDetail($transaction_id)
    {
        $data = $this->model->where('id', $transaction_id)->first();
        if ($data) {
            $detail = $this->detailModel->where('transaction_id', $transaction_id)->get()->getResult();
            $total = 0;
            foreach ($detail as $iDetail) {
                $product_data = json_decode($iDetail->product_data);
                $iDetail->product_data = $product_data;
                $total += ($product_data->product_price * $iDetail->qty);
            }
            $data['data_delivery'] = json_decode($data['data_delivery']);
            $data['detail_transaction'] = $detail;
            $data['totalTagihan'] = $total;
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

    public function store($user_id)
    {
        helper(['char_random_helper']);
        $noTrans = 'TBS-' . chunk_split(date('ym'), 2, strtoupper(randomNumChar(3))) . date('d') . '-' . strtoupper(randomChar(2));

        $transaction_data = [
            'user_id' => $user_id,
            'no_transaction' => $noTrans,
            'data_delivery' => json_encode($this->request->getJSON()->data_delivery),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        $this->model->insert($transaction_data);
        $transaction_id = $this->model->getInsertID();

        $xendit_trans = [];
        $detail_transaction = [];
        $total = 0;
        foreach ($this->request->getJSON()->items as $itemTrans) {
            array_push($xendit_trans, [
                'name' => $itemTrans->product_data->product_name,
                'price' => $itemTrans->product_data->product_price,
                'quantity' => $itemTrans->qty
            ]);
            $total += ($itemTrans->qty * $itemTrans->product_data->product_price);

            $itemTrans->transaction_id = $transaction_id;
            $itemTrans->product_data = json_encode($itemTrans->product_data);
            array_push($detail_transaction, $itemTrans);
            (new Cart())->where([
                'user_id' => $user_id,
                'product_id' => $itemTrans->product_id
            ])->delete();
        }
        $this->detailModel->insertBatch($detail_transaction);

        $params = [
            'external_id' => $noTrans,
            'items' => $xendit_trans,
            'amount' => $total,
            'payment_methods' => (file_exists(ROOTPATH . "public/files/system/" . "payment_channel.json") ? json_decode(file_get_contents(ROOTPATH . "public/files/system/" . "payment_channel.json")) : [])
        ];

        $createInvoice = \Xendit\Invoice::create($params);

        $this->model->update($transaction_id, ['payment_id' => $createInvoice["id"]]);

        return $this->respond([
            'status' => 200,
            'message' => 'Order Success-' . $createInvoice["id"]
        ]);
    }

}
