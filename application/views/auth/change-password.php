<div class="login-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="#" class="h1"><b><?= $title ?></b></a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">You are only one step a way from your new password, recover your password now.</p>
      <h5 class="mb-4"> <?= $this->session->userdata('reset_email') ?></h5>
      <?= $this->session->flashdata('message'); ?>
      <form action="<?= base_url('auth/changePassword'); ?>" method="post">
        <div class="form-group mb-3">
          <input type="password" class="form-control" id="password1" name="password1" placeholder="Password">
          <?= form_error('password1', '<small class="text-danger">', '</small>') ?>
        </div>
        <div class="form-group mb-3">
          <input type="password" id="password2" name="password2" class="form-control" placeholder="Confirm Password">
          <?= form_error('password1', '<small class="text-danger">', '</small>') ?>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Change password</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <p class="mt-3 mb-1">
        <a href="<?= base_url('auth') ?>">Login</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->