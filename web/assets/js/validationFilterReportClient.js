var reportClientValidationEngine = function (id) {
    "use strict";
    /*----------- BEGIN validationEngine CODE -------------------------*/
    /*----------- END validationEngine CODE -------------------------*/

    /*----------- BEGIN validate CODE -------------------------*/
    $('#' + id).validate({
        rules: {
            inicio: {
                required: true,
               

            },
            fin: {
             required: true
         }
        },
        messages: {
            inicio: {
                required: "* Este campo es requerido",
               
            },

            fin: {
                required: "* Este campo es requerido",
              
            }
        },
        errorClass: 'help-block col-xs',
        errorElement: 'span',
        highlight: function (element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass('has-success').addClass('has-error');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass('has-error').addClass('has-success');
        }

    });
    /*----------- END validate CODE -------------------------*/
}