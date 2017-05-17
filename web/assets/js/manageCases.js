/**
 * Created by rene on 4/03/17.
 */
var initCase = function () {
    $('#page-body').html(getCaseTableHeader());
    buildListCase();
    if (userPermission.AGCaso.post) {
        addModalCase();

        $('#addModalCase').on('hidden.bs.modal', function ()
        {
            clearForm('addModalCase');
            $("#case-details").children("div").remove();

        });
    }
    if (userPermission.AGCaso.updateAllCase || userPermission.AGCaso.updateMyCase) {
        $('#updateModalContainer').on('hidden.bs.modal', function ()
        {
            clearForm('updateModalContainer');
            $("#case-details-update").children("div").remove();
        });
        $('#confirmUpdateModalCase').load("assets/pages/closeCaseConfirm.html", {});
        updateModalCase( );
    }
    if (userPermission.AGCaso.deleteAllCase || userPermission.AGCaso.deleteMyCase) {
        removeModalCase();
    }
    detailModalCase();

};

var buildListCase = function () {

    var idTable = 'case-list';
    waitMeShow();
    excecuteAjax('GET', getRoute('casolist'), {}, null, function (response)
    {
        if (response.success == true)
        {

            var header = [{dataName: 'Nombre', dataIndex: 'nombre'},
                         {dataName: 'Tipo de caso', renderer: function (t) { return t['tipocaso'].nombre;}},
                         {dataName: 'Cliente', renderer: function (t) { return t['empresa'].nombre; }},
                         {dataName: 'Ciudad', renderer: function (t) { return t['ciudad'].nombre; }},
                         {dataName:'Fecha de creaci&oacute;n', dataIndex:'fechacreacion'},
                         {dataName: 'Pagos pendientes', dataIndex: 'pagospendientes'},
                         {dataName: 'Deuda', dataIndex: 'cantidadatrazada'},
                         {dataName: 'Estado', renderer: function (t) { return t['estado'].nombre; }}];

            var actionsArray = ['detail'];
            if (userPermission.AGCaso.post) {
                actionsArray.push('');
            }
            if (userPermission.AGCaso.updateAllCase || userPermission.AGCaso.updateMyCase)
            {
                actionsArray.push('update');
            }
            if (userPermission.AGCaso.changeToState2)
            {
                actionsArray.push('autorized'); 
            }
            if (userPermission.AGCaso.deleteAllCase || userPermission.AGCaso.deleteMyCase)
            {
                actionsArray.push('delete');
            }
             if (userPermission.AGPagoRealizado.listAllPayment || userPermission.AGPagoRealizado.listMyCasePayment)
            {
               actionsArray.push('payment');
            }
            if (userPermission.AGSeguimiento.listAllTrace || userPermission.AGSeguimiento.listMyTrace)
            {
               actionsArray.push('trace');
            }
            
            

            var htmlTable = buildDataTable(idTable, header, response.data, actionsArray);
            $('#table-data').html(htmlTable);
            $('#table_container').removeClass("hide");
            $('#' + idTable).dataTable();
            waitMeHide();
        }
    }, false, true);
};

var getCaseTableHeader = function ()
{
    var header = {tableTitle: "Casos"};
    var modalsArray = [{modalType: "detail", containerId: "detailModalCase"}];

    if (userPermission.AGCaso.post) {
        header.addModalId = "addCaseModal";
        header.addModalToolTip = "Agregar caso";
        header.addModalTitle = "Nuevo caso";
        modalsArray.push({modalType: "add", containerId: "addModalCase"});
    }
    if (userPermission.AGCaso.updateAllCase || userPermission.AGCaso.updateMyCase)
    {
        modalsArray.push({modalType: "update", containerId: "updateModalContainer"});
        modalsArray.push({modalType: "confirm-update", containerId: "confirmUpdateModalCase"});
    }
    if (userPermission.AGCaso.deleteAllCase || userPermission.AGCaso.deleteMyCase)
    {
        modalsArray.push({modalType: "remove", containerId: "removeModalCase"});
    }

    return buildTableHeader(header, modalsArray);
};

var addModalCase = function ()
{
    $('#addModalCase').load("assets/pages/addCaseModal.html", {}, function ()
    {
        buildCombo('id', 'nombre', 'tipocasolist', 'tipocaso-select');
        buildCombo('id', 'nombre', 'ciudadlist', 'ciudad-select');
        buildCombo('id', 'nombre', 'empresaclients', 'cliente-select');
        buildCombo('id', 'nombreinterfaz', 'usuariointermediarios', 'intermediario-select');
        buildCombo('id', 'nombreinterfaz', 'usuarioabogado', 'responsable-select');
        $("#tipocaso-select").on("change", function ()
        {
            buildCasesDetails($("#tipocaso-select").val(), 'caracteristicalist', 'case-details');
        });
        addModalCaseSubmit();
        caseValidationEngine('form-addCase');
    });
};

