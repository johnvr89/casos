/**
 * Created by rene on 4/03/17.
 */
var initReportConsolidatedClientCase = function () {
    $('#page-body').html(getClientCaseConsolidatedReportTableHeader());

    buildListClientCaseReportConsolidated();

};
function dateChanged(ev) {
    var id = $(ev.currentTarget).attr('id');
    var d = new Date(ev.date);
    if (id == 'fecha-inicial') {
        $('#fecha-final').data("DateTimePicker").minDate(d);
    }
    if (id == 'fecha-final') {
        $('#fecha-inicial').data("DateTimePicker").maxDate(d);
    }
    ;
}

var buildListClientCaseReportConsolidated = function () {

    waitMeShow();
    $('#page-body #form-content-report').load("assets/pages/formHeaderReportClientCaseConsolidated.html", {}, function ()
    {
        waitMeHide();
        /*para ocultar los combos*/
        if (!userPermission.AGCaso.listAllCase) {
            if (userPermission.AGCaso.listMyCase) {
                $('#div-responsable-select').hide();
            }
            if (userPermission.AGCaso.listIntermediaryCase) {
                $('#div-intermediario-select').hide();
            }
        }
        $('.datetimepicker-field').datetimepicker({
            locale: 'es',
            format: 'YYYY-MM-DD',
            showTodayButton: true,
            maxDate: new Date(),
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
        }).on('dp.change', dateChanged);

        reportClientValidationEngine('search-report');
        $('#table_container').removeClass("hide");
        $("#search-report input[name=inicio]").on('change', function () {

        })
        executeFilterClientCaseConsolidated();
        $('#fecha-inicial').on('dp.change', function (e) {
            var formatedValue = e.date.format(e.date._f);
        })
        buildCombo('id', 'nombre', 'empresaclients', 'cliente-select', function () {
            $('#cliente-select').chosen();
        });

        buildCombo('id', 'nombre', 'estadolist', 'estado-select-update', function () {
            $('#estado-select-update').chosen();
        });
        if (userPermission.AGCaso.listAllCase || userPermission.AGCaso.listMyCase) {
            buildCombo('id', 'nombreinterfaz', 'usuariointermediarios', 'intermediario-select', function () {
                $('#intermediario-select').chosen();
            });

        }
        if (userPermission.AGCaso.listAllCase || userPermission.AGCaso.listIntermediaryCase) {

            buildCombo('id', 'nombreinterfaz', 'usuarioabogado', 'responsable-select', function () {
                $('#responsable-select').chosen();
            });
        }
        buildCombo('id', 'nombre', 'tipocasolist', 'tipocaso-select', function () {
            $('#tipocaso-select').chosen();
        });



    });

};
var executeFilterClientCaseConsolidated = function () {
    $("#search-report").on("submit", function (e)
    {
        e.preventDefault();
        if ($("#search-report").valid())
        {
            var data = {inicio: $("#search-report input[name=inicio]").val(),
                fin: $("#search-report input[name=fin]").val()};
            if ($('#responsable-select').val() != -1) {
                data.responsable = $('#responsable-select').val();
            }
            if ($('#estado-select-update').val() != -1) {
                data.estado = $('#estado-select-update').val();
            }
            if ($('#cliente-select').val() != -1) {
                data.cliente = $('#cliente-select').val();
            }
            if ($('#intermediario-select').val() != -1) {
                data.intermediario = $('#intermediario-select').val();
            }
            if ($('#tipocaso-select').val() != -1) {
                data.tipocaso = $('#tipocaso-select').val();
            }
           

            waitMeShow();
            var idTable = 'client-case-consolidated-list-report';
            excecuteAjax('GET', getRoute('clientecasoreporteconsolidado'), data, null, function (response)
            {
                if (response.success == true)
                {

                    var header = [{dataName: 'Nombre del cliente', dataIndex: 'nombrecliente'},


                        {dataName: 'N&uacute;mero de casos', dataIndex: 'numerocasos'},
                        {dataName: 'Valor total de los casos', dataIndex: 'valortotal'},
                        {dataName: 'Valor total de dinero pagado', dataIndex: 'valortotalpagado'},
                        {dataName: 'Valor total de dinero pendiente', dataIndex: 'valortotalpendiente'},
                       
                    ];

                    var htmlTable = buildDataTable(idTable, header, response.data, []);
                    $('#table-data').html(htmlTable);
                    var table = $('#' + idTable).DataTable({
                        lengthChange: false,
                        buttons: ['excel', 'pdf']
                    });
                    table.buttons().container().appendTo('#' + idTable + '_wrapper .col-sm-6:eq(0)');
                    waitMeHide();
                }
            },false,true);
        }
    });
}

var getClientCaseConsolidatedReportTableHeader = function ()
{
    return buildTableHeaderReport({tableTitle: "Listado de clientes consolidado"});
}