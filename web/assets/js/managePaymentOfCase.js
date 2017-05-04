/**
 * Created by rene on 4/03/17.
 */
var initPaymentOfCase = function (id, caseName, totalPayment, honorarios)
{
    $('#page-body').html(getPaymentCaseTableHeader(caseName));
    buildListPaymentCase(id);
    if (userPermission.AGPagoRealizado.addPaymentToAllCase || userPermission.AGPagoRealizado.addPaymentToMyCase) {
        addModalPaymentCase(id, totalPayment, honorarios);
        $('#addModalPaymentCase').on('hidden.bs.modal', function ()
        {
            clearForm('addModalPaymentCase');
        });
    }
    if (userPermission.AGPagoRealizado.updatePaymentToAllCase || userPermission.AGPagoRealizado.updatePaymentToMyCase) {
        $('#updateModalContainer').on('hidden.bs.modal', function ()
        {
            clearForm('updateModalContainer');
        });
        updateModalPayment(id, totalPayment, honorarios);
    }
    if (userPermission.AGPagoRealizado.deletePaymentToAllCase || userPermission.AGPagoRealizado.deletePaymentToMyCase) {
        removeModalPaymentCase(id);
    }
    detailModalPaymentCase(id);


};

var buildListPaymentCase = function (id) {

    var idTable = 'payment-list';
    waitMeShow();
    excecuteAjax('GET', getRoute('listpagorealizadocaso'), {caso: id}, null, function (response)
    {

        if (response.success == true)
        {

            var header = [{dataIndex: 'valor_pagado', dataName: 'Valor pagado'},
                {dataName: 'Cuenta', renderer: function (data) {
                        return data['cuenta'].numero;
                    }},
                {dataName: 'Forma de pago', renderer: function (data) {
                        return data['forma_pago'].nombre;
                    }},
                {dataName: 'Tipo de cobro', renderer: function (data) {
                        return data['tipo_cobro'].nombre;
                    }},
                {dataIndex: 'fecha_proximo_cobro', dataName: 'Fecha del pr&oacute;ximo cobro'}
            ];
            var actionsArray = ['detail'];
            if (userPermission.AGPagoRealizado.updatePaymentToAllCase || userPermission.AGPagoRealizado.updatePaymentToMyCase) {
                actionsArray.push('update')
            }

            if (userPermission.AGPagoRealizado.deletePaymentToAllCase || userPermission.AGPagoRealizado.deletePaymentToMyCase) {
                actionsArray.push('delete')
            }
            actionsArray.push('paymentpdf')
            actionsArray.push('document-trace');
            var htmlTable = buildDataTable(idTable, header, response.data, actionsArray);
            $('#table-data').html(htmlTable);
            $('#table_container').removeClass("hide");
            $('#back2case').removeClass("hide");
            $('#' + idTable).dataTable();
            waitMeHide();
            $('#confirmClosePaymentModalCase').load("assets/pages/closePaymentConfirm.html", {});
            $('#confirmUpdateClosePaymentModalCase').load("assets/pages/closeUpdatePaymentConfirm.html", {});

        }
    }, false, true);
};

var getPaymentCaseTableHeader = function (caseName)
{
    var header = '<a id="back2case" class="cursor-pointer hide" onclick="initCase()"><i class="fa fa-arrow-left"></i> Volver al listado de casos</a>';
    var header2 = {tableTitle: "Pagos  del caso: " + caseName};
    var modalsArray = [{modalType: "detail", containerId: "detailModalPaymentCase"}];

    if (userPermission.AGPagoRealizado.addPaymentToAllCase || userPermission.AGPagoRealizado.addPaymentToMyCase) {
        header2.addModalId = "addPaymentModal";
        header2.addModalToolTip = "Agregar Pago";
        header2.addModalTitle = "Nuevo pago";
        modalsArray.push({modalType: "add", containerId: "addModalPaymentCase"});
    }
    if (userPermission.AGPagoRealizado.updatePaymentToAllCase || userPermission.AGPagoRealizado.updatePaymentToMyCase) {
        modalsArray.push({modalType: "update", containerId: "updateModalContainer"});
    }
    if (userPermission.AGPagoRealizado.deletePaymentToAllCase || userPermission.AGPagoRealizado.deletePaymentToMyCase) {
        modalsArray.push({modalType: "remove", containerId: "removeModalPaymentCase"});
    }
    modalsArray.push({modalType: "confirm-update", containerId: "confirmClosePaymentModalCase"})
    modalsArray.push({modalType: "confirm-update-payment", containerId: "confirmUpdateClosePaymentModalCase"})

    header += buildTableHeader(header2, modalsArray);

    return header;


};

