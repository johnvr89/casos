/**
 * Created by rene on 4/03/17.
 */
var initReportConsolidatedCase = function () {
    $('#page-body').html(getCaseConsolidatedReportTableHeader());

    buildListCaseReportConsolidated();

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

var buildListCaseReportConsolidated = function () {

    waitMeShow();
    $('#page-body #form-content-report').load("assets/pages/formHeaderReportCaseConsolidated.html", {}, function ()
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
            format: 'DD/MM/YYYY',
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
        executeFilterConsolidatedCase();
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
var executeFilterConsolidatedCase = function () {
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
            if ($('#nombrecaso').val() !=""&&$('#nombrecaso').val() !=null) {
                data.nombrecaso = $('#nombrecaso').val();
            }

            waitMeShow();
            var idTable = 'case-consolidated-list-report';
            excecuteAjax('GET', getRoute('casoreporteconsolidado'), data, null, function (response)
            {
                if (response.success == true)
                {

                    var header = [{dataName: 'Cliente', dataIndex: 'nombrecliente'},
                        {dataName: 'Caso', dataIndex: 'nombre'},
                        {dataName: 'Tipo de caso', renderer: function (t) { return t['tipocaso'].nombre; }},
                        {dataName: 'Honorarios', dataIndex: 'honorarios'},
                        {dataName: 'Dinero pago', dataIndex: 'dineropagado'},
                        {dataName: 'Dinero por pagar', renderer: function (t) { return t['porpagar']; }},
                        {dataName: 'Abogado', renderer: function (t) { return t['responsable'].nombreinterfaz; }},
                        {dataName: 'Intermediario', renderer: function (t) { if (t['intermediario']&&t['intermediario'].nombreinterfaz) return t['intermediario'].nombreinterfaz; return '';}},
                        {dataName: 'Estado', renderer: function (t) { return t['estado'].nombre; }},
                        {dataName: 'Fecha de ingreso', dataIndex: 'fechaingreso'},
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
            });
        }
    });
}

var getCaseConsolidatedReportTableHeader = function ()
{
    return buildTableHeaderReport({tableTitle: "Listado de casos por clientes consolidado"});
}