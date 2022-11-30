<div class="register-box">
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="#" class="h1"><b><?= $title ?></b></a>
        </div>
        <div class="card-body col-lg">
            <p class="login-box-msg">Register new Membership</p>

            <form action="<?= base_url('auth/register') ?>" method="post">
                <div class="form-group mb-3">
                    <input type="text" id="name" name="name" class="form-control" placeholder="Full name">
                    <?= form_error('name', '<small class ="text-danger pl-3">', '</small>') ?>
                </div>
                <div class="form-group mb-3">
                    <input type="text" id="email" name="email" class="form-control" placeholder="Email">
                    <?= form_error('email', '<small class ="text-danger pl-3">', '</small>') ?>
                </div>
                <div class="form-group mb-3">
                    <input type="password" id="password1" name="password1" class="form-control" placeholder="Password">
                    <?= form_error('password1', '<small class ="text-danger pl-3">', '</small>') ?>
                </div>
                <div class="form-group mb-3">
                    <input type="password" id="password2" name="password2" class="form-control" placeholder="Retype password">

                </div>
                <div class="row">
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Register</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

            <a href="<?= base_url('auth') ?>" class="text-center">I already have a membership</a>
        </div>
        <!-- /.form-box -->
    </div><!-- /.card -->
</div>
<!-- /.register-box -->