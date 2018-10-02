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

class DefaultController extends BaseController {

    /**
     * @Rest\Get("/api/homepage")
     * @Method({"GET","OPTIONS"})
     */
    public function indexAction(Request $request)
    {
        $session = $request->getSession();
        $intEmpresaId = $session->get('idEmpresa');

        try
        {

            $repoUser = $this->getRepo('AGUsuario');
            $repoCase = $this->getRepo('AGCaso');
            $repoCompany = $this->getRepo('AGEmpresa');
            $totalUser = 0;
            $totalClient = 0;
            $logo = '';
            //$totalUser = $repoUser->getTotal($intEmpresaId);
            $arrayUser = $repoUser->findBy(array('visible' => 1, 'empresa' => $intEmpresaId));
            $totalUser = count($arrayUser);

            $lastCase = array();
            $totalCase = 0;
            $pendingByPayment = array();
            $garantedAllCase = $this->isGarantedInCurrentRequest('listAllCase', 'AGCaso');

            $user = $this->getUserOfCurrentRequest();
            $empresa = $repoCompany->find($intEmpresaId);
            if($empresa && !empty($empresa->getLogo()))
            {
                $logo = '/bundles/app/images/' . $empresa->getLogo();
            }
            if($user)
            {

                if($this->hasRole('Administrador'))
                {
                    //$totalClient = count($repoCompany->getAllClientList());
                    $arrayEmpresa = $repoCompany->findBy(array('visible' => 1));
                    $totalClient = count($arrayEmpresa);
                }
                else
                {
                    //$totalClient = count($repoCompany->getAllClientList(false, $user->getId()));
                    $arrayEmpresa = $repoCompany->findBy(array('visible' => 1, 'empresaId' => $intEmpresaId));
                    $totalClient = count($arrayEmpresa);
                }
            }

            if($garantedAllCase)
            {

                if($empresa)
                {
                    $pendingByPayment = $this->getRepo('AGPagoRealizado')->getCaseWithPaymentOutDate(true, null, $intEmpresaId);
                    $lastCase = $repoCase->getPermissionCase(true, false, false, -1, $empresa->getId(), true);
                    $totalCase = $repoCase->getTotal($intEmpresaId);
                }
            }
            else
            {
                $garantedMyCase = $this->isGarantedInCurrentRequest('listMyCase', 'AGCaso');
                $garantedIntermediaryCase = $this->isGarantedInCurrentRequest('listIntermediaryCase', 'AGCaso');
                if($user)
                {

                    if($garantedMyCase && $garantedIntermediaryCase)
                    {
                        $lastCase = $repoCase->getPermissionCase(false, true, true, $user->getId(), $empresa->getId(), true);
                        $idsCase = $repoCase->getIdOfCaseWithPermision(false, true, true, $user->getId(), $empresa->getId());
                        $pendingByPayment = $this->getRepo('AGPagoRealizado')->getCaseWithPaymentOutDate(false, $idsCase);
                        $totalCase = count($idsCase);
                    }
                    else if($garantedMyCase)
                    {
                        $lastCase = $repoCase->getPermissionCase(false, true, false, $user->getId(), $empresa->getId(), true);
                        $idsCase = $repoCase->getIdOfCaseWithPermision(false, true, false, $user->getId(), $empresa->getId());
                        $pendingByPayment = $this->getRepo('AGPagoRealizado')->getCaseWithPaymentOutDate(false, $idsCase);

                        $totalCase = count($idsCase);
                    }
                    else if($garantedIntermediaryCase)
                    {
                        $lastCase = $repoCase->getPermissionCase(false, false, true, $user->getId(), $empresa->getId(), true);
                        $idsCase = $repoCase->getIdOfCaseWithPermision(false, false, true, $user->getId(), $empresa->getId());
                        $pendingByPayment = $this->getRepo('AGPagoRealizado')->getCaseWithPaymentOutDate(false, $idsCase);
                        $totalCase = count($idsCase);
                    }
                }
            }

            $data = array();
            $data['logo'] = $logo;
            $data['totalUser'] = $totalUser;
            $data['totalCase'] = $totalCase;
            $data['totalClient'] = $totalClient;
            $data['lastCase'] = $this->normalizeResult('AGCaso', $lastCase)['data'];
            $data['pendingByPayment'] = $pendingByPayment;
            return new View(array('success' => true, 'data' => $data), Response::HTTP_OK);
        }
        catch(\Exception $ex)
        {
            $strError = $ex->getMessage();
            error_log($strError);
            return new View(array('success' => false, 'error' => $this->get('translator')->trans('ESYSTEM')));
        }
    }

}
