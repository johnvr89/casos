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

class AGPagoRealizadoController extends BaseController {

    /**
     * @Rest\Get("/api/pagorealizado")
     * @Method({"GET","OPTIONS"})
     */
    public function getAllAction() {
        $garantedAll = $this->isGarantedInCurrentRequest('listAllPayment', 'AGPagoRealizado');

        if ($garantedAll) {
            $result = $this->getRepo('AGPagoRealizado')->findBy(array(), array('fechaProximoCobro' => 'DESC'));
            return new View($this->normalizeResult('AGPagoRealizado', $result), Response::HTTP_OK);
        }
        $user = $this->getUserOfCurrentRequest();
        if (!$user) {
            return new View($this->returnDeniedResponse(), Response::HTTP_OK);
        }

        $garantedMyPayment = $this->isGarantedInCurrentRequest('listMyCasePayment', 'AGPagoRealizado');
        if ($garantedMyPayment) {
            $result = $this->getRepo('AGPagoRealizado')->getResosurces($user->getToken());
            return new View($this->normalizeResult('AGPagoRealizado', $result), Response::HTTP_OK);
        }
        return new View($this->returnDeniedResponse(), Response::HTTP_OK);
    }

    /**
     * @Rest\Get("/api/pagosatrazados")
     * @Method({"GET","OPTIONS"})
     */
    public function getAllOutDateAction() {
        $garantedAll = $this->isGarantedInCurrentRequest('listAllPaymentOutDate', 'AGPagoRealizado');

        if ($garantedAll) {
            $result = $this->getRepo('AGPagoRealizado')->getPaymentOutDate(true);
            return new View($this->normalizeResult('AGPagoRealizado', $result), Response::HTTP_OK);
        }
        $mainCompany = $this->getRepo('AGEmpresa')->getMainCompanyClient();
        if (count($mainCompany) == 0) {
            return new View(array('success' => false, 'error' => 'No se ha insertado una empresa rectora.'), Response::HTTP_OK);
        }
        $mainCompany = $mainCompany[0];
        $user = $this->getUserOfCurrentRequest();
        if (!$user) {
            return new View($this->returnDeniedResponse(), Response::HTTP_OK);
        }

        $garantedMyPayment = $this->isGarantedInCurrentRequest('listMyCasePaymentOutDate', 'AGPagoRealizado');

        if ($garantedMyPayment) {
            $idsCase = $this->getRepo('AGCaso')->getIdOfCaseWithPermision(false, true, false, $user->getId(),$mainCompany->getId());
            $idsCaseIntermediary = $this->getRepo('AGCaso')->getIdOfCaseWithPermision(false, false, true, $user->getId(),$mainCompany->getId());
            $idsCase = array_merge($idsCase, $idsCaseIntermediary);
            $result = $this->getRepo('AGPagoRealizado')->getPaymentOutDate(false, $idsCase);
            return new View($this->normalizeResult('AGPagoRealizado', $result), Response::HTTP_OK);
        }
        return new View($this->returnDeniedResponse(), Response::HTTP_OK);
    }

    /**
     * @Rest\Get("/api/pagorealizado/caso")
     * @Method({"GET","OPTIONS"})
     */
    public function getAllByCaseAction(Request $request) {
        /* si tiene permiso para listar todos los pagos pasa ssi tiene permiso para
         *  listar los pagos de mis casos y el id de caso es mio pasa */

        $garantedAll = $this->isGarantedInCurrentRequest('listAllPayment', 'AGPagoRealizado');
        $garantedMyPayment = $this->isGarantedInCurrentRequest('listMyCasePayment', 'AGPagoRealizado');

        if ($garantedAll || ($garantedMyPayment && $this->thisCaseIsMy($request->get('caso')))) {
            $repo = $this->getRepo('AGPagoRealizado');
            $result = $repo->findBy(array('caso' => $request->get('caso'),'visible'=>1), array("id" => "DESC"));

            return new View($this->normalizeResult('AGPagoRealizado', $result), Response::HTTP_OK);
        }

        return new View($this->returnDeniedResponse(), Response::HTTP_OK);
    }

