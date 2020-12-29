document.addEventListener("DOMContentLoaded", function(event) {
    document.form_login.addEventListener('submit', (e) => {
        e.preventDefault();

        let login = {
            usuario: document.querySelector('#usuario').value,
            contrasena: document.querySelector('#contrasena').value
        };

        $.ajax({
            type: "POST",
            url: "/login/iniciarSesion",
            data: { login },
            success: function(result) {
                if (result.error && result.tipo === 'validaciones') {
                    //foco al primer elemento con error
                    document.querySelector(`#${Object.keys(result.errores)[0]}`).focus();
                }

                if (result.error && result.tipo === 'no_encontrado') {
                    document.querySelector(`#usuario`).focus();
                }

                if (!result.error) {
                    location.href = result.url;
                }
            }
        });
    });
});
