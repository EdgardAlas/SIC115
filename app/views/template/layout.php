<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">

    <!-- cache -->
    <meta http-equiv="Expires" content="0">

    <meta http-equiv="Last-Modified" content="0">

    <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">


    <title> <?= (isset($titulo)) ? $titulo : ''?></title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="<?=URL_BASE?>/public/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=URL_BASE?>/public/assets/css/dataTables.bootstrap4.min.css" />
    <link rel="stylesheet" href="<?=URL_BASE?>/public/assets/css/all.css">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="<?=URL_BASE?>/public/assets/css/select2.min.css" />

    <!-- Template CSS -->
    <link rel="stylesheet" href="<?=URL_BASE?>/public/assets/css/style.css">
    <link rel="stylesheet" href="<?=URL_BASE?>/public/assets/css/custom.css" />
    <link rel="stylesheet" href="<?=URL_BASE?>/public/assets/css/components.css">
</head>

<body>
    <div id="app">
        <div class="main-wrapper">
            <?= (isset($navbar)) ? $navbar : ''?>
            <?= (isset($sidebar)) ? $sidebar : ''?>
            <?= (isset($main)) ? $main : ''?>
            <?= (isset($footer)) ? $footer : ''?>
        </div>
        <a id="back-to-top" href="#" class="btn btn-secondary btn-lg back-to-top" role="button"
            style="opacity: 1; display: none;"><i class="fas fa-chevron-up"></i></a>
    </div>

    <!-- General JS Scripts -->
    <script src="<?=URL_BASE?>/public/assets/js/plugins/jquery-3.4.1.min.js"></script>
    <script src="<?=URL_BASE?>/public/assets/js/plugins/popper.min.js"></script>
    <script src="<?=URL_BASE?>/public/assets/js/plugins/bootstrap.min.js"></script>
    <script src="<?=URL_BASE?>/public/assets/js/plugins/jquery.nicescroll.min.js"></script>
    <script src="<?=URL_BASE?>/public/assets/js/plugins/stisla.js"></script>

    <!-- JS Libraies -->
    <script src="<?=URL_BASE?>/public/assets/js/plugins/sweetalert2.js"></script>
    <script src="<?=URL_BASE?>/public/assets/js/plugins/cleave.min.js"></script>
    <script src="<?=URL_BASE?>/public/assets/js/plugins/jquery.dataTables.min.js"></script>
    <script src="<?=URL_BASE?>/public/assets/js/plugins/select2.min.js"></script>
    <script src="<?=URL_BASE?>/public/assets/js/plugins/shortcut.js"></script>

    <!-- Template JS File -->
    <script src="<?=URL_BASE?>/public/js/utils.js"></script>
    <script src="<?=URL_BASE?>/public/assets/js/plugins/scripts.js"></script>
    <script src="<?=URL_BASE?>/public/assets/js/plugins/custom.js"></script>
    <script src="<?=URL_BASE?>/public/js/sidebar.js"></script>

    <!-- Page Specific JS File -->
    <?= isset($js_especifico) ? $js_especifico : '';?>

</body>

</html>