<?php

 namespace AppBundle\Libs\Normalizer;

use Doctrine\ORM\PersistentCollection;

/**
 * Description of AbstractNormalizer
 *
 * @author rene
 */
abstract class AbstractNormalizer {

    public function normalice($value, $prototype) {
        if ($value instanceof PersistentCollection) {
            return $this->normalizeArray($value->toArray(), $prototype);
        }

        if (is_object($value)) {
           
            return $this->normalizeObject($value, $prototype);
        }
        if (is_array($value)) {
          
            return $this->normalizeArray($value, $prototype);
        }

        return array();
    }

    abstract function normalizeObject($object, $prototype);

    public function normalizeArray($array, $prototype) {
        $result = array();
        foreach ($array as $value) {
            $result[] = $this->normalizeObject($value, $prototype);
        }
        return $result;
    }

}
