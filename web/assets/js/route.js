/**
 /**
 * Created by rene on 4/03/17.
 */
var getRoute = function (name) {
    var systemRoute = {
        empresalist: '/api/empresa',
        empresalistrectora: '/api/empresa/rectora',
        empresaclients: '/api/empresa/todosclientes',
        empresasave: '/api/empresa',
        empresaedit: '/api/empresa/editar',
        empresadelete: '/api/empresa/eliminar',
        clientelist:'/api/empresa/clientes',
        clientecasoreporteconsolidado:'/api/empresa/consolidado', 
        logout: '/api/session',
        ciudadlist: '/api/ciudad',
        tipoclientelist: '/api/tipocliente',
        tipoclienteempresarectoralist: '/api/tipocliente/empresarectora',
        tipoclienteempresaclientelist: '/api/tipocliente/empresacliente',
        cuentalist: '/api/cuenta',
        cuentaedit: '/api/cuenta/editar',
        cuentadelete: '/api/cuenta/eliminar',
        bancolist: '/api/banco',
        tipocasolist: '/api/tipocaso',
        tipocasoedit: '/api/tipocaso/editar',
        tipocasodelete: '/api/tipocaso/eliminar',
        caracteristicalist: '/api/caracteristica',
        caracteristicaedit: '/api/caracteristica/editar',
        caracteristicadelete: '/api/caracteristica/eliminar',
        tipodatolist: '/api/tipodato',
        usuarioslist: '/api/usuario',
        usuarioslistall: '/api/usuario/listar',
        usuariosedit: '/api/usuario/editar',
        usuariosdelete: '/api/usuario/eliminar',
        usuariosallroles: '/api/usuario/roles',
        usuariosupdaterole: '/api/usuario/rolasignacion',
        usuariopermission: '/api/usuario/permisos',
        usuariointermediarios: '/api/usuario/intermediario',
        usuarioabogado: '/api/usuario/abogado',
        usuarioinfo: '/api/usuario/token',
        rollist: '/api/rol',
        rolledit: '/api/rol/editar',
        rolpermission: '/api/rol/permisos',
        rolupdatepermission: '/api/rol/permisoasignacion',
        actionlist: '/api/acciones',
        actionadd: '/api/acciones/post',
        casolist: '/api/caso',
        casoedit: '/api/caso/editar',
        casodelete: '/api/caso/eliminar',
        casoreporteconsolidado:'/api/caso/consolidado',
        casoautorized:'/api/caso/estado',
        pagoslist: '/api/pagorealizado',
        seguimientolist: '/api/seguimiento',
        homepage: '/api/homepage',
        rolaccionlist: '/api/rol/accion',
        estadolist:'/api/estado',
        listpagorealizadocaso:'/api/pagorealizado/caso',
        formapagolist:'/api/formapago',
        tipocobrolist:'/api/tipocobro',
        pagosatrazadoslist:'/api/pagosatrazados',
        pagoedit:'/api/pagorealizado/caso/editar',
        pagodelete:'/api/pagorealizado/caso/eliminar',
        seguimientocasolist:'/api/seguimiento/caso',
        seguimientocasodelete:'/api/seguimiento/caso/eliminar',
        seguimientocasoedit:'/api/seguimiento/caso/editar',
        casoreport:'/api/caso/reporte',
        clientereport:'/api/empresa/reporte',
        pagoexportpdf:'/api/pagorealizado/pdf/',
        cambiarcontraseña:'/api/usuario/cambiarcontraseña',
        gestionclientelist:'/api/empresa/cliente/listar',
        gestionclienteadd:'/api/empresa/cliente/adicionar',
        gestionclienteedit:'/api/empresa/cliente/editar',
        gestionclientedelete:'/api/empresa/cliente/eliminar'
    }
    return serviceaddress + systemRoute[name];
}
