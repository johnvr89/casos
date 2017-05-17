/**
 * Created by rene on 4/03/17.
 */
var initAction = function (idrole, rolename)
{
    $('#page-body').html(getActionTableHeader(rolename));
    buildListAction(idrole);
    if (userPermission.AGAccion.put) {
        $('#updateModalContainer').on('hidden.bs.modal', function ()
        {
            clearForm('updateModalContainer');
        });
        if (idrole == undefined)
        {
            updateModalAction();

        }
    }
    if (userPermission.AGAccion.post) {
         $('#addModalAction').on('hidden.bs.modal', function ()
        {
            clearForm('form-addAction');
        });
        addModalAction();
    }

    detailAction();
};

var getActionTableHeader = function (rolename)
{
    var goback = '<a id="back2rol" class="cursor-pointer hide" onclick="initRole()"><i class="fa fa-arrow-left"></i> Volver al listado de roles</a>';
    var header = {tableTitle: "Permisos"};
    var modalsArray = [{modalType: "detail", containerId: "detailModalAction"}];


    if (userPermission.AGAccion.put) {
        modalsArray.push({modalType: "update", containerId: "updateModalContainer"});
    }
    if (userPermission.AGAccion.post) {
        header.addModalId = "addActionModal";
        header.addModalToolTip = "Agregar Permiso";
        header.addModalTitle = "Nuevo Permiso";
        modalsArray.push({modalType: "add", containerId: "addModalAction"});
    }

    if (!rolename) {
         header = buildTableHeader(header, modalsArray);
    } else {
         header = buildTableHeader({tableTitle: "Permisos " + (rolename != undefined ? "del rol: " + rolename : "")},
                modalsArray);
    }
    header = rolename != undefined ? goback + header : header;
    return header;
};

var addModalAction = function ()
{
    $('#addModalAction').load("assets/pages/addActionModal.html", {}, function ()
    {
        actionValidationEngine('form-addAction');
        addModalActionSubmit();
    });
};

var addModalActionSubmit = function ()
{
    $("#form-addAction").on("submit", function (e)
    {
        e.preventDefault();
        if ($("#form-addAction").valid())
        {
            waitMeShow("wrapper");
            var data = {nombre: $("#form-addAction input[name=nombre]").val(), controlador: $("#form-addAction input[name=controlador]").val(),
                alias: $("#form-addAction input[name=alias]").val(),
                aliasContrador: $("#form-addAction input[name=aliasContrador]").val(),
                posicion: $("#form-addAction input[name=posicion]").val(),
                descripcion: $("#form-addAction textarea[name=descripcion]").val()};

            excecuteAjax('POST', getRoute('actionadd'), data, null, function (response)
            {
                if (response.success == true)
                {
                    $("#addActionModal").modal('hide');
                    waitMeHide("wrapper");
                    alertify.success("registro ingresado satisfactoriamente");
                    buildListAction();
                }
            },false, true);
        }
    });
};

var updateModalAction = function ()
{
    $('#updateModalContainer').load("assets/pages/updateActionModal.html", {}, function ()
    {
        caseTypeValidationEngine('form-updateAction');
        updateModalActionSubmit();
    });
    $('#updateModalContainer').on('show.bs.modal', function (e) {
        var data = $(e.relatedTarget).data().recordId;
        var model = controller.getData(data);
        $("#form-updateAction input[name=alias]").val(model.alias);
        $("#form-updateAction textarea[name=descripcion]").val(model.descripcion);
        $("#form-updateAction").attr('data-id', data)
    });
};

var updateModalActionSubmit = function (id)
{
    $("#form-updateAction").on("submit", function (e)
    {
        e.preventDefault();
        if ($("#form-updateAction").valid())
        {
            waitMeShow("wrapper");
            var data = {id: $("#form-updateAction").attr('data-id'), alias: $("#form-updateAction input[name=alias]").val(), descripcion: $("#form-updateAction textarea[name=descripcion]").val()}
            
            excecuteAjax('POST', getRoute('actionlist'), data, null, function (response)
            {
                if (response.success == true)
                {
                    $("#divUpdateModal").modal('hide');
                    waitMeHide("wrapper");
                    alertify.success("Elemento actualizado satisfactoriamente");
                    buildListAction();
                }
            }, false, true);
        }
    });
};

var buildListAction = function (id) {
    var idTable = 'action-list';
    var route = id == undefined ? getRoute('actionlist') : getRoute('rolpermission') + '/' + id;
    waitMeShow();
    excecuteAjax('GET', route, {}, null, function (response)
    {
        if (response.success == true)
        {
            var htmlTable = "";
            if (id == undefined)
            {
                var header = [{dataIndex: 'alias', dataName: 'Nombre', renderer: function (data) {
                            return '<div style="min-width: 80%;"><strong>' + data['alias'] + "</strong><br>" + data['descripcion'] + '</div>';
                        }}];
                var actionsArray = ['detail'];
                if (userPermission.AGAccion.put) {
                    actionsArray.push('update');
                }
                if (userPermission.AGAccion.post) {
                    actionsArray.push('add');
                }
                htmlTable = buildDataTable(idTable, header, response.data, actionsArray);
            } else
            {
                var table = '<div class="panel-body"> <div class="table-responsive">\n\
                                <table class="table table-striped table-bordered table-hover" id="' + idTable + '">\n\
                                    <thead>\n\
                                        <tr>\n\
                                            <th class="hide"></th>\n\
                                            <th>Nombre</th>\n\
                                            <th>Estado</th>\n\
                                        </tr>\n\
                                    </thead>\n\
                                <tbody>';
                var body = '';
                var obj = response.data.accion;

                for (var i = 0; i < obj.length; i++) {

                    body += '<tr><td class="hide"></td><td><div style="min-width: 80%;"><strong>' + obj[i]['alias'] + "</strong><br>" + obj[i]['descripcion'] + '</div><td class="center "><center>' +
                            '<a  onclick="updateRoleAction(' + id + ',' + obj[i]['id'] + ')" title="Cambiar Estado"  class="updateAction cursor-pointer">';
                    if (obj[i]['activo']) {
                        body += '<span id="span-action' + obj[i]['id'] + '" data-state="' + (eval(obj[i].activo == "0" ? 1 : 0)) + '" class="label label-success">Asignado</span></a></center></td>';
                    } else {
                        body += '<span id="span-action' + obj[i]['id'] + '" data-state="' + (eval(obj[i].activo == "0" ? 1 : 0)) + '" class="label label-danger">No asignado</span></a></center></td>';
                    }
                }

                htmlTable = table + body + '</tbody></table></div></div>';
            }
            $('#table-data').html(htmlTable);
            $('#table_container').removeClass("hide");
            $('#back2rol').removeClass("hide");
            $('#' + idTable).dataTable();
            waitMeHide();

        }
    }, false, true);
};

var detailAction = function () {

    $('#detailModalAction').load("assets/pages/detail.html", {}, function () {
        $('#detailModalAction #myModalLabel').html('Detalles de acci&oacute;n');
    });

    $('#detailModalAction').on('show.bs.modal', function (e) {
        var data = $(e.relatedTarget).data().recordId;
        var configDetail = [[{dataIndex: 'alias', dataName: 'Nombre'}],
            [{dataIndex: 'descripcion', dataName: 'Descripci&oacute;n'}]];
        $('#detailContent').html('');
        buildDetail(data, 2, configDetail, 'detailContent');
    });
};