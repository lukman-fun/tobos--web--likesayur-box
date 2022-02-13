<?= $this->extend('admin/template/app') ?>

<?= $this->section('title') ?>
Management Product
<?= $this->endSection() ?>

<?= $this->section('name_page') ?>
Management Product
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header">
                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalProduct"><i class="fe fe-plus mr-2"></i> Add Data</button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover datatable">
                        <thead class="font-weight-bold text-center">
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Category</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Price -> Discon</th>
                                <th>Price</th>
                                <th>Max.Buy -> Diskon</th>
                                <th>Stock</th>
                                <th>Satuan</th>
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
<div class="modal fade" id="modalProduct" tabindex="-1" role="dialog" aria-labelledby="modaltitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <form class="modal-content" id="form-product" method="POST" enctype="multipart/form-data">
            <div class="modal-header">
                <h5 class="modal-title" id="modaltitle">Form Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="onModalReset()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="alert-error"></div>
                <div class="form-group text-center">
                    <span>
                        <i class="fe fe-x fe-16 text-white bg-danger position-absolute d-none" id="img-reset" style="padding: 5px; border-radius: 1000px; cursor: pointer;"></i>
                        <label for="img-upload" style="width: 80px; height: 80px; cursor: pointer; background-color: #f6f6f6; border: 2px dashed #DDDDDD;" class="rounded-lg">
                            <img src="" onerror="this.className='d-none'" alt="Image Product" id="img-preview" style="width: 80px; height: 80px;" class="rounded-lg">
                        </label>
                    </span>
                    <input type="hidden" name="type" value="add">
                    <input type="file" accept="image/*" name="image" id="img-upload" class="form-control d-none" onchange="onUploadImage(this)">
                </div>
                <div class="row">
                    <div class="form-group col-12 col-md-6">
                        <label for="">Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter Name" required>
                    </div>
                    <div class="form-group col-12 col-md-4">
                        <label for="">Category</label>
                        <select name="category_id" id="" class="form-control">
                        </select>
                    </div>
                    <div class="form-group col-12 col-md-2">
                        <label for="">Satuan</label>
                        <input type="text" name="per" id="" class="form-control" placeholder="Enter Satuan" required>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-12 col-md-4">
                        <label for="">Description</label>
                        <input type="text" name="description" class="form-control" placeholder="Enter Description" required>
                    </div>
                    <div class="form-group col-12 col-md-2">
                        <label for="">Price</label>
                        <input type="number" name="price" class="form-control" placeholder="Enter Price" required>
                    </div>
                    <div class="form-group col-12 col-md-2">
                        <label for="">Discon</label>
                        <input type="text" name="discon" class="form-control" placeholder="Enter Discon">
                    </div>
                    <div class="form-group col-12 col-md-2">
                        <label for="">Max Buy</label>
                        <input type="number" name="max_buy_discon" class="form-control" placeholder="Enter Max Buy Discon">
                    </div>
                    <div class="form-group col-12 col-md-2">
                        <label for="">Stock</label>
                        <input type="number" name="stock" class="form-control" placeholder="Enter Stock" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Product Information</label>
                    <textarea name="information[product_information]" class="form-control" placeholder="Enter Product Information" required></textarea>
                </div>
                <div class="form-group">
                    <label for="">Nutrition and Benefits</label>
                    <textarea name="information[nutrition_and_benefits]" class="form-control" placeholder="Enter Nutrition and Benefits" required></textarea>
                </div>
                <div class="form-group">
                    <label for="">How to Save</label>
                    <textarea name="information[how_to_save]" class="form-control" placeholder="Enter How to Save" required></textarea>
                </div>
                <div class="form-group">
                    <label for="">Farmers and Suppliers</label>
                    <!-- <textarea name="information[farmers_and_suppliers]" class="form-control" placeholder="Enter Farmers and Suppliers" required></textarea> -->
                    <select name="information[farmers_and_suppliers][]" id="" class="form-control" multiple="multiple">
                        <!-- <option>Man</option>
                        <option>Mun</option>
                        <option>Mas</option> -->
                        <?php foreach($supplier as $iSupplier): ?>
                            <option value="<?= $iSupplier['id'] ?>"><?= $iSupplier['name'] ?></option>
                        <?php endforeach ?>
                    </select>
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
    var modalProduct = $("#modalProduct");
    var type = $(".modal-body input[name='type']");
    var fileImg = $(".modal-body input[name='image']")
    var nama = $(".modal-body input[name='name']");
    var category_id = $(".modal-body select[name='category_id']");
    var description = $(".modal-body input[name='description']");
    var price = $(".modal-body input[name='price']");
    var discon = $(".modal-body input[name='discon']");
    var max_buy_discon = $(".modal-body input[name='max_buy_discon']");
    var stock = $(".modal-body input[name='stock']");
    var product_information = $(".modal-body textarea[name='information[product_information]']");
    var nutrition_and_benefits = $(".modal-body textarea[name='information[nutrition_and_benefits]']");
    var how_to_save = $(".modal-body textarea[name='information[how_to_save]']");
    var farmers_and_suppliers = $(".modal-body select[name='information[farmers_and_suppliers][]']");
    var satuan = $(".modal-body input[name='per']");
    var btnSave = $(".modal-footer button[type='submit']");
    var btnCancel = $(".modal-footer button[type='button']");
    var btnClose = $(".modal-header button[type='button']");

    var table = $(".datatable").DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: window.api_url + 'product-get/all',
        order: [
            [1, 'desc']
        ],
        columns: [{
                data: "no",
                orderable: false
            },
            {
                data: "image"
            },
            {
                data: "ctgName"
            },
            {
                data: "name"
            },
            {
                data: "description"
            },
            {
                data: "discon"
            },
            {
                data: "price"
            },
            {
                data: "max_buy_discon"
            },
            {
                data: "stock"
            },
            {
                data: "per"
            },
            {
                data: "action"
            }
        ]
    });

    function getCategory() {
        $.ajax({
            url: window.api_url + 'product-category',
            success: function(res) {
                if (res.status == 200) {
                    $.each(res.data, function(i, v) {
                        category_id.append(`<option value="${v.id}">${v.name}</option>`);
                    });
                } else {
                    console.log("Category Kosong");
                }
            }
        });
    }

    getCategory();

    stock.parent().removeClass('col-md-2').addClass('col-md-4');
    max_buy_discon.parent().addClass('d-none')
    discon.keyup(function(e) {
        e.preventDefault();
        if (discon.val().replace('%', '') != '' && discon.val().replace('%', '') != '0') {
            max_buy_discon.parent().removeClass('d-none');
            stock.parent().removeClass('col-md-4').addClass('col-md-2');
        } else {
            max_buy_discon.parent().addClass('d-none');
            max_buy_discon.val('');
            stock.parent().removeClass('col-md-2').addClass('col-md-4');
        }
    })

    farmers_and_suppliers.select2({
        placeholder: "Select Farmers and Suppliers",
        allowClear: true
    });

    function onUploadImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $("#img-preview").attr('src', e.target.result).removeClass('d-none');
                $("#img-reset").removeClass('d-none');
                $("label[for='img-upload']").css({
                    'border': ''
                });
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#img-reset").click(function(e) {
        e.preventDefault();
        $("#img-preview").attr('src', '').addClass('d-none');
        $(this).addClass('d-none');
        $("label[for='img-upload']").css({
            'border': '2px dashed #DDDDDD'
        });
        fileImg.val('');
    });

    $("#form-product").on('submit', function(e) {
        e.preventDefault();
        btnClose.attr('data-dismiss', '');
        btnCancel.prop('disabled', true);
        btnSave.text('Saving...').prop('disabled', true);
        $.ajax({
            url: (type.val() == 'add') ? window.api_url + 'product-store' : window.api_url + 'product-update/' + type.val(),
            type: 'POST',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function(res) {
                // alert(JSON.stringify(res));
                if (res.status == 200) {
                    onModalReset();
                    modalProduct.modal('hide');
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
            url: window.api_url + 'product-get/' + id,
            success: function(res) {
                if (res.status == 200) {
                    const data = res.data;
                    type.val(data.id);
                    $("#img-preview").attr('src', window.base_url + '/' + data.image).removeClass('d-none');
                    $("label[for='img-upload']").css({
                        'border': ''
                    });
                    nama.val(data.name);
                    category_id.val(data.category_id);
                    description.val(data.description);
                    price.val(data.price);
                    discon.val(data.discon);
                    if (discon.val().replace('%', '') != '' && discon.val().replace('%', '') != '0') {
                        max_buy_discon.parent().removeClass('d-none');
                        stock.parent().removeClass('col-md-4').addClass('col-md-2');
                    } else {
                        max_buy_discon.parent().addClass('d-none');
                        max_buy_discon.val('');
                        stock.parent().removeClass('col-md-2').addClass('col-md-4');
                    }
                    max_buy_discon.val(data.max_buy_discon);
                    stock.val(data.stock);
                    satuan.val(data.per);

                    const information = JSON.parse(data.information);
                    product_information.val(information.product_information);
                    nutrition_and_benefits.val(information.nutrition_and_benefits);
                    how_to_save.val(information.how_to_save);

                    farmers_and_suppliers.select2('val', [information.farmers_and_suppliers]);
                    // alert(JSON.stringify(information.farmers_and_suppliers));
                    modalProduct.modal({
                        backdrop: 'static'
                    });
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
                    url: window.api_url + 'product-delete/' + id,
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
        $("#form-product")[0].reset();
        type.val('add');
        $("#alert-error").html('')
        farmers_and_suppliers.select2('val', ['']);
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