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

class AGTipoCasoCaracteristicaController extends BaseController
{
    /**
     * @Rest\Get("/api/caracteristica")
     * @Method({"GET","OPTIONS"})
     */
    public function getAllByCaseTypeAction(Request $request)
    {
        $repo = $this->getRepo('AGTipoCasoCaracteristica');
        $result = $repo->findBy(array('tipoCaso' => $request->get('tipoCaso'),'visible'=>1));

        return new View($this->normalizeResult('AGTipoCasoCaracteristica',$result), Response::HTTP_OK);
    }

    /**
     * @Rest\Get("/api/caracteristica/{id}")
     * @Method({"GET","OPTIONS"})
     */
    public function getByIdAction($id)
    {
        return $this->getDataOfModelById('AGTipoCasoCaracteristica', $id);
    }

    /**
     * @ApiDoc(
     *  description="Crea un nuevo ciudad",
     *  input="Your\Namespace\Form\Type\YourType",
     *  output="Your\Namespace\Class",
     *     headers={
     *         {
     *             "name"="X-AUTHORIZE-KEY",
     *             "description"="Authorization key",
     *              "required":true
     *         }
     *     }
     * )
     *
     * @Rest\Post("/api/caracteristica")
     * @Method({"POST","OPTIONS"})
     */
    public function postAction(Request $request)
    {
        $data = $request->request->all();
        $save = $this->saveModel('AGTipoCasoCaracteristica', $data);
        return new View($save, Response::HTTP_OK);
    }
    
    /**
     * @Rest\Post("/api/caracteristica/editar")
     * @Method({"POST","OPTIONS"})
     */
    public function putAction(Request $request)
    {
        $data = $request->request->all();
        unset($data['tipoCampo']);
        $save = $this->saveModel('AGTipoCasoCaracteristica', $data);
        return new View($save, Response::HTTP_OK);
    }

    /**
     * @Rest\Post("/api/caracteristica/eliminar/{id}")
     * @Method({"POST","OPTIONS"})
     */
    public function deleteAction($id)
    {
        
        return new View($this->removeModel('AGTipoCasoCaracteristica', $id), Response::HTTP_OK);
    }
}

