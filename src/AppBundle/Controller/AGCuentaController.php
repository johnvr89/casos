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
    public function getAllAction(Request $request)
    {
        $session = $request->getSession();
        $intEmpresa = $session->get('idEmpresa');
        try
        {
            $garanted = $this->isGarantedInCurrentRequest('getAll', 'AGCuenta');
            $garantedView = $this->isGarantedInCurrentRequest('viewAccount', 'AGCuenta');
            if(!$garanted && !$garantedView)
            {
                return new View($this->returnDeniedResponse(), Response::HTTP_OK);
            }

            $arrayCuentas = $this->getRepo('AGCuenta')->findBy(array('empresaId' => $intEmpresa, 'visible' => 1));
            return new View($this->normalizeResult('AGCuenta', $arrayCuentas), Response::HTTP_OK);
        }
        catch(\Exception $ex)
        {
            error_log($ex->getMessage());
            return new View(array('success' => false, 'error' => $this->get('translator')->trans('ESYSTEM')));            
        }
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
        $session = $request->getSession();
        $data = $request->request->all();
        $data['empresaId'] = $session->get('idEmpresa');
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

