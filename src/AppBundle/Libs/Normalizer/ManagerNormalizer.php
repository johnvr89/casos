<?php

namespace AppBundle\Libs\Normalizer;

use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Libs\Normalizer\NormalizerInterface;

use AppBundle\Libs\Normalizer\AbstractNormalizer;
//use UCI\Boson\ExcepcionesBundle\Exception\LocalException;

/**
 * Description of ManagerNormalizer
 *
 * @author rene
 */
class ManagerNormalizer implements NormalizerInterface {

    private $container;

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }

    public function normalize($class, $value, $prototype) {
       
        $normalizer = $this->container->get($class);


        if (in_array('Symfony\Component\DependencyInjection\ContainerAwareInterface', class_implements($normalizer))) {
            $normalizer->setContainer($this->container);
        }

        return ($normalizer->normalice($value, $prototype));
    }

}
