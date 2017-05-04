var traceValidationEngine = function (id) {
    "use strict";
    /*----------- BEGIN validationEngine CODE -------------------------*/
    /*----------- END validationEngine CODE -------------------------*/

    /*----------- BEGIN validate CODE -------------------------*/
    $('#' + id).validate({
        rules: {
            nombre: {
                required: true,
                minlength: 2,
                maxlength: 200,
                letterspacenumber: true

            },
            descripcion: {
                required: true,
                minlength: 1
            },
            observacion: {
                required: true,
                minlength: 1
            }
        },
        messages: {
            nombre: {
                required: "* Este campo es requerido",
                minlength: "Introduzca al menos 2 caracteres",
                maxlenght: "Solo se permiten como m&aacute;ximo 200 caracteres",
                letterspacenumber: 'Solo se permiten letras, espacios o n&uacute;meros',
            },

            descripcion: {
                required: "* Este campo es requerido",
                minlength: "Introduzca al menos 1 caracteres",
            },
            observacion: {
                required: "* Este campo es requerido",
                minlength: "Introduzca al menos 1 caracteres",
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