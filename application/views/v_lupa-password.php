<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php 
if ($this->session->userdata('supplier_logged_in') == 'Sudah_Loggin'){
    redirect('home','refresh');
} else if ($this->session->userdata('officer_logged_in') == 'Sudah_Loggin'){
    redirect('officer/home','refresh');
} ?>
<!DOCTYPE html>
<html dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" href="<?= base_url('assets/') ?>assets/images/favicon.ico" type="image/x-icon">
    <link href="<?= base_url('assets/') ?>fonts.googleapis.com/css0f7c.css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    <link href="<?= base_url('assets/') ?>fonts.googleapis.com/css1180.css?family=Quicksand:500,700" rel="stylesheet">
    <title>Lupa Password</title>
    <!-- Custom CSS -->
    <link href="<?= base_url('assets/')?>dist/css/style.css" rel="stylesheet">
    <?=  $this->recaptcha->getScriptTag(); ?>
</head>

<body>
    <div class="main-wrapper">
        <div class="preloader">
            <div class="lds-ripple">
                <div class="lds-pos"></div>
                <div class="lds-pos"></div>
            </div>
        </div>
        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center position-relative"
            style="background:url(<?= base_url('assets/')?>assets/images/big/auth-bg.jpg) no-repeat center center;">
            <div class="auth-box row">
                <div class="col-lg-6 col-md-5 modal-bg-img" style="background-image: url(<?= base_url('assets/')?>assets/images/big/login.jpg);"></div>
                <!-- <div class="col-lg-6 col-md-5 modal-bg-img" style="background-color:#ffa"></div> -->
                <div class="col-lg-6 col-md-7 bg-white">
                    <div class="p-3">
                        <div class="text-center">
                            <img src="<?= base_url('assets/')?>assets/images/big/icon.png" alt="wrapkit">
                        </div>
                        <h2 class="mt-3 text-center">Lupa Password</h2>
                        <p class="text-center">Masukkan username yang telah terdaftar untuk mereset akun anda</p>
                        <?= $this->session->flashdata('pesan'); ?>
                        <?= $this->session->flashdata('error'); ?>
                        <?= form_open('welcome/proses_reset'); ?>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="text-dark" for="uname">Username</label>
                                        <input class="form-control" id="uname" type="text" name="username" 
                                            placeholder="Masukkan NIK/No.HP" value="<?= $this->session->flashdata('username'); ?>">
                                    </div>
                                </div>
                                <div class="col-lg-12 text-center">
                                    <?= $this->recaptcha->getWidget() ?>
                                </div>
                                <div class="col-lg-12">
                                    <button class="btn btn-block btn-dark">Reset Password</button>
                                    <hr>
                                </div>
                                <div class="col-lg-12" style="font-size:0.7em">
                                    Sudah punya akun? <a href="<?= site_url('login') ?>" class="text-danger">Login</a>
                                </div>
                                <div class="col-lg-12" style="font-size:0.7em">
                                    Belum punya akun? <a href="<?= site_url('daftar') ?>" class="text-danger">Ayo Daftar!!</a>
                                </div>
                            </div>
                        <?= form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?= base_url('assets/')?>assets/libs/jquery/dist/jquery.min.js "></script>
    <script src="<?= base_url('assets/')?>assets/libs/popper.js/dist/umd/popper.min.js "></script>
    <script src="<?= base_url('assets/')?>assets/libs/bootstrap/dist/js/bootstrap.min.js "></script>
    
    <script>
        $(".preloader ").fadeOut();
    </script>
</body>

</html>