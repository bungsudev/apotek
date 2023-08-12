<!-- Begin Page Content -->
<div class="container-fluid" id="adminObat">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h3 mb-2 text-gray-800">Obat Stok Kosong</h1>
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
            <h6 class="m-0 font-weight-bold text-primary">List Obat Stok Kosong</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive" id="dataTableObat">

            </div>
        </div>
    </div>

</div>
<script>
    $(document).ready(function() {

        getListObat();

        function getListObat() {
            $('.loading').show();
            $.ajax({
                url: "<?php echo base_url(); ?>obatkosong/obatkosong_fetch",
                method: "POST",
                success: function(data) {
                    $('#dataTableObat').html(data);
                    $("#dataTable").DataTable();
                    $('.loading').hide();
                },
                error: function(err) {
                    $('.loading').hide()
                    console.log(err)
                    swalError('Error ' + err.status, err.statusText);
                }
            })
        }

    })
</script>