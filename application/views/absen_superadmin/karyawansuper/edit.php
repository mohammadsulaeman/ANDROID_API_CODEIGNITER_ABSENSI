<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-8 mx-auto">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0"><?= $title ?></h2>
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
                <div class="form-group breadcrumb-right">
                    <div class="btn-group">
                        <a href="<?= base_url('Karyawan_Super') ?>" class="btn btn-primary active" aria-current="page">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="row">
                <div class="col-10 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <?php
                            if (isset($error)) {
                                echo '<div class="alert alert-warning alert-dismissible fade show" role="alert"><div class="alert-body">';
                                echo $error;
                                echo '</div><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
                            }

                            // Notifikasi error
                            echo validation_errors('<div class="alert alert-warning alert-dismissible fade show" role="alert"><div class="alert-body">', '</div><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');

                            // Notifikasi open
                            echo form_open_multipart(base_url('Karyawan_Super/edit/' . $karyawan->karyawan_id), 'class="form form-vertical"');
                            ?>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Nama </label>
                                        <input type="text" class="form-control" name="karyawan_name" placeholder="Nama " value="<?= $karyawan->karyawan_name ?>" required />
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Phone </label>
                                        <input type="number" class="form-control" name="karyawan_phone" placeholder="Phone " value="<?= $karyawan->karyawan_phone ?>" required />
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Password </label>
                                        <input type="password" class="form-control" name="password" placeholder="Password" value="<?= $karyawan->password ?>" required />
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Status :</label>
                                        <select name="karyawan_status" class="form-control">
                                            <option value="Tetap">Karyawan Tetap</option>
                                            <option value="Kontrak">Karyawan Kontrak</option>
                                            <option value="Magang" <?php if ($karyawan->karyawan_status == "Magang") {
                                                                        echo "selected";
                                                                    } ?>>Magang</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="form-group">
                                        <label>Upload Foto Terbaru</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="karyawan_photo" />
                                            <label class="custom-file-label">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>Foto Saat Ini: </label><br>
                                        <img src="<?php echo base_url('images/karyawan/' . $karyawan->karyawan_photo) ?>" class="img-thumbnail rounded" height="80" width="80">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Gender :</label>
                                        <select name="karyawan_gender" class="form-control">
                                            <option value="Pria">Pria</option>
                                            <option value="Wanita" <?php if ($karyawan->karyawan_gender == "Wanita") {
                                                                        echo "selected";
                                                                    } ?>>Wanita</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Kode Negara </label>
                                        <input type="text" class="form-control" name="karyawan_code" placeholder="Kode Negara " value="<?= $karyawan->karyawan_code ?>" required />
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Alamat</label>
                                        <textarea name="karyawan_alamat" id="ckeditor2" rows="5" class="form-control" placeholder="Alamat" required><?= $karyawan->karyawan_alamat ?></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Tanggal Lahir </label>
                                        <input type="text" class="form-control" name="karyawan_lahir" placeholder="Tanggal Lahir " value="<?= $karyawan->karyawan_lahir ?>" required />
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button type="submit" name="submit" class="btn btn-primary mr-1">Submit</button>
                                    <button type="reset" name="reset" class="btn btn-outline-secondary">Reset</button>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>