<?php

namespace AppBundle\Libs\EntityNormalizer;

use AppBundle\Libs\Normalizer\AbstractNormalizer;
use AppBundle\Libs\Decorator\CustomDecorator;

/**
 * Description of AGBancoNormalizer
 *
 * @author SimplexUseCaseGenerator
 */
class AGUsuarioNormalizer extends AbstractNormalizer implements \Symfony\Component\DependencyInjection\ContainerAwareInterface {

    private $container;

    public function normalizeObject($object, $prototype) {

        $obj = array();
        $normalice = $this->container->get('manager.json');
        switch ($prototype) {
            case CustomDecorator::DEFAULT_DECORATOR:
                $obj['id'] = $object->getId();
                $obj['username'] = $object->getUsername();
                $obj['correo'] = $object->getCorreo();
                $obj['nombreinterfaz'] = $object->getNombreinterfaz();
                $obj['role'] = $normalice->normalize('normalizer.agrol', $object->getRoles(), CustomDecorator::DEFAULT_DECORATOR);
                $obj['empresa'] = $normalice->normalize('normalizer.agempresa', $object->getEmpresa(), CustomDecorator::USER_COMPANY);
                
                break;
            case CustomDecorator::SIMPLE_DECORATOR:
                $obj['id'] = $object->getId();
                $obj['nombreinterfaz'] = $object->getNombreinterfaz();
                break;
            case CustomDecorator::ROLES_DECORATOR:
                $obj['id'] = $object->getId();
                $obj['username'] = $object->getUsername();
                $obj['correo'] = $object->getCorreo();
                $obj['nombreinterfaz'] = $object->getNombreinterfaz();
                $roles = $this->container->get('doctrine')->getRepository('AppBundle:AGRol')->findAll();
                $obj['role'] = $normalice->normalize('normalizer.agrol', $roles, CustomDecorator::DEFAULT_DECORATOR);
                foreach ($obj['role'] as &$rol) {
                    if ($object->userHasRole($rol['id'])) {
                        $rol['activo'] = 1;
                    } else {
                        $rol['activo'] = 0;
                    }
                }
                break;
           case CustomDecorator::USER_COMPANY:
                $obj['id'] = $object->getId();
                $obj['username'] = $object->getUsername();
                $obj['correo'] = $object->getCorreo();
                $obj['nombreinterfaz'] = $object->getNombreinterfaz();
                $obj['permission'] = $this->container->get('doctrine')->getRepository('AppBundle:AGAccion')->getPermissionByController($obj['id']);
                $obj['empresa'] = $normalice->normalize('normalizer.agempresa', $object->getEmpresa(), CustomDecorator::USER_COMPANY);
                
                return $obj;
             

               
        }

        return $obj;
    }

    public function setContainer(\Symfony\Component\DependencyInjection\ContainerInterface $container = null) {
        $this->container = $container;
    }

}
