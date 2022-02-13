<?= $this->extend('admin/template/app') ?>

<?= $this->section('title') ?>
Pengaturan Kurir
<?= $this->endSection() ?>

<?= $this->section('name_page') ?>
Pengaturan Kurir
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header">
                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalKurir" data-backdrop="static"><i class="fe fe-plus mr-2"></i> Add Data</button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover datatable">
                        <thead class="font-weight-bold text-center">
                            <tr>
                                <th>#</th>
                                <th>Fullname</th>
                                <th>Phone</th>
                                <th>Address</th>
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

<!-- Modal -->
<div class="modal fade" id="modalKurir" tabindex="-1" role="dialog" aria-labelledby="modaltitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form class="modal-content" id="form-kurir" method="POST">
            <div class="modal-header">
                <h5 class="modal-title" id="modaltitle">Form Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="onModalReset()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="alert-error"></div>
                <div class="form-group">
                    <label for="">Full Name</label>
                    <input type="hidden" name="type" value="add">
                    <input type="text" name="fullname" class="form-control" placeholder="Enter Full Name" required>
                </div>
                <div class="form-group">
                    <label for="">Phone</label>
                    <input type="text" name="phone" class="form-control" placeholder="Enter Phone" required>
                </div>
                <div class="form-group">
                    <label for="">Address</label>
                    <input type="text" name="address" class="form-control" placeholder="Enter Address" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="onModalReset()">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('footer') ?>
<script>
    var modalKurir = $("#modalKurir");
    var type = $(".modal-body input[name='type']");
    var fullname = $(".modal-body input[name='fullname']");
    var address = $(".modal-body input[name='address']");
    var phone = $(".modal-body input[name='phone']");
    var btnSave = $(".modal-footer button[type='submit']");
    var btnCancel = $(".modal-footer button[type='button']");
    var btnClose = $(".modal-header button[type='button']");

    var table = $(".datatable").DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: window.api_url + '/kurir-get/all',
        order: [
            [3, 'desc']
        ],
        columns: [{
                data: "no",
                orderable: false
            },
            {
                data: "fullname"
            },
            {
                data: "phone"
            },
            {
                data: "address"
            },
            {
                data: "action"
            },
        ]
    });


    $("#form-kurir").on('submit', function(e) {
        e.preventDefault();
        btnClose.attr('data-dismiss', '')
        btnCancel.prop('disabled', true);
        btnSave.text('Saving...').prop('disabled', true);
        $.ajax({
            url: (type.val() == 'add') ? window.api_url + 'kurir-store' : window.api_url + 'kurir-update/' + type.val(),
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function(res) {
                if (res.status == 200) {
                    onModalReset();
                    modalKurir.modal('hide');
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
    });

    function onEdit(id) {
        // $("#modalUsers").modal({backdrop: 'static'});
        $.ajax({
            url: window.api_url + 'kurir-get/' + id,
            type: "GET",
            success: function(res) {
                if (res.status == 200) {
                    const data = res.data;
                    type.val(data.id);
                    fullname.val(data.fullname);
                    phone.val(data.phone);
                    address.val(data.address);
                    modalKurir.modal({
                        backdrop: 'static'
                    });
                    // alert(JSON.stringify(data))
                } else {
                    alert(JSON.stringify(res))
                }
            }
        })
    }

    function onDelete(id) {
        Swal.fire({
            icon: 'question',
            text: 'Are you sure want to delete this data?',
            showCancelButton: true,
        }).then((confirm) => {
            if (confirm.isConfirmed) {
                $.ajax({
                    url: window.api_url + 'kurir-delete/' + id,
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

    function onModalReset() {
        $("#form-kurir")[0].reset();
        type.val('add');
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
</script>
<?= $this->endSection() ?>