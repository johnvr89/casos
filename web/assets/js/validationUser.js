var userValidationEngine = function (id, requiredPassword) {
    "use strict";
    /*----------- BEGIN validationEngine CODE -------------------------*/
    /*----------- END validationEngine CODE -------------------------*/

    /*----------- BEGIN validate CODE -------------------------*/
    $('#' + id).validate({
        rules: {
            username: {
                required: true,
                minlength: 2,
                maxlength: 20,
                alphanumeric: true

            },
            nombreinterfaz: {
                required: true,
                minlength: 2,
                maxlength: 100,
                letterspacenumber: true

            },
            correo: {
                required: true,
                email: true
            },
            password: {
                required: requiredPassword


            },
            passwordConfirm: {
                passwordrequiredcondition: true

            }
        },
        messages: {
            password: {
                required: "* Este campo es requerido"


            },
            passwordConfirm: {
                required: "* Este campo es requerido",
                passwordrequiredcondition: 'Las contraseñas no coinciden'

            },
            username: {
                required: "* Este campo es requerido",
                minlength: "Introduzca al menos 2 caracteres",
                maxlenght: "Solo se permiten como m&aacute;ximo 20 caracteres",
                alphanumeric: 'Solo se permiten letras o n&uacute;meros',
            },
            nombreinterfaz: {
                required: "* Este campo es requerido",
                minlength: "Introduzca al menos 2 caracteres",
                maxlenght: "Solo se permiten como m&aacute;ximo 100 caracteres",
                letterspacenumber: 'Solo se permiten letras, espacios o n&uacute;meros',
            },
            correo: {
                required: "* Este campo es requerido",
                email: 'Direcci&oacute;n de correo electr&oacute;nico incorrecta.'
            },
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