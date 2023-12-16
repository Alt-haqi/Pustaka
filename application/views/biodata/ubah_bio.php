<!-- Begin Page Content -->
<div class="container-fluid">
    <?= $this->session->flashdata('pesan'); ?>
    <div class="row">
        <div class="col-lg-6">
            <?php if (validation_errors()) { ?>
                <div class="alert alert-danger" role="alert">
                    <?= validation_errors(); ?>
                </div>
            <?php } ?>
            <?= $this->session->flashdata('pesan'); ?>
            <?php foreach ($biodata_saya as $o) { ?>
                <form action="<?= base_url('biodata/ubahBiodata'); ?>" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="hidden" name="id" id="id" value="<?php echo $o['id']; ?>">
                        <input type="text" class="form-control form-control-user" id="nim" name="nim" placeholder="Masukkan NIM" value="<?= $o['nim']; ?>">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control form-control-user" id="nama" name="nama" placeholder="Masukkan Nama" value="<?= $o['nama']; ?>">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control form-control-user" id="alamat" name="alamat" placeholder="Masukkan Alamat" value="<?= $o['alamat']; ?>">
                    </div>
                    <div class="form-group">
                        <select name="jenis_kelamin" class="form-control form-control-user">
                            <option value="<?= $o['jenis_kelamin']; ?>"><?= $o['jenis_kelamin']; ?></option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control form-control-user" id="hobby" name="hobby" placeholder="Masukkan Hobby" value="<?= $o['hobby']; ?>">
                    </div>
                    <div class="form-group">
                        <?php
                        if (isset($o['photo'])) { ?>

                            <input type="hidden" name="old_pict" id="old_pict" value="<?= $o['photo']; ?>">

                            <picture>
                                <source srcset="" type="image/svg+xml">
                                <img src="<?= base_url('assets/img/upload/') . $o['photo']; ?>" class="rounded mx-auto mb-3 d-blok" alt="..." width="20%">
                            </picture>

                        <?php } ?>

                        <input type="file" class="form-control form-control-user" id="photo" name="photo">
                    </div>
                    <div class="form-group">
                        <input type="button" class="form-control form-control-user btn btn-dark col-lg-3 mt-3" value="Kembali" onclick="window.history.go(-1)">
                        <input type="submit" class="form-control form-control-user btn btn-primary col-lg-3 mt-3" value="Update">
                    </div>
                </form>
            <?php } ?>
        </div>
    </div>
</div>