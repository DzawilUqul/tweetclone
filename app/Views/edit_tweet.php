<?= $this->extend('components/layout') ?>

<?= $this->section('content') ?>
<?php helper('form') ?>

    <?php 
        if($tweet->tweet_image != null)
        {
            $image = $tweet->tweet_image;
        }
    ?>

<div class="row" style="margin-top: 100px; margin-bottom: 100px;">
    <div class="col-md-6 offset-md-3 align-self-center">
    <div class="card">
        <div class="card-header bg-info">
            <strong>Edit Tweet</strong>
        </div>
        <div class="card-body">
            <?= form_open_multipart(base_url('/edit')) ?>
            <?= form_hidden('id', $tweet->id) ?>

            <?php if($image != null){ ?>
                <?= img(['src' => $image, 'height' => '200px', 'style' => 'display: block; margin: 0 auto;']) ?>
            <?php } ?>
            <label>Upload Gambar</label>
            <div class="input-group mb-3">
                <div class="custom-file">
                    <input name="tweet_image" type="file" class="custom-file-input" id="inputGroupFile01">
                    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                </div>
            </div>

            <div class="mb-3">
                <label for="content" class="form-label">Tweet</label>
                <textarea name="content" id="tweet" class="form-control"><?=$tweet->content?></textarea>
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Kategori</label>
                <?=form_dropdown('category', $categories, $tweet->category, 'class="form-select"')?>
            </div>
            <div class="mb-3">
                <input type="submit" class="btn btn-primary" value="Edit Tweet">
                <a href="<?=previous_url()?>" class="btn btn-warning">Kembali</a>
            </div>
            <?= form_close() ?>
        </div>
    </div>
    </div>
</div>
<?= $this->endSection() ?>