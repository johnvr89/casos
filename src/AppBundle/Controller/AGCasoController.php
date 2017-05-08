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
use AppBundle\Libs\Normalizer\ResultDecorator;

class AGCasoController extends BaseController {

    /**
     * @Rest\Get("/api/caso")
     * @Method({"GET","OPTIONS"})
     */
    public function getAllAction() {
        $garanted = $this->isGarantedInCurrentRequest('listAllCase', 'AGCaso');
        $repoCase = $this->getRepo('AGCaso');
        $result = null;
        $empresa = $this->getRepo('AGEmpresa')->findOneBy(array('tipoCliente' => 3));
        if (!$empresa) {
            return new View(array('success' => false, 'error' => 'No se ha registrado la empresa rectora.'), Response::HTTP_OK);
        }
        if ($garanted) {

            $result = $repoCase->getPermissionCase(true, false, false, -1, $empresa->getId());
            return new View($this->normalizeResult('AGCaso', $result), Response::HTTP_OK);
        }
        $garantedMyCase = $this->isGarantedInCurrentRequest('listMyCase', 'AGCaso');
        $garantedIntermediaryCase = $this->isGarantedInCurrentRequest('listIntermediaryCase', 'AGCaso');
        $user = $this->getUserOfCurrentRequest();
        if ($user) {
            if ($garantedMyCase && $garantedIntermediaryCase) {
                $result = $repoCase->getPermissionCase(false, true, true, $user->getId(), $empresa->getId());
                return new View($this->normalizeResult('AGCaso', $result), Response::HTTP_OK);
            }
            if ($garantedMyCase) {
                $result = $repoCase->getPermissionCase(false, true, false, $user->getId(), $empresa->getId());
                return new View($this->normalizeResult('AGCaso', $result), Response::HTTP_OK);
            }
            if ($garantedIntermediaryCase) {
                $result = $repoCase->getPermissionCase(false, false, true, $user->getId(), $empresa->getId());
                return new View($this->normalizeResult('AGCaso', $result), Response::HTTP_OK);
            }
        }
        return new View($this->returnDeniedResponse(), Response::HTTP_OK);
    }

    /**
     * @Rest\Get("/api/caso/consolidado")
     * @Method({"GET","OPTIONS"})
     */
    public function getReportCaseAction(Request $request) {
        $garanted = $this->isGarantedInCurrentRequest('listAllCase', 'AGCaso');
        $repoCase = $this->getRepo('AGCaso');
        $result = null;
        $empresa = $this->getRepo('AGEmpresa')->findOneBy(array('tipoCliente' => 3));


        if (!$empresa) {
            return new View(array('success' => false, 'error' => 'No se ha registrado la empresa rectora.'), Response::HTTP_OK);
        }
        $client = $request->get('cliente');
        $caseName = $request->get('nombrecaso');
        $state = $request->get('estado');
        $lawer = $request->get('responsable');
        $caseType = $request->get('tipocaso');
        $intermediary = $request->get('intermediario');
        $startDate = $request->get('inicio');
        $endDate = $request->get('fin');
        if ($garanted) {
            $result = $repoCase->getCaseForReportConnsolidated(true, false, false, $startDate, $endDate, $empresa->getId(), $client, $lawer, $intermediary, $state, $caseType, $caseName);

            return new View($this->normalizeResult('AGCaso', $result, ResultDecorator::SIMPLE_DECORATOR), Response::HTTP_OK);
        }
        $garantedMyCase = $this->isGarantedInCurrentRequest('listMyCase', 'AGCaso');
        $garantedIntermediaryCase = $this->isGarantedInCurrentRequest('listIntermediaryCase', 'AGCaso');
        $user = $this->getUserOfCurrentRequest();
        if ($user) {
            if ($garantedMyCase && $garantedIntermediaryCase) {
                $result = $repoCase->getCaseForReportConnsolidated(true, false, false, $startDate, $endDate, $empresa->getId(), $client, $user->getId(), $user->getId(), $state, $caseType, $caseName);
                return new View($this->normalizeResult('AGCaso', $result), Response::HTTP_OK);
            }
            if ($garantedMyCase) {
                $result = $repoCase->getCaseForReportConnsolidated(true, false, false, $startDate, $endDate, $empresa->getId(), $client, $user->getId(), $intermediary, $state, $caseType, $caseName);
                return new View($this->normalizeResult('AGCaso', $result, ResultDecorator::SIMPLE_DECORATOR), Response::HTTP_OK);
            }
            if ($garantedIntermediaryCase) {
                $result = $repoCase->getCaseForReportConnsolidated(true, false, false, $startDate, $endDate, $empresa->getId(), $client, $lawer, $user->getId(), $state, $caseType, $caseName);
                return new View($this->normalizeResult('AGCaso', $result, ResultDecorator::SIMPLE_DECORATOR), Response::HTTP_OK);
            }
        }
        return new View($this->returnDeniedResponse(), Response::HTTP_OK);
    }

