<?= $this->extend('admin/template/app') ?>

<?= $this->section('title') ?>
Management Waktu Pengiriman
<?= $this->endSection() ?>

<?= $this->section('name_page') ?>
Management Waktu Pengiriman
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header">
                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalWaktu"><i class="fe fe-plus mr-2"></i> Add Data</button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover datatable">
                        <thead class="font-weight-bold text-center">
                            <tr>
                                <th>#</th>
                                <th>Waktu</th>
                                <th>Start</th>
                                <th>End</th>
                                <th>Timezone</th>
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
<div class="modal fade" id="modalWaktu" tabindex="-1" role="dialog" aria-labelledby="modaltitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form class="modal-content" id="form-waktu" method="POST">
            <div class="modal-header">
                <h5 class="modal-title" id="modaltitle">Form Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="onModalReset()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="alert-error"></div>
                <div class="row">
                    <div class="form-group col-12 col-md-6">
                        <label for="">Waktu</label>
                        <input type="text" name="type" value="add" hidden>
                        <input type="text" name="name" class="form-control" placeholder="Enter Waktu" required>
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label for="">Zona Waktu</label>
                        <input type="text" name="timezone" class="form-control" placeholder="Enter TimeZone (Ex: WIB)" required>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-12 col-md-6">
                        <label for="">Start</label>
                        <input type="time" name="start" class="form-control" placeholder="Enter Start" required>
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label for="">End</label>
                        <input type="time" name="end" class="form-control" placeholder="Enter End" required>
                    </div>
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
<script type="text/javascript">
    var modalWaktu = $("#modalWaktu");
    var type = $(".modal-body input[name='type']");
    var nama = $(".modal-body input[name='name']");
    var start = $(".modal-body input[name='start']");
    var end = $(".modal-body input[name='end']");
    var timezone = $(".modal-body input[name='timezone']");
    var btnSave = $(".modal-footer button[type='submit']");
    var btnCancel = $(".modal-footer button[type='button']");
    var btnClose = $(".modal-header button[type='button']");

    var table = $(".datatable").DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: window.api_url + 'waktu-get/all',
        order: [
            [1, 'desc']
        ],
        columns: [{
                data: "no",
                orderable: false
            },
            {
                data: "name"
            },
            {
                data: "start"
            },
            {
                data: "end"
            },
            {
                data: "timezone"
            },
            {
                data: "action"
            },
        ]
    });

    $("#form-waktu").on('submit', function(e) {
        e.preventDefault();
        btnClose.attr('data-dismiss', '')
        btnCancel.prop('disabled', true);
        btnSave.text('Saving...').prop('disabled', true);
        $.ajax({
            url: (type.val() == 'add') ? window.api_url + 'waktu-store' : window.api_url + 'waktu-update/' + type.val(),
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function(res) {
                // alert(JSON.stringify(res))
                if (res.status == 200) {
                    onModalReset();
                    modalWaktu.modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        showConfirmButton: false,
                        timer: 1000
                    });
                    table.ajax.reload();
                } else {
                    alert_error(res.errors);
                }
                btnClose.attr('data-dismiss', 'modal')
                btnCancel.prop('disabled', false);
                btnSave.text('Save').prop('disabled', false);
            }
        })
    });

    function onEdit(id) {
        $.ajax({
            url: window.api_url + 'waktu-get/' + id,
            success: function(res) {
                // alert(JSON.stringify(res));
                if (res.status == 200) {
                    const data = res.data;
                    type.val(data.id);
                    nama.val(data.name);
                    start.val(data.start);
                    end.val(data.end);
                    timezone.val(data.timezone);
                    modalWaktu.modal({
                        backdrop: 'static'
                    });
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
                    url: window.api_url + 'waktu-delete/' + id,
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
        $("#form-waktu")[0].reset();
        type.val('add');
        $("#alert-error").html('')
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