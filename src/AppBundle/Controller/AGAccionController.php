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

class AGAccionController extends BaseController {

    /**
     * @Rest\Get("/api/acciones")
     * @Method({"GET","OPTIONS"})
     */
    public function getAllAction() {

        $repo = $this->getRepo('AGAccion');
        $result = $repo->findBy(array(), array('controlador' => 'ASC', 'posicion' => 'ASC'));

        return new View($this->normalizeResult('AGAccion', $result), Response::HTTP_OK);
    }

    /**
     * @Rest\Post("/api/acciones")
     * @Method({"POST","OPTIONS"})
     */
    public function putAction(Request $request) {
        $data = $request->request->all();
        $dataUpdate = array();
        $dataUpdate['id'] = $data['id'];
        $dataUpdate['descripcion'] = $data['descripcion'];
        $dataUpdate['alias'] = $data['alias'];
        $save = $this->saveModel('AGAccion', $dataUpdate);
        return new View($save, Response::HTTP_OK);
    }

    /**
     * @Rest\Post("/api/acciones/post")
     * @Method({"POST","OPTIONS"})
     */
    public function postAction(Request $request) {
        $data = $request->request->all();
        $repoAcction = $this->getRepo('AGAccion');
        $findByAlias = $repoAcction->findOneBy(array('alias' => $data['alias'], 'controlador' => $data['controlador']));
        if ($findByAlias) {
            return new View(array('success'=>false,'error'=>'Ya existe un permiso con ese alias en el mismo controlador'), Response::HTTP_OK);
        }
        $findByName = $repoAcction->findOneBy(array('nombre' => $data['nombre'], 'controlador' => $data['controlador']));
        if ($findByName) {
            return new View(array('success'=>false,'error'=>'Ya existe un permiso con ese nombre en el mismo controlador'), Response::HTTP_OK);
        }
        $save = $this->saveModel('AGAccion', $data);
        return new View($save, Response::HTTP_OK);
    }

}