    /**
     * @Rest\Post("/api/caso/eliminar/{id}")
     * @Method({"POST","OPTIONS"})
     */
    public function deleteAction($id) {

        $garanted = $this->isGarantedInCurrentRequest('deleteAllCase', 'AGCaso');
        $garantedMyCase = $this->isGarantedInCurrentRequest('deleteMyCase', 'AGCaso');
        if (!$garanted && !$garantedMyCase) {
            return new View($this->returnDeniedResponse(), Response::HTTP_OK);
        }
        if (!$garanted && $garantedMyCase && !$this->thisCaseIsMy($id)) {
            return new View($this->returnDeniedResponse(), Response::HTTP_OK);
        }
        $repo = $this->getRepo('AGCaso');
        try {
            $repo->beginTransaction();
            $result = $this->removeModel('AGCaso', $id, array(array('method' => 'updateDependences', 'class' => $this)), array(), false);

            $repo->commit();
            return new View($result, Response::HTTP_OK);
        } catch (\Exception $e) {
            $repo->rollback();
            return new View($this->manageException($e), Response::HTTP_OK);
        }
    }

    public function updateDependences($case) {
      
        $traces = $case->getSeguimiento()->toArray();
        $payment = $case->getPagoRealizado()->toArray();
        $details=$case->getDetalles()->toArray();
        foreach ($traces as $trace) {
               if($trace->getVisible())
            $this->saveModel('AGSeguimiento', array('visible' => 0, 'id' => $trace->getId()), array(), false);
        }
        foreach ($payment as $pay) {
            if($pay->getVisible())
            $this->saveModel('AGPagoRealizado', array('visible' => 0, 'id' => $pay->getId()), array(), false);
        }
        foreach ($details as $detail) {
            if($detail->getVisible())
            $this->saveModel('AGDetalle', array('visible' => 0, 'id' => $detail->getId()), array(), false);
        }
    }

    /**
     * @Rest\Post("/api/caso")
     * @Method({"POST","OPTIONS"})
     */
    public function postAction(Request $request) {


        $data = $request->request->all();
        $userRepo = $this->getRepo('AGUsuario');


        $empresa = $this->getRepo('AGEmpresa')->findOneBy(array('tipoCliente' => 3));
        $caseRepo = $this->getRepo('AGCaso');
        $case = $caseRepo->findOneBy(array('nombre' => $data['nombre'], 'visible' => 1));
        if ($case) {
            return new View(array('success' => false, 'error' => 'Ya existe un caso con ese nombre.'), Response::HTTP_OK);
        }
        if (!$empresa) {
            return new View(array('success' => false, 'error' => 'No se ha registrado la empresa rectora.'), Response::HTTP_OK);
        }
        $data['empresaRectora'] = $empresa->getId();
        /* cuando se crea el caso el estado es nuevo */
        $data['estado'] = 1;
        /* insertar el caso y luego los detalles */
        try {

            $userRepo->beginTransaction();
            $save = $this->saveModel('AGCaso', $data, array(), false);
            if ($save['success'] == false) {
                $userRepo->rollback();
                return new View($save, Response::HTTP_OK);
            }
            $features = $data['caracteristicas'];
            foreach ($features as $feature) {
                $feature = (array) $feature;
                $arraySave = array('tipoCasoCaracteristica' => $feature['id'], 'valor' => $feature['valor'], 'caso' => $save['data']['id']);
                $saveDetail = $this->saveModel('AGDetalle', $arraySave, array(), false);
                if ($saveDetail['success'] == false) {
                    $userRepo->rollback();
                    return new View($saveDetail, Response::HTTP_OK);
                }
            }
            $userRepo->commit();
            $mailer = $this->get('manager.email');
            $case = $caseRepo->find($save['data']['id']);
            $mailer->setCase($case);
            $mailer->sendMessage(3);
            return new View($save, Response::HTTP_OK);
        } catch (\Exception $e) {
            $userRepo->rollback();
            $result = $this->manageException($e);
            return new View($result, Response::HTTP_OK);
        }
    }

