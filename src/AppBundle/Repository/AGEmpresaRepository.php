<?php

namespace AppBundle\Repository;

use AppBundle\Libs\Normalizer\ResultDecorator;
use AppBundle\Libs\TraitMyCase\ValidateEntity;

/**
 * AGEmpresaRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AGEmpresaRepository extends \AppBundle\Libs\Repository\BaseRepository {

    use ValidateEntity;

    public function getBaseQuery($baseEntity, $start = 0, $limit = 30, $filters = array(), $columnsAlias = array(), $decorator = ResultDecorator::DEFAULT_DECORATOR) {
        
    }



    public function getAllClient($intEmpresa) 
    {
        $qb = $this->createQueryBuilder('company');
        $qb->innerJoin('company.tipoCliente', 'tipoCliente');
        $qb->andWhere($qb->expr()->eq('company.visible', '?1'));
        $qb->andWhere($qb->expr()->eq('company.empresaId', '?2'));
        $qb->setParameter(1, 1);
        $qb->setParameter(2, $intEmpresa);
        $qb->andWhere($qb->expr()->notIn('tipoCliente.id', array(3)));

        return $qb->getQuery()->getResult();
    }

    public function getMainCompanyClient() {
        $qb = $this->createQueryBuilder('company');
        $qb->innerJoin('company.tipoCliente', 'tipoCliente');
        $qb->where($qb->expr()->in('tipoCliente.id', array(3)));
        $qb->andWhere($qb->expr()->eq('company.visible', '?1'));
        $qb->setParameter(1, 1);

        return $qb->getQuery()->getResult();
    }

    public function getAllClientList($all = true, $userid = -1) {
        $qb = $this->createQueryBuilder('company');
        $qb->innerJoin('company.tipoCliente', 'tipoCliente');
        $qb->where($qb->expr()->notIn('tipoCliente.id', array(3)));
        if (!$all) {
            $qb->andWhere($qb->expr()->eq('company.usuarioCrea', $userid));
        }
        $qb->andWhere($qb->expr()->eq('company.visible', '?1'));
        $qb->setParameter(1, 1);
        return $qb->getQuery()->getResult();
    }

    public function getTotal() {
        $qb = $this->createQueryBuilder('entity');
        $qb->select('COUNT(entity.id)');
        $qb->innerJoin('entity.casos', 'casos');
        $qb->innerJoin('casos.estado', 'estado');
        $qb->where($qb->expr()->notIn('estado.id', array(5, 6)));
        $qb->andWhere($qb->expr()->eq('entity.visible', '?1'));
        $qb->andWhere($qb->expr()->eq('casos.visible', '?1'));
        $qb->setParameter(1, 1);
        return $qb->getQuery()->getSingleScalarResult();
    }

    public function getClientCaseReport($intEmpresa, $all = true, $myCase = false, $intermediary = false, $initialDate, $endDate, $client = null, $lawer = null, $intermediary = null, $state = null, $caseType = null) {
        $qb = $this->createQueryBuilder('entity');

        $qb->select('entity.nombre AS nombrecliente');
        $qb->addSelect('COUNT(DISTINCT(casos.id)) AS numerocasos');
        $qb->addSelect('SUM(DISTINCT(casos.honorarios)) AS valortotal');
        $qb->addSelect('SUM(pagoRealizado.valorPagado) AS valortotalpagado');
        $qb->addSelect('(SUM(DISTINCT(casos.honorarios)) - SUM(pagoRealizado.valorPagado)) AS valortotalpendiente');
        $qb->innerJoin('entity.casos', 'casos');
        $qb->innerJoin('casos.tipocaso', 'tipocaso');
        $qb->innerJoin('casos.estado', 'estado');
        $qb->leftJoin('casos.pagoRealizado', 'pagoRealizado');


        if (!$all) {
            if ($myCase && $intermediary) {
                $qb->andWhere($qb->expr()->eq('casos.responsable', '?3'));

                $qb->orWhere($qb->expr()->eq('casos.intermediario', '?5'));
                $qb->setParameter(3, $lawer);
            }
            if ($myCase) {
                $qb->andWhere($qb->expr()->eq('casos.responsable', '?3'));
                $qb->setParameter(3, $lawer);
            }
            if ($intermediary) {
                $qb->andWhere($qb->expr()->eq('casos.intermediario', '?5'));
                $qb->setParameter(5, $intermediary);
            }
        }

        if ($client) {
            $qb->andWhere($qb->expr()->eq('entity.id', '?1'));
            $qb->setParameter(1, $client);
        }

        if ($all) {
            if ($lawer) {
                $qb->andWhere($qb->expr()->eq('casos.responsable', '?3'));

                $qb->setParameter(3, $lawer);
            }
            if ($intermediary) {
                $qb->innerJoin('casos.intermediario', 'intermediario');
                $qb->andWhere($qb->expr()->eq('intermediario.id', '?5'));
                $qb->setParameter(5, $intermediary);
            }
        }
        if ($state) {
            $qb->andWhere($qb->expr()->eq('estado.id', '?4'));
            $qb->setParameter(4, $state);
        }

        if ($initialDate && $endDate) {
            $initial = \DateTime::createFromFormat('Y-m-d', $initialDate)->format('Y-m-d');
            $end = \DateTime::createFromFormat('Y-m-d', $endDate)->format('Y-m-d');
            $qb->andWhere($qb->expr()->between('casos.fechaCrea', '?6', '?7'));
            $qb->setParameter(6, $initial);
            $qb->setParameter(7, $end);
        }
        if ($caseType) {
            $qb->andWhere($qb->expr()->eq('tipocaso.id', '?8'));
            $qb->setParameter(8, $caseType);
        }
        $qb->andWhere($qb->expr()->eq('entity.visible', '?10'));
        $qb->andWhere($qb->expr()->eq('casos.visible', '?10'));
        $qb->setParameter(10, 1);
        
        if($intEmpresa > 0)
        {
            $qb->andWhere($qb->expr()->eq('casos.empresaRectora', '?11'));
            $qb->setParameter(11, $intEmpresa);
        }
        
        $qb->addGroupBy('entity');
        $result = $qb->getQuery()->getResult();
        $nombrecliente = 'Total';
        $numerocasos = 0;
        $valortotal = 0;
        $valortotalpagado = 0;


        foreach ($result as $value) {
            $numerocasos += $value['numerocasos'];
            $valortotal += $value['valortotal'];
            $valortotalpagado += $value['valortotalpagado'];
        }
        $valortotalpendiente = $valortotal - $valortotalpagado;

        if (count($result) > 0) {
            $result[] = array('nombrecliente' => $nombrecliente, 'numerocasos' => $numerocasos
                , 'valortotal' => $valortotal, 'valortotalpagado' => $valortotalpagado, 'valortotalpendiente' => $valortotalpendiente);
        }
        return array('success' => true, 'data' => $result);
    }

    public function getClientWithPaymet() {
        $date = new \DateTime('tomorrow');
        $qb = $this->createQueryBuilder('company');
     //  $qb->addSelect('company');
     //  $qb->addSelect('case');
      //  $qb->addSelect('pagoRealizado');
        $qb->innerJoin('company.casos', 'case');
       $qb->innerJoin('case.estado', 'estado');
       $qb->innerJoin('case.pagoRealizado', 'pagoRealizado');
        $qb->where($qb->expr()->notIn('estado.id', array(1, 5, 6)));
       $qb->andWhere($qb->expr()->eq('pagoRealizado.fechaProximoCobro', '?1'));
        $qb->andWhere($qb->expr()->eq('company.visible', '?2'));
       $qb->andWhere($qb->expr()->eq('pagoRealizado.visible', '?2'));
        $qb->setParameter(2, 1);
        $qb->setParameter(1, $date->format('Y-m-d'));
       $qb->distinct();

        return $qb->getQuery()->getResult();
    }

}
