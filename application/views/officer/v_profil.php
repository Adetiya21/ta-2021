<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
	$(document).ready(function() {
		$('.profil').addClass('active');
	});

	function check_int(evt) {
		var charCode = ( evt.which ) ? evt.which : event.keyCode;
		return ( charCode >= 48 && charCode <= 57 || charCode == 8 );
	}

	function PreviewImage() {
		var oFReader = new FileReader();
		oFReader.readAsDataURL(document.getElementById("uploadImage").files[0]);

		oFReader.onload = function (oFREvent) {
			document.getElementById("uploadPreview").src = oFREvent.target.result;
		};
	};
</script>

<div class="pcoded-content">
	<div class="page-header card">
		<div class="row align-items-end">
			<div class="col-lg-8">
				<div class="page-header-title">
					<i class="feather icon-user bg-c-blue"></i>
					<div class="d-inline">
						<h5>Profil</h5>
						<span>Perbarui data profil anda</span>
					</div>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="page-header-breadcrumb">
					<ul class=" breadcrumb breadcrumb-title">
						<li class="breadcrumb-item">
							<a href="<?= site_url('officer/home') ?>"><i class="feather icon-home"></i></a>
						</li>
						<li class="breadcrumb-item">
							<a href="<?= site_url('officer/home/profil') ?>">Profil</a>
						</li>
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
						<div class="col-sm-12">
							<div class="card">
								<div class="card-header">
									<h5>Data Profil</h5>
									<div class="card-header-right"> <ul class="list-unstyled card-option"> <li class="first-opt"><i class="feather icon-chevron-left open-card-option"></i></li> <li><i class="feather icon-maximize full-card"></i></li> <li><i class="feather icon-minus minimize-card"></i></li> <li><i class="feather icon-refresh-cw reload-card"></i></li> <li><i class="feather icon-trash close-card"></i></li> <li><i class="feather icon-chevron-left open-card-option"></i></li> </ul> </div>					
								</div>
								<div class="card-block">
									<!-- <form id="main" method="post" action="https://colorlib.com/" novalidate> -->
										<?= $this->session->flashdata('pesan'); ?>
										<?= $this->session->flashdata('error'); ?>
										<?php $arb = array('enctype' => "multipart/form-data", );?>
										<?= form_open('officer/home/edit_profil', $arb); ?>
										<div class="row">
											<div class="col-sm-6">
												<div class="form-group">
													<label class="col-form-label">NIK</label>
													<input type="text" class="form-control" value="<?= $profil->nik ?>" name="nik" readOnly>
												</div>
												<div class="form-group">
													<label class="col-form-label">Nama</label>
													<input type="text" class="form-control" value="<?= $profil->nama ?>" name="nama">
												</div>
												<div class="form-group">
													<label class="col-form-label">Email</label>
													<input type="text" class="form-control" value="<?= $profil->email ?>" name="email">
												</div>
												<div class="form-group">
													<label class="col-form-label">No.Telp</label>
													<input type="text" class="form-control" value="<?= $profil->no_telp ?>" name="no_telp">
												</div>
												<div class="form-group">
													<label class="col-form-label">Password</label>
													<input type="password" class="form-control" name="password" placeholder="Password">
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label class="col-form-label">Foto</label>
													<input id="uploadImage" type="file" name="gambar" onchange="PreviewImage();" class="form-control" accept='image/*' value="<?= $profil->gambar ?>" />
                          <p style="font-size: 0.7em; padding: 5px;">JPG, JPEG, PNG Max. 2MB</p>
                          <div class="form-group" id="photo-preview">
                              <div>
                              <span class="help-block"></span>
                              </div>
                          </div>
                          <div class="form-group" id="photo">
                              <div>
                              <img id="uploadPreview" style="max-width:200px;" class="img-thumbnail" src="<?= base_url('assets/img/officer/') ?><?= $profil->gambar ?>"/>
                              <span class="help-block"></span>
                              </div>
                          </div>											
												</div>
											</div>
										</div>
										<hr>
										<div class="form-group row">
											<!-- <label class="col-sm-2"></label> -->
											<div class="col-sm-2">
												<button class="btn btn-primary m-b-0 btn-round" style="color: #fff"><i class="fa fa-edit"></i> Edit Data</abutton>
												</div>
											</div>
											<!-- </form> -->
											<?= form_close(); ?>
										</div>
									</div>

								</div>
							</div>
						</div>

					</div>
				</div>

				<div id="styleSelector">
				</div>
			</div>
		</div>