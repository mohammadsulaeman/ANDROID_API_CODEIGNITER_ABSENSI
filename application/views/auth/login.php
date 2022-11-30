<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="#" class="h1"><b><?= $title ?></b></a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Sign in to start your session</p>
      <!-- Tampilkan pesan -->
      <?= $this->session->flashdata('message') ?>
      <form action="<?= base_url('auth') ?>" method="post">
        <div class="form-group">
          <input type="text" id="email" name="email" value="<?= set_value('email') ?>" class="form-control" placeholder="Email">
          <?= form_error('email', '<small class ="text-danger pl-3">', '</small>') ?>
        </div>
        <div class="form-group">
          <input type="password" id="password" name="password" class="form-control" placeholder="Password">
          <?= form_error('password', '<small class ="text-danger pl-3">', '</small>') ?>
        </div>
        <div class="row">
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <p class="mb-1">
        <a href="<?= base_url('auth/forgetpass') ?>">I forgot my password</a>
      </p>
      <p class="mb-0">
        <a href="<?= base_url('auth/register') ?>" class="text-center">Register a new membership</a>
      </p>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->