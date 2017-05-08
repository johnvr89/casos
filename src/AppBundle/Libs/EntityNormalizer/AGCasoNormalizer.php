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
class AGCasoNormalizer extends AbstractNormalizer implements ContainerAwareInterface {

    private $container;

    public function normalizeObject($object, $prototype) {
        $normalice = $this->container->get('manager.json');
        $obj = array();
        switch ($prototype) {
            case CustomDecorator::DEFAULT_DECORATOR:
                $obj['id'] = $object->getId();
                $obj['nombre'] = $object->getNombre();
                $obj['proximopago'] = $object->getProximoPago();
                $obj['pagospendientes'] = $object->tienePagosPendientes();
                $obj['honorarios'] = $object->getHonorarios();
                $obj['dineropagado'] = $object->getDineroPagado();
                $obj['observacion'] = $object->getObservacion();
                $obj['resolucion'] = $object->getResolucion();
                $obj['ciudad'] = $normalice->normalize('normalizer.agciudad', $object->getCiudad(), CustomDecorator::DEFAULT_DECORATOR);
                $obj['estado'] = $normalice->normalize('normalizer.agestado', $object->getEstado(), CustomDecorator::DEFAULT_DECORATOR);
                $obj['tipocaso'] = $normalice->normalize('normalizer.agtipocaso', $object->getTipoCaso(), CustomDecorator::DEFAULT_DECORATOR);
                $obj['empresa'] = $normalice->normalize('normalizer.agempresa', $object->getEmpresa(), CustomDecorator::SIMPLE_DECORATOR);
                $obj['responsable'] = $normalice->normalize('normalizer.agusuario', $object->getResponsable(), CustomDecorator::SIMPLE_DECORATOR);
                $obj['intermediario'] = $normalice->normalize('normalizer.agusuario', $object->getIntermediario(), CustomDecorator::SIMPLE_DECORATOR);
                $obj['cantidadatrazada'] ='$'. ($obj['honorarios']-$obj['dineropagado']);
                $obj['detalles'] = $normalice->normalize('normalizer.agdetalle', $object->getDetalles(), CustomDecorator::DEFAULT_DECORATOR);
                $obj['fechacreacion'] =  $object->getFechaCrea()->format('d/m/Y');
                break;

            case CustomDecorator::SIMPLE_DECORATOR:
                $obj['id'] = $object->getId();
                $obj['nombre'] = $object->getNombre();
                $obj['nombrecliente'] = $object->getEmpresa()->getNombre();
                $obj['pagospendientes'] = $object->tienePagosPendientes();
                $obj['honorarios'] = $object->getHonorarios();
                $obj['dineropagado'] = $object->getDineroPagado();
                $obj['porpagar'] = $obj['honorarios'] - $obj['dineropagado'];
                $obj['estado'] = $normalice->normalize('normalizer.agestado', $object->getEstado(), CustomDecorator::DEFAULT_DECORATOR);
                $obj['tipocaso'] = $normalice->normalize('normalizer.agtipocaso', $object->getTipoCaso(), CustomDecorator::DEFAULT_DECORATOR);
                $obj['empresa'] = $normalice->normalize('normalizer.agempresa', $object->getEmpresa(), CustomDecorator::SIMPLE_DECORATOR);
                $obj['responsable'] = $normalice->normalize('normalizer.agusuario', $object->getResponsable(), CustomDecorator::SIMPLE_DECORATOR);
                $obj['intermediario'] = $normalice->normalize('normalizer.agusuario', $object->getIntermediario(), CustomDecorator::SIMPLE_DECORATOR);
                $obj['fechaingreso'] =  $object->getFechaCrea()->format('d/m/Y');
               
                break;
        }

        return $obj;
    }

    public function setContainer(\Symfony\Component\DependencyInjection\ContainerInterface $container = null) {
        $this->container = $container;
    }

}
