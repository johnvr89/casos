<?php

namespace AppBundle\Libs\Validator;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;

/**
 * Description of AbstractValidator
 *
 * @author rene
 */
abstract class AbstractValidator implements ContainerAwareInterface {

    private $container;

    public abstract function validate(array $data, $objectPersist, $validationType);

    public function setContainer(\Symfony\Component\DependencyInjection\ContainerInterface $container = null) {
        $this->container = $container;
    }

    public function getTranslator() {
        return $this->container->get('translator');
    }
    public function getContainer(){
        return $this->container;
    }
    public abstract function suportEntityOrData($entity,$data);

}
