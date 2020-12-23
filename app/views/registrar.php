<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Registrarte</title>
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
                <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">

                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Registrarte</h4>
                        </div>

                        <div class="card-body">
                            <form id='form_registrar'>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="form-group col-12">

                                            <label for="nombre">Nombre de la Empresa</label>
                                            <input id="nombre" type="text" class="form-control" name="nombre" required
                                                   autofocus data-ok=0>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label for="usuario" class="d-block">Usuario <small>(min. 8 caracteres)</small></label>
                                            <input id="usuario" type="text" class="form-control" name="usuario"
                                                   required data-ok=0>
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="correo" class="d-block">Correo</label>
                                                <input id="correo" type="email" class="form-control" name="email" required
                                                   data-ok=0>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label for="contrasena" class="d-block">Contraseña <small>(min. 8 caracteres)</small></label>
                                            <input id="contrasena" type="password" class="form-control"
                                                   name="contrasena" required>
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="contrasenav" class="d-block">Confirmar Contraseña</label>
                                            <input id="contrasenav" type="password" class="form-control"
                                                   name="contrasenav" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" id="registrar" class="btn btn-primary btn-lg btn-block">
                                        Registrarte
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
<script src="<?= URL_BASE ?>/public/js/utils.js"></script>
<script src="<?= URL_BASE ?>/public/js/registrar.js"></script>
</body>

</html>