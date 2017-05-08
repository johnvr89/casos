<?php

namespace AppBundle\Libs\EntityNormalizer;

use AppBundle\Libs\Normalizer\AbstractNormalizer;
use AppBundle\Libs\Decorator\CustomDecorator;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;


/**
 * Description of AGEmpresaNormalizer
 *
 * @author SimplexUseCaseGenerator
 */
class AGEmpresaNormalizer extends AbstractNormalizer implements ContainerAwareInterface {
    private $container;
    public function normalizeObject($object, $prototype) {

        $obj = array();
        $normalice = $this->container->get('manager.json');
        switch ($prototype) {
            case CustomDecorator::DEFAULT_DECORATOR:
                $obj['id'] = $object->getId();
                $obj['nombre'] = $object->getNombre();
                $obj['razon_social'] = $object->getRazonSocial();
                $obj['descripcion'] = $object->getDescripcion();
                $obj['direccion'] = $object->getDireccion();
                $obj['tipo_identificacion'] = $object->getTipoIdentificacion();
                $obj['numero_identificacion'] = $object->getNumeroIdentificacion();
                $obj['clave_sri'] = $object->getClaveSri();
                $obj['representante'] = $object->getRepresentante();
                $obj['telefono'] = $object->getTelefono();
                $obj['correo'] = $object->getCorreo();
                $obj['logo'] = $object->getLogo();
                $obj['ciudad'] = $normalice->normalize('normalizer.agciudad', $object->getCiudad(), CustomDecorator::DEFAULT_DECORATOR);
                $obj['tipo_cliente'] = $normalice->normalize('normalizer.agtipocliente', $object->getTipoCliente(), CustomDecorator::DEFAULT_DECORATOR);
                break;
             case CustomDecorator::CLIENT:
                $obj['id'] = $object->getId();
                $obj['nombre'] = $object->getNombre();
                $obj['razon_social'] = $object->getRazonSocial();
                $obj['descripcion'] = $object->getDescripcion();
                $obj['direccion'] = $object->getDireccion();
                $obj['tipo_identificacion'] = $object->getTipoIdentificacion();
                $obj['numero_identificacion'] = $object->getNumeroIdentificacion();
                $obj['clave_sri'] = $object->getClaveSri();
                $obj['representante'] = $object->getRepresentante();
                $obj['telefono'] = $object->getTelefono();
                $obj['correo'] = $object->getCorreo();
                $obj['logo'] = $object->getLogo();
                $obj['ciudad'] = $normalice->normalize('normalizer.agciudad', $object->getCiudad(), CustomDecorator::DEFAULT_DECORATOR);
                $obj['tipo_cliente'] = $normalice->normalize('normalizer.agtipocliente', $object->getTipoCliente(), CustomDecorator::DEFAULT_DECORATOR);
                $obj['cantidad_casos'] = count($object->getCasosReales());
                break;
            case CustomDecorator::SIMPLE_DECORATOR:
                $obj['id'] = $object->getId();
                $obj['nombre'] = $object->getNombre();
               break;
           case CustomDecorator::USER_COMPANY:
                $obj['id'] = $object->getId();
                $obj['nombre'] = $object->getNombre();
                $obj['razon_social'] = $object->getRazonSocial();
                $obj['descripcion'] = $object->getDescripcion();
                $obj['direccion'] = $object->getDireccion();
                $obj['tipo_identificacion'] = $object->getTipoIdentificacion();
                $obj['numero_identificacion'] = $object->getNumeroIdentificacion();
                $obj['clave_sri'] = $object->getClaveSri();
                $obj['representante'] = $object->getRepresentante();
                $obj['telefono'] = $object->getTelefono();
                $obj['correo'] = $object->getCorreo();
                $obj['logo'] = $object->getLogo();
                $obj['ciudad'] = $normalice->normalize('normalizer.agciudad', $object->getCiudad(), CustomDecorator::DEFAULT_DECORATOR);
              
               break;
        }
        
        return $obj;
    }

    public function setContainer(\Symfony\Component\DependencyInjection\ContainerInterface $container = null) {
        $this->container = $container;
    }


}
