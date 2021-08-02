<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('.tagihan').addClass('active');
        $('.data-tagihan').addClass('active');
        $('.seluruh-tagihan').addClass('active');
    });

    function check_int(evt) {
        var charCode = ( evt.which ) ? evt.which : event.keyCode;
        return ( charCode >= 48 && charCode <= 57 || charCode == 8 );
    }

    function PreviewImage() {
        $('#photo-preview div').empty();
        $('#photo div').html('<img id="uploadPreview" style="max-width:200px;" class="img-thumbnail" />'); // show photo
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
                        <h5>Seluruh Data Tagihan</h5>
                        <span>Berikut data seluruh tagihan ....</span>
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
                            <h5>Data Tagihan</h5>
                            <div class="card-header-right"> <ul class="list-unstyled card-option"> <li class="first-opt"><i class="feather icon-chevron-left open-card-option"></i></li> <li><i class="feather icon-maximize full-card"></i></li> <li><i class="feather icon-minus minimize-card"></i></li> <li><i class="feather icon-refresh-cw reload-card"></i></li> <li><i class="feather icon-trash close-card"></i></li> <li><i class="feather icon-chevron-left open-card-option"></i></li> </ul> </div>
                        </div>
                        <div class="card-block">
                            <div class="dt-responsive">
                                <table id="compact" class="table table-bordered table-hover nowrap table-responsive" width="100%">
                                    <thead>
                                        <tr><th width="1%">No</th>
                                            <th>No Faktur</th>
                                            <th>Tanggal Tagihan</th>
                                            <th>Tanggal Transfer</th>
                                            <th>Nama Supplier</th>
                                            <th>Biaya</th>
                                            <th>Status</th>
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
        ajax: {"url": "<?= base_url() ?>officer/tagihan/jsonSeluruh", "type": "POST"},
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
                }
            },
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
        {"data": "tgl_transfer",
            render: function(data) { 
                if (data!==null) {
                    var datePart = data.match(/\d+/g),
                    year = datePart[0].substring(0), // get only four digits
                    month = datePart[1], day = datePart[2];

                    var ttgl =  day+'-'+month+'-'+year;
                    return ttgl
                    // return data
                }else {
                    return '-';
                }
            }, 
            defaultContent: 'tgl_transfer'
        },
        {"data": "nama_supplier"},
        {"data": "biaya",
        render: function(data) { 
            var reverse = data.toString().split('').reverse().join(''),
            ribuan  = reverse.match(/\d{1,3}/g);
            ribuan  = ribuan.join('.').split('').reverse().join('');
            return 'Rp.'+ribuan+',-';
        },
        defaultContent: 'biaya'
    },
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

//fun reload
function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax
}

