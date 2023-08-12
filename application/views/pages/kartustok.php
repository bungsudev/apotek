<!-- Begin Page Content -->
<div class="container-fluid" id="adminObat">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h3 mb-2 text-gray-800">Kartu Stok</h1>
    </div>
    <?php
    if ($this->session->flashdata('message')) {
        echo $this->session->flashdata('message');
    }
    ?>
    <!-- <p class="mb-4">Manage Obat that Home Care Sells</a>.</p> -->
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">List Obat</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive" id="dataTableObat">
            <table class="table  table-bordered" id="data-table" width="100%" cellspacing="0">
                    <thead class="bg-primary text-light">
                        <tr>
                            <th>Nama Obat</th>
                            <th>Sisa Stok</th>
                            <th>Gambar</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="list-obat">
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterModalLabel">Cetak Kartu Stok</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="tracking_date">Nama Obat</label>
                    <input type="hidden" id="id_obat" class="form-control">
                    <input type="text" readonly id="nama_obat" class="form-control">
                </div>
                <div class="form-group">
                    <label for="tracking_date">Tanggal Mulai</label>
                    <input type="date" id="date1" class="form-control" value="<?= date("Y-m-01") ?>">
                </div>
                <div class="form-group">
                    <label for="tracking_date">Tanggal Akhir</label>
                    <input type="date" id="date2" class="form-control" value="<?= date("Y-m-t") ?>">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" data-dismiss="modal" id="filterButton" class="btn btn-primary">Cetak Kartu Stok</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {

        table = $('#data-table').DataTable({

            "processing": true,
            "serverSide": true,
            "order": [],

            "ajax": {
                "url": "<?php echo site_url('kartustok/kartustok_fetch_serverside')?>",
                "type": "POST",
                error(e){
                    console.log(e)
                }
            },


            "columnDefs": [{
                "targets": [0],
                "orderable": false,
            }, ],

        });
        // function getListObat() {
        //     $('.loading').show();
        //     $.ajax({
        //         url: "<?php echo base_url(); ?>kartustok/kartustok_fetch",
        //         method: "POST",
        //         success: function(data) {
        //             $('#dataTableObat').html(data);
        //             $("#dataTable").DataTable();
        //             $('.loading').hide();
        //         },
        //         error: function(err) {
        //             $('.loading').hide()
        //             console.log(err)
        //             swalError('Error ' + err.status, err.statusText);
        //         }
        //     })
        // }

        $(document).on('click', "#filterButton", function() {
            window.location.href = "<?= base_url() ?>kartustok/lihatkartustok/" + $('#id_obat').val() + "/" + $('#date1').val() + "/" + $('#date2').val();

        })
        $(document).on('click', ".cetakKartuStok", function() {
            const id_obat = $(this).data('id_obat');
            const nama_obat = $(this).data('nama_obat');
            $('#id_obat').val(id_obat)
            $('#nama_obat').val(nama_obat)
            $('#filterModal').modal('toggle');
        })

    })
</script>