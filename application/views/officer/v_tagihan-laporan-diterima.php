<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
      $('.tagihan').addClass('active');
      $('.laporan-tagihan').addClass('active');
      $('.laporan-diterima').addClass('active');
  	});


    function check_int(evt) {
      var charCode = ( evt.which ) ? evt.which : event.keyCode;
      return ( charCode >= 48 && charCode <= 57 || charCode == 8 );
    }
</script>

<div class="pcoded-content">
	<div class="page-header card">
		<div class="row align-items-end">
			<div class="col-lg-8">
				<div class="page-header-title">
					<i class="feather icon-book bg-c-blue"></i>
					<div class="d-inline">
						<h5>Laporan Tagihan <label class="label label-sm label-success" style="text-align:center">
                            <?php if($this->session->userdata('tipe')=='Finance'){ echo 'Selesai'; } 
                                else { echo 'Diterima'; } ?>
                        </label></h5>
						<span>Berikut data laporan tagihan yang 
                            <?php if($this->session->userdata('tipe')=='Finance'){ echo 'diselesaikan '.$tipe; } 
                                else { ?>
                            diterima <?= $tipe; }?>.</span>
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
							<a href="<?= site_url('officer/tagihan') ?>">Tagihan</a>
						</li>
						<li class="breadcrumb-item">
							<a href="<?= site_url('officer/tagihan/diterima/'.$tipe) ?>">Laporan</a>
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
					<div class="card">
						<div class="card-header">
							<h5>Laporan Data Tagihan Yang 
                                <?php if($this->session->userdata('tipe')=='Finance'){ echo 'diselesaikan '.$tipe; } 
                                else { ?>
                            diterima <?= $tipe; }?></h5>
							<div class="card-header-right"> <ul class="list-unstyled card-option"> <li class="first-opt"><i class="feather icon-chevron-left open-card-option"></i></li> <li><i class="feather icon-maximize full-card"></i></li> <li><i class="feather icon-minus minimize-card"></i></li> <li><i class="feather icon-refresh-cw reload-card"></i></li> <li><i class="feather icon-trash close-card"></i></li> <li><i class="feather icon-chevron-left open-card-option"></i></li> </ul> </div>
						</div>
						<div class="card-block">
							<div id="" class="dt-responsive">
								<table id="compact" class="myCanvas table table-bordered table-hover nowrap table-responsive" width="100%">
									<thead>
										<tr><th width="1%">No</th>
										<th>No Faktur</th>
                                        <th>Tanggal Tagihan</th>
                                        <th>Nama Supplier</th>
                                        <th>Officer Loket</th>
                                        <th>Tagihan</th>
                                        <th width="10%">Biaya</th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
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

<!-- DataTables -->
<script src="<?= base_url('assets/') ?>datatables/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets/') ?>datatables/js/dataTables.bootstrap.js"></script>

<script src="<?= base_url('assets/') ?>bower_components/datatables.net/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?= base_url('assets/') ?>bower_components/datatables.net-buttons/js/dataTables.buttons.min.js" type="text/javascript"></script>
<script src="<?= base_url('assets/') ?>assets/pages/data-table/js/jszip.min.js" type="text/javascript"></script>
<script src="<?= base_url('assets/') ?>assets/pages/data-table/js/pdfmake.min.js" type="text/javascript"></script>
<script src="<?= base_url('assets/') ?>assets/pages/data-table/js/vfs_fonts.js" type="text/javascript"></script>
<script src="<?= base_url('assets/') ?>bower_components/datatables.net-buttons/js/buttons.print.min.js" type="text/javascript"></script>
<script src="<?= base_url('assets/') ?>bower_components/datatables.net-buttons/js/buttons.html5.min.js" type="text/javascript"></script>
<script src="<?= base_url('assets/') ?>bower_components/datatables.net-bs4/js/dataTables.bootstrap4.min.js" type="text/javascript"></script>
<script src="<?= base_url('assets/') ?>bower_components/datatables.net-responsive/js/dataTables.responsive.min.js" type="text/javascript"></script>
<script src="<?= base_url('assets/') ?>bower_components/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js" type="text/javascript"></script>
<!-- page script -->

