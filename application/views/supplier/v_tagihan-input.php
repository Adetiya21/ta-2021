<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
	$(document).ready(function() {
		$('.tagihan').addClass('active');
		$('.input-tagihan').addClass('active');
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
					<i class="feather icon-book bg-c-blue"></i>
					<div class="d-inline">
						<h5>Tambah Tagihan</h5>
						<span>Tambah data tagihan</span>
					</div>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="page-header-breadcrumb">
					<ul class=" breadcrumb breadcrumb-title">
						<li class="breadcrumb-item">
							<a href="<?= site_url('home') ?>"><i class="feather icon-home"></i></a>
						</li>
						<li class="breadcrumb-item">
							<a href="<?= site_url('tagihan') ?>">Tagihan</a>
						</li>
						<li class="breadcrumb-item">
							<a href="<?= site_url('tagihan/input') ?>">Tambah</a>
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
									<h5>Form Tagihan</h5>
									<div class="card-header-right"> <ul class="list-unstyled card-option"> <li class="first-opt"><i class="feather icon-chevron-left open-card-option"></i></li> <li><i class="feather icon-maximize full-card"></i></li> <li><i class="feather icon-minus minimize-card"></i></li> <li><i class="feather icon-refresh-cw reload-card"></i></li> <li><i class="feather icon-trash close-card"></i></li> <li><i class="feather icon-chevron-left open-card-option"></i></li> </ul> </div>					
								</div>
								<div class="card-block">
									<!-- <form id="main" method="post" action="https://colorlib.com/" novalidate> -->
										<?= $this->session->flashdata('pesan'); ?>
										<?= $this->session->flashdata('error'); ?>
										<?php $arb = array('enctype' => "multipart/form-data", );?>
										<?= form_open('tagihan/proses', $arb); ?>
										<div class="row">
											<div class="col-sm-4">
												<div class="form-group">
													<label class="col-form-label">Tagihan</label>
													<input type="text" class="form-control" name="nama">
												</div>
												<div class="form-group">
													<label class="col-form-label">Biaya</label>
													<input type="text" class="form-control" name="biaya" maxlength="10" onkeypress='return check_int(event)'>
												</div>
											</div>
											<div class="col-sm-4">
												<div class="form-group">
													<label class="col-form-label">Tanggal Tagihan</label>
													<input type="date" class="form-control" name="tgl_tagihan" placeholder="Tanggal">
												</div>
												<div class="form-group">
													<label class="col-form-label">Keterangan</label>
													<textarea class="form-control" name="keterangan"></textarea>
												</div>
											</div>
										</div>
										<hr>
										<div class="form-group row">
											<!-- <label class="col-sm-2"></label> -->
											<div class="col-sm-2">
												<button class="btn btn-primary m-b-0" style="color: #fff"><i class="fa fa-edit"></i> Simpan Data</abutton>
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