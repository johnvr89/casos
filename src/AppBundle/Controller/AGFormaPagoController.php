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

class AGFormaPagoController extends BaseController {

    /**
     * @Rest\Get("/api/formapago")
     * @Method({"GET","OPTIONS"})
     */
    public function getAllAction() {

        return new View($this->getAllDataOfModel('AGFormaPago'), Response::HTTP_OK);
    }


}