<script type="text/javascript">

    $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings)
    {
        return {
            "iStart": oSettings._iDisplayStart,
            "iEnd": oSettings.fnDisplayEnd(),
            "iLength": oSettings._iDisplayLength,
            "iTotal": oSettings.fnRecordsTotal(),
            "iFilteredTotal": oSettings.fnRecordsDisplay(),
            "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
            "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
        };
    };

    var table = $('#compact').DataTable({
        oLanguage: {
            sProcessing: "loading..."
        },
        processing: true,
        serverSide: true,
        ajax: {"url": "<?= base_url() ?>officer/tagihan/jsonTerima", "type": "POST"},
        columns: [
        {
            "data": "id",
            "orderable": false
        },
        {"data": "no_faktur",
        render: function(data) { 
            if(data!==null) {
                return data 
            } else {
                return '<i>(Tidak ada No Faktur)</i>'
            }},
            defaultContent: 'no_faktur'
        },
        // {"data": "tgl",
        //     render: function(data) { 
        //         var datePart = data.match(/\d+/g),
        //         year = datePart[0].substring(0), // get only four digits
        //         month = datePart[1], day = datePart[2];

        //         var ttgl =  day+'-'+month+'-'+year;
        //         return ttgl
        //         // return data
        //     }, 
        //     defaultContent: 'tgl'
        // },        
        {"data": "tgl"},
        {"data": "nama_supplier"},
        {"data": "nama_officer"},
        {"data": "nama_tagihan"},
        {"data": "biaya",
	        render: function(data) { 
	        	var	reverse = data.toString().split('').reverse().join(''),
				ribuan 	= reverse.match(/\d{1,3}/g);
				ribuan	= ribuan.join('.').split('').reverse().join('');
	        	return 'Rp. '+ribuan+',-';
	        },
            defaultContent: 'Status'
	    }
        ],
        order: [[2, 'desc']],
        rowCallback: function(row, data, iDisplayIndex) {
            var info = this.fnPagingInfo();
            var page = info.iPage;
            var length = info.iLength;
            var index = page * length + (iDisplayIndex + 1);
            $('td:eq(0)', row).html(index);
        },
        dom: 'Bfrtip',
        buttons: [
            {
                extend:    'excelHtml5',
                text:      '<i class="fa fa-file-excel-o"></i>',
                titleAttr: 'Excel'
            },
            {
                extend:    'pdfHtml5',
                text:      '<i class="fa fa-file-pdf-o"></i>',
                titleAttr: 'PDF'
            }, 'print'
        ]
    });

    //fun reload
    function reload_table()
    {
        table.ajax.reload(null,false); //reload datatable ajax
    }

    function refreshTokens() {
        var url = "<?= base_url()."welcome/get_tokens" ?>";
        $.get(url, function(theResponse) {
          /* you should do some validation of theResponse here too */
          $('#csrfHash').val(theResponse);;
      });
    }
</script>
<script src="https://kendo.cdn.telerik.com/2017.2.621/js/jquery.min.js"></script>
<script src="https://kendo.cdn.telerik.com/2017.2.621/js/jszip.min.js"></script>
<script src="https://kendo.cdn.telerik.com/2017.2.621/js/kendo.all.min.js"></script>
<script type="text/javascript">
     function ExportPdf(){ 
kendo.drawing
    .drawDOM(".myCanvas", 
    { 
        paperSize: "A4",
        margin: { left:"1cm", right:"1cm" ,top: "0.5cm", bottom: "0.2cm" },
        scale: 0.61,
        height: 800
    })
        .then(function(group){
        kendo.drawing.pdf.saveAs(group, "Laporan Tagihan Diterima <?= $tagihan->nama; ?>.pdf")
    });
}
</script>