var companyValidationEngine = function(id){
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
            direccion: {
                required: true,
                minlength: 1
            },
            descripcion: {
                required: true,
                minlength: 1
            },
            tipoIdentificacion: {
                required: true,
                 selectionrequired:true
            },
            numeroIdentificacion: {
                required: true,
                digits: true
            },
            telefono: {
                required: true,
                digits: 1
            },
            correo: {
                required: true,
                email: true
            },
            razonSocial: {
                minlength: 2
            },
            claveSri: {
                required: true
            },
            representante: {
                minlength: 2
            },
            tipoCliente: {
                required: true,
                min:1
            },
            ciudad: {
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
            direccion: {
                required: "* Este campo es requerido",
                minlength: "Introduzca al menos 1 caracteres",
            },
            descripcion: {
                required: "* Este campo es requerido",
                 minlength: "Introduzca al menos 1 caracteres",
            },
            tipoIdentificacion: {
                required: "* Este campo es requerido",
                selectionrequired: "Debe seleccionar una opci&oacute;n"
            },
            numeroIdentificacion: {
                required: "* Este campo es requerido",
                digits:'Solo se aceptan n&uacute;meros.'
            },
            telefono: {
                required: "* Este campo es requerido",
                digits:'Solo se aceptan n&uacute;meros.'
                
            },
            correo: {
                required: "* Este campo es requerido",
                email:'Direcci&oacute;n de correo electr&oacute;nico incorrecta.'
            },
             razonSocial: {
                minlength: "Introduzca al menos 2 caracteres",
              
            },
            claveSri: {
                required: "* Este campo es requerido"
            },
            representante: {
                minlength: "Introduzca al menos 2 caracteres",
            },
            tipoCliente: {
                required: "* Este campo es requerido",
                min: "Debe seleccionar una opci&oacute;n"
            },
            ciudad: {
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