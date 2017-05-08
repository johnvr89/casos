<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * appProdProjectContainerUrlMatcher.
 *
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appProdProjectContainerUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher
{
    /**
     * Constructor.
     */
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }

    public function match($pathinfo)
    {
        $allow = array();
        $pathinfo = rawurldecode($pathinfo);
        $context = $this->context;
        $request = $this->request;

        if (0 === strpos($pathinfo, '/api')) {
            if (0 === strpos($pathinfo, '/api/acciones')) {
                // app_agaccion_getall
                if ($pathinfo === '/api/acciones') {
                    if (!in_array($this->context->getMethod(), array('GET', 'OPTIONS', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'OPTIONS', 'HEAD'));
                        goto not_app_agaccion_getall;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\AGAccionController::getAllAction',  '_route' => 'app_agaccion_getall',);
                }
                not_app_agaccion_getall:

                // app_agaccion_put
                if ($pathinfo === '/api/acciones') {
                    if (!in_array($this->context->getMethod(), array('POST', 'OPTIONS'))) {
                        $allow = array_merge($allow, array('POST', 'OPTIONS'));
                        goto not_app_agaccion_put;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\AGAccionController::putAction',  '_route' => 'app_agaccion_put',);
                }
                not_app_agaccion_put:

                // app_agaccion_post
                if ($pathinfo === '/api/acciones/post') {
                    if (!in_array($this->context->getMethod(), array('POST', 'OPTIONS'))) {
                        $allow = array_merge($allow, array('POST', 'OPTIONS'));
                        goto not_app_agaccion_post;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\AGAccionController::postAction',  '_route' => 'app_agaccion_post',);
                }
                not_app_agaccion_post:

            }

            // app_agbanco_getall
            if ($pathinfo === '/api/banco') {
                if (!in_array($this->context->getMethod(), array('GET', 'OPTIONS', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'OPTIONS', 'HEAD'));
                    goto not_app_agbanco_getall;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\AGBancoController::getAllAction',  '_route' => 'app_agbanco_getall',);
            }
            not_app_agbanco_getall:

            if (0 === strpos($pathinfo, '/api/c')) {
                if (0 === strpos($pathinfo, '/api/caso')) {
                    // app_agcaso_getall
                    if ($pathinfo === '/api/caso') {
                        if (!in_array($this->context->getMethod(), array('GET', 'OPTIONS', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'OPTIONS', 'HEAD'));
                            goto not_app_agcaso_getall;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\AGCasoController::getAllAction',  '_route' => 'app_agcaso_getall',);
                    }
                    not_app_agcaso_getall:

                    // app_agcaso_getreportcase
                    if ($pathinfo === '/api/caso/consolidado') {
                        if (!in_array($this->context->getMethod(), array('GET', 'OPTIONS', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'OPTIONS', 'HEAD'));
                            goto not_app_agcaso_getreportcase;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\AGCasoController::getReportCaseAction',  '_route' => 'app_agcaso_getreportcase',);
                    }
                    not_app_agcaso_getreportcase:

                    // app_agcaso_delete
                    if (0 === strpos($pathinfo, '/api/caso/eliminar') && preg_match('#^/api/caso/eliminar/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('POST', 'OPTIONS'))) {
                            $allow = array_merge($allow, array('POST', 'OPTIONS'));
                            goto not_app_agcaso_delete;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_agcaso_delete')), array (  '_controller' => 'AppBundle\\Controller\\AGCasoController::deleteAction',));
                    }
                    not_app_agcaso_delete:

                    // app_agcaso_post
                    if ($pathinfo === '/api/caso') {
                        if (!in_array($this->context->getMethod(), array('POST', 'OPTIONS'))) {
                            $allow = array_merge($allow, array('POST', 'OPTIONS'));
                            goto not_app_agcaso_post;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\AGCasoController::postAction',  '_route' => 'app_agcaso_post',);
                    }
                    not_app_agcaso_post:

                    if (0 === strpos($pathinfo, '/api/caso/e')) {
                        // app_agcaso_changestatus
                        if ($pathinfo === '/api/caso/estado') {
                            if (!in_array($this->context->getMethod(), array('POST', 'OPTIONS'))) {
                                $allow = array_merge($allow, array('POST', 'OPTIONS'));
                                goto not_app_agcaso_changestatus;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\AGCasoController::changeStatusAction',  '_route' => 'app_agcaso_changestatus',);
                        }
                        not_app_agcaso_changestatus:

                        // app_agcaso_put
                        if ($pathinfo === '/api/caso/editar') {
                            if (!in_array($this->context->getMethod(), array('POST', 'OPTIONS'))) {
                                $allow = array_merge($allow, array('POST', 'OPTIONS'));
                                goto not_app_agcaso_put;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\AGCasoController::putAction',  '_route' => 'app_agcaso_put',);
                        }
                        not_app_agcaso_put:

                    }

                    // app_agcaso_getbyid
                    if (preg_match('#^/api/caso/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'OPTIONS', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'OPTIONS', 'HEAD'));
                            goto not_app_agcaso_getbyid;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_agcaso_getbyid')), array (  '_controller' => 'AppBundle\\Controller\\AGCasoController::getByIdAction',));
                    }
                    not_app_agcaso_getbyid:

                }

                // app_agciudad_getall
                if ($pathinfo === '/api/ciudad') {
                    if (!in_array($this->context->getMethod(), array('GET', 'OPTIONS', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'OPTIONS', 'HEAD'));
                        goto not_app_agciudad_getall;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\AGCiudadController::getAllAction',  '_route' => 'app_agciudad_getall',);
                }
                not_app_agciudad_getall:

                if (0 === strpos($pathinfo, '/api/cuenta')) {
                    // app_agcuenta_getall
                    if ($pathinfo === '/api/cuenta') {
                        if (!in_array($this->context->getMethod(), array('GET', 'OPTIONS', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'OPTIONS', 'HEAD'));
                            goto not_app_agcuenta_getall;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\AGCuentaController::getAllAction',  '_route' => 'app_agcuenta_getall',);
                    }
                    not_app_agcuenta_getall:

                    // app_agcuenta_getbyid
                    if (preg_match('#^/api/cuenta/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'OPTIONS', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'OPTIONS', 'HEAD'));
                            goto not_app_agcuenta_getbyid;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_agcuenta_getbyid')), array (  '_controller' => 'AppBundle\\Controller\\AGCuentaController::getByIdAction',));
                    }
                    not_app_agcuenta_getbyid:

                    // app_agcuenta_delete
                    if (0 === strpos($pathinfo, '/api/cuenta/eliminar') && preg_match('#^/api/cuenta/eliminar/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('POST', 'OPTIONS'))) {
                            $allow = array_merge($allow, array('POST', 'OPTIONS'));
                            goto not_app_agcuenta_delete;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_agcuenta_delete')), array (  '_controller' => 'AppBundle\\Controller\\AGCuentaController::deleteAction',));
                    }
                    not_app_agcuenta_delete:

                    // app_agcuenta_post
                    if ($pathinfo === '/api/cuenta') {
                        if (!in_array($this->context->getMethod(), array('POST', 'OPTIONS'))) {
                            $allow = array_merge($allow, array('POST', 'OPTIONS'));
                            goto not_app_agcuenta_post;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\AGCuentaController::postAction',  '_route' => 'app_agcuenta_post',);
                    }
                    not_app_agcuenta_post:

                    // app_agcuenta_put
                    if ($pathinfo === '/api/cuenta/editar') {
                        if (!in_array($this->context->getMethod(), array('POST', 'OPTIONS'))) {
                            $allow = array_merge($allow, array('POST', 'OPTIONS'));
                            goto not_app_agcuenta_put;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\AGCuentaController::putAction',  '_route' => 'app_agcuenta_put',);
                    }
                    not_app_agcuenta_put:

                }

            }

            if (0 === strpos($pathinfo, '/api/e')) {
                if (0 === strpos($pathinfo, '/api/empresa')) {
                    // app_agempresa_getall
                    if ($pathinfo === '/api/empresa') {
                        if (!in_array($this->context->getMethod(), array('GET', 'OPTIONS', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'OPTIONS', 'HEAD'));
                            goto not_app_agempresa_getall;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\AGEmpresaController::getAllAction',  '_route' => 'app_agempresa_getall',);
                    }
                    not_app_agempresa_getall:

                    // app_agempresa_getmaincompanylist
                    if ($pathinfo === '/api/empresa/rectora') {
                        if (!in_array($this->context->getMethod(), array('GET', 'OPTIONS', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'OPTIONS', 'HEAD'));
                            goto not_app_agempresa_getmaincompanylist;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\AGEmpresaController::getMainCompanyListAction',  '_route' => 'app_agempresa_getmaincompanylist',);
                    }
                    not_app_agempresa_getmaincompanylist:

                    // app_agempresa_getreportclientcase
                    if ($pathinfo === '/api/empresa/consolidado') {
                        if (!in_array($this->context->getMethod(), array('GET', 'OPTIONS', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'OPTIONS', 'HEAD'));
                            goto not_app_agempresa_getreportclientcase;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\AGEmpresaController::getReportClientCaseAction',  '_route' => 'app_agempresa_getreportclientcase',);
                    }
                    not_app_agempresa_getreportclientcase:

                    // app_agempresa_getallclient
                    if ($pathinfo === '/api/empresa/todosclientes') {
                        if (!in_array($this->context->getMethod(), array('GET', 'OPTIONS', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'OPTIONS', 'HEAD'));
                            goto not_app_agempresa_getallclient;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\AGEmpresaController::getAllClientAction',  '_route' => 'app_agempresa_getallclient',);
                    }
                    not_app_agempresa_getallclient:

                    // app_agempresa_getallcompanywithcase
                    if ($pathinfo === '/api/empresa/clientes') {
                        if (!in_array($this->context->getMethod(), array('GET', 'OPTIONS', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'OPTIONS', 'HEAD'));
                            goto not_app_agempresa_getallcompanywithcase;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\AGEmpresaController::getAllCompanyWithCaseAction',  '_route' => 'app_agempresa_getallcompanywithcase',);
                    }
                    not_app_agempresa_getallcompanywithcase:

                    // app_agempresa_getclientforpayment
                    if ($pathinfo === '/api/empresa/reporte') {
                        if (!in_array($this->context->getMethod(), array('GET', 'OPTIONS', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'OPTIONS', 'HEAD'));
                            goto not_app_agempresa_getclientforpayment;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\AGEmpresaController::getClientForPayment',  '_route' => 'app_agempresa_getclientforpayment',);
                    }
                    not_app_agempresa_getclientforpayment:

                    if (0 === strpos($pathinfo, '/api/empresa/e')) {
                        // app_agempresa_delete
                        if (0 === strpos($pathinfo, '/api/empresa/eliminar') && preg_match('#^/api/empresa/eliminar/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if (!in_array($this->context->getMethod(), array('POST', 'OPTIONS'))) {
                                $allow = array_merge($allow, array('POST', 'OPTIONS'));
                                goto not_app_agempresa_delete;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_agempresa_delete')), array (  '_controller' => 'AppBundle\\Controller\\AGEmpresaController::deleteAction',));
                        }
                        not_app_agempresa_delete:

                        // app_agempresa_put
                        if ($pathinfo === '/api/empresa/editar') {
                            if (!in_array($this->context->getMethod(), array('POST', 'OPTIONS'))) {
                                $allow = array_merge($allow, array('POST', 'OPTIONS'));
                                goto not_app_agempresa_put;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\AGEmpresaController::putAction',  '_route' => 'app_agempresa_put',);
                        }
                        not_app_agempresa_put:

                    }

                    // app_agempresa_post
                    if ($pathinfo === '/api/empresa') {
                        if (!in_array($this->context->getMethod(), array('POST', 'OPTIONS'))) {
                            $allow = array_merge($allow, array('POST', 'OPTIONS'));
                            goto not_app_agempresa_post;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\AGEmpresaController::postAction',  '_route' => 'app_agempresa_post',);
                    }
                    not_app_agempresa_post:

                    if (0 === strpos($pathinfo, '/api/empresa/cliente')) {
                        // app_agempresa_getcompanyclient
                        if ($pathinfo === '/api/empresa/cliente/listar') {
                            if (!in_array($this->context->getMethod(), array('GET', 'OPTIONS', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'OPTIONS', 'HEAD'));
                                goto not_app_agempresa_getcompanyclient;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\AGEmpresaController::getCompanyClientAction',  '_route' => 'app_agempresa_getcompanyclient',);
                        }
                        not_app_agempresa_getcompanyclient:

                        // app_agempresa_postclient
                        if ($pathinfo === '/api/empresa/cliente/adicionar') {
                            if (!in_array($this->context->getMethod(), array('POST', 'OPTIONS'))) {
                                $allow = array_merge($allow, array('POST', 'OPTIONS'));
                                goto not_app_agempresa_postclient;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\AGEmpresaController::postClientAction',  '_route' => 'app_agempresa_postclient',);
                        }
                        not_app_agempresa_postclient:

                        if (0 === strpos($pathinfo, '/api/empresa/cliente/e')) {
                            // app_agempresa_putclient
                            if ($pathinfo === '/api/empresa/cliente/editar') {
                                if (!in_array($this->context->getMethod(), array('POST', 'OPTIONS'))) {
                                    $allow = array_merge($allow, array('POST', 'OPTIONS'));
                                    goto not_app_agempresa_putclient;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\AGEmpresaController::putClientAction',  '_route' => 'app_agempresa_putclient',);
                            }
                            not_app_agempresa_putclient:

                            // app_agempresa_deleteclient
                            if (0 === strpos($pathinfo, '/api/empresa/cliente/eliminar') && preg_match('#^/api/empresa/cliente/eliminar/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                                if (!in_array($this->context->getMethod(), array('POST', 'OPTIONS'))) {
                                    $allow = array_merge($allow, array('POST', 'OPTIONS'));
                                    goto not_app_agempresa_deleteclient;
                                }

                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_agempresa_deleteclient')), array (  '_controller' => 'AppBundle\\Controller\\AGEmpresaController::deleteClientAction',));
                            }
                            not_app_agempresa_deleteclient:

                        }

                    }

                }

                // app_agestado_getall
                if ($pathinfo === '/api/estado') {
                    if (!in_array($this->context->getMethod(), array('GET', 'OPTIONS', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'OPTIONS', 'HEAD'));
                        goto not_app_agestado_getall;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\AGEstadoController::getAllAction',  '_route' => 'app_agestado_getall',);
                }
                not_app_agestado_getall:

            }

            // app_agformapago_getall
            if ($pathinfo === '/api/formapago') {
                if (!in_array($this->context->getMethod(), array('GET', 'OPTIONS', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'OPTIONS', 'HEAD'));
                    goto not_app_agformapago_getall;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\AGFormaPagoController::getAllAction',  '_route' => 'app_agformapago_getall',);
            }
            not_app_agformapago_getall:

            if (0 === strpos($pathinfo, '/api/pago')) {
                // app_agpagorealizado_getall
                if ($pathinfo === '/api/pagorealizado') {
                    if (!in_array($this->context->getMethod(), array('GET', 'OPTIONS', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'OPTIONS', 'HEAD'));
                        goto not_app_agpagorealizado_getall;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\AGPagoRealizadoController::getAllAction',  '_route' => 'app_agpagorealizado_getall',);
                }
                not_app_agpagorealizado_getall:

                // app_agpagorealizado_getalloutdate
                if ($pathinfo === '/api/pagosatrazados') {
                    if (!in_array($this->context->getMethod(), array('GET', 'OPTIONS', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'OPTIONS', 'HEAD'));
                        goto not_app_agpagorealizado_getalloutdate;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\AGPagoRealizadoController::getAllOutDateAction',  '_route' => 'app_agpagorealizado_getalloutdate',);
                }
                not_app_agpagorealizado_getalloutdate:

                if (0 === strpos($pathinfo, '/api/pagorealizado')) {
                    // app_agpagorealizado_getallbycase
                    if ($pathinfo === '/api/pagorealizado/caso') {
                        if (!in_array($this->context->getMethod(), array('GET', 'OPTIONS', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'OPTIONS', 'HEAD'));
                            goto not_app_agpagorealizado_getallbycase;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\AGPagoRealizadoController::getAllByCaseAction',  '_route' => 'app_agpagorealizado_getallbycase',);
                    }
                    not_app_agpagorealizado_getallbycase:

                    // app_agpagorealizado_getbyid
                    if (preg_match('#^/api/pagorealizado/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'OPTIONS', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'OPTIONS', 'HEAD'));
                            goto not_app_agpagorealizado_getbyid;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_agpagorealizado_getbyid')), array (  '_controller' => 'AppBundle\\Controller\\AGPagoRealizadoController::getByIdAction',));
                    }
                    not_app_agpagorealizado_getbyid:

                    if (0 === strpos($pathinfo, '/api/pagorealizado/caso')) {
                        // app_agpagorealizado_post
                        if ($pathinfo === '/api/pagorealizado/caso') {
                            if (!in_array($this->context->getMethod(), array('POST', 'OPTIONS'))) {
                                $allow = array_merge($allow, array('POST', 'OPTIONS'));
                                goto not_app_agpagorealizado_post;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\AGPagoRealizadoController::postAction',  '_route' => 'app_agpagorealizado_post',);
                        }
                        not_app_agpagorealizado_post:

                        if (0 === strpos($pathinfo, '/api/pagorealizado/caso/e')) {
                            // app_agpagorealizado_put
                            if ($pathinfo === '/api/pagorealizado/caso/editar') {
                                if (!in_array($this->context->getMethod(), array('POST', 'OPTIONS'))) {
                                    $allow = array_merge($allow, array('POST', 'OPTIONS'));
                                    goto not_app_agpagorealizado_put;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\AGPagoRealizadoController::putAction',  '_route' => 'app_agpagorealizado_put',);
                            }
                            not_app_agpagorealizado_put:

                            // app_agpagorealizado_delete
                            if (0 === strpos($pathinfo, '/api/pagorealizado/caso/eliminar') && preg_match('#^/api/pagorealizado/caso/eliminar/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                                if (!in_array($this->context->getMethod(), array('POST', 'OPTIONS'))) {
                                    $allow = array_merge($allow, array('POST', 'OPTIONS'));
                                    goto not_app_agpagorealizado_delete;
                                }

                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_agpagorealizado_delete')), array (  '_controller' => 'AppBundle\\Controller\\AGPagoRealizadoController::deleteAction',));
                            }
                            not_app_agpagorealizado_delete:

                        }

                    }

                    // app_agpagorealizado_generatepdf
                    if (0 === strpos($pathinfo, '/api/pagorealizado/pdf') && preg_match('#^/api/pagorealizado/pdf/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'OPTIONS', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'OPTIONS', 'HEAD'));
                            goto not_app_agpagorealizado_generatepdf;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_agpagorealizado_generatepdf')), array (  '_controller' => 'AppBundle\\Controller\\AGPagoRealizadoController::generatePDFAction',));
                    }
                    not_app_agpagorealizado_generatepdf:

                }

            }

            if (0 === strpos($pathinfo, '/api/rol')) {
                // app_agrol_getall
                if ($pathinfo === '/api/rol') {
                    if (!in_array($this->context->getMethod(), array('GET', 'OPTIONS', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'OPTIONS', 'HEAD'));
                        goto not_app_agrol_getall;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\AGRolController::getAllAction',  '_route' => 'app_agrol_getall',);
                }
                not_app_agrol_getall:

                // app_agrol_put
                if ($pathinfo === '/api/rol/editar') {
                    if (!in_array($this->context->getMethod(), array('POST', 'OPTIONS'))) {
                        $allow = array_merge($allow, array('POST', 'OPTIONS'));
                        goto not_app_agrol_put;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\AGRolController::putAction',  '_route' => 'app_agrol_put',);
                }
                not_app_agrol_put:

                if (0 === strpos($pathinfo, '/api/rol/permiso')) {
                    // app_agrol_getallpermission
                    if (0 === strpos($pathinfo, '/api/rol/permisos') && preg_match('#^/api/rol/permisos/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'OPTIONS', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'OPTIONS', 'HEAD'));
                            goto not_app_agrol_getallpermission;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_agrol_getallpermission')), array (  '_controller' => 'AppBundle\\Controller\\AGRolController::getAllPermissionAction',));
                    }
                    not_app_agrol_getallpermission:

                    // app_agrol_updaterolepermission
                    if ($pathinfo === '/api/rol/permisoasignacion') {
                        if (!in_array($this->context->getMethod(), array('POST', 'OPTIONS'))) {
                            $allow = array_merge($allow, array('POST', 'OPTIONS'));
                            goto not_app_agrol_updaterolepermission;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\AGRolController::updateRolePermissionAction',  '_route' => 'app_agrol_updaterolepermission',);
                    }
                    not_app_agrol_updaterolepermission:

                }

                // app_agrol_getbyid
                if (preg_match('#^/api/rol/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'OPTIONS', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'OPTIONS', 'HEAD'));
                        goto not_app_agrol_getbyid;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_agrol_getbyid')), array (  '_controller' => 'AppBundle\\Controller\\AGRolController::getByIdAction',));
                }
                not_app_agrol_getbyid:

                // app_agrol_delete
                if (preg_match('#^/api/rol/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('POST', 'OPTIONS'))) {
                        $allow = array_merge($allow, array('POST', 'OPTIONS'));
                        goto not_app_agrol_delete;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_agrol_delete')), array (  '_controller' => 'AppBundle\\Controller\\AGRolController::deleteAction',));
                }
                not_app_agrol_delete:

                // app_agrol_post
                if ($pathinfo === '/api/rol') {
                    if (!in_array($this->context->getMethod(), array('POST', 'OPTIONS'))) {
                        $allow = array_merge($allow, array('POST', 'OPTIONS'));
                        goto not_app_agrol_post;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\AGRolController::postAction',  '_route' => 'app_agrol_post',);
                }
                not_app_agrol_post:

            }

            if (0 === strpos($pathinfo, '/api/seguimiento')) {
                // app_agseguimiento_getall
                if ($pathinfo === '/api/seguimiento') {
                    if (!in_array($this->context->getMethod(), array('GET', 'OPTIONS', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'OPTIONS', 'HEAD'));
                        goto not_app_agseguimiento_getall;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\AGSeguimientoController::getAllAction',  '_route' => 'app_agseguimiento_getall',);
                }
                not_app_agseguimiento_getall:

                if (0 === strpos($pathinfo, '/api/seguimiento/caso')) {
                    // app_agseguimiento_post
                    if ($pathinfo === '/api/seguimiento/caso') {
                        if (!in_array($this->context->getMethod(), array('POST', 'OPTIONS'))) {
                            $allow = array_merge($allow, array('POST', 'OPTIONS'));
                            goto not_app_agseguimiento_post;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\AGSeguimientoController::postAction',  '_route' => 'app_agseguimiento_post',);
                    }
                    not_app_agseguimiento_post:

                    // app_agseguimiento_put
                    if ($pathinfo === '/api/seguimiento/caso/editar') {
                        if (!in_array($this->context->getMethod(), array('POST', 'OPTIONS'))) {
                            $allow = array_merge($allow, array('POST', 'OPTIONS'));
                            goto not_app_agseguimiento_put;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\AGSeguimientoController::putAction',  '_route' => 'app_agseguimiento_put',);
                    }
                    not_app_agseguimiento_put:

                    // app_agseguimiento_getallbycase
                    if ($pathinfo === '/api/seguimiento/caso') {
                        if (!in_array($this->context->getMethod(), array('GET', 'OPTIONS', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'OPTIONS', 'HEAD'));
                            goto not_app_agseguimiento_getallbycase;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\AGSeguimientoController::getAllByCaseAction',  '_route' => 'app_agseguimiento_getallbycase',);
                    }
                    not_app_agseguimiento_getallbycase:

                }

                // app_agseguimiento_getbyid
                if (preg_match('#^/api/seguimiento/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'OPTIONS', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'OPTIONS', 'HEAD'));
                        goto not_app_agseguimiento_getbyid;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_agseguimiento_getbyid')), array (  '_controller' => 'AppBundle\\Controller\\AGSeguimientoController::getByIdAction',));
                }
                not_app_agseguimiento_getbyid:

                // app_agseguimiento_delete
                if (0 === strpos($pathinfo, '/api/seguimiento/caso/eliminar') && preg_match('#^/api/seguimiento/caso/eliminar/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('POST', 'OPTIONS'))) {
                        $allow = array_merge($allow, array('POST', 'OPTIONS'));
                        goto not_app_agseguimiento_delete;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_agseguimiento_delete')), array (  '_controller' => 'AppBundle\\Controller\\AGSeguimientoController::deleteAction',));
                }
                not_app_agseguimiento_delete:

            }

            if (0 === strpos($pathinfo, '/api/caracteristica')) {
                // app_agtipocasocaracteristica_getallbycasetype
                if ($pathinfo === '/api/caracteristica') {
                    if (!in_array($this->context->getMethod(), array('GET', 'OPTIONS', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'OPTIONS', 'HEAD'));
                        goto not_app_agtipocasocaracteristica_getallbycasetype;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\AGTipoCasoCaracteristicaController::getAllByCaseTypeAction',  '_route' => 'app_agtipocasocaracteristica_getallbycasetype',);
                }
                not_app_agtipocasocaracteristica_getallbycasetype:

                // app_agtipocasocaracteristica_getbyid
                if (preg_match('#^/api/caracteristica/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'OPTIONS', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'OPTIONS', 'HEAD'));
                        goto not_app_agtipocasocaracteristica_getbyid;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_agtipocasocaracteristica_getbyid')), array (  '_controller' => 'AppBundle\\Controller\\AGTipoCasoCaracteristicaController::getByIdAction',));
                }
                not_app_agtipocasocaracteristica_getbyid:

                // app_agtipocasocaracteristica_post
                if ($pathinfo === '/api/caracteristica') {
                    if (!in_array($this->context->getMethod(), array('POST', 'OPTIONS'))) {
                        $allow = array_merge($allow, array('POST', 'OPTIONS'));
                        goto not_app_agtipocasocaracteristica_post;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\AGTipoCasoCaracteristicaController::postAction',  '_route' => 'app_agtipocasocaracteristica_post',);
                }
                not_app_agtipocasocaracteristica_post:

                if (0 === strpos($pathinfo, '/api/caracteristica/e')) {
                    // app_agtipocasocaracteristica_put
                    if ($pathinfo === '/api/caracteristica/editar') {
                        if (!in_array($this->context->getMethod(), array('POST', 'OPTIONS'))) {
                            $allow = array_merge($allow, array('POST', 'OPTIONS'));
                            goto not_app_agtipocasocaracteristica_put;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\AGTipoCasoCaracteristicaController::putAction',  '_route' => 'app_agtipocasocaracteristica_put',);
                    }
                    not_app_agtipocasocaracteristica_put:

                    // app_agtipocasocaracteristica_delete
                    if (0 === strpos($pathinfo, '/api/caracteristica/eliminar') && preg_match('#^/api/caracteristica/eliminar/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('POST', 'OPTIONS'))) {
                            $allow = array_merge($allow, array('POST', 'OPTIONS'));
                            goto not_app_agtipocasocaracteristica_delete;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_agtipocasocaracteristica_delete')), array (  '_controller' => 'AppBundle\\Controller\\AGTipoCasoCaracteristicaController::deleteAction',));
                    }
                    not_app_agtipocasocaracteristica_delete:

                }

            }

            if (0 === strpos($pathinfo, '/api/tipo')) {
                if (0 === strpos($pathinfo, '/api/tipoc')) {
                    if (0 === strpos($pathinfo, '/api/tipocaso')) {
                        // app_agtipocaso_getall
                        if ($pathinfo === '/api/tipocaso') {
                            if (!in_array($this->context->getMethod(), array('GET', 'OPTIONS', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'OPTIONS', 'HEAD'));
                                goto not_app_agtipocaso_getall;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\AGTipoCasoController::getAllAction',  '_route' => 'app_agtipocaso_getall',);
                        }
                        not_app_agtipocaso_getall:

                        if (0 === strpos($pathinfo, '/api/tipocaso/e')) {
                            // app_agtipocaso_delete
                            if (0 === strpos($pathinfo, '/api/tipocaso/eliminar') && preg_match('#^/api/tipocaso/eliminar/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                                if (!in_array($this->context->getMethod(), array('POST', 'OPTIONS'))) {
                                    $allow = array_merge($allow, array('POST', 'OPTIONS'));
                                    goto not_app_agtipocaso_delete;
                                }

                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_agtipocaso_delete')), array (  '_controller' => 'AppBundle\\Controller\\AGTipoCasoController::deleteAction',));
                            }
                            not_app_agtipocaso_delete:

                            // app_agtipocaso_put
                            if ($pathinfo === '/api/tipocaso/editar') {
                                if (!in_array($this->context->getMethod(), array('POST', 'OPTIONS'))) {
                                    $allow = array_merge($allow, array('POST', 'OPTIONS'));
                                    goto not_app_agtipocaso_put;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\AGTipoCasoController::putAction',  '_route' => 'app_agtipocaso_put',);
                            }
                            not_app_agtipocaso_put:

                        }

                        // app_agtipocaso_getbyid
                        if (preg_match('#^/api/tipocaso/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if (!in_array($this->context->getMethod(), array('GET', 'OPTIONS', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'OPTIONS', 'HEAD'));
                                goto not_app_agtipocaso_getbyid;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_agtipocaso_getbyid')), array (  '_controller' => 'AppBundle\\Controller\\AGTipoCasoController::getByIdAction',));
                        }
                        not_app_agtipocaso_getbyid:

                        // app_agtipocaso_post
                        if ($pathinfo === '/api/tipocaso') {
                            if (!in_array($this->context->getMethod(), array('POST', 'OPTIONS'))) {
                                $allow = array_merge($allow, array('POST', 'OPTIONS'));
                                goto not_app_agtipocaso_post;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\AGTipoCasoController::postAction',  '_route' => 'app_agtipocaso_post',);
                        }
                        not_app_agtipocaso_post:

                    }

                    if (0 === strpos($pathinfo, '/api/tipocliente')) {
                        // app_agtipocliente_getall
                        if ($pathinfo === '/api/tipocliente') {
                            if (!in_array($this->context->getMethod(), array('GET', 'OPTIONS', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'OPTIONS', 'HEAD'));
                                goto not_app_agtipocliente_getall;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\AGTipoClienteController::getAllAction',  '_route' => 'app_agtipocliente_getall',);
                        }
                        not_app_agtipocliente_getall:

                        if (0 === strpos($pathinfo, '/api/tipocliente/empresa')) {
                            // app_agtipocliente_gettypemaincompany
                            if ($pathinfo === '/api/tipocliente/empresarectora') {
                                if (!in_array($this->context->getMethod(), array('GET', 'OPTIONS', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'OPTIONS', 'HEAD'));
                                    goto not_app_agtipocliente_gettypemaincompany;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\AGTipoClienteController::getTypeMainCompanyAction',  '_route' => 'app_agtipocliente_gettypemaincompany',);
                            }
                            not_app_agtipocliente_gettypemaincompany:

                            // app_agtipocliente_gettypeclientcompany
                            if ($pathinfo === '/api/tipocliente/empresacliente') {
                                if (!in_array($this->context->getMethod(), array('GET', 'OPTIONS', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'OPTIONS', 'HEAD'));
                                    goto not_app_agtipocliente_gettypeclientcompany;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\AGTipoClienteController::getTypeClientCompanyAction',  '_route' => 'app_agtipocliente_gettypeclientcompany',);
                            }
                            not_app_agtipocliente_gettypeclientcompany:

                        }

                    }

                    // app_agtipocobro_getall
                    if ($pathinfo === '/api/tipocobro') {
                        if (!in_array($this->context->getMethod(), array('GET', 'OPTIONS', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'OPTIONS', 'HEAD'));
                            goto not_app_agtipocobro_getall;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\AGTipoCobroController::getAllAction',  '_route' => 'app_agtipocobro_getall',);
                    }
                    not_app_agtipocobro_getall:

                }

                // app_agtipodatos_getall
                if ($pathinfo === '/api/tipodato') {
                    if (!in_array($this->context->getMethod(), array('GET', 'OPTIONS', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'OPTIONS', 'HEAD'));
                        goto not_app_agtipodatos_getall;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\AGTipoDatosController::getAllAction',  '_route' => 'app_agtipodatos_getall',);
                }
                not_app_agtipodatos_getall:

            }

            if (0 === strpos($pathinfo, '/api/usuario')) {
                // app_agusuario_getnotlogued
                if ($pathinfo === '/api/usuario') {
                    if (!in_array($this->context->getMethod(), array('GET', 'OPTIONS', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'OPTIONS', 'HEAD'));
                        goto not_app_agusuario_getnotlogued;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\AGUsuarioController::getNotLoguedAction',  '_route' => 'app_agusuario_getnotlogued',);
                }
                not_app_agusuario_getnotlogued:

                // app_agusuario_getall
                if ($pathinfo === '/api/usuario/listar') {
                    if (!in_array($this->context->getMethod(), array('GET', 'OPTIONS', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'OPTIONS', 'HEAD'));
                        goto not_app_agusuario_getall;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\AGUsuarioController::getAllAction',  '_route' => 'app_agusuario_getall',);
                }
                not_app_agusuario_getall:

                // app_agusuario_getallintermediary
                if ($pathinfo === '/api/usuario/intermediario') {
                    if (!in_array($this->context->getMethod(), array('GET', 'OPTIONS', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'OPTIONS', 'HEAD'));
                        goto not_app_agusuario_getallintermediary;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\AGUsuarioController::getAllIntermediaryAction',  '_route' => 'app_agusuario_getallintermediary',);
                }
                not_app_agusuario_getallintermediary:

                // app_agusuario_getalllawer
                if ($pathinfo === '/api/usuario/abogado') {
                    if (!in_array($this->context->getMethod(), array('GET', 'OPTIONS', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'OPTIONS', 'HEAD'));
                        goto not_app_agusuario_getalllawer;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\AGUsuarioController::getAllLawerAction',  '_route' => 'app_agusuario_getalllawer',);
                }
                not_app_agusuario_getalllawer:

                // app_agusuario_getuserbytoken
                if ($pathinfo === '/api/usuario/token') {
                    if (!in_array($this->context->getMethod(), array('GET', 'OPTIONS', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'OPTIONS', 'HEAD'));
                        goto not_app_agusuario_getuserbytoken;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\AGUsuarioController::getUserByTokenAction',  '_route' => 'app_agusuario_getuserbytoken',);
                }
                not_app_agusuario_getuserbytoken:

                // app_agusuario_getbyid
                if (preg_match('#^/api/usuario/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'OPTIONS', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'OPTIONS', 'HEAD'));
                        goto not_app_agusuario_getbyid;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_agusuario_getbyid')), array (  '_controller' => 'AppBundle\\Controller\\AGUsuarioController::getByIdAction',));
                }
                not_app_agusuario_getbyid:

                // app_agusuario_delete
                if (0 === strpos($pathinfo, '/api/usuario/eliminar') && preg_match('#^/api/usuario/eliminar/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('POST', 'OPTIONS'))) {
                        $allow = array_merge($allow, array('POST', 'OPTIONS'));
                        goto not_app_agusuario_delete;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_agusuario_delete')), array (  '_controller' => 'AppBundle\\Controller\\AGUsuarioController::deleteAction',));
                }
                not_app_agusuario_delete:

                // app_agusuario_post
                if ($pathinfo === '/api/usuario') {
                    if (!in_array($this->context->getMethod(), array('POST', 'OPTIONS'))) {
                        $allow = array_merge($allow, array('POST', 'OPTIONS'));
                        goto not_app_agusuario_post;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\AGUsuarioController::postAction',  '_route' => 'app_agusuario_post',);
                }
                not_app_agusuario_post:

                // app_agusuario_put
                if ($pathinfo === '/api/usuario/editar') {
                    if (!in_array($this->context->getMethod(), array('POST', 'OPTIONS'))) {
                        $allow = array_merge($allow, array('POST', 'OPTIONS'));
                        goto not_app_agusuario_put;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\AGUsuarioController::putAction',  '_route' => 'app_agusuario_put',);
                }
                not_app_agusuario_put:

                if (0 === strpos($pathinfo, '/api/usuario/rol')) {
                    // app_agusuario_updateuserrole
                    if ($pathinfo === '/api/usuario/rolasignacion') {
                        if (!in_array($this->context->getMethod(), array('POST', 'OPTIONS'))) {
                            $allow = array_merge($allow, array('POST', 'OPTIONS'));
                            goto not_app_agusuario_updateuserrole;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\AGUsuarioController::updateUserRoleAction',  '_route' => 'app_agusuario_updateuserrole',);
                    }
                    not_app_agusuario_updateuserrole:

                    // app_agusuario_getuserallroles
                    if (0 === strpos($pathinfo, '/api/usuario/roles') && preg_match('#^/api/usuario/roles/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'OPTIONS', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'OPTIONS', 'HEAD'));
                            goto not_app_agusuario_getuserallroles;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_agusuario_getuserallroles')), array (  '_controller' => 'AppBundle\\Controller\\AGUsuarioController::getUserAllRolesAction',));
                    }
                    not_app_agusuario_getuserallroles:

                }

                // app_agusuario_changepassword
                if ($pathinfo === '/api/usuario/cambiarcontraseña') {
                    if (!in_array($this->context->getMethod(), array('POST', 'OPTIONS'))) {
                        $allow = array_merge($allow, array('POST', 'OPTIONS'));
                        goto not_app_agusuario_changepassword;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\AGUsuarioController::changePasswordAction',  '_route' => 'app_agusuario_changepassword',);
                }
                not_app_agusuario_changepassword:

            }

            // app_app_tokenauthentication
            if ($pathinfo === '/api/token-authentication') {
                if (!in_array($this->context->getMethod(), array('POST', 'OPTIONS'))) {
                    $allow = array_merge($allow, array('POST', 'OPTIONS'));
                    goto not_app_app_tokenauthentication;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\AppController::tokenAuthenticationAction',  '_route' => 'app_app_tokenauthentication',);
            }
            not_app_app_tokenauthentication:

            // app_app_closesession
            if ($pathinfo === '/api/session') {
                if (!in_array($this->context->getMethod(), array('POST', 'OPTIONS'))) {
                    $allow = array_merge($allow, array('POST', 'OPTIONS'));
                    goto not_app_app_closesession;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\AppController::closeSessionAction',  '_route' => 'app_app_closesession',);
            }
            not_app_app_closesession:

            // app_app_logo
            if ($pathinfo === '/api/logo') {
                if (!in_array($this->context->getMethod(), array('GET', 'OPTIONS', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'OPTIONS', 'HEAD'));
                    goto not_app_app_logo;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\AppController::logoAction',  '_route' => 'app_app_logo',);
            }
            not_app_app_logo:

            // app_default_index
            if ($pathinfo === '/api/homepage') {
                if (!in_array($this->context->getMethod(), array('GET', 'OPTIONS', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'OPTIONS', 'HEAD'));
                    goto not_app_default_index;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\DefaultController::indexAction',  '_route' => 'app_default_index',);
            }
            not_app_default_index:

            // app_email_send
            if ($pathinfo === '/api/correo') {
                if (!in_array($this->context->getMethod(), array('GET', 'OPTIONS', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'OPTIONS', 'HEAD'));
                    goto not_app_email_send;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\EmailController::sendAction',  '_route' => 'app_email_send',);
            }
            not_app_email_send:

            // nelmio_api_doc_index
            if (0 === strpos($pathinfo, '/api/doc') && preg_match('#^/api/doc(?:/(?P<view>[^/]++))?$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_nelmio_api_doc_index;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'nelmio_api_doc_index')), array (  '_controller' => 'Nelmio\\ApiDocBundle\\Controller\\ApiDocController::indexAction',  'view' => 'default',));
            }
            not_nelmio_api_doc_index:

        }

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}
