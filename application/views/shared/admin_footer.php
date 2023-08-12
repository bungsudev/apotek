   <?php
    if ($currentPage != 'login') {
        ?>
       </div>
       <!-- End of Main Content -->

       <!-- Footer -->
       <footer class="sticky-footer bg-white">
           <div class="container my-auto">
               <div class="copyright text-center my-auto">
                   <span>Copyright &copy; Sistem Informasi Apotek by Ariyozi <?= date("Y") ?></span>
               </div>
           </div>
       </footer>
       <!-- End of Footer -->

       </div>
       <!-- End of Content Wrapper -->
       </div>
       <!-- Scroll to Top Button-->
       <a class="scroll-to-top rounded" href="#page-top">
           <i class="fas fa-angle-up"></i>
       </a>
   <?php
    }
    ?>

   <!-- Bootstrap core JavaScript-->
   <script src="<?= base_url() ?>assets/admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

   <!-- Main Bootstrap Select library -->
   <script src="<?= base_url() ?>assets/js/bootstrap-select.js"></script>
   <!-- Core plugin JavaScript-->
   <script src="<?= base_url() ?>assets/admin/vendor/jquery-easing/jquery.easing.min.js"></script>

   <!-- Custom scripts for all pages-->
   <script src="<?= base_url() ?>assets/admin/js/sb-admin-2.min.js"></script>

   <!-- Sweetalert2 -->
   <script src="<?= base_url() ?>assets/js/function.js"></script>
   <script src="<?= base_url() ?>assets/js/sweetalert2.js"></script>

   <!-- Data Table Requirement -->
   <script src="<?= base_url() ?>assets/admin/vendor/datatables/jquery.dataTables.min.js"></script>
   <script src="<?= base_url() ?>assets/admin/vendor/datatables/dataTables.bootstrap4.min.js"></script>

   <script src="<?= base_url() ?>assets/admin/js/demo/datatables-demo.js"></script>
   <!-- End Data Table Requirement -->

   <?php
    if ($currentPage == 'dashboard') {
        ?>
       <!-- Dashboard Section -->
       <script src="<?= base_url() ?>assets/admin/vendor/chart.js/Chart.min.js"></script>
       <script src="<?= base_url() ?>assets/admin/js/demo/chart-area-demo.js"></script>
       <script src="<?= base_url() ?>assets/admin/js/demo/chart-pie-demo.js"></script>
       <!-- End Dashboard Section -->
   <?php
    }
    ?>


   </body>

   </html>