  <!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
      <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
    </div>

    <!-- Content Row -->
    <div class="row">

      <!-- Earnings (Monthly) Card Example -->
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Pendapatan Bulan Ini</div>
                <div class="h6 mb-0 font-weight-bold text-gray-800">Rp. <?= number_format($earningMonth, 0, ",", ".") ?></div>
              </div>
              <div class="col-auto">
                <i class="fas fa-calendar fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Earnings (Monthly) Card Example -->
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Pendapatan Tahunan</div>
                <div class="h6 mb-0 font-weight-bold text-gray-800">Rp. <?= number_format($earningYear, 0, ",", ".") ?></div>
              </div>
              <div class="col-auto">
                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Earnings (Monthly) Card Example -->

      <div class="col-xl-3 col-md-6 mb-4">
        <a href="<?= base_url() ?>obatkosong">
          <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Obat Stok Kosong</div>
                  <div class="row no-gutters align-items-center">
                    <div class="col-auto">
                      <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php
                                                                                $query = "SELECT * FROM obat Where stok = 0";
                                                                                $totalObatKosong =  $this->db->query($query)->num_rows();

                                                                                ?>
                        <?= $totalObatKosong ?>
                      </div>
                    </div>
                    <!-- <div class="col">
                    <div class="progress progress-sm mr-2">
                      <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div> -->
                  </div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-exclamation fa-2x text-gray-300"></i>
                </div>
              </div>
            </div>
          </div>
        </a>

      </div>
      <!-- Pending Requests Card Example -->
      <div class="col-xl-3 col-md-6 mb-4">
        <a href="<?= base_url() ?>obatminimum">

          <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Obat Stok Minimum</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800"><?php
                                                                      $query = "SELECT * FROM obat Where stok > 0 AND stok <= min_stok";
                                                                      $totalObatKurangDariMinStok =  $this->db->query($query)->num_rows();

                                                                      ?>
                    <?= $totalObatKurangDariMinStok ?>
                  </div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-exclamation-triangle fa-2x text-gray-300"> </i>
                </div>
              </div>
            </div>
          </div>
        </a>

      </div>
    </div>
    <!-- <h1 class="h6 mb-4 text-gray-800">Sistem Pelaporan Produk Daging Hewan</h1> -->
    <img src="<?= base_url() ?>assets/images/dashboard.svg" class="rounded mx-auto d-block" width="300px" alt="...">
  </div>
  <!-- /.container-fluid -->