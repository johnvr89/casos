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

class AGCuentaController extends BaseController
{
    /**
     * @Rest\Get("/api/cuenta")
     * @Method({"GET","OPTIONS"})
     */
    public function getAllAction()
    {
         $garanted = $this->isGarantedInCurrentRequest('getAll', 'AGCuenta');
         $garantedView = $this->isGarantedInCurrentRequest('viewAccount', 'AGCuenta');
        if (!$garanted&&!$garantedView) {
            return new View($this->returnDeniedResponse(), Response::HTTP_OK);
        }
        return new View( $this->getAllDataOfModel('AGCuenta'), Response::HTTP_OK );
    }
    /**
     * @Rest\Get("/api/cuenta/{id}")
     * @Method({"GET","OPTIONS"})
     */
    public function getByIdAction($id)
    {
        return $this->getDataOfModelById('AGCuenta', $id);
    }

    /**
     * @Rest\Post("/api/cuenta/eliminar/{id}")
     * @Method({"POST","OPTIONS"})
     */
    public function deleteAction($id) {

        return new View($this->removeModel('AGCuenta', $id), Response::HTTP_OK);
    }
    
    /**
     * @Rest\Post("/api/cuenta")
     * @Method({"POST","OPTIONS"})
     */
    public function postAction(Request $request) {
        $data = $request->request->all();
        $save = $this->saveModel('AGCuenta', $data);
        return new View($save, Response::HTTP_OK);
    }
    
      /**
     * @Rest\Post("/api/cuenta/editar")
     * @Method({"POST","OPTIONS"})
     */
    public function putAction(Request $request) {
        $data = $request->request->all();
        $save = $this->saveModel('AGCuenta', $data);
        return new View($save, Response::HTTP_OK);
    }
}

