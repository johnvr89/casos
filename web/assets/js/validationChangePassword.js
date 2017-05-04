var changePasswordValidationEngine = function (id) {
    "use strict";
    /*----------- BEGIN validationEngine CODE -------------------------*/
    /*----------- END validationEngine CODE -------------------------*/

    /*----------- BEGIN validate CODE -------------------------*/
    $('#' + id).validate({
        rules: {
           
            oldPassword: {
                required: true
            },
            newPassword: {
                required: true
            },
            confirmPassword: {
                passwordrequiredcondition: true

            }
        },
        messages: {
            oldPassword: {
                required: "* Este campo es requerido"
            },
            newPassword: {
                required: "* Este campo es requerido"
            },
            confirmPassword: {
                required: "* Este campo es requerido",
                passwordrequiredcondition: 'Las contraseñas no coinciden'

            }
        },
        errorClass: 'help-block col-xs',
        errorElement: 'span',
        highlight: function (element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass('has-success').addClass('has-error');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass('has-error').addClass('has-success');
        },
        errorPlacement: function(error, element) {
            $(error).appendTo( $(element).parents('.form-group') );
        }

    });
    /*----------- END validate CODE -------------------------*/
}