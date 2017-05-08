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
use AppBundle\Libs\Decorator\CustomDecorator;

class AGEmpresaController extends BaseController {

    /**
     * @Rest\Get("/api/empresa")
     * @Method({"GET","OPTIONS"})
     */
    public function getAllAction() {

        return new View($this->getAllDataOfModel('AGEmpresa'), Response::HTTP_OK);
    }

    /**
     * @Rest\Get("/api/empresa/rectora")
     * @Method({"GET","OPTIONS"})
     */
    public function getMainCompanyListAction() {

        return new View($this->normalizeResult('AGEmpresa', $this->getRepo('AGEmpresa')->getMainCompanyClient()), Response::HTTP_OK);
    }

    /**
     * @Rest\Get("/api/empresa/consolidado")
     * @Method({"GET","OPTIONS"})
     */
    public function getReportClientCaseAction(Request $request) {
        $garanted = $this->isGarantedInCurrentRequest('listAllCase', 'AGCaso');
        $repoCompany = $this->getRepo('AGCaso');
        $result = null;
        $repoCompany = $this->getRepo('AGEmpresa');
        $client = $request->get('cliente');
        $state = $request->get('estado');
        $lawer = $request->get('responsable');
        $caseType = $request->get('tipocaso');
        $intermediary = $request->get('intermediario');
        $startDate = $request->get('inicio');
        $endDate = $request->get('fin');
        if ($garanted) {
            $result = $repoCompany->getClientCaseReport(true, false, false, $startDate, $endDate, $client, $lawer, $intermediary, $state, $caseType);

            return new View($result, Response::HTTP_OK);
        }
        $garantedMyCase = $this->isGarantedInCurrentRequest('listMyCase', 'AGCaso');
        $garantedIntermediaryCase = $this->isGarantedInCurrentRequest('listIntermediaryCase', 'AGCaso');
        $user = $this->getUserOfCurrentRequest();
        if ($user) {
            if ($garantedMyCase && $garantedIntermediaryCase) {
                $result = $repoCompany->getClientCaseReport(true, false, false, $startDate, $endDate, $client, $user->getId(), $user->getId(), $state, $caseType);
                return new View($this->normalizeResult('AGCaso', $result), Response::HTTP_OK);
            }
            if ($garantedMyCase) {
                $result = $repoCompany->getClientCaseReport(true, false, false, $startDate, $endDate, $client, $user->getId(), $intermediary, $state, $caseType);
                return new View($result, Response::HTTP_OK);
            }
            if ($garantedIntermediaryCase) {
                $result = $repoCompany->getClientCaseReport(true, false, false, $startDate, $endDate, $client, $lawer, $user->getId(), $state, $caseType);
                return new View($result, Response::HTTP_OK);
            }
        }
        return new View($this->returnDeniedResponse(), Response::HTTP_OK);
    }

    /**
     * @Rest\Get("/api/empresa/todosclientes")
     * @Method({"GET","OPTIONS"})
     */
    public function getAllClientAction() {
        $result = $this->getRepo('AGEmpresa')->getAllClient();
        return new View($this->normalizeResult('AGEmpresa', $result), Response::HTTP_OK);
    }

    /**
     * @Rest\Get("/api/empresa/clientes")
     * @Method({"GET","OPTIONS"})
     */
    public function getAllCompanyWithCaseAction() {
        $garanted = $this->isGarantedInCurrentRequest('listAllCase', 'AGCaso');
        $mainCompany = $this->getRepo('AGEmpresa')->getMainCompanyClient();
        if (count($mainCompany) == 0) {
            return new View(array('success' => false, 'error' => 'No se ha insertado una empresa rectora.'), Response::HTTP_OK);
        }
        $mainCompany = $mainCompany[0];
        if ($garanted) {
            $all = $this->getRepo('AGcaso')->getIdOfCaseWithPermision(true, false, false, -1, $mainCompany->getId());
            $result = $this->getRepo('AGCaso')->getAllCompanyWithCase(false, $all);

            return new View($this->normalizeResult('AGEmpresa', $result, CustomDecorator::CLIENT), Response::HTTP_OK);
        }
        $user = $this->getUserOfCurrentRequest();
        $denied = new View($this->returnDeniedResponse(), Response::HTTP_OK);
        if (!$user) {
            return $denied;
        }
        $garantedMyCase = $this->isGarantedInCurrentRequest('listMyCase', 'AGCaso');
        $garantedIntermediaryCase = $this->isGarantedInCurrentRequest('listIntermediaryCase', 'AGCaso');
        if (!$garantedMyCase && !$garantedIntermediaryCase) {
            return $denied;
        }
        $repoCompany = $this->getRepo('AGCaso');
        $ids = $repoCompany->getIdOfCaseWithPermision(false, true, false, $user->getId(), $mainCompany->getId());
        $idsIntermediary = $repoCompany->getIdOfCaseWithPermision(false, false, true, $user->getId(), $mainCompany->getId());
        $ids = array_merge($ids, $idsIntermediary);
        if (count($ids) == 0) {
            return new View(array('success' => true, 'data' => array()), Response::HTTP_OK);
        }
        $result = $this->getRepo('AGCaso')->getAllCompanyWithCase(false, $ids);

        return new View($this->normalizeResult('AGEmpresa', $result, CustomDecorator::CLIENT), Response::HTTP_OK);
    }

