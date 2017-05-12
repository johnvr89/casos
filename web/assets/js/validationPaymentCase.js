var paymentValidationEngine = function(id){
    "use strict";
    /*----------- BEGIN validationEngine CODE -------------------------*/
    /*----------- END validationEngine CODE -------------------------*/

    /*----------- BEGIN validate CODE -------------------------*/
    $('#'+id).validate({
        rules: {
            valorPagado: {
                required: true,
                currency:["$",false]
            },
          
            formaPago: {
                required: true,
                min:1
            },
            tipoCobro: {
                required: true,
                min:1
            },
            fechaProximoCobro: {
                conditionalvalue: true
            }
        },
        messages: {
             valorPagado: {
                required: "* Este campo es requerido",
                currency:'Especifique una cantidad v&aacute;lida'
                
            },
            formaPago: {
                required: "* Este campo es requerido",
                min: "Debe seleccionar una opci&oacute;n"
            },
            tipoCobro: {
                required: "* Este campo es requerido",
                min: "Debe seleccionar una opci&oacute;n"
            },
            fechaProximoCobro: {
                conditionalvalue: '* Este campo es requerido'
            }
        },
        errorClass: 'help-block col-xs',
        errorElement: 'span',
        highlight: function(element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass('has-success').addClass('has-error');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass('has-error').addClass('has-success');
        },
        errorPlacement: function(error, element) {
            $(error).appendTo( $(element).parents('.form-group') );
        }
            
    });
    /*----------- END validate CODE -------------------------*/
}