    /**
     * @Rest\Post("/api/caso/estado")
     * @Method({"POST","OPTIONS"})
     */
    public function changeStatusAction(Request $request) {

        $data = $request->request->all();
        $data['estado'] = 2;
        $userRepo = $this->getRepo('AGUsuario');
        $caseRepo = $this->getRepo('AGCaso');
        $validation = $this->checkState($data);
        if ($validation['success'] == false) {
            return new View($validation, Response::HTTP_OK);
        }

        $user = $this->getUserOfCurrentRequest();

        /* insertar el caso y luego los detalles */
        try {

            $userRepo->beginTransaction();
            $case = $caseRepo->find(@$data['id']);
            if (!$case) {
                $userRepo->rollback();
                return new View(array('success' => false, 'error' => 'Caso no encontrado'), Response::HTTP_OK);
            }
            if ($case->getEstado()->getId() != 1) {
                return new View(array('success' => false, 'error' => 'Solo se permite cambiar el estado a un caso nuevo.'), Response::HTTP_OK);
            }

            $oldState = $case->getEstado()->getId();
            /* Cuando un caso se autoriza se pasa a estado en tramite y se registra el prmier seguimiento */
            if ($case->getEstado()->getId() == 1 && $data['estado'] == 2) {

                $saveTrace = array('nombre' => 'Cambio de estado', 'cambioEstado' => true, 'observacion' =>
                    'Se autoriz&oacute; el caso', 'descripcion' => 'Cambio de estado de nuevo a autorizado.', 'caso' => $data['id'],
                    'responsableSeguimiento' => $user->getId());
                $saveTrace = $this->saveModel('AGSeguimiento', $saveTrace, array(), false);
                if ($saveTrace['success'] == false) {
                    $userRepo->rollback();
                    return new View($saveTrace, Response::HTTP_OK);
                }
            }

            $save = $this->saveModel('AGCaso', $data, array(), false);
            if ($save['success'] == false) {
                $userRepo->rollback();
                return new View($save, Response::HTTP_OK);
            }

            $userRepo->commit();
            $mailer = $this->get('manager.email');
            $case = $caseRepo->find(@$data['id']);
            $mailer->setCase($case);
            $mailer->sendMessage(2);
            return new View($save, Response::HTTP_OK);
        } catch (\Exception $e) {
            $userRepo->rollback();
            $result = $this->manageException($e);
            return new View($result, Response::HTTP_OK);
        }
    }

