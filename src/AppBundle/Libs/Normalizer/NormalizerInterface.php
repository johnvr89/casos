<?php

namespace AppBundle\Libs\Normalizer;

/**
 *
 * @author rene
 */
interface NormalizerInterface {

    /**
     * @param string $class service to normalize the $value
     * @param mixed $value object or array to serialize
     * @param int $prototype prototype used to serialize
     */
    public function normalize($class,$value, $prototype);
   
}