//fun edit loket
function edit(id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $.ajax({
        url : '<?php echo site_url("officer/tagihan/edit/'+id+'") ?>',
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            $('[name="id"]').val(data.id);
            $('[name="status_faktur"]').val(data.status_faktur);
            $('[name="status_ga"]').val(data.status_ga);
            $('[name="status_fin"]').val(data.status_fin);
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Status Tagihan'); // Set title to Bootstrap modal title
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}

//fun edit ga
function edit_ga(id)
{
    save_method = 'update_ga';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $.ajax({
        url : '<?php echo site_url("officer/tagihan/edit/'+id+'") ?>',
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            $('[name="id"]').val(data.id);
            $('[name="status_faktur"]').val(data.status_faktur);
            $('[name="status_ga"]').val(data.status_ga);
            $('[name="status_fin"]').val(data.status_fin);
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Status Tagihan'); // Set title to Bootstrap modal title
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}

//fun edit fin
function edit_fin(id)
{
    save_method = 'update_fin';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $.ajax({
        url : '<?php echo site_url("officer/tagihan/edit/'+id+'") ?>',
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            $('[name="id"]').val(data.id);
            $('[name="status_faktur"]').val(data.status_faktur);
            $('[name="status_ga"]').val(data.status_ga);
            $('[name="status_fin"]').val(data.status_fin);
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Status Tagihan'); // Set title to Bootstrap modal title
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}

//fun simpan
function save()
{
    refreshTokens();
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable
    var url;

    if(save_method == 'update') {
        url = "<?php echo site_url('officer/tagihan/update_fak')?>";
    } else if(save_method == 'update_ga') {
        url = "<?php echo site_url('officer/tagihan/update_ga')?>";
    } else if(save_method == 'update_fin') {
        url = "<?php echo site_url('officer/tagihan/update_fin')?>";
    }
    // ajax adding data to database
    var formData = new FormData($('#form')[0]);
    $.ajax({
        url : url,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",

        success: function(data)
        {
        if(data.status) //if success close modal and reload ajax table
        {
            $('#modal_form').modal('hide');
            reload_table();
        } else
        {
            for (var i = 0; i < data.inputerror.length; i++)
            {
                $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
            }
        }
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable
        }
    });
}

function refreshTokens() {
    var url = "<?= base_url()."welcome/get_tokens" ?>";
    $.get(url, function(theResponse) {
        /* you should do some validation of theResponse here too */
        $('#csrfHash').val(theResponse);;
    });
}
</script>

<h4 class="modal-title">Modal title</h4>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
</button>

<!--modal tambah dan edit -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" id="csrfHash" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
                    <div class="modal-body">
                        <input type="hidden" name="id">
                        <div class="form-group">
                            <label >Status</label>
                            <?php if($this->session->userdata('tipe')=='Loket') { ?>
                            <select name="status_faktur" class="form-control" id="test">
                                <option>--- Pilih Status Tagihan ---</option>
                                <option value="Menunggu">Menunggu</option>
                                <option value="Diterima">Diterima</option>
                                <option value="Ditolak">Ditolak</option>
                            </select>
                            <?php } else if($this->session->userdata('tipe')=='GA') { ?>
                            <select name="status_ga" class="form-control" id="test">
                                <option>--- Pilih Status Tagihan ---</option>
                                <option value="Menunggu">Menunggu</option>
                                <option value="Diterima">Diterima</option>
                                <option value="Ditolak">Ditolak</option>
                            </select>
                            <?php } else if($this->session->userdata('tipe')=='Finance') { ?>
                            <select name="status_fin" class="form-control" id="test">
                                <option>--- Pilih Status Tagihan ---</option>
                                <option value="Menunggu">Menunggu</option>
                                <option value="Selesai">Selesai</option>
                                <option value="Ditolak">Ditolak</option>
                            </select>
                            <?php } ?>
                            <span class="help-block"></span>
                        </div>
                        <div class="form-group" id="hidden_div1" style="display: none;">
                            <label >Tanggal Transfer</label>
                            <input type="date" class="form-control" name="tgl_transfer">
                            <span class="help-block"></span>
                        </div>
                        <div class="form-group" id="hidden_div3" style="display: none;">
                            <label for="exampleInputEmail1">Bukti Transfer</label><br>
                            <input id="uploadImage" type="file" name="gambar" onchange="PreviewImage();" class="form-control" accept='image/*' />
                            <p style="font-size: 0.6em; padding: 5px;">JPG, JPEG, PNG Max. 2MB</p>
                            <div class="form-group" id="photo">
                                <div>
                                    <img id="uploadPreview" style="max-width:250px;" class="img-thumbnail" />
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group" id="hidden_div2" style="display: none;">
                            <label >Keterangan</label>
                            <textarea class="form-control" name="keterangan"></textarea>
                            <span class="help-block"></span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="pull-right">
                    <button type="button" id="btnSave" onclick="save()" class="btn btn-primary"><i class="fa fa-edit "></i> Simpan</button>
                </div>
                <div class="pull-left">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
    document.getElementById('test').addEventListener('change', function () {
        var style = this.value == 'Ditolak' ? 'block' : 'none';
        document.getElementById('hidden_div2').style.display = style;
    });
</script>

<script type="text/javascript">
    document.getElementById('test').addEventListener('change', function () {
        var style = this.value == 'Selesai' ? 'block' : 'none';
        document.getElementById('hidden_div1').style.display = style;
    });
</script>

<script type="text/javascript">
    document.getElementById('test').addEventListener('change', function () {
        var style = this.value == 'Selesai' ? 'block' : 'none';
        document.getElementById('hidden_div3').style.display = style;
    });
</script>