/**
 * Created by rene on 4/03/17.
 */
var initUser = function () {
    $('#page-body').html(getUsersTableHeader());
    buildListUsers();
    if (userPermission.AGUsuario.post) {
        addModalUser();
        $('#addModalUser').on('hidden.bs.modal', function ()
        {
            clearForm('addModalUser');
        });
    }
    if (userPermission.AGUsuario.put) {
        $('#updateModalContainer').on('hidden.bs.modal', function ()
        {
            clearForm('updateModalContainer');
        });
        updateModalUser();
    }
    if (userPermission.AGUsuario.delete) {
        removeModalUser();
    }
    detailModalUser();
    if (userPermission.AGUsuario.updateUserRole) {
        rolesModalUser();
    }
};

var buildListUsers = function () {
    var idTable = 'user-list';
    waitMeShow();
    excecuteAjax('GET', getRoute('usuarioslist'), {}, null, function (response)
    {
        if (response.success == true)
        {

            var header = [{dataIndex: 'nombreinterfaz', dataName: 'Nombre'},
                {dataIndex: 'username', dataName: 'Usuario'},
                {dataIndex: 'correo', dataName: 'Correo'}];
            var actionsArray = ['detail'];
            if (userPermission.AGUsuario.put) {
                actionsArray.push('update')
            }
            if (userPermission.AGUsuario.delete) {
                actionsArray.push('delete')
            }
            if (userPermission.AGUsuario.updateUserRole) {
                actionsArray.push('userroles')
            }
            var htmlTable = buildDataTable(idTable, header, response.data, actionsArray);
            $('#table-data').html(htmlTable);
            $('#table_container').removeClass("hide");
            $('#' + idTable).dataTable();
            waitMeHide();
        }
    }, false, true);
};

var getUsersTableHeader = function ()
{

    var header = {tableTitle: "Usuarios"};
    var modalsArray = [{modalType: "detail", containerId: "detailModalUser"}];

    if (userPermission.AGUsuario.post) {
        header.addModalId = "addUserModal";
        header.addModalToolTip = "Agregar usuario";
        header.addModalTitle = "Nuevo usuario";
        modalsArray.push({modalType: "add", containerId: "addModalUser"});
    }
    if (userPermission.AGUsuario.put) {
        modalsArray.push({modalType: "update", containerId: "updateModalContainer"});
    }
    if (userPermission.AGUsuario.delete) {
        modalsArray.push({modalType: "remove", containerId: "removeModalUser"});
    }
    if (userPermission.AGUsuario.updateUserRole) {
        modalsArray.push({modalType: "userroles", containerId: "rolesModalUser"});
    }

    return buildTableHeader(header, modalsArray);

};

var addModalUser = function ()
{
    $('#addModalUser').load("assets/pages/addUserModal.html", {}, function ()
    {
        userValidationEngine('form-addUser', true);
        addModalUserSubmit();
    });
};

var addModalUserSubmit = function ()
{
    $("#form-addUser").on("submit", function (e)
    {
        e.preventDefault();
        if ($("#form-addUser").valid())
        {
            waitMeShow("wrapper");
            var data = {username: $("#form-addUser input[name=username]").val(), correo: $("#form-addUser input[name=correo]").val(),
                nombreinterfaz: $("#form-addUser input[name=nombreinterfaz]").val(),
                password: $("#form-addUser input[name=password]").val()};

            excecuteAjax('POST', getRoute('usuarioslist'), data, null, function (response)
            {
                if (response.success == true)
                {
                    $("#addUserModal").modal('hide');
                    waitMeHide("wrapper");
                    alertify.success("registro ingresado satisfactoriamente");
                    buildListUsers();
                }
            }, false, true);
        }
    });
};

var updateModalUser = function ()
{
    $('#updateModalContainer').load("assets/pages/updateUserModal.html", {}, function ()
    {
        userValidationEngine('form-updateUser', false);
        updateModalUserSubmit();
    });
    $('#updateModalContainer').on('show.bs.modal', function (e) {

        var data = $(e.relatedTarget).data().recordId;
        $("#form-updateUser").attr('data-id', data);
        var model = controller.getData(data);
        $("#form-updateUser input[name=username]").val(model.username);
        $("#form-updateUser input[name=correo]").val(model.correo);
        $("#form-updateUser input[name=nombreinterfaz]").val(model.nombreinterfaz);
        $("#form-updateUser input[name=password]").val(model.password);
    });
};

