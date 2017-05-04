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

class AGTipoClienteController extends BaseController {

    /**
     * @Rest\Get("/api/tipocliente")
     * @Method({"GET","OPTIONS"})
     */
    public function getAllAction() {
        return new View($this->getAllDataOfModel('AGTipoCliente'), Response::HTTP_OK);
    }

    /**
     * @Rest\Get("/api/tipocliente/empresarectora")
     * @Method({"GET","OPTIONS"})
     */
    public function getTypeMainCompanyAction() {
        return new View($this->normalizeResult('AGTipoCliente',$this->getRepo
                ('AGTipoCliente')->getByType()), Response::HTTP_OK);
    }
     /**
     * @Rest\Get("/api/tipocliente/empresacliente")
     * @Method({"GET","OPTIONS"})
     */
    public function getTypeClientCompanyAction() {
        return new View($this->normalizeResult('AGTipoCliente',$this->getRepo
                ('AGTipoCliente')->getByType(array(1,2))), Response::HTTP_OK);
    }

}
