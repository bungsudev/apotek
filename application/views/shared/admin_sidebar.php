<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url() ?>dashboard">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fa fa-chart-bar"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Dashboard Apotek</div>
    </a>

    <hr class="sidebar-divider my-0">
    <li class="nav-item <?php if ($currentPage == 'dashboard') echo 'active' ?>">
        <a class="nav-link" href="<?= base_url() ?>dashboard">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    <hr class="sidebar-divider">

    <div class="sidebar-heading">
        Master Data
    </div>
    <?php if ($_SESSION['apotek_role_id'] == '1') {
    ?>
        <li class="nav-item <?php if ($currentPage == 'user') echo 'active' ?>">
            <a class="nav-link" href="<?= base_url() ?>user">
                <i class="fas fa-fw fa-user"></i>
                <span>Data User</span>
            </a>
        </li>
    <?php
                                                                                    }
    ?>
    <?php if ($_SESSION['apotek_role_id'] != '3') {
    ?>
        <li class="nav-item <?php if ($currentPage == 'profil') echo 'active' ?>">
            <a class="nav-link" href="<?= base_url() ?>profil">
                <i class="fas fa-fw fa-hospital"></i>
                <span>Profile Apotek</span>
            </a>
        </li>

        <li class="nav-item <?php if ($currentPage == 'kategori_obat') echo 'active' ?>">
            <a class="nav-link" href="<?= base_url() ?>kategori_obat">
                <i class="fas fa-fw fa-list-alt"></i>
                <span>Data Kategori Obat</span>
            </a>
        </li>
        <li class="nav-item <?php if ($currentPage == 'satuan_obat') echo 'active' ?>">
            <a class="nav-link" href="<?= base_url() ?>satuan_obat">
                <i class="fas fa-fw fa-capsules"></i>
                <span>Data Satuan Obat</span>
            </a>
        </li>
        <li class="nav-item <?php if ($currentPage == 'supplier') echo 'active' ?>">
            <a class="nav-link" href="<?= base_url() ?>supplier">
                <i class="fas fa-fw fa-diagnoses"></i>
                <span>Data Supplier</span>
            </a>
        </li>
        <li class="nav-item <?php if ($currentPage == 'obat') echo 'active' ?>">
            <a class="nav-link" href="<?= base_url() ?>obat">
                <i class="fas fa-fw fa-pills"></i>
                <span>Data Obat</span>
            </a>
        </li>
        <hr class="sidebar-divider d-none d-md-block">
    <?php
                                                                                    } ?>

    <div class="sidebar-heading">
        Transaksi
    </div>
    <li class="nav-item <?php if ($currentPage == 'kartustok') echo 'active' ?>">
        <a class="nav-link" href="<?= base_url() ?>kartustok">
            <i class="fas fa-fw fa-sticky-note"></i>
            <span>Kartu Stok</span></a>
    </li>
    <li class="nav-item <?php if ($currentPage == 'penjualan') echo 'active' ?>">
        <a class="nav-link" href="<?= base_url() ?>penjualan">
            <i class="fas fa-fw fa-shopping-cart"></i>
            <span>Penjualan Obat</span></a>
    </li>
    <?php if ($_SESSION['apotek_role_id'] != '3') {
    ?>
        <li class="nav-item <?php if ($currentPage == 'pembelian') echo 'active' ?>">
            <a class="nav-link" href="<?= base_url() ?>pembelian">
                <i class="fas fa-fw fa-shipping-fast"></i>
                <span>Pembelian Obat</span></a>
        </li>
        <li class="nav-item <?php if ($currentPage == 'barangrusak') echo 'active' ?>">
            <a class="nav-link" href="<?= base_url() ?>barangrusak">
                <i class="fas fa-fw fa-undo"></i>
                <span>Obat Rusak / Musnah</span></a>
        </li>
        <hr class="sidebar-divider d-none d-md-block">

        <div class="sidebar-heading">
            Re-Inventory Obat
        </div>
        <li class="nav-item <?php if ($currentPage == 'obatkosong') echo 'active' ?>">
            <a class="nav-link" href="<?= base_url() ?>obatkosong">
                <i class="fas fa-fw fa-stethoscope"></i>
                <span>Obat Stok Kosong </span>
                <?php
                                                                                        $query = "SELECT * FROM obat Where stok = 0";
                                                                                        $totalObatKosong =  $this->db->query($query)->num_rows();
                                                                                        if ($totalObatKosong > 0) {
                ?>
                    <span class="badge badge-danger"><?= $totalObatKosong ?></span>
                <?php
                                                                                        }
                ?>
            </a>
        </li>
        <li class="nav-item <?php if ($currentPage == 'obatminimum') echo 'active' ?>">
            <a class="nav-link" href="<?= base_url() ?>obatminimum">
                <i class="fas fa-fw fa-prescription-bottle-alt"></i>
                <span>Obat Stok Minimum </span>
                <?php
                                                                                        $query = "SELECT * FROM obat Where stok > 0 AND stok < min_stok";
                                                                                        $totalObatKurangDariMinStok =  $this->db->query($query)->num_rows();
                                                                                        if ($totalObatKurangDariMinStok > 0) {
                ?>
                    <span class="badge badge-warning"><?= $totalObatKurangDariMinStok ?></span>
                <?php
                                                                                        }
                ?>
            </a>
        </li>
        <hr class="sidebar-divider d-none d-md-block">

        <div class="sidebar-heading">
            Report
        </div>
        <li class="nav-item <?php if ($currentPage == 'laporanlabarugi') echo 'active' ?>">
            <a class="nav-link" href="<?= base_url() ?>laporan/laporanlabarugi">
                <i class="fas fa-fw fa-money-bill-alt"></i>
                <span>Laporan Laba Rugi</span></a>
        </li>
        <li class="nav-item <?php if ($currentPage == 'laporanpenjualan') echo 'active' ?>">
            <a class="nav-link" href="<?= base_url() ?>laporan/laporanpenjualan">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>Laporan Penjualan</span></a>
        </li>
        <li class="nav-item <?php if ($currentPage == 'laporanpembelian') echo 'active' ?>">
            <a class="nav-link" href="<?= base_url() ?>laporan/laporanpembelian">
                <i class="fas fa-fw fa-chart-bar"></i>
                <span>Laporan Pembelian</span></a>
        </li>
        <li class="nav-item <?php if ($currentPage == 'laporanbarangrusak') echo 'active' ?>">
            <a class="nav-link" href="<?= base_url() ?>laporan/laporanbarangrusak">
                <i class="fas fa-fw fa-chart-line"></i>
                <span>Laporan Obat Rusak</span></a>
        </li>
        <li class="nav-item <?php if ($currentPage == 'laporanretur') echo 'active' ?>">
            <a class="nav-link" href="<?= base_url() ?>laporan/laporanretur">
                <i class="fas fa-fw fa-chart-pie"></i>
                <span>Laporan Retur Obat</span></a>
        </li>
        <hr class="sidebar-divider d-none d-md-block">
    <?php
                                                                                    }
    ?>

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->