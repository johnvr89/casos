/**
 * Created by rene on 4/03/17.
 */
var initCompany = function ()
{
    $('#page-body').html(getCompanyTableHeader());
    buildListCompany();
    if (userPermission.AGEmpresa.post) {
        addModalCompany();
        $('#addModalCompany').on('hidden.bs.modal', function ()
        {
            clearForm('addModalCompany');
        });
    }
    if (userPermission.AGEmpresa.delete) {
        removeModalCompany();
    }
    detailModalCompany();
    if (userPermission.AGEmpresa.put) {
        $('#updateModalContainer').on('hidden.bs.modal', function ()
        {
            clearForm('updateModalContainer');
        });
        updateModalCompany();
    }
};

var buildListCompany = function () {

    var idTable = 'empresa-list';
    waitMeShow();
    excecuteAjax('GET', getRoute('empresalistrectora'), {}, null, function (response)
    {
        if (response.success == true)
        {

            var header = [{dataIndex: 'nombre', dataName: 'Nombre'},
                {dataName: 'Tipo', renderer: function (data) {
                        return data['tipo_cliente'].nombre;
                    }},
                {dataIndex: 'correo', dataName: 'Correo'}, {dataIndex: 'telefono', dataName: 'Tel&eacute;fono'},
                {dataName: 'Ciudad', renderer: function (data) {
                        return data['ciudad'].nombre;
                    }},
            ];
            var actionsArray = ['detail'];
            if (userPermission.AGEmpresa.put) {
                actionsArray.push('update')
            }
            if (userPermission.AGEmpresa.delete) {
                actionsArray.push('delete')
            }


            var htmlTable = buildDataTable(idTable, header, response.data, actionsArray);
            $('#table-data').html(htmlTable);
            $('#table_container').removeClass("hide");
            $('#' + idTable).dataTable();
            waitMeHide();
        }
    }, false, true);
};

var getCompanyTableHeader = function ()
{
    var header = {tableTitle: "Empresa"};
    var modalsArray = [{modalType: "detail", containerId: "detailModalCompany"}];

    if (userPermission.AGEmpresa.post) {
        header.addModalId = "addCompanyModal";
        header.addModalToolTip = "Agregar Nueva Empresa";
        header.addModalTitle = "Nueva empresa";
        modalsArray.push({modalType: "add", containerId: "addModalCompany"});
    }
    if (userPermission.AGEmpresa.put) {
        modalsArray.push({modalType: "update", containerId: "updateModalContainer"});
    }
    if (userPermission.AGEmpresa.delete) {
        modalsArray.push({modalType: "remove", containerId: "removeModalCompany"});
    }

    return buildTableHeader(header, modalsArray);
};

var registerEvent = function (id) {
    $("#" + id + " select[name=tipoCliente]").on('change', function () {
        var val = $("#" + id + " select[name=tipoCliente]").val();
        $("#" + id + " textarea[name=razonSocial]").prop('disabled', val == 1).val('');
        $("#" + id + " input[name=representante]").prop('disabled', val == 1).val('');

    });
};

var convertFile = function () {
    $(":file").filestyle({
        buttonName: "btn-info",
        buttonText: 'Buscar',
        placeholder: 'No hay fichero seleccionado',
        buttonBefore: true,
        size: "sm",
        iconName: "glyphicon glyphicon-picture"
    });
    $('input.filestyle').attr('accept', 'image/*');
}

var addModalCompany = function ()
{

    $('#addModalCompany').load("assets/pages/addCompanyModal.html", {}, function ()
    {
        buildCombo('id', 'nombre', 'ciudadlist', 'ciudad-select');
        buildCombo('id', 'nombre', 'tipoclienteempresarectoralist', 'tipo_cliente');
        companyValidationEngine('form-addCompany');
        convertFile();
        addModalCompanySubmit();
    });
    $('#addModalCompany').on('show.bs.modal', function (e) {

        registerEvent('form-addCompany');
        $("#addModalCompany" + " select[name=tipoCliente]").val('3');
    });
};

