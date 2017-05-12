<?php

namespace AppBundle\Repository;

use AppBundle\Libs\TraitMyCase\ValidateEntity;

use Doctrine\ORM\EntityRepository;
use telconet\schemaBundle\DependencyInjection\BaseRepository;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Doctrine\DBAL\Connection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;

/**
 * UsersRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AGUsuarioRepository extends \AppBundle\Libs\Repository\BaseRepository {

    use ValidateEntity;

    public function getBaseQuery($baseEntity, $start = 0, $limit = 30, $filters = array(), $columnsAlias = array(), $decorator = ResultDecorator::DEFAULT_DECORATOR) {
        
    }

    public function checkPermision($data) {
        try {

            $qb = $this->createQueryBuilder('user');
            $qb->innerJoin('user.roles', 'roles')
                    ->innerJoin('roles.accion', 'action')
                    ->where($qb->expr()->eq('user.token', '?1'))
                    ->andWhere($qb->expr()->eq('action.nombre', '?2'))
                    ->andWhere($qb->expr()->eq('action.controlador', '?3'))
                    ->andWhere($qb->expr()->eq('user.visible', '?4'));
            $qb->setParameter(1, $data['key']);
            $qb->setParameter(2, $data['action']);
            $qb->setParameter(3, $data['controller']);
            $qb->setParameter(4, 1);

            $result = $qb->getQuery()->getResult();
            //echo $qb->getDQL();
            if (count($result) > 0) {

                return true;
            }
            return false;
        } catch (\Exception $e) {

            return false;
        }
    }

    public function getTotal() {
        $qb = $this->createQueryBuilder('entity');
        $qb->select('COUNT(entity.id)');
        $qb->andWhere($qb->expr()->eq('entity.visible', '?1'));
        $qb->setParameter(1, 1);
        return $qb->getQuery()->getSingleScalarResult();
    }

    public function findAllNotLoged($token) {
        $qb = $this->createQueryBuilder('user');
        $qb->where($qb->expr()->neq('user.token', '?1') . ' OR ' . $qb->expr()->isNull('user.token'));
        $qb->andWhere($qb->expr()->eq('user.visible', '?2'));
        $qb->setParameter(2, 1);
        $qb->setParameter(1, $token);
        return $qb->getQuery()->getResult();
    }

    /* si se cambian los roles cambiar aqui */

    public function findAllUserSupervisor() {
        $qb = $this->createQueryBuilder('user');
        $qb->innerJoin('user.roles', 'roles');
        $qb->where($qb->expr()->eq('roles.id', '?1'));
        $qb->andWhere($qb->expr()->eq('user.visible', '?2'));
        $qb->setParameter(2, 1);
        $qb->setParameter(1, 7);
        return $qb->getQuery()->getResult();
    }

    public function findAllUserIntermediary() {
        $qb = $this->createQueryBuilder('user');
        $qb->innerJoin('user.roles', 'roles');
        $qb->where($qb->expr()->eq('roles.id', '?1'));
        $qb->andWhere($qb->expr()->eq('user.visible', '?2'));
        $qb->setParameter(2, 1);
        $qb->setParameter(1, 6);
        return $qb->getQuery()->getResult();
    }

    public function findAllUserLawer() {
        $qb = $this->createQueryBuilder('user');
        $qb->innerJoin('user.roles', 'roles');
        $qb->where($qb->expr()->eq('roles.id', '?1'));
        $qb->andWhere($qb->expr()->eq('user.visible', '?2'));
        $qb->setParameter(2, 1);
        $qb->setParameter(1, 5);
        return $qb->getQuery()->getResult();
    }
    
    public function findUsersForRol($strRol) {
        $qb = $this->_em->createQuery();
        
        $sql = "  SELECT u.id, u.nombreinterfaz
                    FROM AppBundle:AGRol r,
                         AppBundle:AGUsuarioAgRol ur,
                         AppBundle:AGUsuario u
                    WHERE r.nombre = :rol
                    AND ur.rolId  = r.id
                    AND u.id       = ur.usuarioId";
        
        $qb->setDQL($sql);
        
        $qb->setParameter('rol', $strRol);
       
        return $qb->getResult();
    }    

}