    /**
     * @Rest\Get("/api/pagorealizado/{id}")
     * @Method({"GET","OPTIONS"})
     */
    public function getByIdAction($id) {
        return $this->getDataOfModelById('AGPagoRealizado', $id);
    }

    /**
     * @Rest\Get("/api/pagorealizado/caso")
     * @Method({"POST","OPTIONS"})
     */
    public function postAction(Request $request) {
        /* addPaymentToAllCase si esta ese permiso pasa si no addPaymentToMyCase 
         * Si lo tiene se veifica si el caso es creado por el usuario */
        $data = $request->request->all();
        $data = $data['payment'];
        $data = (array) (json_decode($data));
        $files = $request->files->all();
        if (array_key_exists('caso', $data) && is_numeric($data['caso'])) {
            $repoCase = $this->getRepo('AGCaso');
            $case = $repoCase->find($data['caso']);
            if (!$case) {
                return new View(array('success' => false, 'error' => 'No se encontr&oacute; el caso al que desea registrarle el pago.'), Response::HTTP_OK);
            } else {

                $garantedAll = $this->isGarantedInCurrentRequest('addPaymentToAllCase', 'AGPagoRealizado');
                $garantedMyPayment = $this->isGarantedInCurrentRequest('addPaymentToMyCase', 'AGPagoRealizado');
                if (!$garantedAll && !$garantedMyPayment) {
                    return new View($this->returnDeniedResponse(), Response::HTTP_OK);
                }

                if (!$garantedAll && $garantedMyPayment) {
                    if (!$this->thisCaseIsMy($data['caso'])) {
                        return new View($this->returnDeniedResponse(), Response::HTTP_OK);
                    }
                }
                $state = $case->getEstado()->getId();
                if ($state == 1) {
                    return new View(array('success' => false, 'error' => 'El caso no se encuentra autorizado'), Response::HTTP_OK);
                }
                if ($state > 4) {
                    return new View(array('success' => false, 'error' => 'El pago que desea registrar no se puede procesar porque el caso se encuentra en un estado que no lo permite.'), Response::HTTP_OK);
                }
                $totalPayment = $case->getDineroPagado();
                if (($case->getHonorarios() < $data['valorPagado'])) {
                    return new View(array('success' => false, 'error' => 'El valor a pagar debe de ser menor o igual que ' . $case->getHonorarios()), Response::HTTP_OK);
                }
                if (($totalPayment + $data['valorPagado'] >= $case->getHonorarios() ) && $data['tipoCobro'] != 2) {
                    return new View(array('success' => false, 'error' => 'La suma de los pagos realizados supera los honorarios del caso y el tipo de cobro debe de ser final.'), Response::HTTP_OK);
                }
                if ($data['tipoCobro'] == 1 && empty($data['fechaProximoCobro'])) {
                    return new View(array('success' => false, 'error' => 'La fecha del pr&oacute;ximo cobro es requerida'), Response::HTTP_OK);
                }
                if ($data['tipoCobro'] == 2 && ($data['valorPagado'] + $totalPayment) < $case->getHonorarios() && $data['confirm'] == 0) {
                    return new View(array('success' => false, 'error' => 'No se encontr&oacute; la confirmaci&oacute;n de cierre del caso'), Response::HTTP_OK);
                }

                if ($data['tipoCobro'] == 2) {
                    unset($data['fechaProximoCobro']);
                }
                $data['pagoFinal'] = ($data['tipoCobro'] == 2);
            }try {
                $repoCase->beginTransaction();
                $saveDoc = array('nombre' => '', 'url' => '');
                $saveUseCase = array('success' => true);
                if ($data['tipoCobro'] == 2) {
                    $saveUseCase = $this->saveModel('AGCaso', array('id' => $case->getId(), 'estado' => 5));
                }
                $save = $this->saveModel('AGPagoRealizado', $data, array(), false);
                if (count($files) > 0) {
                    $saveDoc = $this->get('importfileimage')->moveFile($request, true, true);

                    if ($saveDoc['success'] == false) {
                        $repoCase->rollback();
                        return new View($saveDoc, Response::HTTP_OK);
                    }
                    $saveDoc['nombre'] = $saveDoc['originalName'];
                    $saveDoc['url'] = '/bundles/app/docs/' . $saveDoc['convert'];
                    $saveDoc['pago'] = $save['data']['id'];
                    $result = $this->saveModel('AGDocumento', $saveDoc, array(), false);
                    if ($result['success'] == false) {
                        $repoCase->rollback();
                        return new View($result, Response::HTTP_OK);
                    }
                }
                $repoCase->commit();
                if ($save['success'] == false || $saveUseCase['success'] == false) {
                    $repoCase->rollback();
                    return new View($save['success'] == false ? $save : $saveUseCase, Response::HTTP_OK);
                }

                $mailer = $this->get('manager.email');
                $repoPayment = $this->getRepo('AGPagoRealizado')->find($save['data']['id']);

                $mailer->setPayment($repoPayment);
                $mailer->sendMessage(1);
                return new View($save, Response::HTTP_OK);
            } catch (\Exception $exc) {
                $repoCase->rollback();
                return new View($this->manageException($exc), Response::HTTP_OK);
            }
        } else {
            return new View(array('success' => false, 'error' => 'No se encontr&oacute; el identificador del caso'), Response::HTTP_OK);
        }
    }

