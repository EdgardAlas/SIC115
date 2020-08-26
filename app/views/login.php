<!DOCTYPE html>
<!-- saved from url=(0072)http://demo.themekita.com/atlantis/livepreview/examples/demo1/login.html -->
<html lang="en"
    class="wf-flaticon-n4-inactive wf-lato-n7-active wf-lato-n9-active wf-fontawesome5solid-n4-active wf-fontawesome5regular-n4-active wf-fontawesome5brands-n4-active wf-simplelineicons-n4-active wf-lato-n4-active wf-lato-n3-active wf-active">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport">

    <!-- Fonts and icons -->
    <script src="<?=URL_BASE?>/public/assets/login/webfont.min.js.descargar"></script>
    <link rel="stylesheet" href="<?=URL_BASE?>/public/assets/login/css" media="all">
    <link rel="stylesheet" href="<?=URL_BASE?>/public/assets/login/fonts.min.css" media="all">
    <link rel="icon" href="<?=URL_BASE?>/public/assets/img/icon.ico" type="image/x-icon" />
    <script>
    WebFont.load({
        google: {
            "families": ["Lato:300,400,700,900"]
        },
        custom: {
            "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands",
                "simple-line-icons"
            ],
            urls: ['<?=URL_BASE?>/public/assets/login/css/fonts.min.css']
        },
        active: function() {
            sessionStorage.fonts = true;
        }
    });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="<?=URL_BASE?>/public/assets/login/bootstrap.min.css">
    <link rel="stylesheet" href="<?=URL_BASE?>/public/assets/login/atlantis.css">
</head>

<body class="login">
    <div class="wrapper wrapper-login">
        <div class="container container-login animated fadeIn" style="display: block;">
            <h3 class="text-center">Iniciar sesión</h3>
            <div class="login-form">
                <div class="form-group form-floating-label">
                    <input id="username" name="username" type="text" class="form-control input-border-bottom"
                        required="">
                    <label for="username" class="placeholder">Username</label>
                </div>
                <div class="form-group form-floating-label">
                    <input id="password" name="password" type="password" class="form-control input-border-bottom"
                        required="">
                    <label for="password" class="placeholder">Password</label>
                    <div class="show-password">
                        <i class="icon-eye"></i>
                    </div>
                </div>
                <div class="form-action mb-3">
                    <button class='btn btn-primary btn-rounded btn-login'>Iniciar Sesión</button>
                </div>
            </div>
        </div>
    </div>
    <script src="<?=URL_BASE?>/public/assets/js/core/jquery.3.2.1.min.js"></script>
    <script src="<?=URL_BASE?>/public/assets/js/core/popper.min.js"></script>
    <script src="<?=URL_BASE?>/public/assets/js/core/bootstrap.min.js"></script>
    <script src="<?=URL_BASE?>/public/assets/login/jquery-ui.min.js.descargar"></script>
    <script src="<?=URL_BASE?>/public/assets/js/atlantis.min.js"></script>

</body>

</html>