var addModalPaymentCase = function (id, totalPayment, honorarios)
{
    $('#addModalPaymentCase').load("assets/pages/addPaymentModal.html", {}, function ()
    {
        buildCombo('id', 'numero', 'cuentalist', 'select-cuenta');
        buildCombo('id', 'nombre', 'formapagolist', 'select-forma-pago');
        buildCombo('id', 'nombre', 'tipocobrolist', 'select-tipo-cobro');

        $('.datetimepicker-field').datetimepicker({
            locale: 'es',
            format: 'YYYY-MM-DD',
            showTodayButton: true,
            minDate: new Date(),
            tooltips: {
                today: 'Hoy',
                selectMonth: 'Seleccionar mes',
                prevMonth: 'Mes anterior',
                nextMonth: 'Mes siguiente',
                selectYear: 'Seleccionar año',
                prevYear: 'Año siguiente',
                nextYear: 'Año siguiente',
                selectDecade: 'Seleccinar d&eacute;cada',
                prevDecade: 'D&eacute;cada anterior',
                nextDecade: 'D&eacute;cada siguiente',
                prevCentury: 'Siglo anterior',
                nextCentury: 'Siglo siguiente'
            }
        });
        paymentValidationEngine('form-addPayment');
        addModalPaymentCaseSubmit(id, totalPayment, honorarios);
          $('#porpagar').html( 'Cantidad por pagar: $'+(parseInt(honorarios) - parseInt(totalPayment)))  ;
       

        $('#form-addPayment #select-tipo-cobro').on('change', function () {

            if ($('#form-addPayment #select-tipo-cobro').val() == 2) {
                $('#form-addPayment input[name=fechaProximoCobro]').val('');
                $('#form-addPayment #requiered-payment-date').addClass("hide");
            } else
            {
                $('#form-addPayment #requiered-payment-date').removeClass("hide");
            }
        })
        convertFilePayment();
    });
};

var addModalPaymentCaseSubmit = function (id, totalPayment, honorarios)
{
    $("#form-addPayment").on("submit", function (e)
    {

        e.preventDefault();
        if ($("#form-addPayment").valid())
        {
            var data = {cuenta: $("#form-addPayment select[name=cuenta]").val(),
                formaPago: $("#form-addPayment select[name=formaPago]").val(),
                tipoCobro: $("#form-addPayment select[name=tipoCobro]").val(),
                valorPagado: $("#form-addPayment input[name=valorPagado]").val(),
                fechaProximoCobro: $("#form-addPayment input[name=fechaProximoCobro]").val(),
                caso: id,
                confirm: 0};
            var fileInput = document.getElementById("import-payment");
            var file = fileInput.files[0];
            if ((parseInt(data.valorPagado) + parseInt(totalPayment) < parseInt(honorarios)) && data.tipoCobro == 2) {

                $('#confirm-payment').modal();

                $('#confirm-payment').modal('show');
                $('#confirm-payment #btn-accept').on('click', function (e) {
                    data.confirm = 1;

                    executeAddPayment(data, id, totalPayment, file,honorarios);
                    $("#confirm-payment").modal('hide');
                });
            } else {
                executeAddPayment(data, id, totalPayment, file,honorarios);
            }


        }
    });
};

var executeAddPayment = function (data, id, totalPayment, file,honorarios) {

    waitMeShow("wrapper");
    var formdata = new FormData();
    formdata.append('import', file);
    formdata.append('payment', JSON.stringify(data));

    excecuteAjax('POST', getRoute('listpagorealizadocaso'), formdata, null, function (response)
    {
        if (response.success == true)
        {
            $("#addPaymentModal").modal('hide');
            waitMeHide("wrapper");
            alertify.success("Elemento insertado satisfactoriamente");
             $('#porpagar').html( 'Cantidad por pagar: $'+(parseInt(honorarios) - parseInt(totalPayment)-parseInt(data.valorPagado)))  ;
            buildListPaymentCase(id);
            totalPayment += data.valorPagado;
            if (data.tipoCobro == 2) {
                $('a[data-target=#addPaymentModal]').addClass('hidden');
            }
        }
    }, true, true);
};

