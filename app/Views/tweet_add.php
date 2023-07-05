<?= $this->extend('components/layout') ?>

<?= $this->section('content') ?>
<?php helper('form') ?>
<div class="row" style="margin-top: 100px; margin-bottom: 100px;">
    <div class="col-md-6 offset-md-3 align-self-center">
    <div class="card">
        <div class="card-header bg-info">
            <strong>Tweet Baru</strong>
        </div>
        <div class="card-body">
            <?= form_open_multipart(base_url('/add')) ?>
            <div class="mb-3">
                <label for="username" class="form-label">Tweet</label>
                <textarea name="content" id="tweet" class="form-control"></textarea>
            </div>
            
            <div class="mb-3">
                <label for="password" class="form-label">Kategori</label>
                <?=form_dropdown('category', $categories, '', 'class="form-select"')?>
            </div>

            <label>Upload Gambar</label>
            <div class="input-group mb-3">
                <div class="custom-file">
                    <input name="tweet_image" type="file" class="custom-file-input" id="inputGroupFile01">
                    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                </div>
            </div>
            
            <?php if($validation != null){ ?>
                <div style="color: red; font-size: small;"><?=$validation->getError('tweet_image')?></div>
            <?php } ?>
            

            <div class="mb-3">
                <input type="submit" class="btn btn-primary" value="Tambah Tweet">
                <a href="<?=previous_url()?>" class="btn btn-warning">Kembali</a>
            </div>
            <?= form_close() ?>
        </div>
    </div>
    </div>
</div>
<?= $this->endSection() ?>