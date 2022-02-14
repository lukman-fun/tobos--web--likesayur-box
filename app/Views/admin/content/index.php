<?= $this->extend('admin/template/app') ?>

<?= $this->section('title') ?>
Management Content
<?= $this->endSection() ?>

<?= $this->section('name_page') ?>
Management Content
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header">
                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalContent" data-backdrop="static"><i class="fe fe-plus mr-2"></i> Add Data</button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover datatable">
                        <thead class="font-weight-bold text-center">
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Sub Title</th>
                                <th>Image</th>
                                <th>Total Items</th>
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
<!-- Modal -->
<div class="modal fade" id="modalContent" tabindex="-1" role="dialog" aria-labelledby="modaltitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form class="modal-content" id="form-content" method="POST" enctype="multipart/form-data">
            <div class="modal-header">
                <h5 class="modal-title" id="modaltitle">Form Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="onModalReset()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="alert-error"></div>
                <div class="form-group">
                    <span>
                        <i class="fe fe-x fe-16 text-white bg-danger position-absolute d-none" id="img-reset" style="padding: 5px; border-radius: 1000px; cursor: pointer;"></i>
                        <label for="img-upload" class="d-flex" style="height: 120px; width: 100%; background-color: #f6f6f6; border-radius: 8px; cursor: pointer; border: 2px dashed #DDDDDD;">
                            <span style="height: 120px; width: 100%;" class="d-flex justify-content-center align-items-center font-weight-bold">Upload Your Image</span>
                            <img src="" alt="Image Slider" onerror="this.className='d-none'" id="img-preview" style="height: 120px; width: 100%; border-radius: 8px;">
                        </label>
                    </span>
                    <input type="hidden" name="type" value="add">
                    <input type="file" name="image" accept="image/*" id="img-upload" class="form-control d-none" onchange="onUploadImage(this)">
                </div>
                <div class="form-group">
                    <label for="">Title</label>
                    <input type="text" name="title" class="form-control" placeholder="Enter Title" required>
                </div>
                <div class="form-group">
                    <label for="">Sub Title</label>
                    <input type="text" name="sub_title" class="form-control" placeholder="Enter Sub Title" required>
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
    var modalContent = $("#modalContent");
    var type = $(".modal-body input[name='type']");
    var fileImg = $(".modal-body input[name='image']")
    var title = $(".modal-body input[name='title']");
    var sub_title = $(".modal-body input[name='sub_title']");
    var btnSave = $(".modal-footer button[type='submit']");
    var btnCancel = $(".modal-footer button[type='button']");
    var btnClose = $(".modal-header button[type='button']");

    var table = $(".datatable").DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: window.api_url + '/content-get/all',
        order: [
            [3, 'desc']
        ],
        columns: [{
                data: "no",
                orderable: false
            },
            {
                data: "title"
            },
            {
                data: "sub_title"
            },
            {
                data: "image"
            },
            {
                data: "total_items"
            },
            {
                data: "action"
            },
        ]
    });

    function onUploadImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $("#img-preview").attr('src', e.target.result).removeClass('d-none');
                $("#img-reset").removeClass('d-none');
                $("label[for='img-upload'] span").removeClass('d-flex').addClass('d-none');
                $("label[for='img-upload']").css({
                    'border': ''
                });
            }
            reader.readAsDataURL(input.files[0])
        }
    }

    $("#img-reset").click(function(e) {
        e.preventDefault();
        $("#img-preview").attr('src', '').addClass('d-none');
        $(this).val('');
        $("label[for='img-upload'] span").removeClass('d-none').addClass('d-flex');
        $("label[for='img-upload']").css({
            'border': '2px dashed #DDDDDD'
        });
        $(this).addClass("d-none");
    });

    $("#form-content").on('submit', function(e) {
        e.preventDefault();
        btnClose.attr('data-dismiss', '')
        btnCancel.prop('disabled', true);
        btnSave.text('Saving...').prop('disabled', true);
        $.ajax({
            url: (type.val() == 'add') ? window.api_url + 'content-store' : window.api_url + 'content-update/' + type.val(),
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
                    modalContent.modal('hide');
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
    })

    function onEdit(id) {
        $.ajax({
            url: window.api_url + 'content-get/' + id,
            success: function(res) {
                if (res.status == 200) {
                    const data = res.data;
                    type.val(data.id);
                    $("#img-preview").attr('src', window.base_url + '/' + data.image).removeClass('d-none');
                    $("label[for='img-upload'] span").removeClass('d-flex').addClass('d-none');
                    $("label[for='img-upload']").css({
                        'border': ''
                    });
                    title.val(data.title);
                    sub_title.val(data.sub_title);
                    modalContent.modal({
                        backdrop: 'static'
                    });
                } else {
                    console.log('Data Kosong');
                }
            }
        });
    }

    function onDelete(id) {
        Swal.fire({
            icon: 'question',
            text: 'Are you sure want to delete this data?',
            showCancelButton: true,
        }).then((confirm) => {
            if (confirm.isConfirmed) {
                $.ajax({
                    url: window.api_url + 'content-delete/' + id,
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
        $("#img-reset").click();
        $("#form-content")[0].reset();
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