    /**
     * @Rest\Get("/api/empresa/reporte")
     * @Method({"GET","OPTIONS"})
     */
    public function getClientForPayment(Request $request) {
        $mainCompany = $this->getRepo('AGEmpresa')->getMainCompanyClient();
        if (count($mainCompany) == 0) {
            return new View(array('success' => false, 'error' => 'No se ha insertado una empresa rectora.'), Response::HTTP_OK);
        }
        $mainCompany = $mainCompany[0];

        $garanted = $this->isGarantedInCurrentRequest('listAllCase', 'AGCaso');


        $repoCompany = $this->getRepo('AGCaso');
        $data = $request->query->all();
        $ids = array();
        if ($garanted) {
            $result = $this->getRepo('AGPagoRealizado')->getClientPaymentOutDate($data['inicio'], $data['fin'], true);
            return new View(array('success' => true, 'data' => $result), Response::HTTP_OK);
        }

        $user = $this->getUserOfCurrentRequest();
        $denied = new View($this->returnDeniedResponse(), Response::HTTP_OK);
        if (!$user) {
            return $denied;
        }
        $garantedMyCase = $this->isGarantedInCurrentRequest('listMyCase', 'AGCaso');
        $garantedIntermediaryCase = $this->isGarantedInCurrentRequest('listIntermediaryCase', 'AGCaso');
        if (!$garantedMyCase && !$garantedIntermediaryCase) {
            return $denied;
        }
        $ids = $repoCompany->getIdOfCaseWithPermision(false, true, false, $user->getId(),$mainCompany->getId());
        $idsIntermediary = $repoCompany->getIdOfCaseWithPermision(false, false, true, $user->getId(),$mainCompany->getId());
        $ids = array_merge($ids, $idsIntermediary);
        if (count($ids) == 0) {
            return new View(array('success' => true, 'data' => array()), Response::HTTP_OK);
        }
        $result = $this->getRepo('AGPagoRealizado')->getClientPaymentOutDate($data['inicio'], $data['fin'], false, $ids);
        return new View(array('success' => true, 'data' => $result), Response::HTTP_OK);
    }

    /**
     * @Rest\Post("/api/empresa/eliminar/{id}")
     * @Method({"POST","OPTIONS"})
     */
    public function deleteAction($id) {
        $company = $this->getRepo('AGEmpresa')->find($id);
        if ($company && $company->getTipoCliente()->getId() == 3) {
            return new View(array('success' => false, 'error' => $this->get('translator')->trans('COMPANYDELETE')), Response::HTTP_OK);
        }
        return new View($this->removeModel('AGEmpresa', $id), Response::HTTP_OK);
    }

    /**
     * @Rest\Post("/api/empresa/editar")
     * @Method({"POST","OPTIONS"})
     */
    public function putAction(Request $request) {

        $data = $request->request->all();
        $data = $data['company'];
        $data = (array) (json_decode($data));

        if ($data['tipoCliente'] == 3) {
            $findCompany = $this->getRepo('AGEmpresa')->findOneBy(array('tipoCliente' => 3));
            if ($findCompany && $findCompany->getId() != $data['id']) {
                return new View(array('success' => false, 'error' => $this->get('translator')->trans('ERRORCOMPANYEXIST')));
            }
        }
        if ($data['tipoCliente'] == 1) {
            $data['razonSocial'] = '';
            $data['representante'] = '';
        }
        $files = $request->files->all();
        $nameFile = null;
        if (count($files) > 0) {
            $saveLogo = $this->get('importfileimage')->moveFile($request, true);
            if ($saveLogo['success'] == false) {
                return new View($saveLogo, Response::HTTP_OK);
            }
            $data['logo'] = $saveLogo['convert'];
            $nameFile = $data['logo'];
        } else {
            unset($data['logo']);
        }

        $save = $this->saveModel('AGEmpresa', $data);
        if ($nameFile) {
            $save['data']['logo'] = '/bundles/app/images/' . $nameFile;
        } else {
            $save['data']['logo'] = null;
        }

        return new View($save, Response::HTTP_OK);
    }

