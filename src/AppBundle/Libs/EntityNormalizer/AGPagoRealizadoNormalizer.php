<?php

namespace AppBundle\Libs\EntityNormalizer;

use AppBundle\Libs\Normalizer\AbstractNormalizer;
use AppBundle\Libs\Decorator\CustomDecorator;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

/**
 * Description of AGEmpresaNormalizer
 *
 * @author SimplexUseCaseGenerator
 */
class AGPagoRealizadoNormalizer extends AbstractNormalizer implements ContainerAwareInterface {

    private $container;

    public function normalizeObject($object, $prototype) {

        $obj = array();
        $normalice = $this->container->get('manager.json');
        $repoDoc = $this->container->get('doctrine')->getRepository('AppBundle:AGDocumento');
        $doc = $repoDoc->findOneBy(array('pago' => $object->getId()));
        switch ($prototype) {
            case CustomDecorator::DEFAULT_DECORATOR:
                $obj['id'] = $object->getId();
                $obj['valor_pagado'] = $object->getValorPagado();
                $fecha = $object->getFechaProximoCobro();

                $obj['fecha_proximo_cobro'] = empty($fecha) ? '' : $fecha->format('d/m/Y');

                $obj['cuenta'] = $normalice->normalize('normalizer.agcuenta', $object->getCuenta(), CustomDecorator::DEFAULT_DECORATOR);
                $obj['forma_pago'] = $normalice->normalize('normalizer.agformapago', $object->getFormaPago(), CustomDecorator::DEFAULT_DECORATOR);
                $obj['tipo_cobro'] = $normalice->normalize('normalizer.agtipocobro', $object->getTipoCobro(), CustomDecorator::DEFAULT_DECORATOR);
                $obj['caso'] = $normalice->normalize('normalizer.agcaso', $object->getCaso(), CustomDecorator::DEFAULT_DECORATOR);
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
