jQuery(($) => {

    //document field jquerymask

    $('#cpf').mask('000.000.000-00', {
        onKeyPress: function (cep, e, field, options) {
            var masks = ['000.000.000-000', '00.000.000/0000-00'];
            var mask = (cep.length >= 15) ? masks[1] : masks[0];
            $('#document').mask(mask, options);
        }
    });

    $('.cpf-mask').mask('000.000.000-00', {
        onKeyPress: function (cep, e, field, options) {
            var masks = ['000.000.000-000', '00.000.000/0000-00'];
            var mask = (cep.length >= 15) ? masks[1] : masks[0];
            $('#document').mask(mask, options);
        }
    });


    $('#document').mask('000.000.000-00');

    $('.money').mask("#.##0,00", {reverse: true});


    //phone field jquerymask

    var SPMaskBehavior = function (val) {
        return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
      },
      spOptions = {
        onKeyPress: function(val, e, field, options) {
            field.mask(SPMaskBehavior.apply({}, arguments), options);
          }
      };
      
      $('.phone').mask(SPMaskBehavior, spOptions);

})