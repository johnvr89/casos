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

class AGRolController extends BaseController {

    /**
     * @Rest\Get("/api/rol")
     * @Method({"GET","OPTIONS"})
     */
    public function getAllAction() {
        return new View($this->getAllDataOfModel('AGRol'), Response::HTTP_OK);
    }

    /**
     * @Rest\Post("/api/rol/editar")
     * @Method({"Post","OPTIONS"})
     */
    public function putAction(Request $request) {
        $data = $request->request->all();

        $save = $this->saveModel('AGRol', $data);
        return new View($save, Response::HTTP_OK);
    }

    /**
     * @Rest\Get("/api/rol/permisos/{id}")
     * @Method({"GET","OPTIONS"})
     */
    public function getAllPermissionAction($id) {
        return $this->getDataOfModelById('AGRol', $id, ResultDecorator::ACTION_DECORATOR);
    }

    /**
     * @Rest\Post("/api/rol/permisoasignacion")
     * @Method({"POST","OPTIONS"})
     */
    public function updateRolePermissionAction(Request $request) {
        try {
            $data = $request->request->all();
            $repo = $this->getRepo('AGRol');
            if (array_key_exists('idrol', $data) && array_key_exists('idaccion', $data) && array_key_exists('estado', $data) && is_numeric($data['idrol']) && is_numeric($data['idaccion'])) {
                $role = $repo->find($data['idrol']);
                $actions = $role->getAccion()->toArray();
                $ids = array();
                if ($data['estado'] == true) {
                    $ids[] = $data['idaccion'];
                }

                foreach ($actions as $action) {
                    if ($action->getId() != $data['idaccion']) {
                        $ids[] = $action->getId();
                    }
                }

                return new View($this->saveModel('AGRol', array('id' => $data['idrol'], 'accion' => $ids)), Response::HTTP_OK);
            } else {
                return new View($this->returnNullResponse(), Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            return new View($this->manageException($e), Response::HTTP_OK);
        }
    }

    /**
     * @Rest\Get("/api/rol/{id}")
     * @Method({"GET","OPTIONS"})
     */
    public function getByIdAction($id) {
        return $this->getDataOfModelById('AGRol', $id);
    }

    /**
     * @Rest\Post("/api/rol/{id}")
     * @Method({"POST","OPTIONS"})
     */
    public function deleteAction($id) {
        $blackList = array(1, 2, 3, 5, 7);
        if (in_array($id, $blackList)) {
            return new View(array('success' => false, error => 'No se permite eliminar un rol del sistema.'), Response::HTTP_OK);
        }
        return new View($this->removeModel('AGRol', $id), Response::HTTP_OK);
    }

    /**
     * @Rest\Post("/api/rol")
     * @Method({"POST","OPTIONS"})
     */
    public function postAction(Request $request) {
        $data = $request->request->all();

        $save = $this->saveModel('AGRol', $data);
        return new View($save, Response::HTTP_OK);
    }

}