var updateModalPayment = function (idCase, totalPayment, honorarios)
{
    $('#updateModalContainer').load("assets/pages/updatePaymentModal.html", {}, function ()
    {
        paymentValidationEngine('form-updatePayment');

        buildCombo('id', 'numero', 'cuentalist', 'select-cuenta-update');
        buildCombo('id', 'nombre', 'formapagolist', 'select-forma-pago-update');
        buildCombo('id', 'nombre', 'tipocobrolist', 'select-tipo-cobro-update');

        $('#updateModalContainer .datetimepicker-field').datetimepicker({
            locale: 'es',
            format: 'YYYY-MM-DD',
            showTodayButton: true,
            minDate: new Date(),
            tooltips: {
                today: 'Hoy',
                selectMonth: 'Seleccionar mes',
                prevMonth: 'Mes anterior',
                nextMonth: 'Mes siguiente',
                selectYear: 'Seleccionar año',
                prevYear: 'Año siguiente',
                nextYear: 'Año siguiente',
                selectDecade: 'Seleccinar d&eacute;cada',
                prevDecade: 'D&eacute;cada anterior',
                nextDecade: 'D&eacute;cada siguiente',
                prevCentury: 'Siglo anterior',
                nextCentury: 'Siglo siguiente'
            }
        });
        convertFilePayment();
        updateModalPaymentCaseSubmit(idCase, totalPayment, honorarios);
        $('#form-updatePayment #select-tipo-cobro-update').on('change', function () {

            if ($('#form-updatePayment #select-tipo-cobro-update').val() == 2) {

                $('#form-updatePayment input[name=fechaProximoCobro]').val('');
                $('#form-addPayment span#requiered-payment-date').addClass("hide");
            } else
            {
                $('#form-addPayment span#requiered-payment-date').removeClass("hide");
            }
        })
    });
    $('#updateModalContainer').on('show.bs.modal', function (e) {

        var data = $(e.relatedTarget).data().recordId;

        var model = controller.getData(data);
        $("#form-updatePayment select[name=cuenta]").val(model.cuenta.id);
        $("#form-updatePayment select[name=formaPago]").val(model.forma_pago.id);
        $("#form-updatePayment select[name=tipoCobro]").val(model.tipo_cobro.id);
        $("#form-updatePayment input[name=valorPagado]").val(model.valor_pagado);
        $("#form-updatePayment input[name=fechaProximoCobro]").val(model.fecha_proximo_cobro);
        $("#form-updatePayment").attr('data-id', data);
    });

};

var updateModalPaymentCaseSubmit = function (idCase, totalPayment, honorarios)
{
    $("#form-updatePayment").on("submit", function (e)
    {

        e.preventDefault();
        if ($("#form-updatePayment").valid())
        {
            var data = {id: $("#form-updatePayment").attr('data-id'), cuenta: $("#form-updatePayment select[name=cuenta]").val(),
                formaPago: $("#form-updatePayment select[name=formaPago]").val(),
                tipoCobro: $("#form-updatePayment select[name=tipoCobro]").val(),
                valorPagado: $("#form-updatePayment input[name=valorPagado]").val(),
                fechaProximoCobro: $("#form-updatePayment input[name=fechaProximoCobro]").val(),
                caso: idCase,
                confirm: 0};
            var fileInput = document.getElementById("import-update-payment");
            var file = fileInput.files[0];

            if (((parseInt(data.valorPagado) + parseInt(totalPayment) - parseInt(controller.getData(data.id).valor_pagado)) < parseInt(honorarios)) && data.tipoCobro == 2 && controller.getData(data.id).tipo_cobro != 2) {

                $('#confirm-payment-update').modal('show');
                $('#confirm-payment-update #btn-accept').on('click', function (e) {
                    data.confirm = 1;

                    $("#confirm-payment-update").modal('hide');
                    $('#confirm-payment-update #btn-accept').unbind('click')
                    executeUpdatePayment(data, idCase, totalPayment, file);

                });
            } else {

                executeUpdatePayment(data, idCase, totalPayment, file);
            }


        }
    });
};

