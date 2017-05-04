/**
 * Created by rene on 4/03/17.
 */
var initTraceList = function()
{
    $('#page-body').html(getTraceTableHeader());
    buildListTrace();
    detailModalTrace();
};

var buildListTrace = function () {
    var idTable = 'trace-list';
    waitMeShow();
    excecuteAjax('GET', getRoute('seguimientolist'), {}, null, function (response)
    {
        if (response.success == true)
        {

            var header = [ { dataName: 'Caso',renderer:function(t){return t['caso'].nombre}},
                {dataIndex: 'nombre',dataName: 'Nombre'},{dataIndex: 'descripcion', dataName: 'Descripci&oacute;n'},
                { dataName: 'Responsable',renderer:function(t){return t['responsable_seguimiento'].nombreinterfaz;}}];

            var htmlTable = buildDataTable(idTable, header, response.data, ['detail', 'document-trace']);
            $('#table-data').html(htmlTable);
            $('#table_container').removeClass("hide");
            $('#' + idTable).dataTable();
            waitMeHide();
        }
    });
};

var getTraceTableHeader = function ()
{
    return buildTableHeader({tableTitle: "Seguimientos"},[{modalType: "detail", containerId: "detailModalTrace"}]);
};

var detailModalTrace = function () {
   
     $('#detailModalTrace').load("assets/pages/detail.html",{},function(){
           $('#detailModalTrace #myModalLabel').html('Detalles de seguimientos realizados');
    });


    $('#detailModalTrace').on('show.bs.modal', function (e) {
        var data = $(e.relatedTarget).data().recordId;
        var configDetail=[[ { dataName: 'Caso',renderer:function(t){return t['caso'].nombre}},
                {dataIndex: 'nombre',dataName: 'Nombre'},
               { dataName: 'Responsable',renderer:function(t){return t['responsable_seguimiento'].nombreinterfaz}},
               { dataName: 'Cambio de estado',renderer:function(t){return t['cambio_estado']=="1"?'Si':'No'}}
               ],[ {dataName:'Descripci&oacute;n',dataIndex:'descripcion'},{dataName:'Observaci&oacute;n',dataIndex:'observacion'}]];
        $('#detailContent').html();
     buildDetail(data,2,configDetail,'detailContent');
      
    });
}