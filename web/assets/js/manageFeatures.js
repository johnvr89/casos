/**
 * Created by rene on 4/03/17.
 */
var initFeature = function (id, caseName)
{
    $('#page-body').html(getFeatureTableHeader(caseName));
    buildListFeature(id);
    if (userPermission.AGTipoCasoCaracteristica.post) {
        addModalFeature(id);
        $('#addModalFeature').on('hidden.bs.modal', function ()
        {
            clearForm('addModalFeature');
        });
    }
    if (userPermission.AGTipoCasoCaracteristica.put) {
        $('#updateModalContainer').on('hidden.bs.modal', function ()
        {
            clearForm('updateModalContainer');
        });
        updateModalFeature(id);
    }
    if (userPermission.AGTipoCasoCaracteristica.delete) {
        removeModalFeature(id);
    }
    detailModalFeature(id);
};

var buildListFeature = function (id) {
    var idTable = 'feature-list';
    waitMeShow();
    excecuteAjax('GET', getRoute('caracteristicalist'), {tipoCaso: id}, null, function (response)
    {

        if (response.success == true)
        {

            var header = [{dataIndex: 'nombre_campo', dataName: 'Nombre del campo'},

                {dataName: 'Tipo de campo', renderer: function (data) {
                        return data['tipo_campo'].nombre;
                    }}
            ];
            var actionsArray = ['detail'];
            if (userPermission.AGTipoCasoCaracteristica.put) {
                actionsArray.push('update')
            }
            if (userPermission.AGTipoCasoCaracteristica.delete) {
                actionsArray.push('delete')
            }
            var htmlTable = buildDataTable(idTable, header, response.data, actionsArray);
            $('#table-data').html(htmlTable);
            $('#table_container').removeClass("hide");
            $('#back2casetype').removeClass("hide");
            $('#' + idTable).dataTable();
            waitMeHide();

        }
    }, false, true);
};

var getFeatureTableHeader = function (caseName)
{
    var header = '<a id="back2casetype" class="cursor-pointer hide" onclick="initCaseType()"><i class="fa fa-arrow-left"></i> Volver al listado de tipos de casos</a>';
    var header2={tableTitle: "Caracter&iacute;sticas del caso: " + caseName};
     var modalsArray = [{modalType: "detail", containerId: "detailModalFeature"}];
     
     if (userPermission.AGTipoCasoCaracteristica.post) {
        header2.addModalId = "addCaseFeaturesModal";
        header2.addModalToolTip = "Agregar Caracter&iacute;stica";
        header2.addModalTitle = "Nueva Caracter&iacute;stica";
        modalsArray.push({modalType: "add", containerId: "addModalFeature"});
    }
    if (userPermission.AGTipoCasoCaracteristica.put) {
        modalsArray.push({modalType: "update", containerId: "updateModalContainer"});
    }
    if (userPermission.AGTipoCasoCaracteristica.delete) {
        modalsArray.push({modalType: "remove", containerId: "removeModalFeature"});
    }
    header += buildTableHeader(header2,modalsArray);

    return header;
};

var addModalFeature = function (id)
{
    $('#addModalFeature').load("assets/pages/addCaseFeatureModal.html", {}, function ()
    {
        buildCombo('id', 'nombre', 'tipodatolist', 'tipoCampo-select');
        caseFeatureValidationEngine('addCaseFeaturesModal');
        addModalFeatureSubmit(id);
    });
};

var addModalFeatureSubmit = function (id)
{
    $("#form-addCaseFeaturesModal").on("submit", function (e)
    {
        e.preventDefault();
        if ($("#form-addCaseFeaturesModal").valid())
        {
            waitMeShow("wrapper");
            var data = {nombreCampo: $("#form-addCaseFeaturesModal input[name=nombreCampo]").val(), tipoCampo: $("#form-addCaseFeaturesModal select[name=tipoCampo]").val(),
                tipoCaso: id};

            excecuteAjax('POST', getRoute('caracteristicalist'), data, null, function (response)
            {
                if (response.success == true)
                {
                    $("#addCaseFeaturesModal").modal('hide');
                    waitMeHide("wrapper");
                    alertify.success("Elemento insertado satisfactoriamente");
                    buildListFeature(id);
                }
            }, false, true);
        }
    });
};

var updateModalFeature = function (id)
{
    $('#updateModalContainer').load("assets/pages/updateCaseFeatureModal.html", {}, function ()
    {
        buildCombo('id', 'nombre', 'tipodatolist', 'updatetipoCampo-select');
        caseFeatureValidationEngine('form-updateCaseFeaturesModal');
        updateModalFeatureSubmit(id);
    });

    $('#updateModalContainer').on('show.bs.modal', function (e) {

        var data = $(e.relatedTarget).data().recordId;
        var model = controller.getData(data);
        $("#form-updateCaseFeaturesModal input[name=nombreCampo]").val(model.nombre_campo);
        $("#form-updateCaseFeaturesModal select[name=tipoCampo]").val(model.tipo_campo.id);
        $("#form-updateCaseFeaturesModal").attr('data-id', data);
    });
};

var updateModalFeatureSubmit = function (id)
{
    $("#form-updateCaseFeaturesModal").on("submit", function (e)
    {
        e.preventDefault();
        if ($("#form-updateCaseFeaturesModal").valid())
        {
            waitMeShow("wrapper");
            var data = {id: $("#form-updateCaseFeaturesModal").attr('data-id'), nombreCampo: $("#form-updateCaseFeaturesModal input[name=nombreCampo]").val()};

            excecuteAjax('POST', getRoute('caracteristicaedit'), data, null, function (response)
            {
                if (response.success == true)
                {
                    $("#divUpdateModal").modal('hide');
                    waitMeHide("wrapper");
                    alertify.success("Elemento actualizado satisfactoriamente");
                    buildListFeature(id);
                }
            }, false, true);
        }
    });
};

var removeModalFeature = function (id) {
    $('#removeModalFeature').load("assets/pages/removeConfirm.html", {}, function () {
        $('#btn-delete').on('click', function (e) {
            waitMeShow("wrapper");
            var recordId = $(this).data('recordId');
            excecuteAjax('POST', getRoute('caracteristicadelete') + '/' + recordId, {}, null, function (response)
            {
                if (response.success == true)
                {
                    alertify.success("Caracter&iacute;stica eliminada satisfactoriamente");
                    $('#confirm-delete').modal('hide');
                    waitMeHide("wrapper");
                    setTimeout(function () {
                        buildListFeature(id);
                    }, 1000);
                }

            }, false, true);

        });
    });

    $('#removeModalFeature').on('show.bs.modal', function (e) {
        var data = $(e.relatedTarget).data();
        $('#btn-delete', this).data('recordId', data.recordId);
    });
};

var detailModalFeature = function () {

    $('#detailModalFeature').load("assets/pages/detail.html", {}, function () {
        $('#detailModalFeature #myModalLabel').html('Detalles de Caracter&iacute;sticas');
    });

    $('#detailModalFeature').on('show.bs.modal', function (e) {
        var data = $(e.relatedTarget).data().recordId;
        var configDetail = [[{dataIndex: 'nombre_campo', dataName: 'Nombre del campo'},

                {dataName: 'Tipo de campo', renderer: function (data) {
                        return data['tipo_campo'].nombre;
                    }}], [{dataName: 'Tipo de caso', renderer: function (data) {
                        return data['tipo_caso'].nombre;
                    }}]];
        $('#detailContent').html("");
        buildDetail(data, 2, configDetail, 'detailContent');
    });
};
