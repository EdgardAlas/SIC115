<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Reestablecer Contraseña</title>
    <link rel="shortcut icon" href="<?= URL_BASE ?>/public/assets/img/favicon.png" type="image/x-icon">

    <!-- General CSS Files -->
    <link rel="stylesheet" href="<?= URL_BASE ?>/public/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= URL_BASE ?>/public/assets/css/all.css">

    <!-- Template CSS -->
    <link rel="stylesheet" href="<?= URL_BASE ?>/public/assets/css/style.css">
    <link rel="stylesheet" href="<?= URL_BASE ?>/public/assets/css/custom.css"/>
    <link rel="stylesheet" href="<?= URL_BASE ?>/public/assets/css/components.css">
</head>

<body>
<div id="app">
    <section class="section">
        <div class="container mt-5">
            <div class="row">
                <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                    <div class="card card-primary">
                        <div class="card-header"><h4>Reestablecer Contraseña</h4></div>

                        <div class="card-body">
                            <p class="text-muted">Se enviara un correo con el codigo de verificación</p>
                            <form method="POST" id="form_reestablecer">
                                <div class="form-group">
                                    <label for="correo">Correo Electronico</label>
                                    <input type="email" class="form-control" id="correo" tabindex="1"
                                           required autofocus>
                                </div>

                                <div class="form-group">
                                    <label for="nueva">Contraseña nueva</label>
                                    <input  type="password" class="form-control pwstrength"
                                           data-indicator="pwindicator" id="nueva" tabindex="2" required>
                                    <div id="pwindicator" class="pwindicator">
                                        <div class="bar"></div>
                                        <div class="label"></div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="confirmar">Confirmar Contraseña</label>
                                    <input  type="password" class="form-control"
                                           id="confirmar" tabindex="2" required>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4" id="submit">
                                        Reset Password
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
<script src="<?= URL_BASE ?>/public/assets/js/plugins/jquery-3.4.1.min.js"></script>
<script src="<?= URL_BASE ?>/public/assets/js/plugins/popper.min.js"></script>
<script src="<?= URL_BASE ?>/public/assets/js/plugins/bootstrap.min.js"></script>
<script src="<?= URL_BASE ?>/public/assets/js/plugins/jquery.nicescroll.min.js"></script>
<script src="<?= URL_BASE ?>/public/assets/js/plugins/moment.min.js"></script>
<script src="<?= URL_BASE ?>/public/assets/js/plugins/stisla.js"></script>

<!-- JS Libraies -->
<script src="<?= URL_BASE ?>/public/assets/js/plugins/sweetalert2.js"></script>

<!-- Template JS File -->
<script src="<?= URL_BASE ?>/public/assets/js/plugins/scripts.js"></script>
<script src="<?= URL_BASE ?>/public/assets/js/plugins/custom.js"></script>
<script src="<?= URL_BASE ?>/public/assets/js/sidebar/sidebar.js"></script>

<!-- Page Specific JS File -->
<script src="<?=URL_BASE?>/public/js/utils.js"></script>
<script src="<?= URL_BASE ?>/public/js/reestablecer.js"></script>
</body>

</html>