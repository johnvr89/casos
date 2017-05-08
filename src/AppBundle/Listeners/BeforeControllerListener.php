<?php

namespace AppBundle\Listeners;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use AppBundle\Libs\Controller\BaseController;
use Symfony\Bridge\Doctrine\ManagerRegistry;

/**
 * Description of ControllerListener
 *
 * @author rene
 */
class BeforeControllerListener {

    private $doctrineService;
    private $whiteList;

    public function __construct(ManagerRegistry $doctrineService) {
        $this->doctrineService = $doctrineService;
        $this->whiteList = array('App' => array('tokenAuthentication'), 'AGUsuario'
            => array('getNotLogued'), 'AGCaso' => array('getAll', 'delete', 'put','getReportCase','changeStatus'),
            'AGPagoRealizado' => array('getAll', 'getAllOutDate', 'getAllByCase',
                'post', 'delete', 'put', 'generatePDF'), 'AGSeguimiento' => 
            array('getAll', 'getAllByCase', 'post', 'delete', 'put'),'AGTipoCaso'=>array('getAll'),
            'AGCuenta'=>array('getAll'),'AGEmpresa'=>array('getReportClientCase'));
    }

    public function onKernelController(FilterControllerEvent $event) {


        $controller = $event->getController();
        $request = $event->getRequest();
        $uri = $request->getRequestUri();

        /*
         * $controller passed can be either a class or a Closure.
         * This is not usual in Symfony but it may happen.
         * If it is a class, it comes in array format
         */
        if (!is_array($controller)) {
            return;
        }
        if ($uri == '/api/token-authentication'||'/api/correo'||'/api/logo') {
            return;
        }

        if ($controller[0] instanceof BaseController) {
            $key = $event->getRequest()->headers->get('apiKey');
            if (!$key) {
                $event->setController(function() {
                    return new JsonResponse(array('success' => false, 'error' => 'No se encontr&oacute; una llave v&aacute;lida en la cabecera de la petici&oacute;n'));
                });
            } else {
                $result = $this->doctrineService->getRepository('AppBundle:AGUsuario')->findBy(array('token' => $key));
                if (!$result) {
                    $event->setController(function() {
                        return new JsonResponse(array('success' => false, 'error' => 'Token inv&aacute;lido', 'code' => 3000));
                    });
                } else {
                    $class = get_class($controller[0]);
                    $rf = new \ReflectionClass($class);
                    $name = $rf->getShortName();
                    $name = str_replace('Controller', '', $name);
                    $action = $controller[1];
                    $action = str_replace('Action', '', $action);



                    $checkPermisions = array('controller' => $name, 'action' => $action, 'key' => $key);

                    if (array_key_exists($name, $this->whiteList) && !in_array($action, $this->whiteList[$name]) || !array_key_exists($name, $this->whiteList)) {
                        $result = $this->doctrineService->getRepository('AppBundle:AGUsuario')->checkPermision($checkPermisions);
                        if (!$result) {
                            $event->setController(function() {
                                return new JsonResponse(array('success' => false, 'error' => 'No tiene permiso para ejecutar la acci&oacute;n solicitada', 'code' => 403));
                            });
                        }
                    }
                }
            }
        }
    }

}