var addModalCompanySubmit = function ()
{
    $("#form-addCompany").on("submit", function (e)
    {
        e.preventDefault();
        if ($("#form-addCompany").valid())
        {
            waitMeShow("wrapper");
            var fileInput = document.getElementById("import");
            var file = fileInput.files[0];
            var formdata = new FormData();
            formdata.append('import', file);
            var data = {nombre: $("#form-addCompany input[name=nombre]").val(), direccion: $("#form-addCompany input[name=direccion]").val(),
                descripcion: $("#form-addCompany textarea[name=descripcion]").val(), tipoIdentificacion: $("#form-addCompany select[name=tipoIdentificacion]").val(),
                numeroIdentificacion: $("#form-addCompany input[name=numeroIdentificacion]").val(), telefono: $("#form-addCompany input[name=telefono]").val(),
                correo: $("#form-addCompany input[name=correo]").val(), razonSocial: $("#form-addCompany textarea[name=razonSocial]").val(),
                claveSri: $("#form-addCompany input[name=claveSri]").val(), representante: $("#form-addCompany input[name=representante]").val(),
                tipoCliente: $("#form-addCompany select[name=tipoCliente]").val(), ciudad: $("#form-addCompany select[name=ciudad]").val(), logo: ''};

            formdata.append('company', JSON.stringify(data));

            excecuteAjax('POST', getRoute('empresasave'), formdata, null, function (response)
            {
                if (response.success == true)
                {
                    $("#addCompanyModal").modal('hide');
                    waitMeHide("wrapper");
                    alertify.success("registro ingresado satisfactoriamente");
                    buildListCompany();
                }
            }, true, true);
        }
    });
};

var updateModalCompany = function ()
{
    $('#updateModalContainer').load("assets/pages/updateCompanyModal.html", {}, function ()
    {
        companyValidationEngine('form-updateCompany');
        updateModalCompanySubmit();
        buildCombo('id', 'nombre', 'ciudadlist', 'ciudad-select-update');
        buildCombo('id', 'nombre', 'tipoclienteempresarectoralist', 'tipo_cliente-update');
        convertFile();
    });
    $('#updateModalContainer').on('show.bs.modal', function (e) {

        var data = $(e.relatedTarget).data().recordId;
        var model = controller.getData(data);
        registerEvent('form-updateCompany');
        $("#form-updateCompany input[name=nombre]").val(model.nombre);
        $("#form-updateCompany input[name=direccion]").val(model.direccion);
        $("#form-updateCompany textarea[name=descripcion]").val(model.descripcion);
        $("#form-updateCompany select[name=tipoIdentificacion]").val(model.tipo_identificacion);
        $("#form-updateCompany input[name=numeroIdentificacion]").val(model.numero_identificacion);
        $("#form-updateCompany input[name=telefono]").val(model.telefono);
        $("#form-updateCompany input[name=correo]").val(model.correo);
        $("#form-updateCompany textarea[name=razonSocial]").val(model.razon_social);
        $("#form-updateCompany input[name=claveSri]").val(model.clave_sri);
        $("#form-updateCompany input[name=representante]").val(model.representante);
        $("#form-updateCompany select[name=tipoCliente]").val(model.tipo_cliente.id);
        $("#form-updateCompany select[name=ciudad]").val(model.ciudad.id);
        $("#form-updateCompany textarea[name=razonSocial]").prop('disabled', model.tipo_cliente.id == 1);
        $("#form-updateCompany input[name=representante]").prop('disabled', model.tipo_cliente.id == 1);
        $("#form-updateCompany").attr('data-id', data);

        var logo = 'usuario-logo.png';
        if (model.logo != "") {
            logo = model.logo;
        }
        $('#img-logo-update').attr('src', serviceaddress + '/bundles/app/images/' + logo);
    });
};

