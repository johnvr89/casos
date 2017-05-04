<?php

namespace AppBundle\Libs\EntityNormalizer;

use AppBundle\Libs\Normalizer\AbstractNormalizer;
use AppBundle\Libs\Decorator\CustomDecorator;


/**
 * Description of AGBancoNormalizer
 *
 * @author SimplexUseCaseGenerator
 */
class AGCuentaNormalizer extends AbstractNormalizer  implements \Symfony\Component\DependencyInjection\ContainerAwareInterface{
    private $container;
    public function normalizeObject($object, $prototype) {

        $obj = array();
        $normalice = $this->container->get('manager.json');
        switch ($prototype) {
            case CustomDecorator::DEFAULT_DECORATOR:
                $obj['id'] = $object->getId();
                $obj['nombre'] = $object->getNombre();
                $obj['numero'] = $object->getNumero();
                $obj['tipo_cuenta'] = $object->getTipoCuenta();
                $obj['banco'] = $normalice->normalize('normalizer.agbanco', $object->getBanco(), CustomDecorator::DEFAULT_DECORATOR);
                break;
        }
        
        return $obj;
    }

    public function setContainer(\Symfony\Component\DependencyInjection\ContainerInterface $container = null) {
        $this->container=$container;
    }

}
