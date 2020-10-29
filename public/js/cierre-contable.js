const monto = new Cleave('#inventario_final', {
    numeral: true,
    numeralThousandsGroupStyle: 'thousand',
    numeralPositiveOnly: true,
    numeralDecimalMark: '.',
    delimiter: ',',
    prefix: '$'
});

$(document).ready(() => {
    focus('inventario_final');
    titulo('Cierre Contable');
});