var updateModalUserSubmit = function ()
{
    $("#form-updateUser").on("submit", function (e)
    {
        e.preventDefault();
        if ($("#form-updateUser").valid())
        {
            waitMeShow("wrapper");
            var data = {id: $("#form-updateUser").attr('data-id'), username: $("#form-updateUser input[name=username]").val(), correo: $("#form-updateUser input[name=correo]").val(),
                nombreinterfaz: $("#form-updateUser input[name=nombreinterfaz]").val(),
                password: $("#form-updateUser input[name=password]").val()};

            excecuteAjax('POST', getRoute('usuariosedit'), data, null, function (response)
            {
                if (response.success == true)
                {
                    $("#divUpdateModal").modal('hide');
                    waitMeHide("wrapper");
                    alertify.success("Usuario actualizado satisfactoriamente");
                    buildListUsers();
                }
            }, false, true);
        }
    });
};

var removeModalUser = function () {
    $('#removeModalUser').load("assets/pages/removeConfirm.html", {}, function () {
        $('#btn-delete').on('click', function (e) {
            waitMeShow("wrapper");
            var id = $(this).data('recordId');
            excecuteAjax('POST', getRoute('usuariosdelete') + '/' + id, {}, null, function (response)
            {
                if (response.success == true)
                {
                    $('#confirm-delete').modal('hide');
                    waitMeHide("wrapper");
                    alertify.success("Usuario eliminado satisfactoriamente");
                    setTimeout(function () {
                        buildListUsers();
                    }, 1000);
                }
            }, false, true);
        });
    });

    $('#removeModalUser').on('show.bs.modal', function (e) {
        var data = $(e.relatedTarget).data();
        $('#btn-delete', this).data('recordId', data.recordId);

    });
};

var detailModalUser = function () {

    $('#detailModalUser').load("assets/pages/detail.html", {}, function () {
        $('#detailModalUser #myModalLabel').html('Detalles de usuario');
    });

    $('#detailModalUser').on('show.bs.modal', function (e) {
        var data = $(e.relatedTarget).data().recordId;
        var configDetail = [[{dataIndex: 'nombreinterfaz', dataName: 'Nombre'},
                {dataIndex: 'username', dataName: 'Usuario'}], [{dataIndex: 'correo', dataName: 'Correo'}]];
        $('#detailContent').html('');
        buildDetail(data, 2, configDetail, 'detailContent');
    });
};

var rolesModalUser = function () {
    $('#rolesModalUser').load("assets/pages/userRolesModal.html");
};

var showRoleModalUser = function (id)
{
    waitMeShow("wrapper");
    var table = '<table class="table table-striped table-bordered table-hover dataTable no-footer"><thead>' +
            '<tr>' +
            ' <th>Rol</th>' +
            ' <th>Descripci&oacute;n</th>' +
            ' <th>Estado</th>' +
            ' </tr></thead><tbody>';
    var body = '';

    excecuteAjax('GET', getRoute('usuariosallroles') + '/' + id, {}, null, function (response)
    {
        if (response.success == true)
        {
            var obj = response.data.role;

            for (var i = 0; i < obj.length; i++) {

                body += '<tr><td>' + obj[i]['nombre'] + '</td><td>' + obj[i]['descripcion'] + '</td>' + '<td class="center "><center>' +
                        '<a  onclick="updateUserRole(' + id + ',' + obj[i]['id'] + ')" title="Cambiar Estado"  class="updateAction cursor-pointer">';
                if (obj[i]['activo']) {
                    body += '<span id="span-action' + obj[i]['id'] + '" data-state="' + (eval(obj[i].activo == "0" ? 1 : 0)) + '" class="label label-success">Asignado</span></a></center></td>'
                } else {
                    body += '<span id="span-action' + obj[i]['id'] + '" data-state="' + (eval(obj[i].activo == "0" ? 1 : 0)) + '" class="label label-danger">No asignado</span></a></center></td>'
                }
            }
            waitMeHide("wrapper");
        }

        $('#userRolesContainer').html(table + body + '</tbody></table');
        $('#userRolesModal').modal("show");

    }, false, true);
};

var updateUserRole = function (idUser, idRol)
{
    waitMeShow("wrapper");
    var data = {idusuario: idUser, idrol: idRol, estado: $('#span-action' + idRol).attr("data-state")};
    excecuteAjax('POST', getRoute('usuariosupdaterole'), data, null, function (response)
    {
        if (response.success == true)
        {
            $('#span-action' + idRol).attr("data-state", data.estado == "0" ? 1 : 0);
            $('#span-action' + idRol).removeClass(data.estado == "1" ? 'label label-danger' : 'label label-success');
            $('#span-action' + idRol).addClass(data.estado == "0" ? 'label label-danger' : 'label label-success');
            $('#span-action' + idRol).html(data.estado == "0" ? 'No asignado' : 'Asignado');
        }
        waitMeHide("wrapper");
    }, false, true);
};