    /**
     * @Rest\Post("/api/pagorealizado/caso/editar")
     * @Method({"POST","OPTIONS"})
     */
    public function putAction(Request $request) {
        /* updatePaymentToAllCase si esta ese permiso pasa si no updatePaymentToMyCase 
         * Si lo tiene se verifica si el caso es creado por el usuario */
        $data = $request->request->all();

        $data = $data['payment'];
        $data = (array) (json_decode($data));
        if (!array_key_exists('id', $data)) {
            return new View(array('success' => false, 'error' => 'Par&aacute;metro id requerido'), Response::HTTP_OK);
        }
        if (!is_numeric($data['id'])) {
            return new View(array('success' => false, 'error' => 'Par&aacute;metro id en formato incorrecto'), Response::HTTP_OK);
        }
        $repoPayment = $this->getRepo('AGPagoRealizado');
        $payment = $repoPayment->find($data['id']);
        if (!$payment) {
            return new View($this->returnNullResponse(), Response::HTTP_OK);
        }
        /* validar que si se va a cambiar a estado a final y delante de el hay mas pagos no se puede cambiar a ese estado */
        $case = $payment->getCaso();
        $garantedAll = $this->isGarantedInCurrentRequest('updatePaymentToAllCase', 'AGPagoRealizado');
        $garantedMyPayment = $this->isGarantedInCurrentRequest('updatePaymentToMyCase', 'AGPagoRealizado');
        if (!$garantedAll && !$garantedMyPayment) {
            return new View($this->returnDeniedResponse(), Response::HTTP_OK);
        }

        if (!$garantedAll && $garantedMyPayment) {
            if (!$this->thisCaseIsMy($case->getId())) {
                return new View($this->returnDeniedResponse(), Response::HTTP_OK);
            }
        }


        $state = $case->getEstado()->getId();
        if ($state == 1) {
            return new View(array('success' => false, 'error' => 'El caso no se encuentra autorizado'), Response::HTTP_OK);
        }
        if ($state > 4) {
            return new View(array('success' => false, 'error' => 'El pago que desea actualizar no se puede procesar porque el caso se encuentra en un estado que no lo permite.'), Response::HTTP_OK);
        }


        $payments = $case->getPagoRealizado()->toArray();
        $totalPayments = count($payments);
        $lastPayment = $payments[$totalPayments - 1];


        if ($totalPayments > 0 && $lastPayment->getId() != $data['id'] && $data['tipoCobro'] == 2) {
            return new View(array('success' => false, 'error' => 'No se puede cambiar el tipo de pago si no es el &uacute;ltimo pago.'), Response::HTTP_OK);
        }
        $totalPayment = $case->getDineroPagado();
        if (($case->getHonorarios() < $data['valorPagado'])) {
            return new View(array('success' => false, 'error' => 'El valor a pagar debe de ser menor o igual que ' . $case->getHonorarios()), Response::HTTP_OK);
        }
        if (($totalPayment + $data['valorPagado'] - $payment->getValorPagado() >= $case->getHonorarios() ) && $data['tipoCobro'] != 2) {
            return new View(array('success' => false, 'error' => 'La suma de los pagos realizados supera los honorarios del caso y el tipo de cobro debe de ser final.'), Response::HTTP_OK);
        }
        if ($data['tipoCobro'] == 1 && empty($data['fechaProximoCobro'])) {
            return new View(array('success' => false, 'error' => 'La fecha del pr&oacute;ximo cobro es requerida'), Response::HTTP_OK);
        }
        if ($payment->getTipoCobro()->getId() != 2 && $data['tipoCobro'] == 2 && ($data['valorPagado'] + $totalPayment - $payment->getValorPagado()) < $case->getHonorarios() && $data['confirm'] == 0) {
            return new View(array('success' => false, 'error' => 'No se encontr&oacute; la confirmaci&oacute;n de cierre del caso'), Response::HTTP_OK);
        }

        if ($data['tipoCobro'] == 2) {
            unset($data['fechaProximoCobro']);
        }
        $data['pagoFinal'] = ($data['tipoCobro'] == 2);
        try {
            $repoPayment->beginTransaction();
            $saveUseCase = array('success' => true);
            if ($data['tipoCobro'] == 2 && $payment->getTipoCobro()->getId() != 2) {
                $saveUseCase = $this->saveModel('AGCaso', array('id' => $case->getId(), 'estado' => 5), array(), false);
            }
            $save = $this->saveModel('AGPagoRealizado', $data, array(), false);

            $repoDocument = $this->getRepo('AGDocumento');
            $doc = $repoDocument->findOneBy(array('pago' => $save['data']['id']));
            $oldUrl = '';
            if ($doc) {
                $oldUrl = $doc->getUrl();
            }
            $files = $request->files->all();
            if (count($files) > 0) {


                $saveDoc = $this->get('importfileimage')->moveFile($request, true, true);

                if ($saveDoc['success'] == false) {
                    $repoPayment->rollback();
                    return new View($saveDoc, Response::HTTP_OK);
                }
                $saveDoc['nombre'] = $saveDoc['originalName'];
                $saveDoc['url'] = '/bundles/app/docs/' . $saveDoc['convert'];
                $saveDoc['pago'] = $save['data']['id'];
                if ($doc) {
                    $saveDoc['id'] = $doc->getId();
                }

                $result = $this->saveModel('AGDocumento', $saveDoc, array(), false);
                if ($result['success'] == false) {
                    $repoPayment->rollback();
                    return new View($result, Response::HTTP_OK);
                } else {
                    if ($oldUrl) {
                        $unlink = $this->getParameter('kernel.root_dir') . '/../web' . $oldUrl;
                        @unlink($unlink);
                    }
                }
            }

            $repoPayment->commit();
            if ($save['success'] == false || $saveUseCase['success'] == false) {
                $repoPayment->rollback();
                return new View($save['success'] == false ? $save : $saveUseCase, Response::HTTP_OK);
            }
            $mailer = $this->get('manager.email');
            $payment = $this->getRepo('AGPagoRealizado')->find($save['data']['id']);

            $mailer->setPayment($payment);
            $mailer->sendMessage(4);
            return new View($save, Response::HTTP_OK);
        } catch (\Exception $exc) {
            $repoPayment->rollback();
            return new View($this->manageException($exc), Response::HTTP_OK);
        }
    }