var updateModalCompanySubmit = function ()
{
    $("#form-updateCompany").on("submit", function (e)
    {
        e.preventDefault();
        if ($("#form-updateCompany").valid())
        {
            waitMeShow("wrapper");
            var fileInput = document.getElementById("import-update");
            var file = fileInput.files[0];
            var formdata = new FormData();
            if (file) {
                formdata.append('import', file);
            }
            var data = {id: $("#form-updateCompany").attr('data-id'), nombre: $("#form-updateCompany input[name=nombre]").val(), direccion: $("#form-updateCompany input[name=direccion]").val(),
                descripcion: $("#form-updateCompany textarea[name=descripcion]").val(), tipoIdentificacion: $("#form-updateCompany select[name=tipoIdentificacion]").val(),
                numeroIdentificacion: $("#form-updateCompany input[name=numeroIdentificacion]").val(), telefono: $("#form-updateCompany input[name=telefono]").val(),
                correo: $("#form-updateCompany input[name=correo]").val(), razonSocial: $("#form-updateCompany textarea[name=razonSocial]").val(),
                claveSri: $("#form-updateCompany input[name=claveSri]").val(), representante: $("#form-updateCompany input[name=representante]").val(),
                tipoCliente: $("#form-updateCompany select[name=tipoCliente]").val(), ciudad: $("#form-updateCompany select[name=ciudad]").val(), logo: ''};
            formdata.append('company', JSON.stringify(data));
            excecuteAjax('POST', getRoute('empresaedit'), formdata, null, function (response)
            {
                if (response.success == true)
                {
                    $("#divUpdateModal").modal('hide');
                    waitMeHide("wrapper");
                    updateLogo(response.data.logo);
                    alertify.success("Elemento actualizado satisfactoriamente");
                    buildListCompany();
                }
            }, true, true);
        }
    });
};

var removeModalCompany = function () {
    $('#removeModalCompany').load("assets/pages/removeConfirm.html", {}, function () {
        $('#btn-delete').on('click', function (e) {
            var id = $(this).data('recordId');
            waitMeShow("wrapper");
            excecuteAjax('POST', getRoute('empresadelete') + '/' + id, {}, null, function (response)
            {
                if (response.success == true)
                {
                    $('#confirm-delete').modal('hide');
                    waitMeHide("wrapper");
                    alertify.success("Empresa eliminada satisfactoriamente");
                    setTimeout(function () {
                        buildListCompany();
                    }, 1000);
                }

            }, false, true);
        });
    });

    $('#removeModalCompany').on('show.bs.modal', function (e) {
        var data = $(e.relatedTarget).data();
        $('#btn-delete', this).data('recordId', data.recordId);

    });
};

var detailModalCompany = function () {
    $('#detailModalCompany').load("assets/pages/detail.html", {}, function () {

        $('#detailModalCompany #myModalLabel').html('Detalles de empresa');
    });

    $('#detailModalCompany').on('show.bs.modal', function (e) {
        var data = $(e.relatedTarget).data().recordId;
        var model = controller.getData(data);
        var configDetail = [[{dataName: 'Logo', renderer: function (data) {
                        var logo = (data["logo"] != "" ? data["logo"] : 'usuario-logo.png');
                        return '<img src="' + serviceaddress + '/bundles/app/images/' + logo + '" height="60px" width="60px" style="margin-top: 5px;"/>';
                    }},
                {dataIndex: 'nombre', dataName: 'Nombre'}, {dataIndex: 'direccion', dataName: 'Direcci&oacute;n'},
                {dataName: 'Tipo', renderer: function (data) {
                        return data['tipo_cliente'].nombre;
                    }}, {dataName: 'Ciudad', renderer: function (data) {
                        return data['ciudad'].nombre;
                    }}],
            [{dataIndex: 'descripcion', dataName: 'Descripci&oacute;n'}],
            [{dataIndex: 'correo', dataName: 'Correo'}, {dataIndex: 'telefono', dataName: 'Tel&eacute;fono'},
                {dataIndex: 'tipo_identificacion', dataName: 'Tipo de identificaci&oacute;n'}, {dataIndex: 'numero_identificacion', dataName: 'N&uacute;mero de identificaci&oacute;n'},
                {dataIndex: 'clave_sri', dataName: 'Clave SRI'}]];

        if (model.tipo_cliente.nombre != "Cliente")
        {
            configDetail[0].push({dataName: 'Representante', renderer: function (data) {
                    return (data['representante'] != undefined && data['representante'] != "") ? data['representante'] : "No especificado";
                }});
            configDetail[1].push({dataIndex: 'razon_social', dataName: 'Raz&oacute;n social', renderer: function (data) {
                    return (data["razon_social"] != undefined && data["razon_social"] != "") ? data["razon_social"] : "No especificada";
                }});
        }

        $('#detailModalCompany #detailContent').html('');
        buildDetail(data, 3, configDetail, 'detailContent');

    });
};