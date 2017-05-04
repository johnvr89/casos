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
class AGSeguimientoNormalizer extends AbstractNormalizer implements ContainerAwareInterface {

    private $container;

    public function normalizeObject($object, $prototype) {
        $normalice = $this->container->get('manager.json');
        $repoDoc = $this->container->get('doctrine')->getRepository('AppBundle:AGDocumento');
        $doc = $repoDoc->findOneBy(array('seguimiento' => $object->getId()));
        $obj = array();
        switch ($prototype) {
            case CustomDecorator::DEFAULT_DECORATOR:
                $obj['id'] = $object->getId();
                $obj['nombre'] = $object->getNombre();
                $obj['descripcion'] = $object->getDescripcion();
                $obj['observacion'] = $object->getObservacion();
                $obj['cambio_estado'] = $object->getCambioEstado();
                $obj['caso'] = $normalice->normalize('normalizer.agcaso', $object->getCaso(), CustomDecorator::DEFAULT_DECORATOR);
                $obj['responsable_seguimiento'] = $normalice->normalize('normalizer.agusuario', $object->getResponsableSeguimiento(), CustomDecorator::DEFAULT_DECORATOR);
                if ($doc) {
                    $obj['documento'] = $normalice->normalize('normalizer.agdocumento', $doc, CustomDecorator::DEFAULT_DECORATOR);
                } else {
                    $obj['documento'] = null;
                }

                break;
        }

        return $obj;
    }

    public function setContainer(\Symfony\Component\DependencyInjection\ContainerInterface $container = null) {
        $this->container = $container;
    }

}
