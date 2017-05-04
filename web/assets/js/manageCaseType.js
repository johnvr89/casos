/**
 * Created by rene on 4/03/17.
 */
var initCaseType = function ()
{
    $('#page-body').html(getCaseTypeTableHeader());
    buildListCaseType();
    if (userPermission.AGTipoCaso.post) {
        addModalCaseType();
        $('#addModalCaseType').on('hidden.bs.modal', function ()
        {
            clearForm('addModalCaseType');
        });
    }
    if (userPermission.AGTipoCaso.put) {
        $('#updateModalContainer').on('hidden.bs.modal', function ()
        {
            clearForm('updateModalContainer');
        });
        updateModalCaseType();
    }
    detailModalCaseType();
    if (userPermission.AGTipoCaso.delete) {

        removeModalCaseType();
    }
};

var buildListCaseType = function () {
    var idTable = 'caseTypes';
    waitMeShow();
    excecuteAjax('GET', getRoute('tipocasolist'), {}, null, function (response)
    {
        if (response.success == true)
        {

            var header = [{dataIndex: 'nombre', dataName: 'Nombre'},

                {dataIndex: 'descripcion', dataName: 'Descripci&oacute;n'},
            ];
            var actionsArray = ['detail'];
            if (userPermission.AGTipoCaso.put) {
                actionsArray.push('update')
            }
            if (userPermission.AGTipoCaso.delete) {
                actionsArray.push('delete')
            }
            if (userPermission.AGTipoCasoCaracteristica.getAllByCaseType) {
                actionsArray.push('features')
            }
            var htmlTable = buildDataTable(idTable, header, response.data, actionsArray);

            $('#table-data').html(htmlTable);
            $('#table_container').removeClass("hide");
            $('#' + idTable).dataTable();
            waitMeHide();

        }
    }, false, true);
};

var getCaseTypeTableHeader = function ()
{
    var header = {tableTitle: "Tipos de casos"};
    var modalsArray = [{modalType: "detail", containerId: "detailModalCaseType"}];

    if (userPermission.AGTipoCaso.post) {
        header.addModalId = "addCaseTypeModal";
        header.addModalToolTip = "Agregar tipo de caso";
        header.addModalTitle = "Nuevo tipo de caso";
        modalsArray.push({modalType: "add", containerId: "addModalCaseType"});
    }
    if (userPermission.AGTipoCaso.put) {
        modalsArray.push({modalType: "update", containerId: "updateModalContainer"});
    }
    if (userPermission.AGTipoCaso.delete) {
        modalsArray.push({modalType: "remove", containerId: "removeModalCaseType"});
    }

    return buildTableHeader(header, modalsArray);

};

var addModalCaseType = function ()
{
    $('#addModalCaseType').load("assets/pages/addCaseTypeModal.html", {}, function ()
    {
        caseTypeValidationEngine('form-addCaseType');
        addModalCaseTypeSubmit();
    });
};

var addModalCaseTypeSubmit = function ()
{
    $("#form-addCaseType").on("submit", function (e)
    {
        e.preventDefault();
        if ($("#form-addCaseType").valid())
        {
            waitMeShow("wrapper");
            var data = {nombre: $("#form-addCaseType input[name=nombre]").val(), descripcion: $("#form-addCaseType textarea[name=descripcion]").val()}

            excecuteAjax('POST', getRoute('tipocasolist'), data, null, function (response)
            {
                if (response.success == true)
                {
                    $("#addCaseTypeModal").modal('hide');
                    waitMeHide("wrapper");
                    alertify.success("Elemento insertado satisfactoriamente");
                    buildListCaseType();
                }
            }, false, true);
        }
    });
};

var updateModalCaseType = function ()
{
    $('#updateModalContainer').load("assets/pages/updateCaseTypeModal.html", {}, function ()
    {
        caseTypeValidationEngine('form-updateCaseType');
        updateModalCaseTypeSubmit();
    });
    $('#updateModalContainer').on('show.bs.modal', function (e) {

        var data = $(e.relatedTarget).data().recordId;
        var model = controller.getData(data);
        $("#form-updateCaseType input[name=nombre]").val(model.nombre);
        $("#form-updateCaseType textarea[name=descripcion]").val(model.descripcion);
        $("#form-updateCaseType").attr('data-id', data);
    });
};

var updateModalCaseTypeSubmit = function (id)
{
    $("#form-updateCaseType").on("submit", function (e)
    {
        e.preventDefault();
        if ($("#form-updateCaseType").valid())
        {
            waitMeShow("wrapper");
            var data = {id: $("#form-updateCaseType").attr('data-id'), nombre: $("#form-updateCaseType input[name=nombre]").val(), descripcion: $("#form-updateCaseType textarea[name=descripcion]").val()}

            excecuteAjax('POST', getRoute('tipocasoedit'), data, null, function (response)
            {
                if (response.success == true)
                {
                    $("#divUpdateModal").modal('hide');
                    waitMeHide("wrapper");
                    alertify.success("Elemento actualizado satisfactoriamente");
                    buildListCaseType();
                }
            }, false, true);
        }
    });
};

var removeModalCaseType = function () {
    $('#removeModalCaseType').load("assets/pages/removeConfirm.html", {}, function () {
        $('#btn-delete').on('click', function (e) {
            waitMeShow("wrapper");
            var id = $(this).data('recordId');
            excecuteAjax('POST', getRoute('tipocasodelete') + '/' + id, {}, null, function (response)
            {
                if (response.success == true)
                {
                    alertify.success("Tipo de caso eliminado satisfactoriamente");
                    $('#confirm-delete').modal('hide');
                    waitMeHide("wrapper");
                    setTimeout(function () {
                        buildListCaseType();
                    }, 1000);
                }

            }, false, true);
        });
    });
    
    $('#removeModalCaseType').on('show.bs.modal', function (e) {
        var data = $(e.relatedTarget).data();
        $('#btn-delete', this).data('recordId', data.recordId);

    });
};

var detailModalCaseType = function () {

    $('#detailModalCaseType').load("assets/pages/detail.html", {}, function () {
        $('#detailModalCaseType #myModalLabel').html('Detalles de tipo de caso');
    });

    $('#detailModalCaseType').on('show.bs.modal', function (e) {
        var data = $(e.relatedTarget).data().recordId;
        var configDetail = [[{dataIndex: 'nombre', dataName: 'Nombre'}], [
                {dataIndex: 'descripcion', dataName: 'Descripci&oacute;n'}
            ]];
        $('#detailContent').html('');
        buildDetail(data, 2, configDetail, 'detailContent');
    });
};