    /**
     * @Rest\Post("/api/pagorealizado/caso/eliminar/{id}")
     * @Method({"POST","OPTIONS"})
     */
    public function deleteAction($id) {
        /* deletePaymentToAllCase si esta ese permiso pasa si no deletePaymentToMyCase 
         * Si lo tiene se verifica si el caso es creado por el usuario */
        $repoPayment = $this->getRepo('AGPagoRealizado');
        $payment = $repoPayment->find($id);
        if (!$payment) {
            return new View($this->returnNullResponse(), Response::HTTP_OK);
        }
        $case = $payment->getCaso();
        $garantedAll = $this->isGarantedInCurrentRequest('deletePaymentToAllCase', 'AGPagoRealizado');
        $garantedMyPayment = $this->isGarantedInCurrentRequest('deletePaymentToMyCase', 'AGPagoRealizado');
        if (!$garantedAll && !$garantedMyPayment) {
            return new View($this->returnDeniedResponse(), Response::HTTP_OK);
        }

        if (!$garantedAll && $garantedMyPayment) {
            if (!$this->thisCaseIsMy($case->getId())) {
                return new View($this->returnDeniedResponse(), Response::HTTP_OK);
            }
        }

        $state = $case->getEstado()->getId();

        if ($state > 4) {
            return new View(array('success' => false, 'error' => 'El pago que desea eliminar  no se puede procesar porque el caso se encuentra en un estado que no lo permite.'), Response::HTTP_OK);
        }

        /* si el pago es de tipo cierre no debe dejar eliminar porque
         *  provocaria que el caso cerrado se deba cambiar */
        if ($payment->getTipoCobro()->getId() == 2) {
            return new View(array('success' => false, 'error' => 'No se puede eliminar un pago con tipo de cobro Final.'), Response::HTTP_OK);
        }
        return new View($this->removeModel('AGPagoRealizado', $id), Response::HTTP_OK);
    }

