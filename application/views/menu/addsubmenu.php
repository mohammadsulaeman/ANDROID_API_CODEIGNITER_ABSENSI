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
                        <a href="<?= base_url('menu/submenu') ?>" class="btn btn-primary active" aria-current="page">Back</a>
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
                            echo form_open_multipart(base_url('menu/addsubmenu'), 'class="form form-vertical"');
                            ?>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input type="text" class="form-control" name="title" id="title" required />
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form group">
                                        <select name="menu_id" id="menu_id" class="form-control">
                                            <option value="">Select Menu</option>
                                            <?php foreach ($menu as $m) : ?>
                                                <option value="<?= $m['id'] ?>"><?= $m['menu'] ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>URL </label>
                                        <input type="text" class="form-control" name="url" id="url" required />
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Icon</label>
                                        <input type="text" class="form-control" name="icon" id="icon" required />
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <div class="div form-check">
                                            <input type="checkbox" class="form-check-input" value="1" name="is_active" id="is_active" checked>
                                            <label for="is_active" class="form-check-label">Actiive?</label>
                                        </div>
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