    /**
     * @Rest\Post("/api/caso/editar")
     * @Method({"POST","OPTIONS"})
     */
    public function putAction(Request $request) {

        $data = $request->request->all();
        $garanted = $this->isGarantedInCurrentRequest('updateAllCase', 'AGCaso');
        $garantedMyCase = $this->isGarantedInCurrentRequest('updateMyCase', 'AGCaso');
        if (!$garanted && !$garantedMyCase) {
            return new View($this->returnDeniedResponse(), Response::HTTP_OK);
        }
        if (!$garanted && $garantedMyCase && !$this->thisCaseIsMy(@$data['id'])) {
            return new View($this->returnDeniedResponse(), Response::HTTP_OK);
        }
        $userRepo = $this->getRepo('AGUsuario');
        $caseRepo = $this->getRepo('AGCaso');
        $case = $caseRepo->findOneBy(array('nombre' => $data['nombre'], 'visible' => 1));
        if ($case && $case->getId() != $data['id']) {
            return new View(array('success' => false, 'error' => 'Ya existe un caso con ese nombre.'), Response::HTTP_OK);
        }
        $validation = $this->checkState($data);
        if ($validation['success'] == false) {
            return new View($validation, Response::HTTP_OK);
        }

        $user = $this->getUserOfCurrentRequest();

        /* insertar el caso y luego los detalles */
        try {

            $userRepo->beginTransaction();
            $case = $caseRepo->find(@$data['id']);
            if (!$case) {
                $userRepo->rollback();
                return new View(array('success' => false, 'error' => 'Caso no encontrado'), Response::HTTP_OK);
            }
            $oldState = $case->getEstado()->getId();
            /* Cuando un caso se autoriza se pasa a estado en tramite y se registra el prmier seguimiento */
            if ($case->getEstado()->getId() == 1 && $data['estado'] == 2) {


                $saveTrace = array('nombre' => 'Cambio de estado', 'cambioEstado' => true, 'observacion' =>
                    'Se autoriz&oacute; el caso', 'descripcion' => 'Cambio de estado de nuevo a autorizado.', 'caso' => $data['id'],
                    'responsableSeguimiento' => $user->getId());
                $saveTrace = $this->saveModel('AGSeguimiento', $saveTrace, array(), false);
                if ($saveTrace['success'] == false) {
                    $userRepo->rollback();
                    return new View($saveTrace, Response::HTTP_OK);
                }
            }
            if ($data['estado'] != $oldState && $data['estado'] > 2 && $data['estado'] < 7) {
                $stateOldName = $this->getRepo('AGEstado')->find($oldState)->getNombre();
                $stateNewName = $this->getRepo('AGEstado')->find($data['estado'])->getNombre();
                $saveTrace = array('nombre' => 'Cambio de estado', 'cambioEstado' => true, 'observacion' =>
                    'Cambio de estado a' . $stateNewName, 'descripcion' => "Cambio de estado de $stateOldName a $stateNewName.", 'caso' => $data['id'],
                    'responsableSeguimiento' => $user->getId());
                $saveTrace = $this->saveModel('AGSeguimiento', $saveTrace, array(), false);
                if ($saveTrace['success'] == false) {
                    $userRepo->rollback();
                    return new View($saveTrace, Response::HTTP_OK);
                }
            }

            $save = $this->saveModel('AGCaso', $data, array(), false);
            if ($save['success'] == false) {
                $userRepo->rollback();
                return new View($save, Response::HTTP_OK);
            }
            $features = $data['detalles'];
            foreach ($features as $feature) {
                $feature = (array) $feature;
                $saveDetail = $this->saveModel('AGDetalle', $feature, array(), false);
                if ($saveDetail['success'] == false) {
                    $userRepo->rollback();
                    return new View($saveDetail, Response::HTTP_OK);
                }
            }
            $userRepo->commit();
            $mailer = $this->get('manager.email');
            $case = $caseRepo->find(@$data['id']);
            $mailer->setCase($case);
            $mailer->sendMessage(2);
            return new View($save, Response::HTTP_OK);
        } catch (\Exception $e) {
            $userRepo->rollback();
            $result = $this->manageException($e);
            return new View($result, Response::HTTP_OK);
        }
    }

    private function checkState($data) {
        if (array_key_exists('estado', $data)) {
            if ($data['estado'] < 6 || $data['estado'] >= 1) {

                $repoCase = $this->getRepo('AGCaso');
                if (!array_key_exists('id', $data)) {
                    return array('success' => false, 'error' => 'No se envi&oacute; el identificador del casos.');
                }
                $case = $repoCase->find($data['id']);
                if ($case == null) {
                    return array('success' => false, 'error' => 'El caso no existe.');
                }
                $oldState = $case->getEstado()->getId();

                if ($oldState > $data['estado']) {

                    return array('success' => false, 'error' => 'No se puede cambiar hacia un estado inferior al actual.');
                }
                $action = 'changeToState';
                if ($data['estado'] > 1) {
                    if ($data['estado'] > 2 && $oldState == 1) {
                        return array('success' => false, 'error' => 'No se puede pasar al estado seleccionado hasta que el caso no sea autorizado.');
                    }
                    $garanted = $this->isGarantedInCurrentRequest($action . $data['estado'], 'AGCaso');
                    if (!$garanted) {
                        return array('success' => false, 'error' => 'No tiene permiso  para cambiar al estado selecionado.');
                    }
                }
                return array('success' => true);
            } else {
                return array('success' => false, 'error' => 'El estado del caso es incorrecto.');
            }
        }
    }

    /**
     * @Rest\Get("/api/caso/{id}")
     * @Method({"GET","OPTIONS"})
     */
    public function getByIdAction($id) {
        return $this->getDataOfModelById('AGCaso', $id);
    }

}