var addModalCaseSubmit = function ()
{
    $("#form-addCase").on("submit", function (e)
    {
        e.preventDefault();
        var allValids = true;
        var inputs = $('#form-addCase .case-feature');
        $.each(inputs, function (index, element)
        {

            var validElement = $(element).valid();
            allValids = validElement && allValids;
            $(element).parent().parent().find("span.error").css({'display': validElement ? 'none' : 'block'});
        });
        if (!allValids)
        {
            e.preventDefault();
        } else {
            if ($("#form-addCase").valid())
            {
                var caracteristicas = [];
                waitMeShow("wrapper");
                $.each($("#form-addCase .case-feature"), function (index, element)
                {
                    caracteristicas.push({id: $(element).attr("idfeature"), valor: $(element).val()});
                });

                var data = {tipocaso: $("#form-addCase select[name=tipocaso]").val(), empresa: $("#form-addCase select[name=empresa]").val(),
                    honorarios: $("#form-addCase input[name=honorarios]").val(), ciudad: $("#form-addCase select[name=ciudad]").val(),
                    observacion: $("#form-addCase textarea[name=observacion]").val(), resolucion: $("#form-addCase textarea[name=resolucion]").val(),
                    nombre: $("#form-addCase input[name=nombre]").val(),
                    responsable: $("#form-addCase select[name=responsable]").val(),
                    caracteristicas: caracteristicas};
                if ($("#form-addCase select[name=intermediario]").val() != -1) {
                    data.intermediario = $("#form-addCase select[name=intermediario]").val();
                }

                excecuteAjax('POST', getRoute('casolist'), data, null, function (response)
                {
                    if (response.success == true)
                    {
                        $("#addCaseModal").modal('hide');
                        waitMeHide("wrapper");
                        alertify.success("registro ingresado satisfactoriamente");
                        buildListCase();
                    }
                }, false, true);
            }
        }
    });
};

var updateModalCase = function ()
{
    $('#updateModalContainer').load("assets/pages/updateCaseModal.html", {}, function ()
    {
        buildCombo('id', 'nombre', 'tipocasolist', 'tipocaso-select-update');
        buildCombo('id', 'nombre', 'ciudadlist', 'ciudad-select-update');
        buildCombo('id', 'nombre', 'empresaclients', 'cliente-select-update');
        buildCombo('id', 'nombreinterfaz', 'usuariointermediarios', 'intermediario-select-update');
        buildCombo('id', 'nombre', 'estadolist', 'estado-select-update');
        buildCombo('id', 'nombreinterfaz', 'usuarioabogado', 'responsable-select-update');
        caseValidationEngine('form-updateCase');
        updateModalCaseSubmit();
    });

    $('#updateModalContainer').on('show.bs.modal', function (e) {

        var data = $(e.relatedTarget).data().recordId;
        var model = controller.getData(data);
        $("#form-updateCase select[name=tipocaso]").val(model.tipocaso.id).prop('disabled', true);
        $("#form-updateCase select[name=empresa]").val(model.empresa.id);
        $("#form-updateCase input[name=honorarios]").val(model.honorarios);
        $("#form-updateCase select[name=ciudad]").val(model.ciudad.id);
        $("#form-updateCase textarea[name=observacion]").val(model.observacion);
        $("#form-updateCase textarea[name=resolucion]").val(model.resolucion);
        $("#form-updateCase input[name=nombre]").val(model.nombre);
        $("#form-updateCase select[name=intermediario]").val(model.intermediario.id);
        $("#form-updateCase select[name=estado]").val(model.estado.id);
        $("#form-updateCase select[name=responsable]").val(model.responsable.id).prop('disabled', true);
        $("#form-updateCase ").attr('data-id', data);

        buildCasesDetails(model.tipocaso.id, 'caracteristicalist', 'case-details-update', model.detalles);
    });
};

var updateModalCaseSubmit = function ()
{
    $("#form-updateCase").on("submit", function (e)
    {
        e.preventDefault();
        var inputs = $('#form-updateCase .case-feature');
        var allValids = true;
        $.each(inputs, function (index, element)
        {
            var validElement = $(element).valid();
            allValids = validElement && allValids;
            $(element).parent().parent().find("span.error").css({'display': validElement ? 'none' : 'block'});
        });
        if (!allValids)
        {
            e.preventDefault();
        } else {
            if ($("#form-updateCase").valid())
            {

                var detalles = [];
                $.each($("#form-updateCase .case-feature"), function (index, element)
                {
                    var detail = {caso: $("#form-updateCase").attr('data-id'), tipoCasoCaracteristica: $(element).attr("idfeature"), valor: $(element).val()};
                    if ($(element).attr("iddetail") != undefined)
                    {
                        detail.id = $(element).attr("iddetail");
                    }
                    detalles.push(detail);
                });

                var data = {id: $("#form-updateCase").attr('data-id'), empresa: $("#form-updateCase select[name=empresa]").val(),
                    honorarios: $("#form-updateCase input[name=honorarios]").val(), ciudad: $("#form-updateCase select[name=ciudad]").val(),
                    observacion: $("#form-updateCase textarea[name=observacion]").val(), resolucion: $("#form-updateCase textarea[name=resolucion]").val(),
                    nombre: $("#form-updateCase input[name=nombre]").val(),
                    estado: $("#form-updateCase select[name=estado]").val(),
                    detalles: detalles};

                if ($("#form-updateCase select[name=intermediario]").val() != -1) {
                    data.intermediario = $("#form-updateCase select[name=intermediario]").val();
                }
                var dataCase = controller.getData($("#form-updateCase").attr('data-id'));
                var estadoSelect = $("#form-updateCase select[name=estado]").val();
                /*si se va a cambiar de terminado y debe dinero debe de advertirle*/

                if (estadoSelect == 5 && dataCase.estado.id == 4 && dataCase.honorarios > dataCase.dineropagado) {


                    $('#confirm-update').modal();

                    $('#confirm-update').modal('show');
                    $('#confirm-update #btn-accept').on('click', function (e) {
                        executeUpdate(data);
                        $("#confirm-update").modal('hide');
                    });
                } else {
                    executeUpdate(data);
                }

            }
        }
    });
};

