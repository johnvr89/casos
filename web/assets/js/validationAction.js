var actionValidationEngine = function(id){
    "use strict";
    /*----------- BEGIN validationEngine CODE -------------------------*/
    /*----------- END validationEngine CODE -------------------------*/

    /*----------- BEGIN validate CODE -------------------------*/
    $('#'+id).validate({
        rules: {
            alias: {
                required: true,
                minlength: 2,
                maxlength: 200,
                letterspacenumber: true
            },
            controlador: {
                required: true,
                minlength: 2,
                maxlength: 200
            },
            nombre: {
                required: true,
                minlength: 2,
                maxlength: 200
            },
            aliasContrador: {
                required: true,
                minlength: 2,
                maxlength: 200,
                letterspacenumber: true

            },
            descripcion: {
                required: true,
                minlength: 2,
                maxlength: 200
            },
            posicion: {
                required: true,
                digits: true
            }
        },
        messages: {
            nombre: {
                required: "* Este campo es requerido",
                minlength: "Introduzca al menos 2 caracteres",
                maxlenght: "Solo se permiten como m&aacute;ximo 200 caracteres",
                
            },
            controlador: {
                required: "* Este campo es requerido",
                minlength: "Introduzca al menos 2 caracteres",
                maxlenght: "Solo se permiten como m&aacute;ximo 200 caracteres",
                
            },
             alias: {
                required: "* Este campo es requerido",
                minlength: "Introduzca al menos 2 caracteres",
                maxlenght: "Solo se permiten como m&aacute;ximo 200 caracteres",
                letterspacenumber: 'Solo se permiten letras, espacios o n&uacute;meros',
            },
             aliasContrador: {
                required: "* Este campo es requerido",
                minlength: "Introduzca al menos 2 caracteres",
                maxlenght: "Solo se permiten como m&aacute;ximo 200 caracteres",
                letterspacenumber: 'Solo se permiten letras, espacios o n&uacute;meros',
            },
             descripcion: {
                required: "* Este campo es requerido",
                minlength: "Introduzca al menos 2 caracteres",
                maxlenght: "Solo se permiten como m&aacute;ximo 200 caracteres"
              
            },
            posicion: {
                required: "* Este campo es requerido",
                digits: "Solo se aceptan n&uacute;meros."
            }
        },
        errorClass: 'help-block col-xs',
        errorElement: 'span',
        highlight: function(element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass('has-success').addClass('has-error');
            console.debug($(element));
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