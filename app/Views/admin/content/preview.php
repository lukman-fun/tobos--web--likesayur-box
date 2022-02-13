<?php

use App\Models\Slider;
?>
<?= $this->extend('admin/template/app') ?>

<?= $this->section('style') ?>
<style>
    .txt-ell {
        display: block;
        text-overflow: ellipsis;
        overflow: hidden;
        white-space: nowrap;
        min-width: 0;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('title') ?>
Content Preview
<?= $this->endSection() ?>

<?= $this->section('name_page') ?>
Content Preview
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-center mb-3">
            <div style="width: 350px; max-height: 100vh; border-radius: 8px; background-color: #f6f6f6; box-sizing: border-box;" class="card shadow-lg overflow-auto scroll-vertical">
                <div class="p-2 position-sticky" style="background-color: white; top: 0; z-index: 5;">
                    <div class="col-12">
                        <div class="rounded-lg d-flex align-items-center p-2" style="height: 40px; background-color: #f6f6f6;">
                            <i class="fe fe-search" style="font-size: 1.1rem;"></i>
                            <span class="ml-1">Cari produk segar disini</span>
                        </div>
                    </div>
                </div>
                <img src="https://s4.bukalapak.com/cinderella/ad-inventory/61c8323ac09b7c00014e0fde/s-581-245/DESK_Home%20Banner_1668x704%20Copy%20(6)-1640510004133.jpg.webp" alt="" class="img-fluid" style="height: 130px; width: 100%;">
                <div class="py-2">
                    <div style="background-color: white;">
                        <div class="col-3 text-center py-2">
                            <img src="https://ik.imagekit.io/dcjlghyytp1/c8328332d4f731f292ae3ce96dfa0517?tr=f-auto" alt="" style="width: 35px; height: 35px;">
                            <span style="font-size: 0.6rem;" class="text-dark">Buah</span>
                        </div>
                    </div>
                    <?php foreach ($content as $iContent) : ?>
                        <div class="mt-2" style="background-color: white;">
                            <div class="col-12 py-2">
                                <div class="row">
                                    <div class="col-8 text-left">
                                        <span class="d-block font-weight-bold text-dark" style="font-size: 0.8rem; margin: auto auto -5px auto;"><?= $iContent->title ?></span>
                                        <span style="font-size: 0.6rem; margin: -5px auto auto auto;" class="text-dark"><?= $iContent->sub_title ?></span>
                                    </div>
                                    <div class="col-4 text-right">
                                        <span class="<?= ($iContent->total_items > 0) ? 'd-block' : 'd-none' ?> font-weight-bold text-base" style="font-size: 0.8rem;">Lihat Semua</span>
                                    </div>
                                </div>
                            </div>
                            <?php if($iContent->image != ''): ?>
                                <img src="<?= base_url() . '/' . $iContent->image ?>" alt="" class="img-fluid" style="height: 90px; width: 100%;">
                            <?php endif; ?>
                            <div class="col-12 <?= count($iContent->product) > 0 ? 'pb-3' : ''; ?>">
                                <div class="d-flex overflow-auto scroll-horizontal align-content-stretch pb-1">
                                    <?php foreach ($iContent->product as $i => $iProduct) : ?>
                                        <div class="rounded-lg shadow-sm mt-2 <?= $i < (count($iContent->product) -1) ? 'mr-2' : '' ?> overflow-hidden" style="min-width: 120px; width: 120px; background-color: white;">
                                            <img src="<?= base_url() . '/' . $iProduct->image ?>" alt="" class="img-fluid rounded-lg" style="width: 120px; height: 110px;">
                                            <div class="p-1">
                                                <span style="font-size: 0.8rem;" class="txt-ell text-dark"><?= $iProduct->name ?></span>
                                                <span class="<?= !in_array($iProduct->discon, ['', '%', '0']) ? 'd-flex' : 'd-none';  ?> align-items-center" style="font-size: 0.5rem;">
                                                    <span style="text-decoration-line: line-through;" class="text-dark">Rp <?= number_format($iProduct->price) ?></span>
                                                    <span class="bg-warning text-white rounded-pill font-weight-bold ml-2" style="padding: 1px 4px;">Save <?= (($iProduct->discon[strlen($iProduct->discon) - 1] == '%') ? $iProduct->discon : 'Rp. ' . number_format($iProduct->discon)) ?></span>
                                                </span>
                                                <span class="d-flex align-items-center">
                                                    <span style="font-size: 0.8rem;" class="text-base">Rp. <?= number_format(($iProduct->discon[strlen($iProduct->discon) - 1] == '%') ? ($iProduct->price - (($iProduct->price * str_replace(['%'], '', $iProduct->discon)) / 100)) : ($iProduct->price - $iProduct->discon)); ?></span>
                                                    <span style="font-size: 0.5rem;" class="text-dark">/ gram</span>
                                                </span>
                                                <span class="text-danger <?= !in_array($iProduct->discon, ['', '%', '0']) ? '' : 'd-none';  ?>" style="font-size: 0.6rem;">Promo!! Maximal beli <?= $iProduct->max_buy_discon ?></span>
                                                <div class="bg-warning d-flex align-items-end">
                                                    <button class="btn btn-sm btn-success w-100">BELI</button>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>