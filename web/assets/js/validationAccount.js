var accountValidationEngine = function(id){
    "use strict";
    /*----------- BEGIN validationEngine CODE -------------------------*/
    /*----------- END validationEngine CODE -------------------------*/

    /*----------- BEGIN validate CODE -------------------------*/
    $('#'+id).validate({
        rules: {
            nombre: {
                required: true,
                minlength: 2,
                maxlength: 200,
                letterspacenumber: true

            },
            numero: {
                required: true,
                digits: true
            },
            tipoCuenta: {
                required: true,
                selectionrequired:true
            },
            banco: {
                required: true,
                min:1
            }
        },
        messages: {
            nombre: {
                required: "* Este campo es requerido",
                minlength: "Introduzca al menos 2 caracteres",
                maxlenght: "Solo se permiten como m&aacute;ximo 200 caracteres",
                letterspacenumber: 'Solo se permiten letras, espacios o n&uacute;meros',
            },
            numero: {
                required: "* Este campo es requerido",
                digits: "Solo se aceptan n&uacute;meros."
            },
            tipoCuenta: {
                required: "* Este campo es requerido",
                selectionrequired: "Debe seleccionar una opci&oacute;n"
            },
            banco: {
                required: "* Este campo es requerido",
                min: "Debe seleccionar una opci&oacute;n"
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