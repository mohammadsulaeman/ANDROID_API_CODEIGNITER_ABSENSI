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
                    <div class="dropdown">
                        <a href="<?= base_url('Setting/icon/') ?>" class="btn-icon btn btn-primary btn-round btn-sm" type="button" data-toggle="tooltip" data-placement="top" title="Icon">
                            <i class="fas fa-image"></i></a>
                        <span>Icon</span>
                        <a href="<?= base_url('Setting/logo/') ?>" class="btn-icon btn btn-primary btn-round btn-sm" type="button" data-toggle="tooltip" data-placement="top" title="Logo">
                        <i class="fas fa-image"></i></i></a>
                        <span>Logo</span>
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
                            echo form_open_multipart(base_url('Setting'), 'class="form form-vertical"');
                            ?>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Nama Website</label>
                                        <input type="text" class="form-control" name="namaweb" placeholder="Judul setting" value="<?= $setting->namaweb ?>" required />
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Tagline/Moto</label>
                                        <input type="text" class="form-control" name="tagline" placeholder="Tagline/Moto" value="<?= $setting->tagline ?>" />
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Author</label>
                                        <input type="text" class="form-control" name="author" placeholder="Author" value="<?= $setting->author ?>" />
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Telepon</label>
                                        <input type="text" class="form-control" name="telepon" placeholder="No. Telepon" value="<?= $setting->telepon ?>" />
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" class="form-control" name="email" placeholder="Email" value="<?= $setting->email ?>" />
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>URL Website</label>
                                        <input type="url" class="form-control" name="website" placeholder="URL Website" value="<?= $setting->website ?>" />
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>URL Facebook</label>
                                        <input type="url" class="form-control" name="facebook" placeholder="https://www.facebook.com/" value="<?= $setting->facebook ?>" />
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>URL Twitter</label>
                                        <input type="url" class="form-control" name="twitter" placeholder="https://twitter.com/" value="<?= $setting->twitter ?>" />
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>URL Instagram</label>
                                        <input type="url" class="form-control" name="instagram" placeholder="https://www.instagram.com/" value="<?= $setting->instagram ?>" />
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>URL Youtube Channel</label>
                                        <input type="url" class="form-control" name="youtube" placeholder="https://www.youtube.com/" value="<?= $setting->youtube ?>" />
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Working Hours</label>
                                        <input type="text" class="form-control" name="working_hour" placeholder="Working Hours" value="<?= $setting->working_hour ?>" />
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Maps Google</label>
                                        <textarea name="maps" rows="4" class="form-control" placeholder="Maps Google"><?= $setting->maps ?></textarea>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Alamat Kantor</label>
                                        <textarea name="alamat" rows="4" class="form-control" placeholder="Alamat Kantor"><?= $setting->alamat ?></textarea>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>Deskripsi Website (Untuk SEO Google)</label>
                                        <textarea name="deskripsi" id="ckeditor" rows="3" class="form-control" placeholder="Deskripsi Website"><?= $setting->deskripsi ?></textarea>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>Keywords SEO Google</label>
                                        <textarea name="keywords" id="ckeditor2" rows="3" class="form-control" placeholder="Keywords SEO Google"><?= $setting->keywords ?></textarea>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>Metatext SEO Google</label>
                                        <textarea name="metatext" id="ckeditor3" rows="3" class="form-control" placeholder="Metatext SEO Google"><?= $setting->metatext ?></textarea>
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