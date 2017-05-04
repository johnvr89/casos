/*
 * *
 * Created by rene on 4/03/17.
 */
var buildHomePage = function () {
    waitMeShow();
    sessionStorage.logoData = serviceaddress + '/bundles/app/images/usuario-logo.png';
    $('#logo-user').attr('src', sessionStorage.logoData);
    excecuteAjax('GET', getRoute('homepage'), {}, null, function (response)
    {
        if (response.success == true)
        {
            var header = updateHeaderInfo(response.data.totalClient, response.data.totalCase, response.data.totalUser);
            var lastCases = updateLastCasesInfo(response.data.lastCase);
            var pendingPayment = updateCasePendingOfPaymentInfo(response.data.pendingByPayment);
            waitMeHide();
            $('#page-body').html(header + lastCases + pendingPayment);
            updateLogo(response.data.logo)
            dashboardEvents();

        }
    });
};
var updateLogo = function (url) {
    if (url) {
        $('#system-logo').attr('src', serviceaddress + url);
        $('#company-logo').attr('src', serviceaddress + url);
    }
}

var updateHeaderInfo = function (toalClients, totalCases, totalUsers)
{
    var headerInfo = '<div class="row">\n\
                            <div class="col-md-4 col-sm-6 col-xs-12 homepage-dashboard">\n\
                                <a id="dashboard-client" class="cursor-pointer"><div class="panel panel-back noti-box">\n\
                                    <span class="icon-box bg-color-red set-icon">\n\
                                        <i class="fa fa-group"></i>\n\
                                    </span>\n\
                                    <div class="text-box">\n\
                                        <p class="main-text">' + toalClients + '</p>\n\
                                        <p class="text-rocket"> Cliente' + (toalClients != 1 ? 's' : '') + '</p>\n\
                                    </div>\n\
                                </div></a>\n\
                            </div>\n\
                            <div class="col-md-4 col-sm-6 col-xs-12 homepage-dashboard">\n\
                                <a id="dashboard-case" class="cursor-pointer"><div class="panel panel-back noti-box">\n\
                                    <span class="icon-box bg-color-green set-icon">\n\
                                        <i class="fa fa-edit"></i>\n\
                                    </span>\n\
                                    <div class="text-box">\n\
                                        <p class="main-text"> ' + totalCases + '</p>\n\
                                        <p class="text-rocket"> Caso' + (totalCases != 1 ? 's' : '') + '</p>\n\
                                    </div>\n\
                                </div></a>\n\
                            </div>\n\
                            <div class="col-md-4 col-sm-6 col-xs-12 homepage-dashboard">\n\
                                <a id="dashboard-user" class="cursor-pointer"><div class="panel panel-back noti-box">\n\
                                    <span class="icon-box bg-color-brown set-icon">\n\
                                        <i class="fa fa-user"></i>\n\
                                    </span>\n\
                                    <div class="text-box">\n\
                                        <p class="main-text"> ' + totalUsers + '</p>\n\
                                        <p class=""> Usuario' + (totalUsers != 1 ? 's' : '') + '</p>\n\
                                    </div>\n\
                                </div></a>\n\
                            </div>\n\
                    </div>';

    return headerInfo;
};

var updateCasePendingOfPaymentInfo = function (lastCases)
{
    var tableBody = '<tbody>';
    lastCases.forEach(function (t, number, array) {
        tableBody += '<tr>\n\
                        <td class="hide"></td>\n\
                        <td>' + t.nombre_caso + '</td>\n\
                        <td>' + t.monto + '</td>\n\
                        <td>' + t.fecha_proximo_pago + '</td>\n\
                      </tr>';
    });
    if (tableBody == '<tbody>')
    {
        tableBody += '<tr><td colspan=3>No hay casos por cobrar</td></tr>';
    }
    tableBody += '</tbody>';

    var lastCasesHeader = '<div class="col-md-6 col-sm-12 col-xs-12">\n\
                                <div class="panel panel-primary">\n\
                                    <div class="panel-heading">Casos Pendientes de Cobro</div>\n\
                                        <div class="panel-body">\n\
                                            <div class="table-responsive">\n\
                                                <table class="table table-striped">\n\
                                                    <thead>\n\
                                                        <tr>\n\
                                                            <th class="hide">\n\
                                                            </th><th>NOMBRE</th>\n\
                                                            <th>MONTO</th>\n\
                                                            <th>FECHA</th>\n\
                                                        </tr>\n\
                                                    </thead>' + tableBody + '\
                                                </table>\n\
                                            </div>\n\
                                        </div>\n\
                                    </div>\n\
                                </div>\n\
                            </div>';

    return lastCasesHeader;
}

var updateLastCasesInfo = function (lastCases)
{
    var tableBody = '<tbody>';
    lastCases.forEach(function (t, number, array) {
        tableBody += '<tr>\n\
                        <td class="hide"></td>\n\
                        <td>' + t.nombre + '</td>\n\
                        <td>' + t.tipocaso.nombre + '</td>\n\
                      </tr>';
    });
    if (tableBody == '<tbody>')
    {
        tableBody += '<tr><td colspan=3>No hay casos para mostrar</td></tr>';
    }
    tableBody += '</tbody>';

    var lastCasesHeader = '<div class="col-md-6 col-sm-12 col-xs-12">\n\
                                <div class="panel panel-primary">\n\
                                    <div class="panel-heading">&Uacute;ltimos Casos Registrados</div>\n\
                                        <div class="panel-body">\n\
                                            <div class="table-responsive">\n\
                                                <table class="table table-striped">\n\
                                                    <thead>\n\
                                                        <tr>\n\
                                                            <th class="hide">\n\
                                                            </th><th>NOMBRE</th>\n\
                                                            <th>TIPO DE CASO</th>\n\
                                                        </tr>\n\
                                                    </thead>' + tableBody + '\
                                                </table>\n\
                                            </div>\n\
                                        </div>\n\
                                    </div>\n\
                                </div>\n\
                            </div>';

    return lastCasesHeader;
}

var dashboardEvents = function ()
{
    if (userPermission.AGEmpresa.getCompanyClient)
    {
        $("#dashboard-client").on("click", function ()
        {
            initClientManagement();
            activeMenu("menu-client");
        });
    }

    if (userPermission.AGUsuario.getAll)
    {
        $("#dashboard-user").on("click", function ()
        {
            initUser();
            activeMenu("menu-user");
            $("a#admin-menu").parent('li').toggleClass('active').children('ul').collapse('toggle');
        });
    }

    if (userPermission.AGCaso.listAllCase || userPermission.AGCaso.listMyCase || userPermission.AGCaso.listIntermediaryCase)
    {
        $("#dashboard-case").on("click", function ()
        {
            initCase();
            activeMenu("menu-case");
        });
    }
};