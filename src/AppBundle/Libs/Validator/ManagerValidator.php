<?php

namespace AppBundle\Libs\Validator;

use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Libs\Validator\ValidateInterface;
use AppBundle\Libs\Validator\AbstractValidator;


/**
 * Description of ManagerValidator
 *
 * @author rene
 */
class ManagerValidator implements ValidateInterface {

    private $container;

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }

    public function validate($class, array $data, $objectPersist, array $typeValidations) {
        $class = 'validator.' . $class;
        
        $validator = $this->container->get($class);

        
        if (in_array('Symfony\Component\DependencyInjection\ContainerAwareInterface', class_implements($validator))) {
            $validator->setContainer($this->container);
        }
        foreach ($typeValidations as $validate) {
            if ($validator->suportEntityOrData($objectPersist, $data)) {
                $result=$validator->validate($data, $objectPersist, $validate);
                if(is_string($result)&& strlen($result)>0){
                    return $result;
                }
               
            }
           
        }
         return '';
    }

}
