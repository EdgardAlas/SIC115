function cargarBalance(){
    $('#div_balance').load('/balance-general/forma-cuenta');
}

$(document).ready(()=>{
    titulo('Balance General');

    tablaSinPaginacion('balance');

    cargarBalance();
});