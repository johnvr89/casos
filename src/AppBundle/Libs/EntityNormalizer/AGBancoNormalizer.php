<?php

namespace AppBundle\Libs\EntityNormalizer;

use AppBundle\Libs\Normalizer\AbstractNormalizer;
use AppBundle\Libs\Decorator\CustomDecorator;


/**
 * Description of AGBancoNormalizer
 *
 * @author SimplexUseCaseGenerator
 */
class AGBancoNormalizer extends AbstractNormalizer {

    public function normalizeObject($object, $prototype) {
   
        $obj = array();
        switch ($prototype) {
            case CustomDecorator::DEFAULT_DECORATOR:
                $obj['id'] = $object->getId();
                $obj['nombre'] = $object->getNombre();
          
                break;
        }

        return $obj;
    }

}
