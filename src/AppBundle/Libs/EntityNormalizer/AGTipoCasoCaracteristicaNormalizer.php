<?php

namespace AppBundle\Libs\EntityNormalizer;

use AppBundle\Libs\Normalizer\AbstractNormalizer;
use AppBundle\Libs\Decorator\CustomDecorator;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;


/**
 * Description of AGBancoNormalizer
 *
 * @author SimplexUseCaseGenerator
 */
class AGTipoCasoCaracteristicaNormalizer extends AbstractNormalizer implements ContainerAwareInterface {
 private $container;

    public function normalizeObject($object, $prototype) {
 $normalice = $this->container->get('manager.json');
        $obj = array();
        switch ($prototype) {
            case CustomDecorator::DEFAULT_DECORATOR:
                $obj['id'] = $object->getId();
                $obj['nombre_campo'] = $object->getNombreCampo();
                $obj['tipo_caso'] = $normalice->normalize('normalizer.agtipocaso', $object->getTipoCaso(), CustomDecorator::DEFAULT_DECORATOR);
                $obj['tipo_campo'] = $normalice->normalize('normalizer.agtipodatos', $object->getTipoCampo(), CustomDecorator::DEFAULT_DECORATOR);
                break;
        }
        
        return $obj;
    }

    public function setContainer(\Symfony\Component\DependencyInjection\ContainerInterface $container = null) {
        $this->container = $container;
    }

}
