
/**
 * Created by rene on 4/03/17.
 */
var initAccounts = function ()
{
    $('#page-body').html(getAccountTableHeader());
    buildListAccount();
    if (userPermission.AGCuenta.post) {
        addModalAccount();
        $('#addModalAccount').on('hidden.bs.modal', function ()
        {
            clearForm("addModalAccount");
        });
    }
    if (userPermission.AGCuenta.put) {
        $('#updateModalContainer').on('hidden.bs.modal', function ()
        {
            clearForm('updateModalContainer');
        });
        updateModalAccount();
    }
    if (userPermission.AGCuenta.delete) {
        removeModalAccount();
    }
    detailModalAccount();

};

var buildListAccount = function () {
    var idTable = 'account-list';
    waitMeShow();
    excecuteAjax('GET', getRoute('cuentalist'), {}, null, function (response)
    {
        if (response.success == true)
        {

            var header = [{dataIndex: 'nombre', dataName: 'Nombre'},

                {dataIndex: 'numero', dataName: 'N&uacute;mero'},
                {dataIndex: 'tipo_cuenta', dataName: 'Tipo de cuenta'},
                {dataName: 'Banco', renderer: function (data) {
                        return data['banco'].nombre
                    }},
            ];
            var actionsArray = ['detail'];
            if (userPermission.AGCuenta.put) {
                actionsArray.push('update')
            }
            if (userPermission.AGCuenta.delete) {
                actionsArray.push('delete')
            }
            var htmlTable = buildDataTable(idTable, header, response.data, actionsArray);
            $('#table-data').html(htmlTable);
            $('#table_container').removeClass("hide");
            $('#' + idTable).dataTable();
            waitMeHide();
        }
    },false, true);
};

var getAccountTableHeader = function ()
{
    var header = {tableTitle: "Cuentas"};
    var modalsArray = [{modalType: "detail", containerId: "detailModalAccount"}];

    if (userPermission.AGCuenta.post) {
        header.addModalId = "addAccountModal";
        header.addModalToolTip = "Agregar Cuenta";
        header.addModalTitle = "Nueva Cuenta";
        modalsArray.push({modalType: "add", containerId: "addModalAccount"});
    }
    if (userPermission.AGCuenta.put) {
        modalsArray.push({modalType: "update", containerId: "updateModalContainer"});
    }
    if (userPermission.AGCuenta.delete) {
        modalsArray.push({modalType: "remove", containerId: "removeModalAccount"});
    }
    return buildTableHeader(header, modalsArray);
};

var addModalAccount = function ()
{

    $('#addModalAccount').load("assets/pages/addAccountModal.html", {}, function ()
    {
        buildCombo('id', 'nombre', 'bancolist', 'banco-select');
        accountValidationEngine('form-addAccount');
        addModalAccountSubmit();
    });
};

var updateModalAccount = function ()
{
    $('#updateModalContainer').load("assets/pages/updateAccountModal.html", {}, function ()
    {
        buildCombo('id', 'nombre', 'bancolist', 'banco-select-update');
        accountValidationEngine('form-updateAccount');
        updateModalAccountSubmit();
    });
    $('#updateModalContainer').on('show.bs.modal', function (e) {

        var data = $(e.relatedTarget).data().recordId;
        var model = controller.getData(data);
        $("#form-updateAccount").attr('data-id', data);
        $("#form-updateAccount input[name=nombre]").val(model.nombre);
        $("#form-updateAccount input[name=numero]").val(model.numero);
        $("#form-updateAccount select[name=banco]").val(model.banco.id);
        $("#form-updateAccount select[name=tipoCuenta]").val(model.tipo_cuenta);

    });
}

var addModalAccountSubmit = function ()
{
    $("#form-addAccount").on("submit", function (e)
    {
        e.preventDefault();
        if ($("#form-addAccount").valid())
        {
            waitMeShow("wrapper");
            var data = {nombre: $("#form-addAccount input[name=nombre]").val(), numero: $("#form-addAccount input[name=numero]").val(),
                banco: $("#form-addAccount select[name=banco]").val(),
                tipoCuenta: $("#form-addAccount select[name=tipoCuenta]").val()};
            
            excecuteAjax('POST', getRoute('cuentalist'), data, null, function (response)
            {
                if (response.success == true)
                {
                    $("#addAccountModal").modal('hide');
                    waitMeHide("wrapper");
                    alertify.success("registro ingresado satisfactoriamente");
                    buildListAccount();
                }
            }, false, true);
        }
    });
};

var updateModalAccountSubmit = function ()
{
    $("#form-updateAccount").on("submit", function (e)
    {
        e.preventDefault();
        if ($("#form-updateAccount").valid())
        {
            waitMeShow("wrapper");
            var data = {id: $("#form-updateAccount").attr('data-id'), nombre: $("#form-updateAccount input[name=nombre]").val(), numero: $("#form-updateAccount input[name=numero]").val(),
                banco: $("#form-updateAccount select[name=banco]").val(),
                tipoCuenta: $("#form-updateAccount select[name=tipoCuenta]").val()};

            excecuteAjax('POST', getRoute('cuentaedit'), data, null, function (response)
            {
                if (response.success == true)
                {
                    $("#divUpdateModal").modal('hide');
                    waitMeHide("wrapper");
                    alertify.success("Elemento actualizado satisfactoriamente");
                    buildListAccount();
                }
            }, false, true);
        }
    });
};

var removeModalAccount = function () {
    $('#removeModalAccount').load("assets/pages/removeConfirm.html", {}, function () {
        $('#btn-delete').on('click', function (e) {
            var id = $(this).data('recordId');
            waitMeShow("wrapper");
            excecuteAjax('POST', getRoute('cuentadelete') + '/' + id, {}, null, function (response)
            {
                if (response.success == true)
                {
                    $('#confirm-delete').modal('hide');
                    waitMeHide("wrapper");
                    alertify.success("Cuenta eliminada satisfactoriamente");
                    setTimeout(function () {
                        buildListAccount();
                    }, 1000);
                }

            }, false, true);
        });
    });

    $('#removeModalAccount').on('show.bs.modal', function (e) {
        var data = $(e.relatedTarget).data();
        $('#btn-delete', this).data('recordId', data.recordId);

    });
};

var detailModalAccount = function () {

    $('#detailModalAccount').load("assets/pages/detail.html", {}, function () {
        $('#detailModalAccount #myModalLabel').html('Detalles de cuenta');
    });


    $('#detailModalAccount').on('show.bs.modal', function (e) {
        var data = $(e.relatedTarget).data().recordId;
        var configDetail = [[{dataIndex: 'nombre', dataName: 'Nombre'},
                {dataIndex: 'numero', dataName: 'N&uacute;mero'},
            ], [{dataIndex: 'tipo_cuenta', dataName: 'Tipo de cuenta'},
                {dataName: 'Banco', renderer: function (data) {
                        return data['banco'].nombre
                    }}]];
        $('#detailContent').html("");
        buildDetail(data, 2, configDetail, 'detailContent');

    });
};