var executeUpdate = function (data) {
    waitMeShow("wrapper");
    excecuteAjax('POST', getRoute('casoedit'), data, null, function (response)
    {
        if (response.success == true)
        {
            $("#divUpdateModal").modal('hide');
            waitMeHide("wrapper");
            alertify.success("Elemento actualizado satisfactoriamente");
            buildListCase();
        }
    }, false, true);
};

var autorizedCase=function(id){
   waitMeShow();
   excecuteAjax('POST', getRoute('casoautorized'), {id:id}, null, function (response)
    {
        if (response.success == true)
        {
            waitMeHide();
            alertify.success("Caso autorizado satisfactoriamente");
            buildListCase();
        }
    }, false, true); 
};

var removeModalCase = function () {
    $('#removeModalCase').load("assets/pages/removeConfirm.html", {}, function () {
        $('#btn-delete').on('click', function (e) {
            var id = $(this).data('recordId');
            waitMeShow("wrapper");
            excecuteAjax('POST', getRoute('casodelete') + '/' + id, {}, null, function (response)
            {
                if (response.success == true)
                {
                    $('#confirm-delete').modal('hide');
                    waitMeHide("wrapper");
                    alertify.success("Caso eliminado satisfactoriamente");
                    setTimeout(function () {
                        buildListCase();
                    }, 1000);
                }

            }, false, true);

        });
    });

    $('#removeModalCase').on('show.bs.modal', function (e) {
        var data = $(e.relatedTarget).data();
        $('#btn-delete', this).data('recordId', data.recordId);
    });
};

var detailModalCase = function () {

    $('#detailModalCase').load("assets/pages/detail.html", {}, function () {
        $('#detailModalCase #myModalLabel').html('Detalles de caso');
    });

    $('#detailModalCase').on('show.bs.modal', function (e) {
        var data = $(e.relatedTarget).data().recordId;
        
        
        
        var configDetail = 
                [
                    [
                        {dataName: 'Nombre', dataIndex: 'nombre'},
                        {dataName: 'Empresa', renderer: function (t) { return t['empresa'].nombre; }},                        
                        {dataName: 'Tipo de caso', renderer: function (t) { return t['tipocaso'].nombre; }},
                        {dataName: 'Responsable', renderer: function (t) { return t['responsable'].nombreinterfaz; }},
                        {dataName: 'Intermediario', renderer: function (t) { return t['intermediario'].nombreinterfaz != undefined ? t['intermediario'].nombreinterfaz : "Sin Intermediario"; }},
                        {dataName: 'Fecha de Creaci&oacute;n', dataIndex:'fechacreacion'},
                        {dataName: 'Estado', renderer: function (t) { return t['estado'].nombre; }}, 
                        
                    ],
                    [
                        {dataName: 'Deuda', dataIndex: 'cantidadatrazada'},        
                        {dataName: 'Honorarios', dataIndex: 'honorarios'},                        
                        {dataName: 'Ciudad', renderer: function (t) { return t['ciudad'].nombre;}},
                        {dataName: 'Fec. pr&oacute;x. pago', renderer: function (t) { return t['proximopago'] != "" ? t['proximopago'] : "No especificado"; }},
                        {dataName: 'Pagos pendientes', dataIndex: 'pagospendientes'},
                        {dataName: 'Observaci&oacute;n', dataIndex: 'observacion'}
                    ],                    
                    [
                        {dataName: 'Resoluci&oacute;n', dataIndex: 'resolucion'},
                        {dataName: '', renderer: function (t) { 
                                                                    var text = "<br>";
                                                                    var i;
                                                                    for (i = 0; i < t['detalles'].length; i++) {
                                                                        text += "<b>"+t['detalles'][i].tipoCasoCaracteristica.nombre_campo + "</b><br>";
                                                                        text += t['detalles'][i].valor + "<br> <br>";
                                                                    }
                                                                    return text;
                                                              }}, 
                    ]    

                ];
        $('#detailContent').html("");
        buildDetail(data, 3, configDetail, 'detailContent');
    });
}
