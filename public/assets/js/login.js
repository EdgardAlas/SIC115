$(document).ready(function() {
    $("form").on("submit", function(event) {
        event.preventDefault();
        validarLogin();
    });
});

function validarLogin() {
    let user = $('#user').val(),
        password = $('#password').val();

    $.post('login/validarLogin', { user, password }, function(data) {
        if (!data.error) {
            location.href = data.redireccion;
        } else {
            focusCampo('user');
        }
    });
}