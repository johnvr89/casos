/**
 * Created by rene on 3/03/17.
 */
var buildDataTable = function (idTable, header, data, actions) {
    /*header=[{dataIndex:property,dataName:header}]*/
    var content = '<div class="panel-body"> <div class="table-responsive"><table class="table table-striped table-bordered table-hover" id=' + '"' + idTable + '"' + '><thead><tr><th class="hide"></th>';
    header.forEach(function (t, number, array) {
        content += '<th >' + t.dataName + '</th>';
    });
    if (actions.length > 0) {
        content += '<th max-width:70px;> Acciones' + '</th>';
    }

    content += '</tr></thead>';
    content += '<tbody>';
    controller.cleanData();
    data.forEach(function (t, number, array) {
        content += '<tr><td class="hide"></td>';
        for (var i = 0; i < header.length; i++) {
            var td = '<td';
            if (header[i].style) {
                td += ' style=' + '"' + header[i].style + '">';
            } else {
                td += ">";
            }

            if (header[i].renderer) {
                content += td + header[i].renderer(t) + '</td>';
            } else {
                content += td + t[header[i].dataIndex] + '</td>';
            }
            controller.setData(t.id, t);
        }
        if (actions.length > 0) {
            content += '<td style="text-align:center; max-width:70px;"><div class="btn-group">\n\
<button data-toggle="dropdown" class="btn btn-warning btn-sm dropdown-toggle">\n\
<i class="fa fa-cog"></i> \n\
<span class="caret"></span></button><ul class="dropdown-menu pull-right">';
            actions.forEach(function (obj, pos, arrayActions) {
                var divider = "";
                if (pos > 0)
                {
                    divider += '<li class="divider"></li>';
                }

                switch (obj) {
                    case 'delete':
                        content += divider + ' <li><a data-record-id="' + t.id + '" href="#" data-toggle="modal" data-target="#confirm-delete"><i class="fa fa-trash"></i> Eliminar</a></li>';
                        break;
                    case 'update':
                        content += divider + ' <li><a  data-record-id="' + t.id + '" href="#" data-toggle="modal" data-target="#divUpdateModal"><i class="fa fa-edit"></i> Actualizar</a></li>';
                        break;
                    case 'update-trace':
                        if (t.cambio_estado != 1) {
                            content += divider + ' <li><a  data-record-id="' + t.id + '" href="#" data-toggle="modal" data-target="#divUpdateModal"><i class="fa fa-edit"></i> Actualizar</a></li>';
                        }
                        break;
                    case 'delete-trace':
                        if (t.cambio_estado != 1) {
                            content += divider + ' <li><a data-record-id="' + t.id + '" href="#" data-toggle="modal" data-target="#confirm-delete"><i class="fa fa-trash"></i> Eliminar</a></li>';
                        }
                        break;
                    case 'update-trace':
                        if (t.cambio_estado != 1) {
                            content += divider + ' <li><a  data-record-id="' + t.id + '" href="#" data-toggle="modal" data-target="#divUpdateModal"><i class="fa fa-edit"></i> Actualizar</a></li>';
                        }
                        break;
                    case 'document-trace':
                        if (t.documento) {
                            content += divider + ' <li><a onclick="downloadDocument(' + t.id + ')" href="#" ><i class="fa fa-file-o"></i> Visualizar documento</a></li>';
                        }
                        break;
                    case 'detail':
                        content += divider + ' <li><a' + ' data-record-id="' + t.id + '" href="#" data-toggle="modal" data-target="#detail"><i class="fa fa-eye"></i> Detalles</a></li>';
                        break;
                    case 'features':
                        content += divider + ' <li><a onclick="initFeature(' + t.id + ',\'' + t.nombre + '\')" href="#" ><i class="fa fa-list-ul"></i> Caracter&iacute;sticas</a></li>';
                        break;
                    case 'payment':
                        if (t.estado.id >= 2 && t.estado.id < 5) {
                            content += divider + ' <li><a onclick="initPaymentOfCase(' + t.id + ',\'' + t.nombre + '\',\'' + t.dineropagado + '\',\'' + t.honorarios + '\')" href="#" ><i class="fa fa-bar-chart-o"></i> Pagos</a></li>';
                        }
                        break;
                    case 'trace':
                        if (t.estado.id >= 2 && t.estado.id < 5) {
                            content += divider + ' <li><a onclick="initTraceOfCase(' + t.id + ',\'' + t.nombre + '\')" href="#" ><i class="fa fa-list-ul"></i> Seguimientos</a></li>';
                        }
                        break;
                        case 'autorized':
                        if (t.estado.id ==1) {
                            content += divider + ' <li><a onclick="autorizedCase(' + t.id +')" href="#" ><i class="fa fa-play"></i> Autorizar caso</a></li>';
                        }
                        break;
                    case 'action':
                        content += divider + ' <li><a' + ' onclick="initAction(' + t.id + ',\'' + t.nombre + '\')" href="#"><i class="fa fa-users"></i> Permisos</a></li>';
                        break;
                    case 'userroles':
                        content += divider + ' <li><a' + ' onclick="showRoleModalUser(' + t.id + ')" href="#"><i class="fa fa-user"></i> Roles</a></li>';
                        break;
                    case 'paymentpdf':
                        content += divider + ' <li><a' + ' onclick="exportPaymentPdf(' + t.id + ')" href="#"><i class="fa fa-file-o"></i> Documento PDF del pago</a></li>';
                        break;
                }
            });
            content += '</ul></div></td>';
        }
        content + '</tr>';
    });
    content += '</tbody></table></div></div>';
    return content;
};

