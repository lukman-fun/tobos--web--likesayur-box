<?= $this->extend('admin/template/app') ?>

<?= $this->section('title') ?>
Pengaturan Profile
<?= $this->endSection() ?>

<?= $this->section('name_page') ?>
Pengaturan Profile
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <form method="POST" id="form-profile" class="card-body">
                <div class="form-group">
                    <label for="">Fullname</label>
                    <input type="text" name="fullname" id="" class="form-control" placeholder="Enter Fullname" required>
                </div>
                <div class="form-group">
                    <label for="">Email</label>
                    <input type="email" name="email" id="" class="form-control" placeholder="Enter Email" required>
                </div>
                <div class="form-group">
                    <label for="">Password (Optional)</label>
                    <input type="text" name="password" id="" class="form-control" placeholder="Enter Password">
                </div>
                <div class="form-group text-center">
                    <input type="submit" class="btn btn-primary" value="Save">
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('footer') ?>
<script>
    var fullname = $("input[name='fullname']");
    var email = $("input[name='email']");
    var password = $("input[name='password']");

    $.ajax({
        url: window.api_url + 'profile-get',
        type: 'GET',
        success: function(res){
            if(res.status == 200){
                const data = res.data;
                fullname.val(data.fullname);
                email.val(data.email);
            }
        }
    });

    $("#form-profile").on('submit', function(e){
        e.preventDefault();
        $.ajax({
            url: window.api_url + 'profile-update',
            type: 'POST',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function(res){
                if(res.status == 200){
                    Swal.fire({
                        title: 'Success!',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 1000
                    })
                    fullname.val(res.data.fullname);
                    email.val(res.data.email);
                    password.val('');
                }
            }
        })
    })
</script>
<?= $this->endSection() ?>