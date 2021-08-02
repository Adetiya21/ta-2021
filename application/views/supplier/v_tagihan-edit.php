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
						<h5>Edit Tagihan <?= $tagihan->nama ?></h5>
						<span>Edit data tagihan <?= $tagihan->nama ?></span>
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
									<h5>Form Edit Tagihan</h5>
									<div class="card-header-right"> <ul class="list-unstyled card-option"> <li class="first-opt"><i class="feather icon-chevron-left open-card-option"></i></li> <li><i class="feather icon-maximize full-card"></i></li> <li><i class="feather icon-minus minimize-card"></i></li> <li><i class="feather icon-refresh-cw reload-card"></i></li> <li><i class="feather icon-trash close-card"></i></li> <li><i class="feather icon-chevron-left open-card-option"></i></li> </ul> </div>					
								</div>
								<div class="card-block">
									<?php if ($tagihan->status=="Menunggu Acc Loket") { ?>
									<!-- <form id="main" method="post" action="https://colorlib.com/" novalidate> -->
										<?= $this->session->flashdata('pesan'); ?>
										<?= $this->session->flashdata('error'); ?>
										<?php $arb = array('enctype' => "multipart/form-data", );?>
										<?= form_open('tagihan/proses_edit', $arb); ?>
										<div class="row">
											<div class="col-sm-4">
												<input type="hidden" name="id" value="<?= $tagihan->id ?>">
												<div class="form-group">
													<label class="col-form-label">Tagihan</label>
													<input type="text" class="form-control" name="nama" value="<?= $tagihan->nama ?>">
												</div>
												<div class="form-group">
													<label class="col-form-label">Biaya</label>
													<input type="text" class="form-control" name="biaya" maxlength="10" value="<?= $tagihan->biaya ?>" onkeypress='return check_int(event)'>
												</div>
											</div>
											<div class="col-sm-4">
												<div class="form-group">
													<label class="col-form-label">Tanggal Tagihan</label>
													<input type="date" class="form-control" name="tgl_tagihan" placeholder="Tanggal" value="<?= $tagihan->tgl_tagihan ?>">
												</div>
												<div class="form-group">
													<label class="col-form-label">Keterangan</label>
													<textarea class="form-control" name="keterangan"><?= $tagihan->keterangan ?></textarea>
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
									<?php } else { ?>
										<h5>Maaf anda tidak dapat mengedit data tagihan karena tagihan anda saat ini sedang dalam proses.</h5>
										<hr>
										<a href="<?= site_url('tagihan') ?>" class="btn btn-primary btn-round">Kembali</a>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div id="styleSelector">
				</div>
			</div>
		</div>