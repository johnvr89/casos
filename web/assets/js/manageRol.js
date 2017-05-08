/**
 * Created by rene on 4/03/17.
 */
var initRole = function () {
    $('#page-body').html(getRolTableHeader());
    buildListRole();
    if (userPermission.AGRol.post) {
        addModalRole();
        $('#addModalRole').on('hidden.bs.modal', function ()
        {
            clearForm('addModalRole');
        });
    }
    if (userPermission.AGRol.put) {
        $('#updateModalContainer').on('hidden.bs.modal', function ()
        {
            clearForm('updateModalContainer');
        });
        updateModalRole();
    }
    if (userPermission.AGRol.delete) {
        removeModalRole();
    }
    detailModalRole();

};

var buildListRole = function () {
    var idTable = 'rol-list';
    waitMeShow();
    excecuteAjax('GET', getRoute('rollist'), {}, null, function (response)
    {
        if (response.success == true)
        {

            var header = [{dataIndex: 'nombre', dataName: 'Nombre'},
                {dataIndex: 'descripcion', dataName: 'Descripci&oacute;n'}];

            var actionsArray = ['detail'];
            if (userPermission.AGRol.put) {
                actionsArray.push('update')
            }
            if (userPermission.AGRol.delete) {
                actionsArray.push('delete')
            }
            if (userPermission.AGRol.updateRolePermission) {
                actionsArray.push('action')
            }
            var htmlTable = buildDataTable(idTable, header, response.data, actionsArray);
            $('#table-data').html(htmlTable);
            $('#table_container').removeClass("hide");
            $('#' + idTable).dataTable();
            waitMeHide();
        }
    }, false, true);
};

var getRolTableHeader = function ()
{
     var header = {tableTitle: "Roles"};
    var modalsArray = [ {modalType: "detail", containerId: "detailModalRole"}];

    if (userPermission.AGRol.post) {
        header.addModalId = "addRoleModal";
        header.addModalToolTip = "Agregar Rol";
        header.addModalTitle = "Nuevo Rol";
        modalsArray.push({modalType: "add", containerId: "addModalRole"});
    }
    if (userPermission.AGRol.put) {
        modalsArray.push({modalType: "update", containerId: "updateModalContainer"});
    }
    if (userPermission.AGRol.delete) {
        modalsArray.push({modalType: "remove", containerId: "removeModalRole"});
    }
    if (userPermission.AGRol.updateRolePermission) {
        modalsArray.push({modalType: "roleactions", containerId: "actionModalRole"});
    }

    return buildTableHeader(header, modalsArray);

   
};

var addModalRole = function ()
{
    $('#addModalRole').load("assets/pages/addRoleModal.html", {}, function ()
    {
        caseTypeValidationEngine('form-addRole');
        addModalRoleSubmit();
    });
};

var addModalRoleSubmit = function ()
{
    $("#form-addRole").on("submit", function (e)
    {
        e.preventDefault();
        if ($("#form-addRole").valid())
        {
            waitMeShow("wrapper");
            var data = {nombre: $("#form-addRole input[name=nombre]").val(),
                descripcion: $("#form-addRole textarea[name=descripcion]").val(),
            };

            excecuteAjax('POST', getRoute('rollist'), data, null, function (response)
            {
                if (response.success == true)
                {
                    $("#addRoleModal").modal('hide');
                    waitMeHide("wrapper");
                    alertify.success("Elemento insertado satisfactoriamente");
                    buildListRole();
                }
            }, false, true);
        }
    });
}

var updateModalRole = function ()
{
    $('#updateModalContainer').load("assets/pages/updateRoleModal.html", {}, function ()
    {
        caseTypeValidationEngine('form-updateRole');
        updateModalRoleSubmit();
    });
    $('#updateModalContainer').on('show.bs.modal', function (e) {

        var data = $(e.relatedTarget).data().recordId;
        var model = controller.getData(data);
        $("#form-updateRole input[name=nombre]").val(model.nombre);
        $("#form-updateRole textarea[name=descripcion]").val(model.descripcion);
        $("#form-updateRole").attr('data-id', data);

    });
};

var updateModalRoleSubmit = function (id)
{
    $("#form-updateRole").on("submit", function (e)
    {
        e.preventDefault();
        if ($("#form-updateRole").valid())
        {
            waitMeShow("wrapper");
            var data = {id: $("#form-updateRole").attr('data-id'), nombre: $("#form-updateRole input[name=nombre]").val(), descripcion: $("#form-updateRole textarea[name=descripcion]").val(),
            }

            excecuteAjax('POST', getRoute('rolledit'), data, null, function (response)
            {
                if (response.success == true)
                {
                    $("#divUpdateModal").modal('hide');
                    waitMeHide("wrapper");
                    alertify.success("Elemento actualizado satisfactoriamente");
                    buildListRole();
                }
            }, false, true);
        }
    });
};

var removeModalRole = function () {
    $('#removeModalRole').load("assets/pages/removeConfirm.html", {}, function () {
        $('#btn-delete').on('click', function (e) {
            waitMeShow("wrapper");
            var id = $(this).data('recordId');
            excecuteAjax('POST', getRoute('rollist') + '/' + id, {}, null, function (response)
            {
                if (response.success == true)
                {
                    $('#confirm-delete').modal('hide');
                    waitMeHide("wrapper");
                    alertify.success("Rol eliminado satisfactoriamente");
                    setTimeout(function () {
                        buildListRole();
                    }, 1000);
                }
            }, false, true);
        });
    });

    $('#removeModalRole').on('show.bs.modal', function (e) {
        var data = $(e.relatedTarget).data();
        $('#btn-delete', this).data('recordId', data.recordId);
    });
};

var detailModalRole = function () {

    $('#detailModalRole').load("assets/pages/detail.html", {}, function () {
        $('#detailModalRole #myModalLabel').html('Detalles de rol');
    });

    $('#detailModalRole').on('show.bs.modal', function (e) {
        var data = $(e.relatedTarget).data().recordId;
        var configDetail = [[{dataIndex: 'nombre', dataName: 'Nombre'}],
            [{dataIndex: 'descripcion', dataName: 'Descripci&oacute;n'}]
        ];
        $('#detailContent').html('');
        buildDetail(data, 2, configDetail, 'detailContent');
    });
};

var updateRoleAction = function (idRol, idAction) {
    waitMeShow("wrapper");
    var data = {idrol: idRol, idaccion: idAction, estado: $('#span-action' + idAction).attr("data-state")};
    excecuteAjax('POST', getRoute('rolupdatepermission'), data, null, function (response)
    {
        if (response.success == true)
        {
            $('#span-action' + idAction).attr("data-state", data.estado == "0" ? 1 : 0);
            $('#span-action' + idAction).removeClass(data.estado == "1" ? 'label label-danger' : 'label label-success');
            $('#span-action' + idAction).addClass(data.estado == "0" ? 'label label-danger' : 'label label-success');
            $('#span-action' + idAction).html(data.estado == "0" ? 'No asignado' : 'Asignado');
        }
        waitMeHide("wrapper");

    }, false, true);
};


