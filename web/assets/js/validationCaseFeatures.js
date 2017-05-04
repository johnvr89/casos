var caseFeatureValidationEngine = function(){
    "use strict";
    /*----------- BEGIN validationEngine CODE -------------------------*/
    /*----------- END validationEngine CODE -------------------------*/

    /*----------- BEGIN validate CODE -------------------------*/
    $('#form-addCaseFeaturesModal').validate({
        rules: {
            nombreCampo: {
                required: true,
                minlength: 2,
                maxlength: 200,
                letterspacenumber: true

            },
            tipoCampo: {
                required: true,
                min:1
            }
        },
        messages: {
            nombreCampo: {
                required: "* Este campo es requerido",
                minlength: "Introduzca al menos 2 caracteres",
                maxlenght: "Solo se permiten como m&aacute;ximo 200 caracteres",
                letterspacenumber: 'Solo se permiten letras, espacios o n&uacute;meros',
            },
            tipoCampo: {
                required: "* Este campo es requerido",
                min: "Debe seleccionar una opci&oacute;n"
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