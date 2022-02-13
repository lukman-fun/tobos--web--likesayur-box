<?= $this->extend('admin/template/app') ?>

<?= $this->section('title') ?>
Pengaturan System
<?= $this->endSection() ?>

<?= $this->section('name_page') ?>
Pengaturan System
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12 col-md-6">
        <div class="card shadow">
            <form method="POST" id="form-payment" class="card-body">
                <h6 class="mb-3">Payment Channel</h6>
                <table class="table">
                    <tbody>
                        <?php foreach ($payment as $iPayment) : ?>
                            <tr>
                                <td><?= $iPayment['name'] ?></td>
                                <td>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input bank-checkbox" id="bank<?= $iPayment['channel_code'] ?>" name="bank[]" value="<?= $iPayment['channel_code'] ?>" <?= in_array($iPayment['channel_code'], $local_payment) ? 'checked' : '' ?>>
                                        <label class="custom-control-label" for="bank<?= $iPayment['channel_code'] ?>" style="cursor: pointer;"></label>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="form-group text-center">
                    <input type="submit" value="Save" class="btn btn-primary col-12 col-md-6">
                </div>
            </form>
        </div>
    </div>
    <div class="col-12 col-md-6 mt-4 mt-md-0">
        <div class="card shadow">
            <form method="POST" id="form-api" class="card-body">
                <h6>API Settings</h6>
                <hr>
                <div class="form-group">
                    <label for="">Xendit API Key</label>
                    <input type="text" name="xendit_api_key" id="" class="form-control" placeholder="Xendit Api Key" value="<?= isset($api_setting->xendit_api_key) ? $api_setting->xendit_api_key : '' ?>">
                </div>
                <div class="form-group">
                    <label for="">Xendit Webhook</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Xendit Webhook" value="<?= base_url('admin/api/confirm-payment') ?>" id="xendit_webhook">
                        <div class="input-group-append">
                            <button class="btn btn-secondary" type="button" onclick="copyToClipboard('#xendit_webhook')"><i class="fe fe-clipboard"></i></button>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="form-group">
                    <label for="">Whatsapp API Key</label>
                    <input type="text" name="wa_api_key" id="" class="form-control" placeholder="Whatsapp API Key" value="<?= isset($api_setting->wa_api_key) ? $api_setting->wa_api_key : '' ?>">
                </div>
                <div class="form-group">
                    <label for="">Whatsapp Sender Number</label>
                    <input type="text" name="wa_number" id="" class="form-control" placeholder="Whatsapp Sender Number" value="<?= isset($api_setting->wa_number) ? $api_setting->wa_number : '' ?>">
                </div>
                <div class="form-group">
                    <label for="">Whatsapp Webhook</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Whatsapp Webhook" value="<?= base_url('admin/api/transaction-confirm') ?>" id="wa_webhook">
                        <div class="input-group-append">
                            <button class="btn btn-secondary" type="button" onclick="copyToClipboard('#wa_webhook')"><i class="fe fe-clipboard"></i></button>
                        </div>
                    </div>
                </div>
                <div class="form-group text-center">
                    <input type="submit" value="Save" class="btn btn-primary col-12 col-md-6">
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('footer'); ?>
<script>
    $("#form-payment").on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: window.api_url + 'system-payment-channel-store',
            type: 'POST',
            data: new FormData(this),
            processData: false,
            cache: false,
            contentType: false,
            dataType: 'json',
            success: function(res) {
                if (res.status == 200) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        showConfirmButton: false,
                        timer: 1000
                    });
                }
            }
        })
    });

    $("#form-api").on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: window.api_url + 'system-api-setting-store',
            type: 'POST',
            data: new FormData(this),
            processData: false,
            cache: false,
            contentType: false,
            dataType: 'json',
            success: function(res) {
                if (res.status == 200) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        showConfirmButton: false,
                        timer: 1000
                    });
                }
            }
        })
    });

    function copyToClipboard(element) {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(element).val()).select();
        document.execCommand("copy");
        $temp.remove();
    }
</script>
<?= $this->endSection() ?>