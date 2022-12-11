jQuery(($) => {

    //document field jquerymask

    $('#document').mask('000.000.000-00', {
        onKeyPress: function (cep, e, field, options) {
            var masks = ['000.000.000-000', '00.000.000/0000-00'];
            var mask = (cep.length >= 15) ? masks[1] : masks[0];
            $('#document').mask(mask, options);
        }
    });


    //phone field jquerymask

    $('#phone').mask('(00) 0000-0000', {
        onKeyPress: function (cep, e, field, options) {
            var masks = ['(00) 0000-00000', '(00) 00000-0000'];
            var mask = (cep.length >= 15) ? masks[1] : masks[0];
            $('#phone').mask(mask, options);
        }
    });

})