var buildCombo = function (propertyId, propertyName, routeName, idComboInject, callback) {

    excecuteAjax('GET', getRoute(routeName), {}, null, function (response)
    {
        if (response.success == true)
        {
            var content = '';
            response.data.forEach(function (t, index, array) {
                content += ' <option value="' + t[propertyId] + '"' + '>' + t[propertyName] + '</option>';
            });
            if (content.length > 0) {
                $('#' + idComboInject).append(content);
            }
            if (callback) {
                callback();
            }



        }

    }, false, false);
};

var buildStaticCombo = function (propertyId, propertyName, data, idComboInject) {

    var content = '';
    data.forEach(function (t, index, array) {
        content += ' <option value="' + t[propertyId] + '"' + '>' + t[propertyName] + '</option>';
    });
    if (content.length > 0) {
        $('#' + idComboInject).append(content);
    }
};

var buildDetail = function (id, totalColumn, configColumns, idInject) {


    var obj = controller.getData(id);
    var content = '<div class="row">';
    var number = 0;
    var body = '';
    if (12 % totalColumn != 0) {
        number = Math.round((12 / totalColumn)) - 1;
    } else {
        number = (12 / totalColumn);
    }
    for (var i = 0; i < totalColumn; i++) {
        body += '<div class="col-md-' + number + '"' + '>';
        configColumns[i].forEach(function (t, index, array) {
            if (index > 0) {
                body += '<div style="height:10px;" class="col-md-12"></div>';
            }
            body += '<div class="form-group"> <span class="col-xs-12"><strong>' + t.dataName + '</strong></span>';
            if (t.renderer) {
                body += '<span class="col-xs-12">' + t.renderer(obj) + '</span></div>';
            } else {
                body += '<span class="col-xs-12">' + obj[t.dataIndex] + '</span></div>';
            }

        });
        body += '</div>';
    }
    body += '</div>';
    if (body.length > 0) {
        $('#' + idInject).append(content + body);
    }
};