var executeUpdatePayment = function (data, id, totalPayment, file) {
    waitMeShow("wrapper");
    var formdata = new FormData();
    formdata.append('import', file);
    formdata.append('payment', JSON.stringify(data));
    excecuteAjax('POST', getRoute('pagoedit'), formdata, null, function (response)
    {
        if (response.success == true)
        {
            $("#divUpdateModal").modal('hide');
            waitMeHide("wrapper");
            alertify.success("Elemento actualizado satisfactoriamente");
            buildListPaymentCase(id);
            /*si es pa cerrar se quita el agregar caso hay que poner que si elimina el cierre se ponga de nuevo el boton*/
            if (data.tipoCobro == 2) {
                $('a[data-target=#addPaymentModal]').addClass('hidden');
            }
            /*se le resta al valor pagado el viejo y eso es se le adiciona al total pagado*/
            totalPayment += (parseInt(data.valorPagado) - parseInt(controller.getData(data.id).valor_pagado));
        }
    }, true, true);
};

var convertFilePayment = function () {

    $(":file").filestyle({
        buttonName: "btn-info",
        buttonText: 'Buscar',
        placeholder: 'No hay fichero seleccionado',
        buttonBefore: true,
        size: "sm",
        iconName: "glyphicon glyphicon-picture"
    });
    $('input.filestyle').attr('accept', '*');

};

var removeModalPaymentCase = function (id) {
    $('#removeModalPaymentCase').load("assets/pages/removeConfirm.html", {}, function () {
        $('#btn-delete').on('click', function (e) {
            waitMeShow("wrapper");
            var recordId = $(this).data('recordId');
            excecuteAjax('POST', getRoute('pagodelete') + '/' + recordId, {}, null, function (response)
            {
                if (response.success == true)
                {
                    $('#confirm-delete').modal('hide');
                    waitMeHide("wrapper");
                    alertify.success("Pago eliminado satisfactoriamente");
                    setTimeout(function () {
                        buildListPaymentCase(id);
                    }, 1000);
                }

            }, false, true);

        });
    });

    $('#removeModalPaymentCase').on('show.bs.modal', function (e) {
        var data = $(e.relatedTarget).data();
        $('#btn-delete', this).data('recordId', data.recordId);
    });
};

var detailModalPaymentCase = function () {

    $('#detailModalPaymentCase').load("assets/pages/detail.html", {}, function () {
        $('#detailModalPaymentCase #myModalLabel').html('Detalles de Pago realizado');
    });

    $('#detailModalPaymentCase').on('show.bs.modal', function (e) {
        var data = $(e.relatedTarget).data().recordId;
        var configDetail = [[{dataIndex: 'valor_pagado', dataName: 'Valor pagado'},
                {dataName: 'Cuenta', renderer: function (data) {
                        return data['cuenta'].numero;
                    }},
                {dataName: 'Nombre del documento', renderer: function (data) {
                        if (data['documento']) {
                            return data['documento'].nombre;
                        }
                        return 'No posee documento asociado.';

                    }},
                {dataName: 'Forma de pago', renderer: function (data) {
                        return data['forma_pago'].nombre;
                    }}],
            [{dataName: 'Tipo de cobro', renderer: function (data) {
                        return data['tipo_cobro'].nombre;
                    }},
                {dataIndex: 'fecha_proximo_cobro', dataName: 'Fecha del pr&oacute;ximo cobro'}]];

        $('#detailContent').html("");
        buildDetail(data, 2, configDetail, 'detailContent');
    });
};

var exportPaymentPdf = function (id) {
    waitMeShow();
    excecuteAjax('GET', getRoute('pagoexportpdf') + id, {}, null, function (response)
    {
        if (response.success == true)
        {
            url = serviceaddress + response.file;
            window.open(url, "", "width=0,height=0");
            waitMeHide();

        }
    }, false, true);
};