<?= $this->extend('admin/template/app') ?>

<?= $this->section('title') ?>
Management Transaction
<?= $this->endSection() ?>

<?= $this->section('style') ?>
<style>
    .bg-kurir {
        cursor: pointer;
        transition: .3s;
    }

    .bg-kurir:hover {
        background-color: #47b04a4b;
        color: white;
    }

    .bg-kurir.active {
        background-color: #47b04a77;
        color: white;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('name_page') ?>
Management Transaction
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover datatable">
                        <thead class="font-weight-bold text-center">
                            <tr>
                                <th>#</th>
                                <th>No. Transaction</th>
                                <th>User Fullname</th>
                                <th>Process</th>
                                <th>Status</th>
                                <th>Kurir</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Kurir -->
<div class="modal fade" id="modalTransaction" tabindex="-1" role="dialog" aria-labelledby="modaltitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form class="modal-content" id="form-transaction" method="POST">
            <div class="modal-header">
                <h5 class="modal-title" id="modaltitle">Form Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="onModalReset()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="alert-error"></div>
                <div class="row">
                    <input type="hidden" name="transaction_id" id="">
                    <input type="hidden" name="kurir_id" id="">
                    <?php foreach ($kurir as $i => $iKurir) : ?>
                        <div class="col-6 mb-3">
                            <div class="card bg-kurir shadow" data-kurir_position="<?= $i ?>" data-kurir_id="<?= $iKurir['id'] ?>">
                                <div class="card-body">
                                    <span class="d-block"><?= $iKurir['fullname'] ?></span>
                                    <span class="d-block"><?= $iKurir['phone'] ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="onModalReset()">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Status -->
<div class="modal fade" id="modalData" tabindex="-1" role="dialog" aria-labelledby="modaltitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
        <form class="modal-content" id="form-data" method="POST">
            <div class="modal-header">
                <h5 class="modal-title" id="modaltitle">Form Data</h5>
                <button type="button" class="close data-dismiss-data" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body overflow-auto">
                <div id="alert-error"></div>
                <div class="row">
                    <div class="col-12 col-md-6 mb-3">
                        <div class="card shadow">
                            <div class="card-header">
                                Data Pengiriman
                            </div>
                            <div class="card-body">
                                <input type="hidden" name="transaction_id">
                                <table>
                                    <tr>
                                        <td class="col-2">Fullname</td>
                                        <td>:</td>
                                        <td class="font-weight-bold" id="fullname"></td>
                                    </tr>
                                    <tr>
                                        <td class="col-2">Address</td>
                                        <td>:</td>
                                        <td class="font-weight-bold" id="address"></td>
                                    </tr>
                                    <tr>
                                        <td class="col-2">Phone</td>
                                        <td>:</td>
                                        <td class="font-weight-bold" id="phone"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            <hr>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-2">Waktu</td>
                                        <td>:</td>
                                        <td class="font-weight-bold" id="waktu"></td>
                                    </tr>
                                    <tr>
                                        <td class="col-2">Catatan</td>
                                        <td>:</td>
                                        <td class="font-weight-bold" id="catatan"></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <div class="card shadow">
                            <div class="card-header">
                                Data Pesanan
                            </div>
                            <div class="card-body data-pesanan">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="">Proses Pengiriman</label>
                                    <select name="process" id="" class="form-control">
                                        <option value="0">Menunggu Pembayaran</option>
                                        <option value="1">Pesanan Dikemas</option>
                                        <option value="2">Pesanan Dikirim</option>
                                        <option value="3">Pesanan Diterima</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="">Status Pengiriman</label>
                                    <select name="status" id="" class="form-control">
                                        <option value="0">Proses</option>
                                        <option value="1">Selesai</option>
                                        <option value="-1">Batal</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-close-data" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary btn-save-data">Save</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('footer') ?>
<script>
    // $("#modalData").modal({
    //         backdrop: 'static'
    //     });
    var modalTransaction = $("#modalTransaction");
    var btnSave = $(".modal-footer button[type='submit']");
    var btnCancel = $(".modal-footer button[type='button']");
    var btnClose = $(".modal-header button[type='button']");

    var table = $(".datatable").DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: window.api_url + '/transaction-get/all',
        order: [
            [3, 'desc']
        ],
        columns: [{
                data: "no",
                orderable: false
            },
            {
                data: "no_transaction"
            },
            {
                data: "userName"
            },
            {
                data: "process"
            },
            {
                data: "status"
            },
            {
                data: "kurir"
            },
            {
                data: "total"
            },
            {
                data: "action"
            },
        ]
    });


    $("#form-transaction").on('submit', function(e) {
        e.preventDefault();
        btnClose.attr('data-dismiss', '')
        btnCancel.prop('disabled', true);
        btnSave.text('Saving...').prop('disabled', true);
        if ($("input[name='kurir_id']").val() == '') {
            alert_error({
                "kurir": "Anda Belum Memilih Kurir"
            });
            btnClose.attr('data-dismiss', 'modal')
            btnCancel.prop('disabled', false);
            btnSave.text('Save').prop('disabled', false);
        } else {
            $.ajax({
                url: window.api_url + 'transaction-kurir',
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'json',
                success: function(res) {
                    if (res.status == 200) {
                        onModalReset();
                        modalTransaction.modal('hide');
                        Swal.fire({
                            title: 'Success!',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 1000
                        })
                        table.ajax.reload();
                    } else {
                        alert_error(res.errors);
                    }
                    btnClose.attr('data-dismiss', 'modal')
                    btnCancel.prop('disabled', false);
                    btnSave.text('Save').prop('disabled', false);
                }
            });
        }
    });



    function onDelete(id) {
        Swal.fire({
            icon: 'question',
            text: 'Are you sure want to delete this data?',
            showCancelButton: true,
        }).then((confirm) => {
            if (confirm.isConfirmed) {
                $.ajax({
                    url: window.api_url + 'transaction-delete/' + id,
                    success: function(res) {
                        // JSON.stringify(res)
                        if (res.status == 200) {
                            Swal.fire({
                                title: 'Success!',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 1000
                            })
                            table.ajax.reload();
                        }
                    }
                })

            }
        })
    }

    function onKurir(id) {
        $("input[name='transaction_id']").val(id);
        modalTransaction.modal({
            backdrop: 'static'
        });
    }

    function onModalReset() {
        for (var i = 0; i < $(".bg-kurir").length; i++) {
            $("div[data-kurir_position='" + i + "']").removeClass('active');
        }
        $("input[name='kurir_id']").val('');
    }

    function alert_error(errors) {
        var data_error = '';
        $.each(errors, function(i, v) {
            data_error += `<li>${v}</li>`;
        })

        $("#alert-error").html(`<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="m-0">
                    ${data_error}
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>`)
    }


    // KURIR
    $(".bg-kurir").click(function(e) {
        e.preventDefault();
        for (var i = 0; i < $(".bg-kurir").length; i++) {
            if ($("div[data-kurir_position='" + i + "']").data('kurir_id') == $(this).data('kurir_id')) {
                $("div[data-kurir_position='" + i + "']").addClass('active');
            } else {
                $("div[data-kurir_position='" + i + "']").removeClass('active');
            }
        }
        $("input[name='kurir_id']").val($(this).data('kurir_id'));
    });

    var modalData = $("#modalData");
    var btnSaveData = $(".modal-footer button[type='submit']");
    var btnCancelData = $(".modal-footer button[type='button']");
    var btnCloseData = $(".modal-header button[type='button']");

    function onDataView(c) {
        const deliv = JSON.parse(atob($(c).data('delivery')));
        $("input[name='transaction_id']").val($(c).data('transaction_id'));
        $("#fullname").text(deliv.fullname);
        $("#address").text(deliv.address);
        $("#phone").text(deliv.phone);
        $("#waktu").text(deliv.waktu);
        $("#catatan").text(deliv.catatan);

        $.ajax({
            url: window.api_url + 'transaction-pesanan/' + $(c).data('transaction_id'),
            type: 'GET',
            success: function(res) {
                if (res.status == 200) {
                    $(".data-pesanan").html('');
                    var total = 0;
                    $.each(res.data, function(i, v) {
                        $(".data-pesanan").append(`<div class="d-flex justify-content-between align-items-center">
                                    <span class="d-flex flex-column">
                                        <span class="font-weight-bold">${ v.product_data.product_name }</span>
                                        <span class="text-base">Rp. ${ v.product_data.product_price }</span>
                                    </span>
                                    <span>x ${ v.qty }</span>
                                </div>
                                <hr>`);
                        total += (v.product_data.product_price * v.qty);
                    });
                    $(".data-pesanan").append(`<div class="font-weight-bold text-center">Total : <span class="text-base">Rp. ${ total }</span></div>`);
                }
            }
        });

        $("select[name='process']").val($(c).data('proses'));
        $("select[name='status']").val($(c).data('status'));
        modalData.modal({
            backdrop: 'static'
        })
    }


    $("#form-data").on('submit', function(e) {
        e.preventDefault();
        btnCloseData.attr('data-dismiss', '')
        btnCancelData.prop('disabled', true);
        btnSaveData.text('Saving...').prop('disabled', true);
        $.ajax({
            url: window.api_url + 'transaction-pesanan',
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function(res) {
                if (res.status == 200) {
                    modalData.modal('hide');
                    Swal.fire({
                        title: 'Success!',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 1000
                    })
                    table.ajax.reload();
                } else {
                    alert_error(res.errors);
                }
                btnCloseData.attr('data-dismiss', 'modal')
                btnCancelData.prop('disabled', false);
                btnSaveData.text('Save').prop('disabled', false);
            }
        });
    });

    function onKurirStatus(msg, nmr, sts) {
        Swal.fire({
            icon: 'question',
            text: sts == '1' ? 'Are you sure you want to approve this courier?' : 'Are you sure you want to reject this courier?',
            showCancelButton: true,
            confirmButtonColor: sts == '1' ? '#47B04B' : '#dc3545',
            confirmButtonText: sts == '1' ? 'Approve Courier' : 'Reject Courier'
        }).then((confirm) => {
            if (confirm.isConfirmed) {
                $.ajax({
                    url: window.api_url + 'transaction-confirm',
                    type: 'POST',
                    data: JSON.stringify({
                        "from" : nmr,
                        "message" : msg
                    }),
                    dataType: 'json',
                    success: function(res) {
                        if (res.status == 200) {
                            Swal.fire({
                                title: 'Success!',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 1000
                            })
                            table.ajax.reload();
                        }
                    }
                })
            }
        })
    }
</script>
<?= $this->endSection() ?>