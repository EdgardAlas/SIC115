<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Iniciar Sesión</title>
    <link rel="shortcut icon" href="<?=URL_BASE?>/public/assets/img/favicon.png" type="image/x-icon">

    <!-- General CSS Files -->
    <link rel="stylesheet" href="<?=URL_BASE?>/public/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=URL_BASE?>/public/assets/css/all.css">

    <!-- Template CSS -->
    <link rel="stylesheet" href="<?=URL_BASE?>/public/assets/css/style.css">
    <link rel="stylesheet" href="<?=URL_BASE?>/public/assets/css/custom.css" />
    <link rel="stylesheet" href="<?=URL_BASE?>/public/assets/css/components.css">
</head>

<body>
    <div id="app">
        <section class="section">
            <div class="container mt-5">
                <div class="row">
                    <div
                        class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                        <!--<div class="login-brand">
              <img src="../assets/img/stisla-fill.svg" alt="logo" width="100" class="shadow-light rounded-circle">
            </div>-->

                        <div class="card card-primary">
                            <div class="card-header">
                                <h4>Iniciar Sesión</h4>
                            </div>

                            <div class="card-body">
                                <form method="POST" action="#" class="needs-validation" novalidate="" name='form_login'>
                                    <div class="form-group">
                                        <label for="usuario">Usuario</label>
                                        <input id="usuario" type="text" class="form-control" name="usuario" tabindex="1"
                                            required autofocus>
                                    </div>

                                    <div class="form-group">
                                        <div class="d-block">
                                            <label for="contrasena" class="control-label">Contraseña</label>
                                        </div>
                                        <input id="contrasena" type="password" class="form-control" name="contrasena"
                                            tabindex="2" required>
                                    </div>

                                    <div class="form-group">

                                    </div>

                                    <div class="form-group">
                                        <button type="submit" id='login' class="btn btn-primary btn-lg btn-block"
                                            tabindex="4">
                                            Acceder
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="simple-footer">
                            SIC115 © 2020
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- General JS Scripts -->
    <script src="<?=URL_BASE?>/public/assets/js/plugins/jquery-3.4.1.min.js"></script>
    <script src="<?=URL_BASE?>/public/assets/js/plugins/popper.min.js"></script>
    <script src="<?=URL_BASE?>/public/assets/js/plugins/bootstrap.min.js"></script>
    <script src="<?=URL_BASE?>/public/assets/js/plugins/jquery.nicescroll.min.js"></script>
    <script src="<?=URL_BASE?>/public/assets/js/plugins/moment.min.js"></script>
    <script src="<?=URL_BASE?>/public/assets/js/plugins/stisla.js"></script>

    <!-- JS Libraies -->
    <script src="<?=URL_BASE?>/public/assets/js/plugins/sweetalert2.js"></script>

    <!-- Template JS File -->
    <script src="<?=URL_BASE?>/public/assets/js/plugins/scripts.js"></script>
    <script src="<?=URL_BASE?>/public/assets/js/plugins/custom.js"></script>
    <script src="<?=URL_BASE?>/public/assets/js/sidebar/sidebar.js"></script>

    <!-- Page Specific JS File -->
    <script src="<?=URL_BASE?>/public/js/login.js"></script>
</body>

</html>