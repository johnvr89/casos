/**
 * Created by rene on 4/03/17.
 */
var initClient = function ()
{
    $('#page-body').html(getClientTableHeader());
    buildListClient();
    detailModalClient();
};

var buildListClient = function () {

    var idTable = 'cliente-list';
    waitMeShow();
    excecuteAjax('GET', getRoute('clientelist'), {}, null, function (response)
    {
        if (response.success == true)
        {
            var header = [{dataIndex: 'nombre', dataName: 'Nombre'},
                {dataName: 'Tipo', renderer: function (data) { return data['tipo_cliente'].nombre;}},
                {dataIndex: 'correo', dataName: 'Correo'}, {dataIndex: 'telefono', dataName: 'Tel&eacute;fono'},
                {dataName: 'Ciudad', renderer: function (data) {return data['ciudad'].nombre; }},
                {dataIndex: 'cantidad_casos', dataName: 'Casos'}
            ];
            
            var htmlTable = buildDataTable(idTable, header, response.data, ['detail']);
            $('#table-data').html(htmlTable);
            $('#table_container').removeClass("hide");
            $('#' + idTable).dataTable();
            waitMeHide();
        }
    },false, true);
};

var getClientTableHeader = function ()
{
    return buildTableHeader({tableTitle: "Clientes con casos"},[{modalType: "detail", containerId: "detailModalClient"}]);
};

var detailModalClient = function () {
    $('#detailModalClient').load("assets/pages/detail.html", {}, function () {

        $('#detailModalClient #myModalLabel').html('Detalles de cliente');
    });


    $('#detailModalClient').on('show.bs.modal', function (e) {
        var data = $(e.relatedTarget).data().recordId;
        var model = controller.getData(data);
        var configDetail = [[{dataName: 'Logo', renderer: function (data) { var logo = ( data["logo"] != "" ? data["logo"] :'usuario-logo.png');
                                return '<img src="'+ serviceaddress + '/bundles/app/images/' + logo + '" height="60px" width="60px" style="margin-top: 5px;"/>'; }},
                            {dataIndex: 'nombre', dataName: 'Nombre'},{dataIndex: 'direccion', dataName: 'Direcci&oacute;n'},
                            {dataName: 'Tipo', renderer: function (data) { return data['tipo_cliente'].nombre; }},{dataName: 'Ciudad', renderer: function (data) { return data['ciudad'].nombre; }}],
                            [{dataIndex: 'descripcion', dataName: 'Descripci&oacute;n'}],
                            [{dataIndex: 'correo', dataName: 'Correo'},{dataIndex: 'telefono', dataName: 'Tel&eacute;fono'},
                            {dataIndex: 'tipo_identificacion', dataName: 'Tipo de identificaci&oacute;n'},{dataIndex: 'numero_identificacion', dataName: 'N&uacute;mero de identificaci&oacute;n'},
                            {dataIndex: 'clave_sri', dataName: 'Clave SRI'}]];
        
        if (model.tipo_cliente.nombre != "Cliente" )
        {
            configDetail[0].push({dataName: 'Representante', renderer: function (data){ return ( data['representante'] != undefined  && data['representante'] != "")? data['representante'] : "No especificado";}});
            configDetail[1].push({dataIndex: 'razon_social', dataName: 'Raz&oacute;n social', renderer: function(data){
                    return ( data["razon_social"] != undefined && data["razon_social"] != "" )? data["razon_social"] : "No especificada";
            }});
        }   
        
        $('#detailModalClient #detailContent').html('');
        buildDetail(data, 3, configDetail, 'detailContent');
    });
};