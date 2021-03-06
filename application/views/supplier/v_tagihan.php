<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
      $('.tagihan').addClass('active');
      $('.data-tagihan').addClass('active');
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
						<h5>Data Tagihan</h5>
						<span>Berikut data tagihan ....</span>
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
  
  <div class="pcoded-inner-content"  style="margin-top: -20px;margin-bottom: -20px">
    <div class="main-body">
      <div class="page-wrapper">
        <div class="page-body">
          <a href="<?= site_url('tagihan/laporan') ?>" class="btn btn-danger btn-round" onclick="ExportPdf()"><span class="fa fa-file"></span> Laporan Tagihan</a>
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
							<h5>Data Seluruh Tagihan</h5>
              <div class="card-header-right"> <ul class="list-unstyled card-option"> <li class="first-opt"><i class="feather icon-chevron-left open-card-option"></i></li> <li><i class="feather icon-maximize full-card"></i></li> <li><i class="feather icon-minus minimize-card"></i></li> <li><i class="feather icon-refresh-cw reload-card"></i></li> <li><i class="feather icon-trash close-card"></i></li> <li><i class="feather icon-chevron-left open-card-option"></i></li> </ul> </div>
						</div>
						<div class="card-block">
							<div class="dt-responsive">
								<table id="compact" class="table table-bordered table-hover nowrap table-responsive" width="100%">
									<thead>
										<tr><th width="1%">No</th>
										<th>No Faktur</th>
                    <th>Tanggal Tagihan</th>
										<th>Tagihan</th>
                    <th>Biaya</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                    <th width="10%">Action</th>
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
        ajax: {"url": "<?= base_url() ?>tagihan/json", "type": "POST"},
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
        {"data": "tgl_tagihan",
            render: function(data) { 
                var datePart = data.match(/\d+/g),
                year = datePart[0].substring(0), // get only four digits
                month = datePart[1], day = datePart[2];

                var ttgl =  day+'-'+month+'-'+year;
                return ttgl
                // return data
            }, 
            defaultContent: 'tgl_tagihan'
        },
        {"data": "nama"},
        {"data": "biaya",
          render: function(data) { 
            var reverse = data.toString().split('').reverse().join(''),
            ribuan  = reverse.match(/\d{1,3}/g);
            ribuan  = ribuan.join('.').split('').reverse().join('');
                  return 'Rp.'+ribuan+',-';
            },
            defaultContent: 'biaya'
        },
        // {"data": "status"},
        {"data": "status",
        	render: function(data) { 
                if(data==='Menunggu Acc Loket') {
                  return '<label class="label label-sm label-warning" style="width:100%; text-align:center">'+data+'</label>' 
                }
                else if(data==='Menunggu Acc GA') {
                  return '<label class="label label-sm label-warning" style="width:100%; text-align:center">'+data+'</label>' 
                } 
                else if(data==='Menunggu Acc Finance') {
                  return '<label class="label label-sm label-warning" style="width:100%; text-align:center">'+data+'</label>' 
                } 
                else if(data==='Diterima Finance') {
                  return '<label class="label label-sm label-info" style="width:100%; text-align:center">'+data+'</label>' 
                } 
                else if(data==='Ditolak Loket') {
                  return '<label class="label label-sm label-inverse" style="width:100%; text-align:center">'+data+'</label>' 
                }
                else if(data==='Ditolak GA') {
                  return '<label class="label label-sm label-inverse" style="width:100%; text-align:center">'+data+'</label>' 
                } 
                else if(data==='Ditolak Finance') {
                  return '<label class="label label-sm label-inverse" style="width:100%; text-align:center">'+data+'</label>' 
                } 
                else if(data==='Selesai') {
                  return '<label class="label label-sm label-success" style="width:100%; text-align:center">'+data+'</label>' 
                }

              },
              defaultContent: 'Status'
            
      	},
        {"data": "ket_status",
          render: function(data) { 
                if(data!==null) {
                  return data 
                } else {
                    return '<p align="center">-</p>'
                }},
              defaultContent: 'ket_status'
        },
        {"data": "view","orderable": false}
        ],
        order: [[2, 'desc']],
        rowCallback: function(row, data, iDisplayIndex) {
            var info = this.fnPagingInfo();
            var page = info.iPage;
            var length = info.iLength;
            var index = page * length + (iDisplayIndex + 1);
            $('td:eq(0)', row).html(index);
        }
    });

    //Fun Hapus
    function hapus(id)
    {
    	if(confirm('Anda yakin ingin menghapus data?'))
      	{
            // ajax delete data to database
            $.ajax({
              url : '<?php echo site_url("tagihan/hapus/'+id+'") ?>',
              type: "POST",
              dataType: "JSON",
              data: { <?= $this->security->get_csrf_token_name(); ?> : function () {
                refreshTokens();
                return $( "#csrfHash" ).val();
              }},
              success: function(data)
              {
                    //if success reload ajax table
                    $('#modal_form').modal('hide');
                    reload_table();
                  },
                  error: function (jqXHR, textStatus, errorThrown)
                  {
                    alert('Data Gagal Dihapus, Data Mungkin Sedang Digunakan');
                  }
                });
        }
    }

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