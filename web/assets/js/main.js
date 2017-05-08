$.ajaxSetup({
    headers: {
        apiKey: sessionStorage.auth_token}
});

var waitMeShow = function (placement)
{
    $('#page-wrapper').attr("waitMe","on");
    $(placement == undefined ? '#page-wrapper' : '#' + placement).waitMe({
        effect: 'roundBounce',
        text: 'Por favor espere...',
        bg: 'rgba(255,255,255,0.7)',
        color: '#000',
        sizeW: '',
        sizeH: '',
        source: '',
        onClose: function () {
            $('#page-wrapper').attr("waitMe","off");
        }
    });
};

var waitMeHide = function (placement)
{
    $(placement == undefined ? '#page-wrapper' : '#' + placement).waitMe("hide");
};

var waitMeStatus = function()
{
    return $('#page-wrapper').attr("waitMe") == "on";
};

var excecuteAjax = function (method, url, data, onerror, onsuccess, uploadFile, hideMaskOnFail)
{
    var config = {
        type: method,
        dataType: 'json',
        contentType: "application/json",
        url: url,
        data: method != "GET" ? JSON.stringify(data) : data,
        error: function (response)
        {
            if (onerror != null)
            {
                onerror(response);
            } else
            {
                if ( hideMaskOnFail ==true )
                {
                    waitMeHide();
                }
                alertify.error("La solicitud no pudo ser procesada");
            }
        },
        success: function (response)
        {
            if (response.success == false)
            {
                
                if ( hideMaskOnFail == true )
                {
                   
                    waitMeHide();
                    waitMeHide("wrapper");
                }
                
                if (response.code == 3000)
                {
                    if($('.ajs-error').length > 0){
                        $('.ajs-error').css('display', 'none');
                    }
                    alertify.error("La sessión ha expirado");
                    setInterval(function ()
                    {
                        sessionStorage.removeItem("auth_token");
                        location.href = "/login.html";
                    }, 3000);
                } else
                {
                    alertify.error(response.error);
                }
            }

            if (onsuccess != null)
            {
                onsuccess(response);
            }
        }
    }
    if (uploadFile===true) {
        config.data = data;
        config.processData = false;
        config.contentType = false;
    }
    $.ajax(config);
};

var activeMenu = function (idmenu)
{
    $(".main-menu").removeClass("active-menu");
    $("#" + idmenu).addClass("active-menu");
    if ($("#" + idmenu).hasClass("payment-item"))
    {
        $("#payment-menu").addClass("active-menu");
    }
    else if ( $("#" + idmenu).hasClass("admin-item") )
    {
        $("#admin-menu").addClass("active-menu");
    }
    else if ( $("#" + idmenu).hasClass("report-item") )
    {
        $("#report-menu").addClass("active-menu");
    }
    else if ( $("#" + idmenu).hasClass("menu-client-item") )
    {
        $("#menu-client").addClass("active-menu");
    }

};

