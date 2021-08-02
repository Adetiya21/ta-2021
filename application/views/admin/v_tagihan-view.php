<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
	$(document).ready(function() {
		$('.tagihan').addClass('active');
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
						<h5>Detail Tagihan</h5>
						<span>Detail data tagihan <?= $tagihan->nama ?>.</span>
					</div>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="page-header-breadcrumb">
					<ul class=" breadcrumb breadcrumb-title">
						<li class="breadcrumb-item">
							<a href="<?= site_url('admin/home') ?>"><i class="feather icon-home"></i></a>
						</li>
						<li class="breadcrumb-item">
							<a href="<?= site_url('admin/tagihan') ?>">Tagihan</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<div class="pcoded-inner-content"  style="margin-top: -20px;margin-bottom: -20px">
		<div class="main-body">
			<div class="page-wrapper">
				<div class="page-body">
					<button class="btn btn-danger btn-round" onclick="ExportPdf()"><span class="fa fa-print"></span> Cetak Dokumen</button>
				</div>
			</div>
		</div>
	</div>

	<div class="pcoded-inner-content">
		<div class="main-body">
			<div class="page-wrapper">
				<div class="page-body">
					<div id="myCanvas" class="row">
						<div class="col-sm-12">
							<div class="card">
								<div class="card-header">
									<h5>Detail Tagihan <?= $tagihan->nama ?></h5>
									<div class="card-header-right"> <ul class="list-unstyled card-option"> <li class="first-opt"><i class="feather icon-chevron-left open-card-option"></i></li> <li><i class="feather icon-maximize full-card"></i></li> <li><i class="feather icon-minus minimize-card"></i></li> <li><i class="feather icon-refresh-cw reload-card"></i></li> <li><i class="feather icon-trash close-card"></i></li> <li><i class="feather icon-chevron-left open-card-option"></i></li> </ul> </div>					
								</div>
								<div class="card-block">
									<!-- <form id="main" method="post" action="https://colorlib.com/" novalidate> -->
										<?= $this->session->flashdata('pesan'); ?>
										<?= $this->session->flashdata('error'); ?>
										<div class="row">
											<div class="col-sm-4">
												<input type="hidden" name="id" value="<?= $tagihan->id ?>">
												<div class="form-group">
													<label class="col-form-label font-weight-bold">No Faktur</label><br>
													<?php if($tagihan->no_faktur==null){ ?>
														No Faktur Belum Ada
													<?php } else { ?>
														<?= $tagihan->no_faktur ?>
													<?php } ?>
												</div>
												<div class="form-group">
													<label class="col-form-label font-weight-bold">Nama Supplier</label><br>
													<?php 
														if ($tagihan->id_supplier==$supplier->id) { 
															echo $supplier->nama;
                                                    } ?>		
												</div>
												<div class="form-group">
													<label class="col-form-label font-weight-bold">Nama Tagihan</label><br>
													<?= $tagihan->nama ?>
												</div>
												<div class="form-group">
													<label class="col-form-label font-weight-bold">Biaya</label><br>
													Rp. <?= rupiah($tagihan->biaya) ?>,-
												</div>
												<div class="form-group">
													<label class="col-form-label font-weight-bold">Keterangan</label><br>
													<?= $tagihan->keterangan ?>
												</div>
											</div>
											<div class="col-sm-4">
												<div class="form-group">
													<label class="col-form-label font-weight-bold">Nama Officer Loket</label><br>
													<?php 
														if ($tagihan->nik_loket==$loket->nik) {
															echo $loket->nama;
														} else {
	                                                    	echo 'Belum di Acc Loket';
                                                    } ?>												
												</div>
												<div class="form-group">
													<label class="col-form-label font-weight-bold">Nama Officer Finance</label><br>
													<?php
														if ($tagihan->nik_fin==$finance->nik) {
															echo $finance->nama;
														} else {
	                                                    	echo 'Belum di Acc Finance';
                                                    } ?>															
												</div>
												<div class="form-group">
													<label class="col-form-label font-weight-bold">Tanggal Tagihan</label><br>
													<?= date('d F Y', strtotime($tagihan->tgl_tagihan)) ?>
												</div>
												<div class="form-group">
													<label class="col-form-label font-weight-bold">Tanggal Transfer</label><br>
													<?php if($tagihan->tgl_transfer==null){ echo '-'; }
														else { echo date('d F Y', strtotime($tagihan->tgl_transfer)); } ?>
												</div>
											</div>
											<div class="col-sm-4">
												<div class="form-group">
													<label class="col-form-label font-weight-bold">Status</label><br>
														<?php 
														if($tagihan->status=='Menunggu Acc Loket') {
										                  echo '<label class="label label-sm label-warning" style="text-align:center">'.$tagihan->status.'</label>';
										                }
										                else if($tagihan->status=='Menunggu Acc GA') {
										                  echo '<label class="label label-sm label-warning" style="text-align:center">'.$tagihan->status.'</label>';
										                } 
										                else if($tagihan->status=='Menunggu Acc Finance') {
										                  echo '<label class="label label-sm label-warning" style="text-align:center">'.$tagihan->status.'</label>';
										                } 
										                else if($tagihan->status=='Diterima Finance') {
										                  echo '<label class="label label-sm label-info" style="text-align:center">'.$tagihan->status.'</label>';
										                } 
										                else if($tagihan->status=='Ditolak Loket') {
										                  echo '<label class="label label-sm label-inverse" style="text-align:center">'.$tagihan->status.'</label>';
										                }
										                else if($tagihan->status=='Ditolak GA') {
										                  echo '<label class="label label-sm label-inverse" style="text-align:center">'.$tagihan->status.'</label>';
										                } 
										                else if($tagihan->status=='Ditolak Finance') {
										                  echo '<label class="label label-sm label-inverse" style="text-align:center">'.$tagihan->status.'</label>';
										                } 
										                else if($tagihan->status=='Selesai') {
										                  echo '<label class="label label-sm label-success" style="text-align:center">'.$tagihan->status.'</label>';
										                } ?>
												</div>
												<div class="form-group">
													<label class="col-form-label font-weight-bold">Keterangan Status</label><br>
													<?php if ($tagihan->ket_status==null) {
														echo "-";
													} else { echo $tagihan->ket_status; } ?>
												</div>
												<div class="form-group">
													<label class="col-form-label font-weight-bold">Bukti Transfer</label>
													<div class="form-group" id="photo">
														<div><?php if($tagihan->bukti_transfer==null){
																echo 'Bukti transfer belum ada';
															} else { ?>
															<img id="uploadPreview" style="max-width:200px;" class="img-thumbnail" src="<?= base_url('assets/img/tagihan/'.$tagihan->bukti_transfer) ?>"/>
															<?php } ?>
															<span class="help-block"></span>
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
			</div>
		</div>

<script src="https://kendo.cdn.telerik.com/2017.2.621/js/jquery.min.js"></script>
<script src="https://kendo.cdn.telerik.com/2017.2.621/js/jszip.min.js"></script>
<script src="https://kendo.cdn.telerik.com/2017.2.621/js/kendo.all.min.js"></script>
<script type="text/javascript">
n =  new Date();
y = n.getFullYear();
m = n.getMonth() + 1;
d = n.getDate();
document.getElementById("date").innerHTML = "Tanggal : "+ d + "/" + m + "/" + y; //Full date Bulan/tanggal/tahun
document.getElementById("date1").innerHTML = d + "/" + m + "/" + y; //Full date Bulan/tanggal/tahun
</script>
<script type="text/javascript">
     function ExportPdf(){ 
kendo.drawing
    .drawDOM("#myCanvas", 
    { 
        paperSize: "A4",
        margin: { left:"1cm", right:"1cm" ,top: "0", bottom: "0.2cm" },
        scale: 0.61,
        height: 800
    })
        .then(function(group){
        kendo.drawing.pdf.saveAs(group, "Tagihan <?= $tagihan->nama; ?>.pdf")
    });
}
</script>