var buildDetailsUpdate = function (id, idInject) {

    var obj = controller.getData(id).detalles;
    var body = '<div class="form-group">\n\
                    <span><strong>Detalles</strong></span>\n\
                </div>';
    obj.forEach(function (t, index, array) {
        body += '<div class="form-group"> <label>' + t.tipoCasoCaracteristica.nombre_campo + '</label><span class="required"> *</span>';
        body += buildInputValue(t.id, t.tipoCasoCaracteristica['tipo_campo'].id) + '</div>';
    });
    if (obj.length > 0) {
        $('#' + idInject).html(body);
        obj.forEach(function (t, index, array) {
            $('#' + idInject + ' ' + '[idfeature=' + t.id + ']').val(t.valor);
        });
    }
    $('#' + idInject + ' .datetimepicker-field').datetimepicker({
        locale: 'es',
       format: 'YYYY-MM-DD',
        showTodayButton: true,
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
};

var buildCasesDetails = function (id, routeName, idInject, details) {

    waitMeShow("wrapper");
    excecuteAjax('GET', getRoute(routeName), {tipoCaso: id}, null, function (response)
    {
        if (response.success == true)
        {
            var obj = response.data;
            var body = '<div class="form-group">\n\
                            <span><strong>Detalles</strong></span>\n\
                      </div>';
            obj.forEach(function (t, index, array) {
                body += '<div class="form-group"> <label>' + t.nombre_campo + '</label><span class="required"> *</span>';
                body += buildInputValue(t.id, t['tipo_campo'].id) + '</div>';
            });
            if (response.data.length > 0) {
                $('#' + idInject).html(body);

                if (details != undefined)
                {
                    details.forEach(function (t, index, array) {
                        $('#' + idInject + ' ' + '[idfeature=' + t.tipoCasoCaracteristica.id + ']').val(t.valor);
                        $('#' + idInject + ' ' + '[idfeature=' + t.tipoCasoCaracteristica.id + ']').attr("iddetail", t.id);
                    });
                }
            }
            else
            {
                $('#' + idInject).html("");
            }

            $('.datetimepicker-field').datetimepicker({
                locale: 'es',
                format: 'YYYY-MM-DD',
                showTodayButton: true,
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
        }
        waitMeHide("wrapper");
    },false,true);
};

var buildInputValue = function (name, type) {
    var value = '';
    switch (type) {
        case 1:
            value = '<div class="input-group"><input idfeature="' + name + '" type="number" class="form-control case-feature" name="integer[]"></div>\n\
<span style="color: rgb(185, 74, 72); display: none; margin-bottom: 10px; margin-top: 5px;" class="col-xs-12 error">Debe de insertar valor válidos</span>'
                    ;
            break;
        case 2:
            value = '<div class="input-group"><input idfeature="' + name + '" type="number" class="form-control case-feature" name="float[]"></div>\n\
       <span style="color: rgb(185, 74, 72); display: none; margin-bottom: 10px; margin-top: 5px;" class="col-xs-12 error">Debe de insertar valor válidos</span>';
            break;
        case 3:
            value = '<div class="input-group"><input idfeature="' + name + '" type="text" class="form-control case-feature" name="string[]"></div> \n\
<span style="color: rgb(185, 74, 72); display: none; margin-bottom: 10px; margin-top: 5px;" class="col-xs-12 error">Debe de insertar valor válidos</span>\n\
     ';
            break;
        case 4:
            value = '<div class="input-group col-xs-12"><textarea idfeature="' + name + '" class="form-control case-feature" name="string[]"></textarea></div>\n\
<span style="color: rgb(185, 74, 72); display: none; margin-bottom: 10px; margin-top: 5px;" class="col-xs-12 error">Debe de insertar valor válidos</span>\n\
     ';
            break;
        case 5:
            value = '<div class="input-group col-md-6 datetimepicker-field">'
                    + '<input idfeature="' + name + '" type="text" class="form-control case-feature" name="date[]" />'
                    + '<span class="input-group-addon" style="cursor: pointer"><i class="fa fa-calendar"></i></span></div>\n\
          <span style="color: rgb(185, 74, 72); display: none; margin-bottom: 10px; margin-top: 5px;" class="col-xs-12 error">Debe de insertar valor válidos</span>'
                    ;
            break;
        case 6:
            value = '<div class="input-group"><select idfeature="' + name + '" name="boolean[]" class="form-control case-feature">'
                    + '<option  value="1">Si</option>'
                    + '<option  value="0">No</option>'
                    + '</select></div>';
            break;
    }
    return value;
};

var buildTableHeader = function (headerInfo, modals)
{
    var header = '<div class="row">\n\
                        <div class="col-md-12">\n\
                            <div id="table_container" class="panel panel-primary hide">\n\
                                <div class="panel-heading row-heading row">\n\
                                    <div class="table-heading col-sm-8 col-md-9 col-xs-10">' + headerInfo.tableTitle + '</div>'
    if (headerInfo.addModalId) {
        header += '<div class="table-heading col-sm-4 col-md-3 col-xs-2"><ul class="nav pull-right">\n\
                                    <a href="" class="btn btn-default btn-xs" data-toggle="modal" data-target="#' + headerInfo.addModalId + '" title="' + headerInfo.addModalToolTip + '"><i class="fa fa-plus"> </i> <strong class="hidden-xs">' + headerInfo.addModalTitle + '</strong></a>\n\
                                    </ul></div>';
    }

    header += '</div><div id="table-data"> < /div>\n\
                </div>\n\
                </div>\n\
                </div>\n\
                <div id="modals-container">';

    modals.forEach(function (obj, pos, array)
    {
        switch (obj.modalType)
        {
            case 'add':
                header += '<div id="' + obj.containerId + '"></div>';
                break;
            case 'update':
                header += '<div id="' + obj.containerId + '"></div>';
                break;
            case 'detail':
                header += '<div id="' + obj.containerId + '"></div>';
                break;
            case 'remove':
                header += '<div id="' + obj.containerId + '"></div>';
                break;
            case 'userroles':
                header += '<div id="' + obj.containerId + '"></div>';
                break;
            case 'roleactions':
                header += '<div id="' + obj.containerId + '"></div>';
                break;
            default:
                header += '<div id="' + obj.containerId + '"></div>';
                break;
        }
    });

    return header + '</div>';
};

var buildTableHeaderReport = function (headerInfo)
{
    var header = '<div class="row">\n\
                        <div class="col-md-12">\n\
                            <div id="table_container" class="panel panel-primary hide">\n\
                                <div class="panel-heading row-heading row">\n\
                                    <div class="table-heading col-sm-8 col-md-9 col-xs-10">' + headerInfo.tableTitle + '</div>\n\
                                </div>\n\
                                <div id="form-content-report" class="col-md-12"></div>\n\
                                <div id="table-data"> </div>\n\
                            </div>\n\
                        </div>\n\
                    </div>';
    return header;
};