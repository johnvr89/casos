var caseValidationEngine = function(id){
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
            resolucion: {
                required: true,
                letterspacenumber: true

            },
            tipocaso: {
                required: true,
                min:1
            },
            empresa: {
                required: true,
                min:1
            },
            responsable: {
                required: true,
                min:1
            },
            
            ciudad: {
                required: true,
                min:1
            },

            honorarios: {
                required: true,
                currency:["$",false]
            },
            'integer[]':{
                required: true,
                min:0,
                digits: true
            },
            'float[]':{
                required: true,
                currency: ["$", false]
            },
            'string[]':{
                required: true
                
            },
            'date[]':{
                required: true
                
                
            }

        },
        messages: {
            nombre: {
                required: "* Este campo es requerido",
                minlength: "Introduzca al menos 2 caracteres",
                maxlenght: "Solo se permiten como m&aacute;ximo 200 caracteres",
                letterspacenumber: 'Solo se permiten letras, espacios o n&uacute;meros'
            },
            observacion: {
                required: "* Este campo es requerido",
                letterspacenumber: 'Solo se permiten letras, espacios o n&uacute;meros'
            },
            resolucion: {
                required: "* Este campo es requerido",
                letterspacenumber: 'Solo se permiten letras, espacios o n&uacute;meros'
            },
             tipocaso: {
                required: "* Este campo es requerido",
                min: "Debe seleccionar una opci&oacute;n",
                
            },
             empresa: {
                required: "* Este campo es requerido",
                min: "Debe seleccionar una opci&oacute;n"
            },
             responsable: {
                required: "* Este campo es requerido",
                min: "Debe seleccionar una opci&oacute;n"
            },
             ciudad: {
                required: "* Este campo es requerido",
                min: "Debe seleccionar una opci&oacute;n"
            },

             honorarios: {
                required: "* Este campo es requerido",
                currency:'Especifique una cantidad v&aacute;lida'
                
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
            if ( $(element).hasClass('case-feature') )
            {
            }
            else
            {
                $(error).appendTo( $(element).parents('.form-group') );
            }
        }
            
    });
    /*----------- END validate CODE -------------------------*/
}