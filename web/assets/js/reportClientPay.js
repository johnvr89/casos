/**
 * Created by rene on 4/03/17.
 */
var initReportClient = function () {
    $('#page-body').html(getClientReportTableHeader());

    buildListClientReport();

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

var buildListClientReport = function () {

    waitMeShow();
    $('#page-body #form-content-report').load("assets/pages/formHeaderReportClient.html", {}, function ()
    {
        waitMeHide();
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
        }) .on('dp.change', dateChanged);

        reportClientValidationEngine('search-report');
        $('#table_container').removeClass("hide");
        $("#search-report input[name=inicio]").on('change', function () {

        })
        executeFilterClientPay();
        $('#fecha-inicial').on('dp.change', function (e) {
            var formatedValue = e.date.format(e.date._f);
        })
    });

};
var executeFilterClientPay = function () {
    $("#search-report").on("submit", function (e)
    {
        e.preventDefault();
        if ($("#search-report").valid())
        {
            var data = {inicio: $("#search-report input[name=inicio]").val(),
                fin: $("#search-report input[name=fin]").val()};

            waitMeShow();
            var idTable = 'client-list-report';
            excecuteAjax('GET', getRoute('clientereport'), data, null, function (response)
            {
                if (response.success == true)
                {

                    var header = [{dataName: 'Nombre del cliente', dataIndex: 'nombre'},
                        {dataName: 'Nombre del caso', dataIndex: 'nombre_caso'},
                        {dataName: 'Fecha del pr&oacute;ximo pago', dataIndex: 'fecha_proximo_pago'},
                        {dataName: 'Honorario', renderer: function (t) {
                                return t['honorario']
                            }}, {dataName: 'Dinero pago', dataIndex: 'dinero_pago'},
                        {dataName: 'Dinero por pagar', renderer: function (t) {
                                return t['por_pagar'];
                            }}
                    ];

                    var htmlTable = buildDataTable(idTable, header, response.data, []);
                    $('#table-data').html(htmlTable);
                    var table = $('#' + idTable).DataTable({
                        lengthChange: false,
                        buttons: [ 'excel','pdf']
                    });
                    table.buttons().container().appendTo( '#' + idTable + '_wrapper .col-sm-6:eq(0)' );
                    waitMeHide();
                    }
            },false,true);
        }
    });
}

var getClientReportTableHeader = function ()
{
    return buildTableHeaderReport({tableTitle: "Listado de clientes con deudas"});
}