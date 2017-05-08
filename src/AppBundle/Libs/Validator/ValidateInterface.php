<?php

namespace AppBundle\Libs\Validator;

/**
 *
 * @author rene
 */
interface ValidateInterface {

    /**
     * @param string $class service to normalize the $value
     * @param array $data  of data to entity
     * @param  $object  object to save
     * @param  $validationTypes  types of validations
     */
    public function validate($class,array $data, $object,array $validationTypes);
   
}
