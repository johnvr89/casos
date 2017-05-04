<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use FOS\RestBundle\Controller\Annotations as Rest;
use AppBundle\Libs\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\Users;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class AppController extends BaseController {

    /**
     * @ApiDoc(
     *  description="Create a new User",
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
     * @Rest\Post("/api/token-authentication")
     * @Method({"POST","OPTIONS"})
     */
    public function tokenAuthenticationAction(Request $request) {

        $username = $request->get('username');

        $password = $request->get('password');
        $user = $this->getRepo('AGUsuario')
                ->findOneBy(['username' => $username, 'visible' => 1]);

        if (!$user) {
            return new View(array('success' => false, 'error' => 'Usuario inv&aacute;lido'), Response::HTTP_OK);
        }

        // password check
        if (!$this->get('security.password_encoder')->isPasswordValid($user, $password)) {
            return new View(array('success' => false, 'error' => 'Contraseña incorrecta'), Response::HTTP_OK);
        }

        // Use LexikJWTAuthenticationBundle to create JWT token that hold only information about user name
        $token = $this->get('lexik_jwt_authentication.encoder')
                ->encode(['username' => $user->getUsername()]);
        $result = $this->saveModel('AGUsuario', array('id' => $user->getId(), 'token' => $token));
        if ($result['success'] == false) {
            return new View($result, Response::HTTP_OK);
        }
        return new View(array('success' => true, 'token' => $token, 'nombreinterfaz' => $user->getNombreinterfaz()), Response::HTTP_OK);
    }

    /**
     * @ApiDoc(
     *  description="Create a new User",
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
     * @Rest\Post("/api/session")
     * @Method({"POST","OPTIONS"})
     */
    public function closeSessionAction(Request $request) {
        $token = $request->headers->get('apiKey');

        $user = $this->getRepo('AGUsuario')
                ->findOneBy(['token' => $token]);

        if (!$user) {
            return new View(array('success' => false, 'error' => 'Token inv&aacute;lido', 'code' => 3000), Response::HTTP_OK);
        }


        $result = $this->saveModel('AGUsuario', array('id' => $user->getId(), 'token' => null));
        if ($result['success'] == false) {
            return new View($result, Response::HTTP_OK);
        }
        return new View(array('success' => true), Response::HTTP_OK);
    }

    /**
     * @Rest\Get("/api/logo")
     * @Method({"GET","OPTIONS"})
     */
    public function logoAction() {
        $logo = null;
        $empresa = $this->getRepo('AGEmpresa')->findOneBy(array('tipoCliente' => 3));
        if ($empresa && !empty($empresa->getLogo())) {
            $logo = '/bundles/app/images/' . $empresa->getLogo();
        }
        return new View(array('success' => true, data => array('logo' => $logo)), Response::HTTP_OK);
    }

}
