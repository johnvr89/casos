$.validator.setDefaults({ignore: ":hidden:not(select)"})

$.validator.addMethod("selectionrequired", function (value, element) {
    return ($(element)).val() != -1;
}, "");
$.validator.addMethod("lettersonly", function (value, element) {

    return this.optional(element) || /^[a-záéíóúñ]+$/.test(value);
}, "Solo se permiten letras min&uacute;sculas");


$.validator.addMethod("passwordrequiredcondition", function (value, element) {
    var valuemain = $('#' + $(element).attr('field-password-equal')).val();
    if (valuemain == null || valuemain == undefined) {
        return true;
    }
    return valuemain == $(element).val();
}, "Las contraseñas no coinciden");

$.validator.addMethod("conditionalvalue", function (value, element) {
    var valuemain = $('#' + $(element).attr('input-depend')).val();

    if (valuemain == $(element).attr('value-depend')) {
        return !($(element).val() == null || $(element).val() == "" || $(element).val() == "");
    }
    return true;
}, "Este campo es requerido");

$.validator.addMethod("allletter", function (value, element) {
    return this.optional(element) || /^[A-Za-záéíóúñÁÉÍÓÚüÜÑ]+$/.test(value);
}, "Solo se permiten letras");

$.validator.addMethod("letterspace", function (value, element) {
    return this.optional(element) || /^([A-Za-záéíóúñÁÉÍÓÚüÜÑ\-]+\s*)+$/.test(value);
}, "Solo se permiten letras y luego espacios");
$.validator.addMethod("select", function (value, element) {
    return this.optional(element) || value != null;
}, "Debe de seleccionar un valor");
$.validator.addMethod("letterspacenumber", function (value, element) {
    return this.optional(element) || /^([A-Z0-9a-záéíóúñÁÉÍÓÚüÜÑ\-\,\;\:\!\?\¡\¿]+\s*)*$/.test(value);
}, "Solo se permiten letras, espacios o n&uacute;meros");
$.validator.addMethod("alphanumeric", function (value, element) {
    return this.optional(element) || /^([A-Z0-9a-záéíóúñÁÉÍÓÚüÜÑ\-]+)*$/.test(value);
}, "Solo se permiten letras, espacios o n&uacute;meros");

$.validator.addMethod("slug", function (value, element) {
    if ($('#template').val() == 2) {
        return /^(http|https):\/\/[\w-]+(\.[\w-]+)+([\w.,@?^=%&amp;:\/~+#-]*[\w@?^=%&amp;\/~+#-])?/.test(value)

    }
    if ($('#template').val() == 3) {
        return  /^([\#])+[a-zA-Z]+([A-Z0-9a-záéíóúñÁÉÍÓÚüÜÑ\-]\s*)*$/.test(value)
    }

    return true;
}, "");


$.validator.addMethod("fieldcheckcount", function (value, element) {

    return $('.order-selected').length > 0;

}, "");

$.validator.addMethod("pagecontentrequired", function (value, element) {
    return $(element).val() != "";
}, "");


$.validator.addMethod("currency", function (value, element, param) {
    var isParamString = typeof param === "string",
            symbol = isParamString ? param : param[0],
            soft = isParamString ? true : param[1],
            regex;

    symbol = symbol.replace(/,/g, "");
    symbol = soft ? symbol + "]" : symbol + "]?";
    regex = "^[" + symbol + "([1-9]{1}[0-9]{0,2}(\\,[0-9]{3})*(\\.[0-9]{0,2})?|[1-9]{1}[0-9]{0,}(\\.[0-9]{0,2})?|0(\\.[0-9]{0,2})?|(\\.[0-9]{1,2})?)$";
    regex = new RegExp(regex);
    return this.optional(element) || regex.test(value);

}, "Please specify a valid currency");

// Accept a value from a file input based on a required mimetype
$.validator.addMethod("accept", function (value, element, param) {
    // Split mime on commas in case we have multiple types we can accept
    var typeParam = typeof param === "string" ? param.replace(/\s/g, "").replace(/,/g, "|") : "image/*",
            optionalValue = this.optional(element),
            i, file;

    // Element is optional
    if (optionalValue) {
        return optionalValue;
    }

    if ($(element).attr("type") === "file") {
        // If we are using a wildcard, make it regex friendly
        typeParam = typeParam.replace(/\*/g, ".*");

        // Check if the element has a FileList before checking each file
        if (element.files && element.files.length) {
            for (i = 0; i < element.files.length; i++) {
                file = element.files[i];

                // Grab the mimetype from the loaded file, verify it matches
                if (!file.type.match(new RegExp(".?(" + typeParam + ")$", "i"))) {
                    return false;
                }
            }
        }
    }

    // Either return true because we've validated each file, or because the
    // browser does not support element.files and the FileList feature
    return true;
}, "Please enter a value with a valid MIMETYPE.");


