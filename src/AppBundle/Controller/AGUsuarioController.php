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
use AppBundle\Libs\Normalizer\ResultDecorator;

class AGUsuarioController extends BaseController {

    /**
     * @Rest\Get("/api/usuario")
     * @Method({"GET","OPTIONS"})
     */
    public function getNotLoguedAction(Request $request) {
        /* verificar si tiene getAll */
        $token = $request->headers->get('apiKey');
        $repoUser = $this->getRepo('AGUsuario');
        return new View($this->normalizeResult('AGUsuario', $repoUser->findAllNotLoged($token)), Response::HTTP_OK);
    }

    /**
     * @Rest\Get("/api/usuario/listar")
     * @Method({"GET","OPTIONS"})
     */
    public function getAllAction() {

        return new View($this->getAllDataOfModel('AGUsuario'), Response::HTTP_OK);
    }

    /**
     * @Rest\Get("/api/usuario/intermediario")
     * @Method({"GET","OPTIONS"})
     */
    public function getAllIntermediaryAction(Request $request) {
        $session = $request->getSession();
        $idEmpresa = $session->get('idEmpresa');
        try
        {
            $repoUser = $this->getRepo('AGUsuario');
            $result = $repoUser->findUsersForRol('Intermediario', $idEmpresa);         
            $res = array('success' => true, 'data' => $result);
        }
        catch(\Exception $e)
        {
            $result = $e->getMessage();
            $res = array('success' => false, 'data' => $result);
        }
        return new View($res, Response::HTTP_OK);
    }
    
     /**
     * @Rest\Get("/api/usuario/abogado")
     * @Method({"GET","OPTIONS"})
     */
    public function getAllLawerAction(Request $request) {
        $session = $request->getSession();
        $idEmpresa = $session->get('idEmpresa');        
        try
        {
            $repoUser = $this->getRepo('AGUsuario');
            $result = $repoUser->findUsersForRol('Abogado', $idEmpresa);         
            $res = array('success' => true, 'data' => $result);
        }
        catch(\Exception $e)
        {
            $result = $e->getMessage();
            $res = array('success' => false, 'data' => $result);
        }
        return new View($res, Response::HTTP_OK);
    }

    /**
     * @Rest\Get("/api/usuario/token")
     * @Method({"GET","OPTIONS"})
     */
    public function getUserByTokenAction(Request $request) {
        try {
            $token = $request->headers->get('apiKey');
            $userRepo = $this->getRepo('AGUsuario');
            $user = $userRepo->findOneBy(array('token' => $token,'visible'=>1));
            return new View($this->normalizeResult('AGUsuario', $user, ResultDecorator::USER_COMPANY), Response::HTTP_OK);
        } catch (\Exception $e) {
            $result = $this->manageException($e);
            return new View($result, Response::HTTP_OK);
        }
    }

    /**
     * @Rest\Get("/api/usuario/{id}")
     * @Method({"GET","OPTIONS"})
     */
    public function getByIdAction($id) {
        return $this->getDataOfModelById('AGUsuario', $id);
    }

    /**
     * @Rest\Post("/api/usuario/eliminar/{id}")
     * @Method({"POST","OPTIONS"})
     */
    public function deleteAction($id) {

        return new View($this->removeModel('AGUsuario', $id), Response::HTTP_OK);
    }

    /**
     * @Rest\Post("/api/usuario")
     * @Method({"POST","OPTIONS"})
     */
    public function postAction(Request $request) {
        $data = $request->request->all();
        $empresa = $this->getRepo('AGEmpresa')->findOneBy(array('tipoCliente' => 3));
        if (!$empresa) {
            return new View(array('success' => false, 'error' => 'No se ha registrado la empresa rectora.'), Response::HTTP_OK);
        }
        $data['empresa'] = $empresa->getId();
        $save = $this->saveModel('AGUsuario', $data);
        return new View($save, Response::HTTP_OK);
    }

    /**
     * @Rest\Post("/api/usuario/editar")
     * @Method({"POST","OPTIONS"})
     */
    public function putAction(Request $request) {
        $data = $request->request->all();
        $save = $this->saveModel('AGUsuario', $data);
        return new View($save, Response::HTTP_OK);
    }

    /**
     * @Rest\Post("/api/usuario/rolasignacion")
     * @Method({"POST","OPTIONS"})
     */
    public function updateUserRoleAction(Request $request) {
        try {
            $data = $request->request->all();
            $repo = $this->getRepo('AGUsuario');
            if (array_key_exists('idusuario', $data) && array_key_exists('idrol', $data) && array_key_exists('estado', $data) && is_numeric($data['idusuario']) && is_numeric($data['idrol'])) {
                $user = $repo->find($data['idusuario']);
                $roles = $user->getRoles();
                $ids = array();
                if ($data['estado'] == true) {
                    $ids[] = $data['idrol'];
                }

                foreach ($roles as $role) {
                    if ($role->getId() != $data['idrol']) {
                        $ids[] = $role->getId();
                    }
                }

                return new View($this->saveModel('AGUsuario', array('id' => $data['idusuario'], 'roles' => $ids)), Response::HTTP_OK);
            } else {
                return new View($this->returnNullResponse(), Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            return new View($this->manageException($e), Response::HTTP_OK);
        }
    }

    /**
     * @Rest\Get("/api/usuario/roles/{id}")
     * @Method({"GET","OPTIONS"})
     */
    public function getUserAllRolesAction($id) {
        return $this->getDataOfModelById('AGUsuario', $id, ResultDecorator::ROLES_DECORATOR);
    }

    /**
     * @Rest\Post("/api/usuario/cambiarcontraseña")
     * @Method({"POST","OPTIONS"})
     */
    public function changePasswordAction(Request $request) {
        $user = $this->getUserOfCurrentRequest();
        if (!$user) {
            return new View($this->returnDeniedResponse(), Response::HTTP_OK);
        }
        $oldPassword = $request->request->get('oldPassword');
        $newPassword = $request->request->get('newPassword');
        $confirmPassword = $request->request->get('confirmPassword');

        if (empty($oldPassword)) {
            return new View(array('success' => false, 'error' => 'La contraseña antigua no puede ser vacia.'), Response::HTTP_OK);
        }
        if (empty($newPassword)) {
            return new View(array('success' => false, 'error' => 'La nueva contraseña no puede ser vac&iacute;a.'), Response::HTTP_OK);
        }
        if (empty($confirmPassword)) {
            return new View(array('success' => false, 'error' => 'La contraseña de confirmaci&oacute;n  no puede ser vacia.'), Response::HTTP_OK);
        }
        if (!$this->get('security.password_encoder')->isPasswordValid($user, $oldPassword)) {
            return new View(array('success' => false, 'error' => 'La contraseña antigua es incorrecta.'), Response::HTTP_OK);
        }
        if ($newPassword != $confirmPassword) {
            return new View(array('success' => false, 'error' => 'La nueva contraseña y la confirmaci&oacute;n no coinciden.'), Response::HTTP_OK);
        }
        if ($newPassword == $oldPassword) {
            return new View(array('success' => false, 'error' => 'La nueva contraseña y la antigua son iguales.'), Response::HTTP_OK);
        }
        $token = $this->get('lexik_jwt_authentication.encoder')
                ->encode(['username' => $user->getUsername()]);
        $save = $this->saveModel('AGUsuario', array('id' => $user->getId(), 'password' => $newPassword, 'token' => $token));
        $save['data']['token'] = $token;
        return new View($save, Response::HTTP_OK);
    }

}