$(document).ready(function()
{
    waitMeShow("body-container");
    excecuteAjax("GET",getRoute("usuarioinfo"),{},null,function(response){
        if ( response.success == true )
        {
            var user = response.data;
            $("span#username-info").html("Usuario: " + user.username);
            
            if ( user.empresa.logo != "" && user.empresa.logo != undefined)
            {
                $("#company-logo").attr('src', serviceaddress + '/bundles/app/images/' + user.empresa.logo);
            }
            
            $("span.name-company-info h3").html(' ' + user.nombreinterfaz);
            $("span.name-company-info span").html('<i class="fa fa-home"></i> ' + user.empresa.nombre );
            $("#company-info-email").html('<strong>Correo:</strong> ' + user.empresa.correo );
            $("#company-info-phone").html('<strong>Telefono:</strong> ' + user.empresa.telefono );
            $("#company-info-city-name").html('<strong>Ciudad:</strong> ' + user.empresa.ciudad.nombre );
            
            userPermission = user.permission;
            //=============================== Menú Inicio ===================================/
            $('#main-menu').append('<li><a id="menu-home" class="main-menu active-menu cursor-pointer"><i class="fa fa-home fa-3x"></i> Inicio</a></li>');
            $("#menu-home").on("click", function () { 
                if ( !waitMeStatus() ) {  buildHomePage(); activeMenu("menu-home"); }
            });
            
            //=============================== Menú Botón cerrar sesion ===================================/
            $("#btn-logout").on("click", function ()
            {
                waitMeShow("wrapper");
                excecuteAjax( 'POST', getRoute("logout"), {}, function (response) { alertify.error(response.error); }, function (response) {
                    if (response.success == true)
                    {
                        sessionStorage.removeItem("auth_token");
                        location.href = "/login.html";
                        waitMeHide("wrapper");
                    }
                }, false, true);
            });
            
            
            
          
            
            
            //=============================== Menú Casos ===================================/
            if ( userPermission.AGCaso.listAllCase || userPermission.AGCaso.listMyCase || userPermission.AGCaso.listIntermediaryCase )
            {
                $('#main-menu').append('<li><a id="menu-case" class="main-menu cursor-pointer"><i class="fa fa-edit fa-3x"></i> Casos</a><li>');
                $("#menu-case").on("click", function ()
                {
                    if ( !waitMeStatus() ) { initCase(); activeMenu("menu-case"); }
                });
            }
            
            //=============================== Menú Clientes ===================================/
            var clientItems = $('<li><a id="menu-client" href="#" class="main-menu"><i class="fa fa-user fa-3x"></i> Clientes<span class="fa arrow"></span></a>\n\
                                    <ul style="height: auto;" class="nav nav-second-level collapse"></ul>\n\
                                <li>');
            
           if (  userPermission.AGEmpresa.getCompanyClient)
            {
                $(clientItems).children("ul").append('</li><li><a id="menu-management-client" class="main-menu menu-client-item cursor-pointer"> Gesti&oacute;n de clientes</a></li>');
                $(clientItems).find("#menu-management-client").on("click", function ()
                {
                   if ( !waitMeStatus() ) { initClientManagement();  activeMenu("menu-management-client"); }
                });
                $(clientItems).addClass("has-items");
            }
            
            
            if (  userPermission.AGEmpresa.getAllCompanyWithCase  )
            {
                $(clientItems).children("ul").append('<li><a id="menu-client-case" class="main-menu menu-client-item cursor-pointer">Clientes con casos</a>');
                $(clientItems).find("#menu-client-case").on("click", function ()
                {
                    if ( !waitMeStatus() ) {  initClient(); activeMenu("menu-client-case"); }
                });
             
            }
            if ( $(clientItems).hasClass("has-items") )
            {
                $('#main-menu').append(clientItems);
            }
           
           
            //=============================== Fin de Clientes ===================================/
            
            
            //=============================== Menú Seguimientos ===================================/
            if ( userPermission.AGSeguimiento.listAllTrace || userPermission.AGSeguimiento.listMyCaseTrace )
            {
                $('#main-menu').append('<li><a id="menu-trace" class="main-menu cursor-pointer"><i class="fa fa-qrcode fa-3x"></i> Seguimientos</a></li>');
                $("#menu-trace").on("click", function ()
                {
                    if ( !waitMeStatus() ) { initTraceList(); activeMenu("menu-trace"); }
                });
            }
            
            //=============================== Menú Pagos ===================================/
            var paymentItems = $('<li><a id="payment-menu" href="#" class="main-menu"><i class="fa fa-bar-chart-o fa-3x"></i> Pagos<span class="fa arrow"></span></a>\n\
                                    <ul style="height: auto;" class="nav nav-second-level collapse"></ul>\n\
                                <li>');
            
            //------------------------------- Menú Pagos Realizados ------------------------------------/
            if ( userPermission.AGPagoRealizado.listAllPayment || userPermission.AGPagoRealizado.listMyCasePayment )
            {
                $(paymentItems).children("ul").append('<li><a id="menu-payment" class="main-menu payment-item cursor-pointer"> Pagos realizados</a>');
                $(paymentItems).find("#menu-payment").on("click", function ()
                {
                    if ( !waitMeStatus() ) { initPaymentList(true); activeMenu("menu-payment"); }
                });
                $(paymentItems).addClass("has-items");
            }
            
            //------------------------------- Menú Pagos Atrazados ------------------------------------/
            if ( userPermission.AGPagoRealizado.listAllPaymentOutDate || userPermission.AGPagoRealizado.listMyCasePaymentOutDate )
            {
                $(paymentItems).children("ul").append('</li><li><a id="menu-payment-not-payment" class="main-menu payment-item cursor-pointer"> Pagos atrasados</a></li>');
                $(paymentItems).find("#menu-payment-not-payment").on("click", function ()
                {
                    if ( !waitMeStatus() ) { initPaymentList(false); activeMenu("menu-payment-not-payment"); }
                });
                $(paymentItems).addClass("has-items");
            }
            
            if ( $(paymentItems).hasClass("has-items") )
            {
                $('#main-menu').append(paymentItems);
            }
            //=============================== Fin de Pagos ===================================/
            
            //=============================== Menú Reportes ===================================/
            if ( userPermission.AGCaso.listAllCase || userPermission.AGCaso.listMyCase || userPermission.AGCaso.listIntermediaryCase )
            {
                $('#main-menu').append('<li><a id="report-menu" href="#" class="main-menu"><i class="fa fa-calendar fa-3x"></i> Reportes<span class="fa arrow"></span></a>\n\
                                            <ul style="height: auto;" class="nav nav-second-level collapse">\n\
                                                <li><a id="menu-case-report" class="main-menu report-item cursor-pointer"> Listado de casos</a></li>\n\
                                                <li><a id="menu-client-report" class="main-menu report-item cursor-pointer"> Listado de clientes con deudas</a></li>\n\
                                                <li><a id="menu-case-report-consolidate" class="main-menu report-item cursor-pointer"> Listado de casos consolidado</a></li>\n\
                                                <li><a id="menu-client-case-report-consolidate" class="main-menu report-item cursor-pointer"> Listado de clientes consolidado</a></li>\n\
                                            </ul>\n\
                                        </li>');
                
                $("#menu-case-report").on("click", function ()
                {
                    if ( !waitMeStatus() ) { initCaseReport(); activeMenu("menu-case-report"); }
                });

                $("#menu-client-report").on("click", function ()
                {
                    if ( !waitMeStatus() ) { initReportClient(); activeMenu("menu-client-report"); }
                });
                $("#menu-case-report-consolidate").on("click", function ()
                {
                    if ( !waitMeStatus() ) { initReportConsolidatedCase(); activeMenu("menu-case-report-consolidate"); }
                });
                $("#menu-client-case-report-consolidate").on("click", function ()
                {
                    if ( !waitMeStatus() ) { initReportConsolidatedClientCase(); activeMenu("menu-client-case-report-consolidate"); }
                });
            }
            
            //=============================== Menú Administración ===================================/
            var adminItems = $('<li><a id="admin-menu" href="#" class="main-menu"><i class="fa fa-cog fa-3x"></i> Administraci&oacute;n<span class="fa arrow"></span></a>\n\
                                    <ul style="height: auto;" class="nav nav-second-level collapse"></ul>\n\
                                </li>');
            
            //------------------------------- Menú Empresas ------------------------------------/
            if ( userPermission.AGEmpresa.getAll )
            {
                $(adminItems).children("ul").append('<li><a id="menu-company" class="main-menu admin-item cursor-pointer"> Empresas</a></li>');
                $(adminItems).find("#menu-company").on("click", function ()
                {
                    if ( !waitMeStatus() ) {  initCompany();  activeMenu("menu-company"); }
                });
                $(adminItems).addClass("has-items");
            }
            
            //------------------------------- Menú Cuentas ------------------------------------/
            if ( userPermission.AGCuenta.getAll )
            {
                $(adminItems).children("ul").append('<li><a id="menu-account" class="main-menu admin-item cursor-pointer"> Cuentas</a></li>');
                $(adminItems).find("#menu-account").on("click", function ()
                {
                    if ( !waitMeStatus() ) { initAccounts(); activeMenu("menu-account"); }
                });
                $(adminItems).addClass("has-items");
            }
            
            //------------------------------- Menú Tipos de Caso ------------------------------------/
            if ( userPermission.AGTipoCaso.getAll )
            {
                $(adminItems).children("ul").append('<li><a id="menu-case-type" class="main-menu admin-item cursor-pointer"> Tipos de Casos</a></li>');
                $(adminItems).find("#menu-case-type").on("click", function ()
                {
                    if ( !waitMeStatus() ) { initCaseType(); activeMenu("menu-case-type"); }
                });
                $(adminItems).addClass("has-items");
            }
            
            //------------------------------- Menú Usuarios ------------------------------------/
            if ( userPermission.AGUsuario.getAll )
            {
                $(adminItems).children("ul").append('<li><a id="menu-user" class="main-menu admin-item cursor-pointer"> Usuarios</a></li>');
                $(adminItems).find("#menu-user").on("click", function ()
                {
                    if ( !waitMeStatus() ) { initUser(); activeMenu("menu-user"); }
                });
                $(adminItems).addClass("has-items");
            }
            
            //------------------------------- Menú Roles ------------------------------------/
            if ( userPermission.AGRol.getAll )
            {
                $(adminItems).children("ul").append('<li><a id="menu-rol" class="main-menu admin-item cursor-pointer"> Roles</a></li>');
                $(adminItems).find("#menu-rol").on("click", function ()
                {
                    if ( !waitMeStatus() ) {  initRole(); activeMenu("menu-rol"); }
                });
                $(adminItems).addClass("has-items");
            }
            
            //------------------------------- Menú Permisos ------------------------------------/
            if ( userPermission.AGAccion.getAll )
            {
                $(adminItems).children("ul").append('<li><a id="menu-permission"  class="main-menu admin-item cursor-pointer"> Permisos</a></li>');
                $(adminItems).find("#menu-permission").on("click", function ()
                {
                    if ( !waitMeStatus() ) { initAction(); activeMenu("menu-permission"); }
                });
                $(adminItems).addClass("has-items");
            }
            
            if ( $(adminItems).hasClass("has-items") )
            {
                $('#main-menu').append(adminItems);
            }
            
            
            //=============================== Fin Menú Administración ===================================/
            waitMeHide("body-container");
            $("#wrapper").removeClass("hide");
            buildHomePage();
            initMentisMenu();
            
        }
    });
});

var initMentisMenu = function()
{
    $('#main-menu').metisMenu();
    
    $(window).bind("load resize", function () {
        if ($(this).width() < 768) {
            $('div.sidebar-collapse').addClass('collapse')
        } else {
            $('div.sidebar-collapse').removeClass('collapse')
        }
    });
};

