/**
 * Created by rene on 4/03/17.
 */
var initCaseReport = function () {
    $('#page-body').html(getCaseReportTableHeader());
    buildListCaseReport();

};

var buildListCaseReport = function () {

    var idTable = 'case-list-report';
    waitMeShow();
    excecuteAjax('GET', getRoute('casolist'), {}, null, function (response)
    {
        if (response.success == true)
        {

            var header = [{dataName: 'Nombre', dataIndex: 'nombre'},
                {dataName: 'Cliente', renderer: function (t) {
                        return t['empresa'].nombre;
                    }},
                {dataName: 'Intermediario', renderer: function (t) {
                        if (t['intermediario']&&t['intermediario'].nombreinterfaz) {
                            return t['intermediario'].nombreinterfaz;
                        }
                        return "";

                    }},
                {dataName: 'Honorario', renderer: function (t) {
                        return t['honorarios']
                    }}, {dataName: 'Dinero pago', dataIndex: 'dineropagado'},
                {dataName: 'Dinero por pagar', renderer: function (t) {
                        return t['honorarios']-t['dineropagado'];
                    }},
                {dataName: 'Estado', renderer: function (t) {
                        return t['estado'].nombre;
                    }}];

            var htmlTable = buildDataTable(idTable, header, response.data, []);
            $('#table-data').html(htmlTable);
            $('#table_container').removeClass("hide");
            var table = $('#' + idTable).DataTable({
                lengthChange: false,
                buttons: [ 'excel','pdf']
            });
            table.buttons().container().appendTo( '#' + idTable + '_wrapper .col-sm-6:eq(0)' );
            waitMeHide();
            
        }
    },false,true);
};

var getCaseReportTableHeader = function ()
{
    return buildTableHeaderReport({tableTitle: "Listado de casos"});
}