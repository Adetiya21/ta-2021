<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('.officer').addClass('active');
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
                    <i class="feather icon-layout bg-c-blue"></i>
                    <div class="d-inline">
                        <h5>Officer</h5>
                        <span>Berikut daftar officer ....</span>
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
                            <a href="<?= site_url('admin/officer') ?>">Officer</a>
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
                            <h5>Daftar Officer</h5>
                            <div class="card-header-right"> <ul class="list-unstyled card-option"> <li class="first-opt"><i class="feather icon-chevron-left open-card-option"></i></li> <li><i class="feather icon-maximize full-card"></i></li> <li><i class="feather icon-minus minimize-card"></i></li> <li><i class="feather icon-refresh-cw reload-card"></i></li> <li><i class="feather icon-trash close-card"></i></li> <li><i class="feather icon-chevron-left open-card-option"></i></li> </ul> </div>
                        </div>
                        <div style="position: absolute;right: 20px; top: 15px;">
                            <button class="btn btn-primary btn-round" onclick="tambah()"><span class="fa fa-edit"></span> Input Data</button>	
                        </div>

                        <div class="card-block">
                            <div class="dt-responsive table-responsive">
                                <table id="compact" class="table table-bordered table-hover nowrap" width="100%">
                                    <thead>
                                        <tr><th width="1%">No</th>
                                            <th width="10%">Foto</th>
                                            <th>NIK</th>
                                            <th>Nama Officer</th>
                                            <th>Email</th>
                                            <th>No. Telp</th>
                                            <th>Jabatan</th>
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
        ajax: {"url": "<?= base_url() ?>admin/officer/json", "type": "POST"},
        columns: [
        {
            "data": "nik",
            "orderable": false
        },
        {"data": "gambar","orderable": false,
        render: function(data) { 
            if(data!==null) {
                // return 'Tidak Ada Foto'
                return '<img class="img-thumbnail" width="100%" height="100" src="<?= base_url('assets/img/officer/') ?>'+data+'">' 
            } else {
                return '<i>(Tidak ada foto)</i>'
            }},
            defaultContent: 'gambar'
        },
        {"data": "nik"},
        {"data": "nama"},
        {"data": "email"},
        {"data": "no_telp"},
        {"data": "tipe","orderable": false,
        render: function(data) { 
            if (data=='Finance') {
                return '<label class="label label-sm label-primary text-center" style="width:90%">'+data+'</label>'
            } else if (data=='GA') {
                return '<label class="label label-sm label-danger text-center" style="width:90%">'+data+'</label>'
            } else if (data=='Loket') {
                return '<label class="label label-sm label-warning text-center" style="width:90%">'+data+'</label>'
            }
        },
        defaultContent: 'tipe'
    },
    {"data": "view","orderable": false}
    ],
    order: [[6, 'asc']],
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

//Fun Hapus
function hapus(nik)
{
    if(confirm('Anda yakin ingin menghapus data?'))
    {
        // ajax delete data to database
        $.ajax({
            url : '<?php echo site_url("admin/officer/hapus/'+nik+'") ?>',
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

//fun tambah
function tambah()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Tambah Officer'); // Set Title to Bootstrap modal title
}

//fun edit
function edit(nik)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $.ajax({
        url : '<?php echo site_url("admin/officer/edit/'+nik+'") ?>',
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            $('#nik').attr('readOnly', 'true');
            $('[name="nik"]').val(data.nik);
            $('[name="nama"]').val(data.nama);
            $('[name="email"]').val(data.email);
            $('[name="no_telp"]').val(data.no_telp);
            $('[name="tipe"]').val(data.tipe);
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Data Officer'); // Set title to Bootstrap modal title
            if(data.gambar)
            {
                $('#label-photo').text('Change Photo'); // label photo upload
                $('#photo-preview div').html('<img src="<?= base_url('assets/img/officer/') ?>'+data.gambar+'" width="200px" class="img-responsive">'); // show photo
                $('#photo-preview div').append('<br><input type="checkbox" name="remove_photo" value="'+data.gambar+'"/> Remove old photo when saving'); // remove photo
            }
            else
            {
                $('#label-photo').text('Upload Photo'); // label photo upload
                $('#photo-preview div').text('(Tidak ada photo)');
            }
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

    if(save_method == 'add') {
        url = "<?php echo site_url('admin/officer/tambah')?>";
    } else {
        url = "<?php echo site_url('admin/officer/update')?>";
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
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label >NIK</label>
                                    <input type="text" class="form-control" placeholder="Masukkan No.NIK" name="nik" required maxlength="13" onkeypress='return check_int(event)' id="nik"/>
                                    <span class="help-block"></span>
                                </div>
                                <div class="form-group">
                                    <label >Nama officer</label>
                                    <input type="text" class="form-control" placeholder="Masukkan Nama Officer" name="nama" required/>
                                    <span class="help-block"></span>
                                </div>
                                <div class="form-group">
                                    <label >Email</label>
                                    <input type="text" class="form-control" placeholder="Masukkan Email" name="email" required/>
                                    <span class="help-block"></span>
                                </div>
                                <div class="form-group">
                                    <label >No. Telp</label>
                                    <input type="text" class="form-control" placeholder="Masukkan No.Telp" name="no_telp" required maxlength="13" onkeypress='return check_int(event)'/>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label >Jabatan</label>
                                    <select name="tipe" class="form-control">
                                        <option>--- Pilih Tipe Jabatan ---</option>
                                        <option value="Loket">Loket</option>
                                        <option value="GA">GA</option>
                                        <option value="Finance">Finance</option>
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Foto</label><br>
                                    <input id="uploadImage" type="file" name="gambar" onchange="PreviewImage();" class="form-control" accept='image/*' />
                                    <p style="font-size: 0.7em; padding: 5px;">JPG, JPEG, PNG Max. 2MB</p>
                                    <div class="form-group" id="photo-preview">
                                        <div>
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                    <div class="form-group" id="photo">
                                        <div>
                                            <img id="uploadPreview" style="max-width:200px;" class="img-thumbnail" />
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
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