    /**
     * @Rest\Post("/api/empresa")
     * @Method({"POST","OPTIONS"})
     */
    public function postAction(Request $request) {
        $data = $request->request->all();

        $data = $data['company'];
        $data = (array) (json_decode($data));

        if ($data['tipoCliente'] == 3) {
            $findCompany = $this->getRepo('AGEmpresa')->findBy(array('tipoCliente' => 3));
            if ($findCompany) {
                return new View(array('success' => false, 'error' => $this->get('translator')->trans('ERRORCOMPANYEXIST')));
            }
        }
        $files = $request->files->all();
        if (count($files) > 0) {
            $saveLogo = $this->get('importfileimage')->moveFile($request, true);

            if ($saveLogo['success'] == false) {
                return new View($saveLogo, Response::HTTP_OK);
            }
            $data['logo'] = $saveLogo['convert'];
        }

        $save = $this->saveModel('AGEmpresa', $data);
        return new View($save, Response::HTTP_OK);
    }

    /* a partir de aqui caso de uso nuevo de gestionar cliente */

    /**
     * @Rest\Get("/api/empresa/cliente/listar")
     * @Method({"GET","OPTIONS"})
     */
    public function getCompanyClientAction() {

        $user = $this->getUserOfCurrentRequest();
        if ($user) {
            $repoCompany = $this->getRepo('AGEmpresa');
            if ($this->hasRole('Administrador')) {
                return new View($this->normalizeResult('AGempresa', $repoCompany->getAllClientList()), Response::HTTP_OK);
            } else {
                return new View($this->normalizeResult('AGempresa', $repoCompany->getAllClientList(false, $user->getId())), Response::HTTP_OK);
            }
        } else {
            return new View($this->returnSecurityViolationResponse(), Response::HTTP_OK);
        }
    }

    /**
     * @Rest\Post("/api/empresa/cliente/adicionar")
     * @Method({"POST","OPTIONS"})
     */
    public function postClientAction(Request $request) {
        $data = $request->request->all();

        $data = $data['company'];
        $data = (array) (json_decode($data));
        $files = $request->files->all();
        if (count($files) > 0) {
            $saveLogo = $this->get('importfileimage')->moveFile($request, true);

            if ($saveLogo['success'] == false) {
                return new View($saveLogo, Response::HTTP_OK);
            }
            $data['logo'] = $saveLogo['convert'];
        }

        $save = $this->saveModel('AGEmpresa', $data);
        return new View($save, Response::HTTP_OK);
    }

    /**
     * @Rest\Post("/api/empresa/cliente/editar")
     * @Method({"POST","OPTIONS"})
     */
    public function putClientAction(Request $request) {


        $data = $request->request->all();
        $data = $data['company'];
        $data = (array) (json_decode($data));

        if (!($this->hasRole('Administrador')) && !$this->thisClientIsMy($data['id'])) {
            return new View($this->returnDeniedResponse(), Response::HTTP_OK);
        }
        if ($data['tipoCliente'] == 1) {
            $data['razonSocial'] = '';
            $data['representante'] = '';
        }
        $files = $request->files->all();

        if (count($files) > 0) {
            $saveLogo = $this->get('importfileimage')->moveFile($request, true);
            if ($saveLogo['success'] == false) {
                return new View($saveLogo, Response::HTTP_OK);
            }
            $data['logo'] = $saveLogo['convert'];
        } else {
            unset($data['logo']);
        }

        $save = $this->saveModel('AGEmpresa', $data);
        return new View($save, Response::HTTP_OK);
    }

    /**
     * @Rest\Post("/api/empresa/cliente/eliminar/{id}")
     * @Method({"POST","OPTIONS"})
     */
    public function deleteClientAction($id) {
        if (!($this->hasRole('Administrador')) && !$this->thisClientIsMy($id)) {
            return new View($this->returnDeniedResponse(), Response::HTTP_OK);
        }
        $repo=$this->getRepo('AGEmpresa');
        $company = $repo->find($id);
        if ($company && $company->getTipoCliente()->getId() == 3) {
            return new View(array('success' => false, 'error' => $this->get('translator')->trans('COMPANYDELETE')), Response::HTTP_OK);
        }

        try {
            $repo->beginTransaction();
            $result =$this->removeModel('AGEmpresa', $id, array(array('method' => 'updateDependencesCase', 'class' => $this)), array(), false);

            $repo->commit();
            return new View($result, Response::HTTP_OK);
        } catch (\Exception $e) {
            $repo->rollback();
            return new View($this->manageException($e), Response::HTTP_OK);
        }

    }

    public function updateDependencesCase($company){
        $cases=$company->getCasosReales();
        $controller= new AGCasoController();
        $controller->setContainer($this->container);
        foreach($cases as $case){
            $this->removeModel('AGCaso', $case->getId(), array(array('method' => 'updateDependences', 'class' => $controller)), array(), false);
        }

    }

}
