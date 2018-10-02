/**
 * Created by rene on 4/03/17.
 */
var initTraceOfCase = function (id, caseName)
{
    $('#page-body').html(getTraceOfCaseTableHeader(caseName));
    builTraceOfCase(id);
    if (userPermission.AGSeguimiento.addTraceToAllCase || userPermission.AGSeguimiento.addTraceToMyCase) {

        addModalTrace(id);
        $('#addModalTraceOfCase').on('hidden.bs.modal', function ()
        {
            clearForm('form-addTraceOfCaseModal');
        });
        $('#updateModalContainer').on('hidden.bs.modal', function ()
        {
            clearForm('updateModalContainer');
        });
    }
    if (userPermission.AGSeguimiento.deleteTraceToAllCase ||
            userPermission.AGSeguimiento.deleteTraceToMyCase) {
        removeModalTraceOfCase(id);
    }
    detailModalTraceOfCase(id);
    if (userPermission.AGSeguimiento.updateTraceToAllCase ||
            userPermission.AGSeguimiento.updateTraceToMyCase) {
        updateModalTraceOfCase(id);
    }
};

var builTraceOfCase = function (id) {
    var idTable = 'trace-case-list';
    waitMeShow();
    excecuteAjax('GET', getRoute('seguimientocasolist'), {caso: id}, null, function (response)
    {

        if (response.success == true)
        {

            var header = [{dataIndex: 'nombre', dataName: 'Nombre'},

                {dataIndex: 'descripcion', dataName: 'Descripci&oacute;n'},
                {dataName: 'Responsable', renderer: function (data) {
                        return data['responsable_seguimiento'].nombreinterfaz;
                    }}
            ];
            var actionsArray = ['detail'];
            if (userPermission.AGSeguimiento.updateTraceToAllCase ||
                    userPermission.AGSeguimiento.updateTraceToMyCase) {
                actionsArray.push('update-trace')
            }

            if (userPermission.AGSeguimiento.deleteTraceToAllCase ||
                    userPermission.AGSeguimiento.deleteTraceToMyCase) {
                actionsArray.push('delete-trace')

            }
            actionsArray.push('document-trace');
            var htmlTable = buildDataTable(idTable, header, response.data, actionsArray);
            $('#table-data').html(htmlTable);
            $('#table_container').removeClass("hide");
            $('#back2case').removeClass("hide");
            $('#' + idTable).dataTable();
            waitMeHide();
        }
    }, false, true);
};

var getTraceOfCaseTableHeader = function (caseName)
{
    var header = '<a id="back2case" class="cursor-pointer hide" onclick="initCase()"><i class="fa fa-arrow-left"></i> Volver al listado de casos</a>';
    
    var header2 = {tableTitle: "Seguimientos del caso: " + caseName};
    var modalsArray = [{modalType: "detail", containerId: "detailModalTraceOfCase"}];

     if (userPermission.AGSeguimiento.addTraceToAllCase || userPermission.AGSeguimiento.addTraceToMyCase) {
        header2.addModalId = "addModalTrace";
        header2.addModalToolTip = "Agregar Seguimiento";
        header2.addModalTitle = "Nuevo Seguimiento";
        modalsArray.push({modalType: "add", containerId: "addModalTraceOfCase"});
    }
    if (userPermission.AGSeguimiento.updateTraceToAllCase ||
                    userPermission.AGSeguimiento.updateTraceToMyCase) {
        modalsArray.push({modalType: "update", containerId: "updateModalContainer"});
    }
    if (userPermission.AGSeguimiento.deleteTraceToAllCase ||
                    userPermission.AGSeguimiento.deleteTraceToMyCase) {
        modalsArray.push({modalType: "remove", containerId: "removeModalTraceOfCase"});
    }
    header += buildTableHeader(header2, modalsArray);

    return header;
};

var addModalTrace = function (id)
{
    $('#addModalTraceOfCase').load("assets/pages/addTraceOfCaseModal.html", {}, function ()
    {

        traceValidationEngine('form-addTraceOfCaseModal');
        addModalTraceSubmit(id);
        convertFile();
    });
};

var addModalTraceSubmit = function (id)
{
    $("#form-addTraceOfCaseModal").on("submit", function (e)
    {
        e.preventDefault();
        if ($("#form-addTraceOfCaseModal").valid())
        {
            waitMeShow("wrapper");
            var fileInput = document.getElementById("import");
            var file = fileInput.files[0];
            var formdata = new FormData();
            formdata.append('import', file);
            var data = {nombre: $("#form-addTraceOfCaseModal input[name=nombre]").val(),
                descripcion: $("#form-addTraceOfCaseModal textarea[name=descripcion]").val(),
                caso: id,
                observacion: $("#form-addTraceOfCaseModal textarea[name=observacion]").val()
            }
            formdata.append('trace', JSON.stringify(data));

            excecuteAjax('POST', getRoute('seguimientocasolist'), formdata, null, function (response)
            {
                if (response.success == true)
                {
                    $("#addModalTrace").modal('hide');
                    waitMeHide("wrapper");
                    alertify.success("registro ingresado satisfactoriamente");
                    builTraceOfCase(id);
                }
            }, true, true);
        }
    });
};

