<?php

namespace AppBundle\Libs\TraitMyCase;

trait GetMyResorces {

    public function getResosurces($token) {
        $qb = $this->createQueryBuilder('entity');

        $qb->innerJoin('entity.caso', 'caso');
        $qb->innerJoin('caso.responsable', 'responsable');
        $qb->leftJoin('caso.intermediario', 'intermediario');
        $qb->where($qb->expr()->eq('responsable.token', '?1').' OR '.$qb->expr()->eq('intermediario.token', '?1'));
        $qb->andWhere($qb->expr()->eq('entity.visible', '?2'));
        $qb->setParameter(1, $token);
        $qb->setParameter(2, 1);
        return $qb->getQuery()->getResult();
    }

}
