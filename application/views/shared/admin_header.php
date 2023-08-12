<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?= $title ?></title>
    <!-- Custom fonts for this template-->
    <link href="<?= base_url() ?>assets/admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url() ?>assets/admin/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom styles for data table -->
    <link href="<?= base_url() ?>assets/admin/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <!-- Custom styles for sweetalert2 -->
    <link href="<?= base_url() ?>assets/css/sweetalert2.css" rel="stylesheet">

    <!-- Custom styles for bootstrap select -->
    <link href="<?= base_url() ?>assets/css/bootstrap-select.css" rel="stylesheet">

    <!-- Main Quill library -->
    <script src="<?= base_url() ?>assets/js/quill.js"></script>
    <script src="<?= base_url() ?>assets/js/image-resize.min.js"></script>

    <!-- Theme included stylesheets -->
    <link href="<?= base_url() ?>assets/css/quill-snow.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/css/quill-bubble.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary" id="page-top">
    <script src="<?= base_url() ?>assets/admin/vendor/jquery/jquery.min.js"></script>

    <!-- Loading -->
    <div class="loading"></div>
    <script>
        $(document).ready(function() {
            $('.loading').hide()
        })
    </script>
    <!-- Page Wrapper -->
    <div id="wrapper">