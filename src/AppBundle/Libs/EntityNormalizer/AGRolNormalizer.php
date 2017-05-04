<?php

namespace AppBundle\Libs\EntityNormalizer;

use AppBundle\Libs\Normalizer\AbstractNormalizer;
use AppBundle\Libs\Decorator\CustomDecorator;

/**
 * Description of AGBancoNormalizer
 *
 * @author SimplexUseCaseGenerator
 */
class AGRolNormalizer extends AbstractNormalizer implements \Symfony\Component\DependencyInjection\ContainerAwareInterface {

    private $container;

    public function normalizeObject($object, $prototype) {

        $obj = array();
        $normalice = $this->container->get('manager.json');
        switch ($prototype) {
            case CustomDecorator::DEFAULT_DECORATOR:
                $obj['id'] = $object->getId();
                $obj['nombre'] = $object->getNombre();
                $obj['descripcion'] = $object->getDescripcion();
                $obj['accion'] = $normalice->normalize('normalizer.agaccion', $object->getAccion(), CustomDecorator::DEFAULT_DECORATOR);
                break;
            case CustomDecorator::ACTION_DECORATOR:
                $actions = $this->container->get('doctrine')->getRepository('AppBundle:AGAccion')->findBy(array(),array('controlador' => 'ASC', 'posicion'=>'ASC'));
                $obj['accion'] = $normalice->normalize('normalizer.agaccion', $actions, CustomDecorator::DEFAULT_DECORATOR);
                foreach ($obj['accion'] as &$accion) {
                    if ($object->containsActionById($accion['id'])) {
                        $accion['activo'] = 1;
                    } else {
                        $accion['activo'] = 0;
                    }
                }
        }

        return $obj;
    }

    public function setContainer(\Symfony\Component\DependencyInjection\ContainerInterface $container = null) {
        $this->container = $container;
    }

}
