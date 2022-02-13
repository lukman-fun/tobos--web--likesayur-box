<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\Users;

class DashboardController extends BaseController
{
    protected $trans;

    function __construct()
    {
        $this->trans = new Transaction();
    }

    public function index()
    {
        return view('admin/index');
    }

    public function totalData()
    {
        $profit = 0;
        foreach ($this->trans->join('detail_transaction', 'detail_transaction.transaction_id=transaction.id', 'inner')->where(['status' => '1'])->findAll() as $iProfit) {
            $productData = json_decode($iProfit['product_data']);
            $profit += ($iProfit['qty'] * $productData->product_price);
        }

        return $this->response->setJSON([
            'transaction' => number_format($this->trans->where('status', '1')->countAllResults()),
            'product' => number_format((new Product())->countAllResults()),
            'users' => number_format((new Users())->countAllResults()),
            'profit' => 'Rp. ' . number_format($profit)
        ]);
    }

    public function weekTransaction()
    {
        $data = [];
        $beforeWeek = date('Y-m-d', strtotime('-6 days'));
        for ($i = 0; $i < 7; $i++) {
            $date = date('Y-m-d', strtotime('+' . $i . ' days ' . $beforeWeek));
            $data['dateTrans'][] = $date;

            $sql = $this->trans->join('detail_transaction', 'detail_transaction.transaction_id=transaction.id', 'inner')->where([
                'DATE(updated_at)' => $date
            ]);
            if ($sql) {
                $process = 0;
                $success = 0;
                $failed = 0;
                foreach ($sql->findAll() as $iTrans) {
                    $productData = json_decode($iTrans['product_data']);
                    if ($iTrans['status'] == '0') {
                        $process += ($iTrans['qty'] * $productData->product_price);
                    } elseif ($iTrans['status'] == '1') {
                        $success += ($iTrans['qty'] * $productData->product_price);
                    } else {
                        $failed += ($iTrans['qty'] * $productData->product_price);
                    }
                }

                $data['processPriceTrans'][] = $process;
                $data['successPriceTrans'][] = $success;
                $data['failedPriceTrans'][] = $failed;
            } else {
                $data['processPriceTrans'][] = 0;
                $data['successPriceTrans'][] = 0;
                $data['failedPriceTrans'][] = 0;
            }
        }
        return $this->response->setJSON($data);
    }

    public function statusToday()
    {
        $pending = 0;
        $dikemas = 0;
        $pengiriman = 0;
        $diterima = 0;
        $batal = 0;
        foreach ($this->trans->where('DATE(updated_at)', date('Y-m-d'))->findAll() as $item) {
            if ($item['status'] == '0' || $item['status'] == '1') {
                switch ($item['process']) {
                    case "0":
                        $pending += 1;
                        break;
                    case "1":
                        $dikemas += 1;
                        break;
                    case "2":
                        $pengiriman += 1;
                        break;
                    case "3":
                        $diterima += 1;
                        break;
                }
            } else {
                $batal += 1;
            }
        }

        return $this->response->setJSON([
            'statusData' => [$pending, $dikemas, $pengiriman, $diterima, $batal],
            'statusLabel' => ['Menunggu Pembayaran', 'Sedang Dikemas', 'Proses Pengiriman', 'Barang Diterima', 'Pesanan Dibatalkan']
        ]);
    }
}
