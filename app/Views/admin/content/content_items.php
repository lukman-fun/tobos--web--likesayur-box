<?= $this->extend('admin/template/app') ?>

<?= $this->section('title') ?>
Management Cotent Items
<?= $this->endSection() ?>

<?= $this->section('name_page') ?>
Management Cotent Items
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-body">
                <ul class="nav nav-tabs mb-3" id="tabCategory" role="tablist">
                    <!-- <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Contact</a>
                    </li> -->
                </ul>
                <div class="table-responsive">
                    <table class="table table-striped table-hover datatable">
                        <thead class="font-weight-bold text-center">
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Category</th>
                                <th>Name</th>
                                <th>Price -> Discon</th>
                                <th>Price</th>
                                <th>Max.Buy -> Diskon</th>
                                <th>Stock</th>
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

<?= $this->endSection() ?>

<?= $this->section('footer') ?>
<script>
    function table(category_id) {
        $(".datatable").DataTable({
            destroy: true,
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: window.api_url + 'content-items/<?= $catalog_id ?>/' + category_id,
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
                    data: "action"
                }
            ]
        });
    }

    function getCategory() {
        $.ajax({
            url: window.api_url + 'product-category',
            success: function(res) {
                if (res.status == 200) {
                    $.each(res.data, function(i, v) {
                        $("#tabCategory").append(`<li class="nav-item">
                            <a class="nav-link ${ (i == 0 ? 'active' : '') }" id="${v.slug}-tab" data-toggle="tab" href="#${v.slug}" role="tab" aria-controls="${v.slug}" aria-selected="${ (i == 0 ? 'true' : 'false') }" onclick="table('${v.id}')">${v.name}</a>
                        </li>`);
                    });

                    if (res.data.length > 0) {
                        table(res.data[0].id);
                    }
                } else {
                    console.log("Category Kosong");
                }
            }
        });
    }

    getCategory();

    function onPilih(e) {
        $.ajax({
            url: window.api_url + 'content-items-update/<?= $catalog_id ?>/' + $(e).val(),
            success: function(res) {
                // alert(JSON.stringify(res));
                if (res.status == 200) {
                    // alert(1);
                    Swal.fire({
                        title: 'Success!',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 1000
                    })
                }
            }
        });
    }
</script>
<?= $this->endSection() ?>