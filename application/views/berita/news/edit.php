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
                        <a href="<?= base_url('News') ?>" class="btn btn-primary active" aria-current="page">Back</a>
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
                            echo form_open_multipart(base_url('News/edit/' . $news->id_news), 'class="form form-vertical"');
                            ?>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Judul Berita</label>
                                        <input type="text" class="form-control" name="judul_news" placeholder="Judul Berita" value="<?= $news->judul_news ?>" required />
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Deskripsi Berita</label>
                                        <textarea name="deskripsi" id="ckeditor" rows="5" class="form-control" placeholder="Deskripsi Berita" required><?= $news->deskripsi ?></textarea>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="form-group">
                                        <label>Upload Foto Berita Terbaru</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="gambar" />
                                            <label class="custom-file-label">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>Foto Berita Saat Ini: </label><br>
                                        <img src="<?php echo base_url('images/news/thumbs/' . $news->gambar) ?>" class="img-thumbnail rounded" height="80" width="80">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Status Tampil di Website :</label>
                                        <select name="status_news" class="form-control">
                                            <option value="1">Publish</option>
                                            <option value="0" <?php if ($news->status_news == "Draft") {
                                                                    echo "selected";
                                                                } ?>>Draft</option>
                                        </select>
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