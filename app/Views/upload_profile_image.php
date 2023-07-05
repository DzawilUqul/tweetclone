<?= $this->extend('components/layout') ?>
<?= $this->section('content') ?>

<?php helper('form'); $validation = \Config\Services::validation(); ?>

    <?php 
        if($user->profile_image == null)
        {
            $image = base_url('images/no-avatar.jpg');
        }
        else
        {
            $image = $user->profile_image;
        }
    ?>

<div class="row" style="margin-top: 100px; margin-bottom: 100px;">
    <div class="col-md-6 offset-md-3 align-self-center">
    <div class="card">
        <div class="card-header text-light bg-dark">
            <strong>Upload Profile Photo</strong>
        </div>
        
        
        <?= img(['src' => $image, 'height' => '200px', 'style' => 'display: block; margin: 0 auto;']) ?>
        <div class="card-body">
            
            <?=form_open_multipart(base_url('/upload_profile_image'));?>
            
            <div class="input-group mb-3">
                <div class="custom-file">
                    <input name="profile_image" type="file" class="custom-file-input" id="inputGroupFile01">
                    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                </div>
            </div>
            <div style="color: red; font-size: small;"><?=$validation->getError('profile_image')?></div>
            
            <div class="mb-3">
                <input type="submit" class="btn btn-primary" value="Edit Image">
                <a href="<?=previous_url()?>" class="btn btn-warning">Kembali</a>
            </div>
            <?= form_close() ?>
        </div>
    </div>
    </div>
</div>
<?= $this->endSection() ?>