    /**
     * @Rest\Get("/api/pagorealizado/pdf/{id}")
     * @Method({"GET","OPTIONS"})
     */
    public function generatePDFAction($id) {


        $repoPayment = $this->getRepo('AGPagoRealizado');
        $payment = $repoPayment->find($id);
        if (!$payment) {
            return new View($this->returnNullResponse(), Response::HTTP_OK);
        }


        $garantedAll = $this->isGarantedInCurrentRequest('listAllPayment', 'AGPagoRealizado');
        $garantedMyPayment = $this->isGarantedInCurrentRequest('listMyCasePayment', 'AGPagoRealizado');
        if (!$garantedAll && !$garantedMyPayment) {
            return new View($this->returnDeniedResponse(), Response::HTTP_OK);
        }
        $user = $this->getUserOfCurrentRequest();
        if (!$user) {
            return new View($this->returnDeniedResponse(), Response::HTTP_OK);
        }
        $case = $payment->getCaso();
        if (!$garantedAll && $garantedMyPayment && !$this->thisCaseIsMy($case->getId())) {
            return new View($this->returnDeniedResponse(), Response::HTTP_OK);
        }
        $mainCompany = $this->getRepo('AGEmpresa')->findOneBy(array('tipoCliente' => 3));
        if (!$mainCompany) {
            return new View(array('success' => false, 'error' => 'No se encontr&oacute; la empresa rectora.'), Response::HTTP_OK);
        }
        $html = $this->renderView(
                'AppBundle:Default:payment.html.twig', array(
            'caso' => $case, 'empresa' => $mainCompany, 'empresaCliente' => $case->getEmpresa(), 'payment' => $payment,
                )
        );

        $pdf = $this->get("white_october.tcpdf")->create('vertical', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetAuthor($mainCompany->getNombre());
        $pdf->SetTitle(('pago del caso' . $case->getNombre()));
        //  $pdf->SetSubject('Our Code World Subject');
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('helvetica', '', 11, '', true);
        //$pdf->SetMargins(20,20,40, true);
        $pdf->AddPage();
        $file = uniqid();
        $filename = $this->getParameter('kernel.root_dir') . '/../web/bundles/app/docs/generatepdf/' . $file;

        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
        $pdf->Output($filename . ".pdf", 'F');
        return new View(array('success' => true, 'file' => '/bundles/app/docs/generatepdf/' . $file . '.pdf'), Response::HTTP_OK);
    }

}
