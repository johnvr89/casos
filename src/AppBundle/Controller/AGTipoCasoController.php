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

class AGTipoCasoController extends BaseController {

    /**
     * @Rest\Get("/api/tipocaso")
     * @Method({"GET","OPTIONS"})
     */
    public function getAllAction() {
        $garanted = $this->isGarantedInCurrentRequest('getAll', 'AGTipoCaso');
        $garantedView = $this->isGarantedInCurrentRequest('viewCaseType', 'AGTipoCaso');
        if (!$garanted && !$garantedView) {
            return new View($this->returnDeniedResponse(), Response::HTTP_OK);
        }
        return new View($this->getAllDataOfModel('AGTipoCaso'), Response::HTTP_OK);
    }

    /**
     * @Rest\Post("/api/tipocaso/eliminar/{id}")
     * @Method({"POST","OPTIONS"})
     */
    public function deleteAction($id) {
        $repoCaseType = $this->getRepo('AGTipoCaso');
        $caseType = $repoCaseType->find($id);
        if (!$caseType) {
            return new View($this->returnNullResponse(), Response::HTTP_OK);
        }
        if (($caseType->hasCase())) {
            return new View(array('success' => false, 'error' => 'El tipo de caso que intenta eliminar tiene casos asociados.'), Response::HTTP_OK);
        }

        $repo = $this->getRepo('AGTipoCaso');
        try {
            $repo->beginTransaction();
            $result = $this->removeModel('AGTipoCaso', $id, array(array('method' => 'updateDependences', 'class' => $this)), array(), false);

            $repo->commit();
            return new View($result, Response::HTTP_OK);
        } catch (\Exception $e) {
            $repo->rollback();
            return new View($this->manageException($e), Response::HTTP_OK);
        }
    }

    public function updateDependences($caseType) {

        $features = $caseType->getTipoCasoCaracteristica()->toArray();

        foreach ($features as $feature) {
            if ($feature->getVisible()) {
                $this->saveModel('AGTipoCasoCaracteristica', array('visible' => 0, 'id' => $feature->getId()), array(), false);
                $details = $feature->getDetalle()->toArray();
                foreach ($details as $detail) {
                    $this->saveModel('AGDetalle', array('visible' => 0, 'id' => $detail->getId()), array(), false);
                }
            }
        }
    }

    /**
     * @Rest\Post("/api/tipocaso/editar")
     * @Method({"Post","OPTIONS"})
     */
    public function putAction(Request $request) {
        $data = $request->request->all();
        $save = $this->saveModel('AGTipoCaso', $data);
        return new View($save, Response::HTTP_OK);
    }

    /**
     * @Rest\Get("/api/tipocaso/{id}")
     * @Method({"GET","OPTIONS"})
     */
    public function getByIdAction($id) {
        return $this->getDataOfModelById('AGTipoCaso', $id);
    }

    /**
     * @Rest\Post("/api/tipocaso")
     * @Method({"POST","OPTIONS"})
     */
    public function postAction(Request $request) {
        $data = $request->request->all();
        $save = $this->saveModel('AGTipoCaso', $data);
        return new View($save, Response::HTTP_OK);
    }

}
