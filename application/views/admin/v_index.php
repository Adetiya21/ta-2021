<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
	$(document).ready(function() {
		$('.home').addClass('active');
	});
</script>
<div class="pcoded-content">
	<div class="page-header card">
		<div class="row align-items-end">
			<div class="col-lg-8">
				<div class="page-header-title">
					<i class="feather icon-home bg-c-blue"></i>
					<div class="d-inline">
						<h5>Dashboard Admin</h5>
						<span>Selamat Datang Admin <?= $this->session->userdata('nama')?></span>
					</div>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="page-header-breadcrumb">
					<ul class=" breadcrumb breadcrumb-title">
						<li class="breadcrumb-item">
							<a href="<?= site_url('admin/home') ?>"><i class="feather icon-home"></i></a>
						</li>
						<li class="breadcrumb-item"><a href="<?= site_url('admin/home') ?>">Home</a> </li>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<div class="pcoded-inner-content">
		<div class="main-body">
			<div class="page-wrapper">
				<div class="page-body">

					<div class="row">

						<!-- <div class="col-xl-4 col-md-6">
							<div class="card prod-p-card card-yellow">
								<div class="card-body">
									<div class="row align-items-center m-b-30">
										<div class="col">
											<h6 class="m-b-5 text-white">Total Status Menunggu</h6>
											<h3 class="m-b-0 f-w-700 text-white"><?= $pdftmenunggu ?> <span style="font-size: 0.7em">Pendaftar</span></h3>
										</div>
										<div class="col-auto">
											<i class="fas fa-hourglass-2 text-c-yellow f-18"></i>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xl-4 col-md-6">
							<div class="card prod-p-card card-green">
								<div class="card-body">
									<div class="row align-items-center m-b-30">
										<div class="col">
											<h6 class="m-b-5 text-white">Total Status Diterima</h6>
											<h3 class="m-b-0 f-w-700 text-white"><?= $pdftditerima ?> <span style="font-size: 0.7em">Pendaftar</span></h3>
										</div>
										<div class="col-auto">
											<i class="fas fa-check text-c-green f-18"></i>
										</div>
									</div>
								</div>
							</div>
						</div> -->

						<div class="col-xl-4 col-md-6">
							<a href="<?= site_url('admin/admin') ?>">
							<div class="card prod-p-card card-red">
								<div class="card-body">
									<div class="row align-items-center m-b-30">
										<div class="col">
											<h6 class="m-b-5 text-white">Total Admin</h6>
											<h3 class="m-b-0 f-w-700 text-white"><?= $admin ?> <span style="font-size: 0.7em">Admin</span></h3>
										</div>
										<div class="col-auto">
											<i class="fas fa-users text-c-red f-18"></i>
										</div>
									</div>
								</div>
							</div>
							</a>
						</div>
						<div class="col-xl-4 col-md-6">
							<a href="<?= site_url('admin/officer') ?>">
							<div class="card prod-p-card card-green">
								<div class="card-body">
									<div class="row align-items-center m-b-30">
										<div class="col">
											<h6 class="m-b-5 text-white">Total Officer</h6>
											<h3 class="m-b-0 f-w-700 text-white"><?= $officer ?> <span style="font-size: 0.7em">Akun</span></h3>
										</div>
										<div class="col-auto">
											<i class="fas fa-check text-c-green f-18"></i>
										</div>
									</div>
								</div>
							</div>
							</a>
						</div>
						
						<div class="col-xl-4 col-md-6">
							<a href="<?= site_url('admin/supplier') ?>">
							<div class="card prod-p-card card-blue">
								<div class="card-body">
									<div class="row align-items-center m-b-30">
										<div class="col">
											<h6 class="m-b-5 text-white">Total Supplier</h6>
											<h3 class="m-b-0 f-w-700 text-white"><?= $pdftall ?> <span style="font-size: 0.7em">Supplier</span></h3>
										</div>
										<div class="col-auto">
											<i class="fas fa-users text-c-blue f-18"></i>
										</div>
									</div>
								</div>
							</div>
							</a>
						</div>
						<!-- <div class="col-xl-4 col-md-12">
							<div class="card comp-card">
								<div class="card-body">
									<div class="row align-items-center">
										<div class="col">
											<h6 class="m-b-25">Total Admin</h6>
											<h3 class="f-w-700 text-c-yellow"><?= $admin ?> Akun</h3>
										</div>
										<div class="col-auto">
											<i class="fas fa-users bg-c-yellow"></i>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xl-4 col-md-6">
							<div class="card comp-card">
								<div class="card-body">
									<div class="row align-items-center">
										<div class="col">
											<h6 class="m-b-25">Total Officer</h6>
											<h3 class="f-w-700 text-c-green"><?= $officer ?> Akun</h3>
										</div>
										<div class="col-auto">
											<i class="fas fa-users bg-c-green"></i>
										</div>
									</div>
								</div>
							</div>
						</div> -->

						<div class="col-xl-12">
							<div class="card product-progress-card">
								<div class="card-header">
									<h5>Total Pengajuan Tagihan : <?= $swall  ?></h5>
									<div class="card-header-right">
										<ul class="list-unstyled card-option">
											<li class="first-opt"><i class="feather icon-chevron-left open-card-option"></i></li>
											<li><i class="feather icon-maximize full-card"></i></li>
											<li><i class="feather icon-minus minimize-card"></i></li>
											<li><i class="feather icon-refresh-cw reload-card"></i></li>
											<li><i class="feather icon-trash close-card"></i></li>
											<li><i class="feather icon-chevron-left open-card-option"></i></li>
										</ul>
									</div>
								</div>
								<div class="card-block">
									<div class="row pp-main">
										<div class="col-xl-3 col-md-6">
											<div class="pp-cont">
												<div class="row align-items-center m-b-20">
													<div class="col-auto">
														<i class="fas fa-book f-24 text-mute"></i>
													</div>
													<div class="col text-right">
														<h2 class="m-b-0 text-c-blue"><?= $selesai ?></h2>
													</div>
												</div>
												<div class="row align-items-center m-b-15">
													<div class="col-auto">
														<p class="m-b-0 font-weight-bold">Total Tagihan Selesai</p>
													</div>
													<div class="col text-right">
														<p class="m-b-0 text-c-blue">
															<?= $selesai ?></p>
													</div>
												</div>
												<div class="progress">
													<div class="progress-bar bg-c-blue" style="width:<?= $selesai ?>%"></div>
												</div>
											</div>
										</div>
										<div class="col-xl-3 col-md-6">
											<div class="pp-cont">
												<div class="row align-items-center m-b-20">
													<div class="col-auto">
														<i class="fas fa-book f-24 text-mute"></i>
													</div>
													<div class="col text-right">
														<h2 class="m-b-0 text-c-green"><?= $tfin ?></h2>
													</div>
												</div>
												<div class="row align-items-center m-b-15">
													<div class="col-auto">
														<p class="m-b-0 font-weight-bold" style="font-size:0.9em">Tagihan Diterima Finance</p>
													</div>
													<div class="col text-right">
														<p class="m-b-0 text-c-green">
															<?= $tfin ?></p>
													</div>
												</div>
												<div class="progress">
													<div class="progress-bar bg-c-green" style="width:<?= $tfin ?>%"></div>
												</div>
											</div>
										</div>
										<?php 
											$ditolak = $tolakLoket + $tolakGA + $tolakFin;
										?>
										<div class="col-xl-3 col-md-6">
											<div class="pp-cont">
												<div class="row align-items-center m-b-20">
													<div class="col-auto">
														<i class="fas fa-close f-24 text-mute"></i>
													</div>
													<div class="col text-right">
														<h2 class="m-b-0 text-c-red"><?= $ditolak ?></h2>
													</div>
												</div>
												<div class="row align-items-center m-b-15">
													<div class="col-auto">
														<p class="m-b-0 font-weight-bold">Total Tagihan Ditolak</p>
													</div>
													<div class="col text-right">
														<p class="m-b-0 text-c-red">
															<!-- <i class="fas fa-long-arrow-alt-down m-r-10"></i> -->
														<?= $ditolak ?></p>
													</div>
												</div>
												<div class="progress">
													<div class="progress-bar bg-c-red" style="width:<?= $ditolak ?>%"></div>
												</div>
											</div>
										</div>
										<?php 
											$menunggu = $tungguLoket + $tungguGA + $tungguFin;
										?>
										<div class="col-xl-3 col-md-6">
											<div class="pp-cont">
												<div class="row align-items-center m-b-20">
													<div class="col-auto">
														<i class="fas fa-hourglass-2 f-24 text-mute"></i>
													</div>
													<div class="col text-right">
														<h2 class="m-b-0 text-c-yellow"><?= $menunggu ?></h2>
													</div>
												</div>
												<div class="row align-items-center m-b-15">
													<div class="col-auto">
														<p class="m-b-0 font-weight-bold">Total Tagihan Menunggu</p>
													</div>
													<div class="col text-right">
														<p class="m-b-0 text-c-yellow">
															<?= $menunggu ?></p>
													</div>
												</div>
												<div class="progress">
													<div class="progress-bar bg-c-yellow" style="width:<?= $menunggu ?>%"></div>
												</div>
											</div>
										</div>
									</div>
									<hr><h5 class="font-weight-bold" align="center">Detail</h5><hr>
									<div class="row pp-main">
										<div class="col-xl-4 col-md-6">
											<div class="pp-cont">
												<div class="row align-items-center m-b-20">
													<div class="col-auto">
														<i class="fas fa-hourglass-2 f-24 text-mute"></i>
													</div>
													<div class="col text-right">
														<h2 class="m-b-0 text-c-yellow"><?= $tungguLoket ?></h2>
													</div>
												</div>
												<div class="row align-items-center m-b-15">
													<div class="col-auto">
														<p class="m-b-0">Tagihan Menunggu Acc Loket</p>
													</div>
													<div class="col text-right">
														<p class="m-b-0 text-c-yellow">
															<?= $tungguLoket ?></p>
													</div>
												</div>
												<div class="progress">
													<div class="progress-bar bg-c-yellow" style="width:<?= $tungguLoket ?>%"></div>
												</div>
											</div>
										</div>
										<div class="col-xl-4 col-md-6">
											<div class="pp-cont">
												<div class="row align-items-center m-b-20">
													<div class="col-auto">
														<i class="fas fa-hourglass-2 f-24 text-mute"></i>
													</div>
													<div class="col text-right">
														<h2 class="m-b-0 text-c-yellow"><?= $tungguGA ?></h2>
													</div>
												</div>
												<div class="row align-items-center m-b-15">
													<div class="col-auto">
														<p class="m-b-0">Tagihan Menunggu Acc GA</p>
													</div>
													<div class="col text-right">
														<p class="m-b-0 text-c-yellow">
															<!-- <i class="fas fa-long-arrow-alt-down m-r-10"></i> -->
														<?= $tungguGA ?></p>
													</div>
												</div>
												<div class="progress">
													<div class="progress-bar bg-c-yellow" style="width:<?= $tungguGA ?>%"></div>
												</div>
											</div>
										</div>
										<div class="col-xl-4 col-md-6">
											<div class="pp-cont">
												<div class="row align-items-center m-b-20">
													<div class="col-auto">
														<i class="fas fa-hourglass-2 f-24 text-mute"></i>
													</div>
													<div class="col text-right">
														<h2 class="m-b-0 text-c-yellow"><?= $tungguFin ?></h2>
													</div>
												</div>
												<div class="row align-items-center m-b-15">
													<div class="col-auto">
														<p class="m-b-0">Tagihan Menunggu Acc Finance</p>
													</div>
													<div class="col text-right">
														<p class="m-b-0 text-c-yellow">
															<?= $tungguFin ?></p>
													</div>
												</div>
												<div class="progress">
													<div class="progress-bar bg-c-yellow" style="width:<?= $tungguFin ?>%"></div>
												</div>
											</div>
										</div>
									</div>
									<hr>
									<div class="row pp-main">
										<div class="col-xl-4 col-md-6">
											<div class="pp-cont">
												<div class="row align-items-center m-b-20">
													<div class="col-auto">
														<i class="fas fa-close f-24 text-mute"></i>
													</div>
													<div class="col text-right">
														<h2 class="m-b-0 text-c-red"><?= $tolakLoket ?></h2>
													</div>
												</div>
												<div class="row align-items-center m-b-15">
													<div class="col-auto">
														<p class="m-b-0">Tagihan Ditolak Loket</p>
													</div>
													<div class="col text-right">
														<p class="m-b-0 text-c-red">
															<?= $tolakLoket ?></p>
													</div>
												</div>
												<div class="progress">
													<div class="progress-bar bg-c-red" style="width:<?= $tolakLoket ?>%"></div>
												</div>
											</div>
										</div>
										<div class="col-xl-4 col-md-6">
											<div class="pp-cont">
												<div class="row align-items-center m-b-20">
													<div class="col-auto">
														<i class="fas fa-close f-24 text-mute"></i>
													</div>
													<div class="col text-right">
														<h2 class="m-b-0 text-c-red"><?= $tolakGA ?></h2>
													</div>
												</div>
												<div class="row align-items-center m-b-15">
													<div class="col-auto">
														<p class="m-b-0">Tagihan Ditolak GA</p>
													</div>
													<div class="col text-right">
														<p class="m-b-0 text-c-red">
															<!-- <i class="fas fa-long-arrow-alt-down m-r-10"></i> -->
														<?= $tolakGA ?></p>
													</div>
												</div>
												<div class="progress">
													<div class="progress-bar bg-c-red" style="width:<?= $tolakGA ?>%"></div>
												</div>
											</div>
										</div>
										<div class="col-xl-4 col-md-6">
											<div class="pp-cont">
												<div class="row align-items-center m-b-20">
													<div class="col-auto">
														<i class="fas fa-close f-24 text-mute"></i>
													</div>
													<div class="col text-right">
														<h2 class="m-b-0 text-c-red"><?= $tolakFin ?></h2>
													</div>
												</div>
												<div class="row align-items-center m-b-15">
													<div class="col-auto">
														<p class="m-b-0">Tagihan Ditolak Finance</p>
													</div>
													<div class="col text-right">
														<p class="m-b-0 text-c-red">
															<?= $tolakFin ?></p>
													</div>
												</div>
												<div class="progress">
													<div class="progress-bar bg-c-red" style="width:<?= $tolakFin ?>%"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="styleSelector">
</div>