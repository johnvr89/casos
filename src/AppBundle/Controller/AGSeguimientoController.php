<?php

namespace AppBundle\Controller;

use AppBundle\Libs\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class AGSeguimientoController extends BaseController {

    /**
     * @Rest\Get("/api/seguimiento")
     * @Method({"GET","OPTIONS"})
     */
    public function getAllAction(Request $request)
    {
        $session = $request->getSession();
        try
        {
            $garantedAll = $this->isGarantedInCurrentRequest('listAllTrace', 'AGSeguimiento');
            if($garantedAll)
            {
                $arrayParams['intEmpresa'] = $session->get('idEmpresa');
                $arrayResult = $this->getRepo('AGSeguimiento')->findTraceByParams($arrayParams);
                return new View($this->normalizeResult('AGSeguimiento', $arrayResult), Response::HTTP_OK);
            }
            $user = $this->getUserOfCurrentRequest();
            if(!$user)
            {
                return new View($this->returnDeniedResponse(), Response::HTTP_OK);
            }

            $garantedMyTrace = $this->isGarantedInCurrentRequest('listMyCaseTrace', 'AGSeguimiento');
            if($garantedMyTrace)
            {
                $result = $this->getRepo('AGSeguimiento')->getResosurces($user->getToken());
                return new View($this->normalizeResult('AGSeguimiento', $result), Response::HTTP_OK);
            }
            return new View($this->returnDeniedResponse(), Response::HTTP_OK);
        }
        catch(\Exception $ex)
        {
            error_log($ex->getMessage());
            return new View(array('success' => false, 'error' => $this->get('translator')->trans('ESYSTEM')));
        }
    }

    /**
     * @Rest\Post("/api/seguimiento/caso")
     * @Method({"POST","OPTIONS"})
     */
    public function postAction(Request $request) {
        /* addTraceToAllCase si esta ese permiso pasa si no addTraceToMyCase 
         * Si lo tiene se verifica si el caso es creado por el usuario */
        $garantedAll = $this->isGarantedInCurrentRequest('addTraceToAllCase', 'AGSeguimiento');
        $garantedMyTrace = $this->isGarantedInCurrentRequest('addTraceToMyCase', 'AGSeguimiento');
        if (!$garantedAll && !$garantedMyTrace) {
            return new View($this->returnDeniedResponse(), Response::HTTP_OK);
        }
        $data = $request->request->all();

        $data = $data['trace'];
        $data = (array) (json_decode($data));
        if (!$garantedAll && $garantedMyTrace) {
            if (!$this->thisCaseIsMy($data['caso'])) {
                return new View($this->returnDeniedResponse(), Response::HTTP_OK);
            }
        }

        $user = $this->getUserOfCurrentRequest();
        if (!$user) {
            return new View($this->returnSecurityViolationResponse(), Response::HTTP_OK);
        }


        $data['responsableSeguimiento'] = $user->getId();
        $files = $request->files->all();
        $repoTrace = $this->getRepo('AGSeguimiento');
        $existTrace = $repoTrace->findOneBy(array('nombre' => $data['nombre'], 'caso' => $data['caso'],'visible'=>1));
        if ($existTrace) {
            return new View(array('success' => false, 'error' => 'Ya existe un seguimiento con ese nombre.'), Response::HTTP_OK);
        }
        $saveDoc = array('nombre' => '', 'url' => '');
        try {
            $data['cambioEstado'] = 0;
            $repoTrace->beginTransaction();
            $case = $this->getRepo('AGCaso')->find($data['caso']);
            if ($case->getEstado()->getId() == 2) {
                
                $saveCase = array('id' => $data['caso'], 'estado' => 3);
                $result = $this->saveModel('AGcaso', $saveCase);
                if ($result['success'] == false) {
                    $repoTrace->rollback();
                    return new View($result, Response::HTTP_OK);
                }
                 $saveTrace = array('nombre' => 'Cambio de estado', 'cambioEstado' => true, 'observacion' =>
                    'Cambio de estado a Trámite', 'descripcion' => 'Cambio de estado de Autorizado a Trámite.', 'caso' => $data['caso'],
                    'responsableSeguimiento' => $user->getId());
                $saveTrace = $this->saveModel('AGSeguimiento', $saveTrace, array(), false);
                if ($saveTrace['success'] == false) {
                    $repoTrace->rollback();
                    return new View($saveTrace, Response::HTTP_OK);
                }
            }
            $saveTrace = $this->saveModel('AGSeguimiento', $data, array(), false);
            if ($saveTrace['success'] == false) {
                $repoTrace->rollback();
                return new View($saveTrace, Response::HTTP_OK);
            }


            if (count($files) > 0) {
                $saveDoc = $this->get('importfileimage')->moveFile($request, true, true);

                if ($saveDoc['success'] == false) {
                    $repoTrace->rollback();
                    return new View($saveDoc, Response::HTTP_OK);
                }
                $saveDoc['nombre'] = $saveDoc['originalName'];
                $saveDoc['url'] = '/bundles/app/docs/' . $saveDoc['convert'];
                $saveDoc['seguimiento'] = $saveTrace['data']['id'];
                $result = $this->saveModel('AGDocumento', $saveDoc, array(), false);
                if ($result['success'] == false) {
                    $repoTrace->rollback();
                    return new View($result, Response::HTTP_OK);
                }
            }
            $repoTrace->commit();

            return new View($saveTrace, Response::HTTP_OK);
        } catch (\Exception $e) {
            $repoTrace->rollback();
            return new View($this->manageException($e), Response::HTTP_OK);
        }
    }

    /**
     * @Rest\Post("/api/seguimiento/caso/editar")
     * @Method({"POST","OPTIONS"})
     */
    public function putAction(Request $request) {
        /* updateTraceToAllCase si esta ese permiso pasa si no updateTraceToMyCase 
         * Si lo tiene se verifica si el caso es creado por el usuario */

        $data = $request->request->all();

        $data = $data['trace'];
        $data = (array) (json_decode($data));
        $garantedAll = $this->isGarantedInCurrentRequest('updateTraceToAllCase', 'AGSeguimiento');
        $garantedMyTrace = $this->isGarantedInCurrentRequest('updateTraceToMyCase', 'AGSeguimiento');
        if (!$garantedAll && !$garantedMyTrace) {
            return new View($this->returnDeniedResponse(), Response::HTTP_OK);
        }
        if (!$garantedAll && $garantedMyTrace) {
            if (!$this->thisCaseIsMy($data['caso'])) {
                return new View($this->returnDeniedResponse(), Response::HTTP_OK);
            }
        }


        if (!array_key_exists('id', $data)) {
            return new View(array('success' => false, 'error' => 'No se encontro el identificador'), Response::HTTP_OK);
        }
        $repoTrace = $this->getRepo('AGSeguimiento');
        $trace = $repoTrace->find($data['id']);
        if (!$trace) {
            return new View($this->returnNullResponse(), Response::HTTP_OK);
        }
        if ($trace->getCambioEstado()) {
            return new View(array('success' => false, 'error' => 'No se puede actualizar un seguimiento que provoc&oacute; un cambio de estado.'), Response::HTTP_OK);
        }

        $data['cambioEstado'] = 0;
        $files = $request->files->all();

        $existTrace = $repoTrace->findOneBy(array('nombre' => $data['nombre'], 'caso' => $data['caso'],'visible'=>1));
        if ($existTrace && $existTrace->getId() != $data['id']) {
            return new View(array('success' => false, 'error' => 'Ya existe un seguimiento con ese nombre.'), Response::HTTP_OK);
        }


        $saveDoc = array('nombre' => '', 'url' => '');
        try {
            $repoTrace->beginTransaction();

            $saveTrace = $this->saveModel('AGSeguimiento', $data, array(), false);
            if ($saveTrace['success'] == false) {
                $repoTrace->rollback();
                return new View($saveTrace, Response::HTTP_OK);
            }
            $repoDocument = $this->getRepo('AGDocumento');
            $doc = $repoDocument->findOneBy(array('seguimiento' => $trace->getId()));
            $oldUrl = '';
            if ($doc) {
                $oldUrl = $doc->getUrl();
            }
            if (count($files) > 0) {


                $saveDoc = $this->get('importfileimage')->moveFile($request, true, true);

                if ($saveDoc['success'] == false) {
                    $repoTrace->rollback();
                    return new View($saveDoc, Response::HTTP_OK);
                }
                $saveDoc['nombre'] = $saveDoc['originalName'];
                $saveDoc['url'] = '/bundles/app/docs/' . $saveDoc['convert'];
                $saveDoc['seguimiento'] = $saveTrace['data']['id'];
                if ($doc) {
                    $saveDoc['id'] = $doc->getId();
                }

                $result = $this->saveModel('AGDocumento', $saveDoc, array(), false);
                if ($result['success'] == false) {
                    $repoTrace->rollback();
                    return new View($result, Response::HTTP_OK);
                } else {
                    if ($oldUrl) {
                        $unlink = $this->getParameter('kernel.root_dir') . '/../web' . $oldUrl;
                        @unlink($unlink);
                    }
                }
            }
            $repoTrace->commit();

            return new View($saveTrace, Response::HTTP_OK);
        } catch (\Exception $e) {
            $repoTrace->rollback();
            return new View($this->manageException($e), Response::HTTP_OK);
        }
    }

    /**
     * @Rest\Get("/api/seguimiento/caso")
     * @Method({"GET","OPTIONS"})
     */
    public function getAllByCaseAction(Request $request) {
        /* si tiene permiso para listar todos los pagos pasa ssi tiene permiso para
         *  listar los pagos de mis casos y el id de caso es mio pasa */


        $garantedAll = $this->isGarantedInCurrentRequest('listAllTrace', 'AGSeguimiento');
        $garantedMyTrace = $this->isGarantedInCurrentRequest('listMyCaseTrace', 'AGSeguimiento');

        if ($garantedAll || ($garantedMyTrace && $this->thisCaseIsMy($request->get('caso')))) {
            $repo = $this->getRepo('AGSeguimiento');
            $result = $repo->findBy(array('caso' => $request->get('caso'),'visible'=>1));

            return new View($this->normalizeResult('AGSeguimiento', $result), Response::HTTP_OK);
        }

        return new View($this->returnDeniedResponse(), Response::HTTP_OK);
    }

    /**
     * @Rest\Get("/api/seguimiento/{id}")
     * @Method({"GET","OPTIONS"})
     */
    public function getByIdAction($id) {
        return $this->getDataOfModelById('AGSeguimiento', $id);
    }

    /**
     * @Rest\Post("/api/seguimiento/caso/eliminar/{id}")
     * @Method({"POST","OPTIONS"})
     */
    public function deleteAction($id) {
        /* deleteTraceToAllCase si esta ese permiso pasa si no deleteTraceToMyCase 
         * Si lo tiene se verifica si el caso es creado por el usuario */
        $repoTrace = $this->getRepo('AGSeguimiento');
        $repoDocument = $this->getRepo('AGDocumento');
        if (!is_numeric($id)) {
            return new View(array('success' => false, 'error' => 'Identificador en formato incorrecto.'), Response::HTTP_OK);
        }
        $trace = $repoTrace->find($id);
        if (!$trace) {
            return new View(array('success' => false, 'error' => 'Seguimiento no encontrado.'), Response::HTTP_OK);
        }
        $garantedAll = $this->isGarantedInCurrentRequest('deleteTraceToAllCase', 'AGSeguimiento');
        $garantedMyTrace = $this->isGarantedInCurrentRequest('deleteTraceToMyCase', 'AGSeguimiento');
        if (!$garantedAll && !$garantedMyTrace) {
            return new View($this->returnDeniedResponse(), Response::HTTP_OK);
        }
        if (!$garantedAll && $garantedMyTrace) {
            if (!$this->thisCaseIsMy($trace->getCaso()->getId())) {
                return new View($this->returnDeniedResponse(), Response::HTTP_OK);
            }
        }
        
        $result = $this->removeModel('AGSeguimiento', $id);
       
        return new View($result, Response::HTTP_OK);
    }

}
