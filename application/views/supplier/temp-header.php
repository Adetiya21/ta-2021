<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
	<title><?= $title ?></title>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="description" content="Admindek Bootstrap admin template made using Bootstrap 4 and it has huge amount of ready made feature, UI components, pages which completely fulfills any dashboard needs." />
	<meta name="keywords" content="bootstrap, bootstrap admin template, admin theme, admin dashboard, dashboard template, admin template, responsive" />
	<meta name="author" content="colorlib" />

	<link rel="icon" href="<?= base_url('assets/') ?>assets/images/favicon.ico" type="image/x-icon">
	<link href="<?= base_url('assets/') ?>fonts.googleapis.com/css0f7c.css?family=Open+Sans:300,400,600,700,800" rel="stylesheet"><link href="<?= base_url('assets/') ?>fonts.googleapis.com/css1180.css?family=Quicksand:500,700" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/') ?>bower_components/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?= base_url('assets/') ?>assets/pages/waves/css/waves.min.css" type="text/css" media="all">
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/') ?>assets/icon/feather/css/feather.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/') ?>assets/icon/themify-icons/themify-icons.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/') ?>assets/icon/icofont/css/icofont.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/') ?>assets/icon/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/') ?>assets/css/font-awesome-n.min.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/') ?>bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/') ?>assets/pages/data-table/css/buttons.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/') ?>bower_components/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css">

	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/') ?>assets/css/style.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/') ?>assets/css/pages.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/') ?>assets/css/widget.css">
</head>
<body>

	<div class="loader-bg">
		<div class="loader-bar"></div>
	</div>

	<div id="pcoded" class="pcoded">
		<div class="pcoded-overlay-box"></div>
		<div class="pcoded-container navbar-wrapper">

			<nav class="navbar header-navbar pcoded-header">
				<div class="navbar-wrapper">
					<div class="navbar-logo">
						<a href="index.html">
							<img class="img-fluid" src="<?= base_url('assets/') ?>assets/images/logo.png" alt="Theme-Logo" />
						</a>
						<a class="mobile-menu" id="mobile-collapse" href="#!">
							<i class="feather icon-menu icon-toggle-right"></i>
						</a>
						<a class="mobile-options waves-effect waves-light">
							<i class="feather icon-more-horizontal"></i>
						</a>
					</div>
					<div class="navbar-container container-fluid">
						<ul class="nav-left">
							<li>
								<a href="#!" onclick="if (!window.__cfRLUnblockHandlers) return false; javascript:toggleFullScreen()" class="waves-effect waves-light" data-cf-modified-10ea6d1a73d3f249f046e978-="">
									<i class="full-screen feather icon-maximize"></i>
								</a>
							</li>
						</ul>
						<ul class="nav-right">
							<li class="user-profile header-notification">
								<div class="dropdown-primary dropdown">
									<div class="dropdown-toggle" data-toggle="dropdown">
										<?php if ($this->session->userdata('gambar')==null) { ?>
											<img src="<?= base_url('assets/') ?>assets/img/user.jpg" class="img-radius" alt="User-Profile-Image">
										<?php } else { ?>
											<img src="<?= base_url('assets/img/supplier/'.$this->session->userdata('gambar')) ?>" class="img-radius" alt="User-Profile-Image">
										<?php } ?>
										<span><?php echo $this->session->userdata('nama')?></span>
										<i class="feather icon-chevron-down"></i>
									</div>
									<ul class="show-notification profile-notification dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
										<li>
											Hello, <?php echo $this->session->userdata('nama')?>
											<hr style="margin-bottom: -10px">
										</li>
										<li>
											<a href="<?= site_url('home/profil/'.$this->session->userdata('id').'') ?>">
												<i class="feather icon-user"></i> Profil
											</a>
										</li>
										<li>
											<a href="<?= site_url('logout') ?>">
												<i class="feather icon-log-out"></i> Logout
											</a>
										</li>
									</ul>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</nav>

			<div class="pcoded-main-container">
				<div class="pcoded-wrapper">

					<nav class="pcoded-navbar">
						<div class="nav-list">
							<div class="pcoded-inner-navbar main-menu">
								<div class="pcoded-navigation-label">Navigation</div>
								<ul class="pcoded-item pcoded-left-item">
									<li class="home">
										<a href="<?= site_url('home') ?>" class="waves-effect waves-dark">
											<span class="pcoded-micon"><i class="feather icon-home"></i></span>
											<span class="pcoded-mtext">Dashboard</span>
										</a>
									</li>
								</ul>
								<hr>
								<ul class="pcoded-item pcoded-left-item">		
									<li class="profil">
										<a href="<?= site_url('home/profil/'.$this->session->userdata('id').'') ?>" class="waves-effect waves-dark">
											<span class="pcoded-micon">
												<i class="feather icon-user"></i>
											</span>
											<span class="pcoded-mtext">Profil Supplier</span>
										</a>
									</li>
									<?php if ($profil->status==null) { ?>
									<li class="tagihan disabled pcoded-hasmenu">
										<a href="javascript:void(0)" class="waves-effect waves-dark">
											<span class="pcoded-micon">
												<i class="feather icon-book"></i>
											</span>
											<span class="pcoded-mtext">Tagihan</span>
										</a>
										<ul class="pcoded-submenu">
											<li class="data-tagihan">
												<a href="<?= site_url('tagihan') ?>" class="waves-effect waves-dark">
													<span class="pcoded-mtext">Data Tagihan</span>
												</a>
											</li>
											<li class="input-tagihan">
												<a href="<?= site_url('tagihan/input') ?>" class="waves-effect waves-dark">
													<span class="pcoded-mtext">Input Tagihan</span>
												</a>
											</li>
										</ul>
									</li>
									<?php } else { ?>
									<li class="tagihan disabled pcoded-hasmenu">
										<a href="javascript:void(0)" class="disabled waves-effect waves-dark">
											<span class="pcoded-micon">
												<i class="feather icon-book"></i>
											</span>
											<span class="pcoded-mtext">Tagihan</span>
										</a>
									</li>
									<?php } ?>
								</ul><hr>
								<div class="pcoded-navigation-label" style="position:absolute;bottom: 0;left: 20%; text-align: center;">Copyright?? 2021<br>Allrights Reserved.</div>

							</div>
						</nav>
