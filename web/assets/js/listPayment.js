/**
 * Created by rene on 4/03/17.
 */
var initPaymentList = function ( type )
{
    $('#page-body').html(getPaymentTableHeader(type));
    buildListPayment(type);
    detailModalPayment(type);
};

var buildListPayment = function (type) {
    var idTable = 'payment-list';
    waitMeShow();
    excecuteAjax('GET', getRoute( type == true ? 'pagoslist' : 'pagosatrazadoslist'), {}, null, function (response)
    {
        if (response.success == true)
        {

            var header = [ { dataName: 'Caso',renderer:function(t){return t['caso'].nombre; }},
                           {dataIndex: 'valor_pagado',dataName: 'Valor pagado'},
                           {dataName: 'Forma de pago', renderer: function (data) { return data['forma_pago'].nombre; }},
                           {dataName: 'Tipo de cobro', renderer: function (data) { return data['tipo_cobro'].nombre; }},
                           {dataIndex: 'fecha_proximo_cobro',dataName: 'Fecha de pr&oacute;ximo cobro'}
            ];
            var htmlTable = buildDataTable(idTable, header, response.data, ['detail']);
            $('#table-data').html(htmlTable);
            $('#table_container').removeClass("hide");
            $('#' + idTable).dataTable();
            waitMeHide();
            
        }
    },false,true);
};

var getPaymentTableHeader = function (type)
{
    return buildTableHeader({tableTitle: ( type ==true ? "Pagos realizados" : "Pagos atrasados") }, [{modalType:"detail",containerId:"detailModalPayment"}]);
};

var detailModalPayment = function (type) {
   
     $('#detailModalPayment').load("assets/pages/detail.html",{},function(){
           $('#detailModalPayment #myModalLabel').html( type== true ? 'Detalles de pagos realizados' : 'Detalles de pagos atrasados');
    });

    $('#detailModalPayment').on('show.bs.modal', function (e) {
        var data = $(e.relatedTarget).data().recordId;
        var configDetail=[[{ dataName: 'Caso',renderer:function(t){return t['caso'].nombre;}},
                           {dataIndex: 'valor_pagado',dataName: 'Valor pagado'},
                           {dataName: 'Cuenta', renderer: function (data) {return data['cuenta'].numero; }}],
                           [{dataName: 'Forma de pago', renderer: function (data) { return data['forma_pago'].nombre; }},
                           {dataName: 'Tipo de cobro', renderer: function (data) { return data['tipo_cobro'].nombre; }},
                           {dataIndex: 'fecha_proximo_cobro',dataName: 'Fecha de pr&oacute;ximo cobro'}]];
        $('#detailContent').html('');
        buildDetail(data,2,configDetail,'detailContent');
    });
};