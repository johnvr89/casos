<?php

namespace AppBundle\Libs\EntityNormalizer;

use AppBundle\Libs\Normalizer\AbstractNormalizer;
use AppBundle\Libs\Decorator\CustomDecorator;


/**
 * Description of AGBancoNormalizer
 *
 * @author SimplexUseCaseGenerator
 */
class AGAccionNormalizer extends AbstractNormalizer {

    public function normalizeObject($object, $prototype) {

        $obj = array();
        switch ($prototype) {
            case CustomDecorator::DEFAULT_DECORATOR:
                $obj['id'] = $object->getId();
                $obj['nombre'] = $object->getNombre();
                $obj['controlador'] = $object->getControlador();
                $obj['descripcion'] = $object->getDescripcion();
                $obj['alias'] = $object->getAlias();
                $obj['alias_controlador'] = $object->getAliasContrador();
               
                break;
        }
        
        return $obj;
    }

}