var updateModalTraceOfCase = function (id)
{
    $('#updateModalContainer').load("assets/pages/updateTraceOfCaseModal.html", {}, function ()
    {

        caseFeatureValidationEngine('form-updateTraceOfCaseModal');
        updateModalTraceOfCaseSubmit(id);
        convertFile();
    });

    $('#updateModalContainer').on('show.bs.modal', function (e) {

        var data = $(e.relatedTarget).data().recordId;
        var model = controller.getData(data);
        $("#form-updateTraceOfCaseModal input[name=nombre]").val(model.nombre);
        $("#form-updateTraceOfCaseModal textarea[name=descripcion]").val(model.descripcion);
        $("#form-updateTraceOfCaseModal textarea[name=observacion]").val(model.observacion);
        $("#form-updateTraceOfCaseModal").attr('data-id', data);


    });
};

var updateModalTraceOfCaseSubmit = function (id)
{
    $("#form-updateTraceOfCaseModal").on("submit", function (e)
    {
        e.preventDefault();
        if ($("#form-updateTraceOfCaseModal").valid())
        {
            waitMeShow("wrapper");
            var fileInput = document.getElementById("import-update");
            var file = fileInput.files[0];
            var formdata = new FormData();
            formdata.append('import', file);
            var data = {id: $("#form-updateTraceOfCaseModal").attr('data-id'), nombre: $("#form-updateTraceOfCaseModal input[name=nombre]").val(),
                descripcion: $("#form-updateTraceOfCaseModal textarea[name=descripcion]").val(),
                caso: id,
                observacion: $("#form-updateTraceOfCaseModal textarea[name=observacion]").val()
            };

            formdata.append('trace', JSON.stringify(data));

            excecuteAjax('POST', getRoute('seguimientocasoedit'), formdata, null, function (response)
            {
                if (response.success == true)
                {
                    $("#divUpdateModal").modal('hide');
                    waitMeHide("wrapper");
                    alertify.success("Elemento actualizado satisfactoriamente");
                    builTraceOfCase(id);
                }
            }, true, true);
        }
    });

};

var removeModalTraceOfCase = function (id) {
    $('#removeModalTraceOfCase').load("assets/pages/removeConfirm.html", {}, function () {
        $('#btn-delete').on('click', function (e) {
            waitMeShow("wrapper");
            var recordId = $(this).data('recordId');
            excecuteAjax('POST', getRoute('seguimientocasodelete') + '/' + recordId, {}, null, function (response)
            {
                if (response.success == true)
                {
                    $('#confirm-delete').modal('hide');
                    waitMeHide("wrapper");
                    alertify.success("Seguimiento eliminado satisfactoriamente");
                    setTimeout(function () {
                        builTraceOfCase(id);
                    }, 1000);
                }
            }, false, true);
        });
    });

    $('#removeModalTraceOfCase').on('show.bs.modal', function (e) {
        var data = $(e.relatedTarget).data();
        $('#btn-delete', this).data('recordId', data.recordId);
    });
};

var detailModalTraceOfCase = function () {

    $('#detailModalTraceOfCase').load("assets/pages/detail.html", {}, function () {
        $('#detailModalTraceOfCase #myModalLabel').html('Detalles de Seguimientos');
    });

    $('#detailModalTraceOfCase').on('show.bs.modal', function (e) {
        var data = $(e.relatedTarget).data().recordId;
        var configDetail = [[{dataIndex: 'nombre', dataName: 'Nombre'},

                {dataName: 'Cambio de estado', renderer: function (data) {
                        return data['cambio_estado'] ? 'Si' : 'No';
                    }},
                {dataName: 'Responsable', renderer: function (data) {
                        return data['responsable_seguimiento'].nombreinterfaz;
                    }}
            ], [{dataIndex: 'descripcion', dataName: 'Descripci&oacute;n'},
                {dataIndex: 'observacion', dataName: 'Observaci&oacute;n'},
                {dataName: 'Nombre del documento', renderer: function (data) {
                        if (data['documento']) {
                            return data['documento'].nombre;
                        }
                        return 'No posee documento asociado.';

                    }}]];
        $('#detailContent').html("");
        buildDetail(data, 2, configDetail, 'detailContent');
    });
};

var convertFile = function () {
    $(":file").filestyle({
        buttonName: "btn-info",
        buttonText: 'Buscar',
        placeholder: 'No hay FICHERO seleccionado',
        buttonBefore: true,
        size: "sm",
        iconName: "glyphicon glyphicon-picture"
    });
    $('input.filestyle').attr('accept', '*');
};

var downloadDocument = function (idTrace) {
    var url = controller.getData(idTrace);
    url = serviceaddress + url.documento.url;
    window.open(url, "", "width=0,height=0");
};