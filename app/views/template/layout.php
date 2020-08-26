<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>SIC115</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <link rel="icon" href="<?=URL_BASE?>/public/assets/img/icon.ico" type="image/x-icon" />

    <!-- Fonts and icons -->
    <script src="<?=URL_BASE?>/public/assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
        WebFont.load({
            google: {
                "families": ["Lato:300,400,700,900"]
            },
            custom: {
                "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"],
                urls: ['<?=URL_BASE?>/public/assets/login/fonts.min.css']
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="<?=URL_BASE?>/public/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=URL_BASE?>/public/assets/css/atlantis.min.css">

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="<?=URL_BASE?>/public/assets/css/demo.css">
</head>

<body>
    <div class="wrapper overlay-sidebar">
        <!--Header-->
        <?= isset($header) ? $header : '';?>

        <?= isset($header) ? $sidebar : '';?>

        <?= isset($main) ? $main : '';?>
        
        <?= isset($footer) ? $footer : '';?>
        </div>

    </div>
    <!--   Core JS Files   -->
    <script src="<?=URL_BASE?>/public/assets/js/core/jquery.3.2.1.min.js"></script>
    <script src="<?=URL_BASE?>/public/assets/js/core/popper.min.js"></script>
    <script src="<?=URL_BASE?>/public/assets/js/core/bootstrap.min.js"></script>

    <!-- jQuery UI -->
    <script src="<?=URL_BASE?>/public/assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
    <script src="<?=URL_BASE?>/public/assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>

    <!-- jQuery Scrollbar -->
    <script src="<?=URL_BASE?>/public/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

    <!-- jQuery Sparkline -->
    <script src="<?=URL_BASE?>/public/assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

    <!-- Datatables -->
    <script src="<?=URL_BASE?>/public/assets/js/plugin/datatables/datatables.min.js"></script>

    <!-- jQuery Vector Maps -->
    <script src="<?=URL_BASE?>/public/assets/js/plugin/jqvmap/jquery.vmap.min.js"></script>
    <script src="<?=URL_BASE?>/public/assets/js/plugin/jqvmap/maps/jquery.vmap.world.js"></script>

    <!-- Sweet Alert -->
    <script src="<?=URL_BASE?>/public/assets/js/plugin/sweetalert/sweetalert.min.js"></script>

    <!-- Atlantis JS -->
    <script src="<?=URL_BASE?>/public/assets/js/atlantis.min.js"></script>

    <!-- js especifico -->
    <script src="<?=URL_BASE?>/public/js/sidebar.js"></script>
    <script src="<?=URL_BASE?>/public/js/utils.js"></script>
    <?= isset($js_especifico) ? $js_especifico : '';?>
</body>

</html>