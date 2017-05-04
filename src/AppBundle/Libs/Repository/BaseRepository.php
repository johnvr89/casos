<?php

namespace AppBundle\Libs\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use UCI\Simplex\SimplextjsBundle\Libs\Normalizer\ResultDecorator;
use Doctrine\ORM\Tools\Pagination\Paginator;
use UCI\Boson\ExcepcionesBundle\Exception\LocalException;
use Doctrine\Common\Inflector\Inflector;

/**
 * Description of BaseRepository
 *
 * @author rene
 */
abstract class BaseRepository extends EntityRepository {

    public function beginTransaction() {
        $this->getEntityManager()->beginTransaction();
    }
    
    public function commit() {
        $em = $this->getEntityManager();
        if ($em->getConnection()->isTransactionActive())
            $em->commit();
    }

    public function rollback() {
        $em = $this->getEntityManager();
        if ($em->getConnection()->isTransactionActive())
            $em->rollback();
    }

    public abstract function getBaseQuery($baseEntity, $start = 0, $limit = 30, $filters = array(), $columnsAlias = array(), $decorator = ResultDecorator::DEFAULT_DECORATOR);

    public function doCount($query, $fetchJoin = true) {
        $paginator = new Paginator($query, $fetchJoin);
        return $paginator->count();
    }

    public function getResult(\Doctrine\ORM\QueryBuilder $qb) {
        /*
          $paginator = new Paginator($qb, true);
          return $paginator->getIterator()->getArrayCopy(); */
        return $qb->getQuery()->getResult();
    }

    protected function getConditionsFromFilters($baseEntity, $filters = array(), $columnsAlias = array()) {
        $conditions = array();
        $qb = $this->getEntityManager()->createQueryBuilder();

        foreach ($filters as $filter) {
            $filter = (array) $filter;

            if (isset($filter['property']) && isset($filter['value']) && isset($filter['operator'])) {
                //$field = $filter['property'];
                if (key_exists($filter['property'], $columnsAlias)) {
                    $field = $columnsAlias[$filter['property']];
                } else {
                    $field = "{$baseEntity}.{$filter['property']}";
                }
                switch ($filter['type']) {
                    case 'combo':
                        $conditions[] = $qb->expr()->eq($field, "'{$filter['value']}'");
                        break;
                    case 'bool':
                        $conditions[] = $qb->expr()->eq($field, "'{$filter['value']}'");
                        break;
                    /* postgres is sensitive to upper */
                    case 'string':
                        $filter['value'] = strtolower($filter['value']);
                        $filter['value'] = str_replace("'","", $filter['value'] );
                        $conditions[] = $qb->expr()->like($qb->expr()->lower($field), "'%{$filter['value']}%'");
                        break;
                    case 'int':
                        $conditions[] = call_user_func(array($qb->expr(), $filter['operator']), $field, $filter['value']);
                        break;
                    case 'null':
                        $conditions[] = $qb->expr()->isNull($field);
                        break;
                    case 'float':
                        $conditions[] = call_user_func(array($qb->expr(), $filter['operator']), $field, $filter['value']);
                        break;
                    case 'list':
                        // $result = json_decode($filter['value']);
                        // if (is_array($result) && count($result) > 0)
                        $conditions[] = $qb->expr()->in($field, $filter['value']);

                        break;
                    case 'date':
                        /* @var $value \DateTime */
                        // $value = \DateTime::createFromFormat('m/d/Y', $filter['value']);
                        $conditions[] = call_user_func(array($qb->expr(), $filter['operator']), $field, "'{$filter['value']}'");
                        // $conditions[] = "{$field} {$filter['comparison']} '{$value->format('Y-m-d')}'";
                        break;

                    default:
                        throw new \Exception("Unsupported column type ({$filter['type']}) for filters in ({$filter['property']}) column.");
                        break;
                }
            }
        }
        if (count($conditions) == 0) {
            $conditions[] = "1=1";
        }
        return implode(' AND ', $conditions);
    }

    public function getRequiredFields() {
        $meta = $this->getClassMetadata();
        $arrayfields = $meta->fieldMappings;
        $pk = $meta->getIdentifierFieldNames();
        $required = array();

        foreach ($arrayfields as $data) {
            if ($data['nullable'] === false)
                $required[] = $data['fieldName'];
        }
        return array_diff($required, $pk);
    }

    public function validateRequiredValues($values) {
        $requiredFields = $this->getRequiredFields();
        $values = array_keys($values);
        foreach ($requiredFields as $val) {

            if (!in_array($val, $values)) {
                throw new \Exception('field ' . $val . '  not send.');
            }
        }
    }

    public function populateEntity($data) {
        // $this->validateRequiredValues($data);
        $object = NULL;
        $class = $this->getClassName();
        if (array_key_exists('id', $data)) {
            $object = $this->find($data['id']);

            if ($object == NULL) {
                throw new LocalException("E6", array($class, !empty($data['id']) ? $data['id'] : -1));
            }
            unset($data['id']);
        } else {
            $object = new $class();
        }

        $meta = $this->getClassMetadata();
        $arrayfieldsName = $meta->getFieldNames();
        $associationMapings = $meta->getAssociationMappings();
        $associationNames = $meta->getAssociationNames();
        foreach ($data as $property => $value) {
            $method = '';

            if (in_array($property, $arrayfieldsName)) {
                $method = 'set' . Inflector::classify($property);
                if (method_exists($object, $method)) {
                    $mapingField = $meta->getFieldMapping($property);
                    $type = @$mapingField['type'];



                    if ( $type == 'date') {
                        $value = \DateTime::createFromFormat('Y-m-d', $value);
                    }
                     if ($type == 'datetime') {
                        $value = \DateTime::createFromFormat('Y-m-d H:i:s', $value);
                    }

                    $object->$method($value);
                } else {
                    throw new LocalException("E9", array($method, $class));
                }
            } else if (in_array($property, $associationNames)) {
                $map = $associationMapings[$property];
                /* relacion 1-N o 1-1 */
                if (($map['type'] == 2 || $map['type'] == 1) && $associationMapings[$property]['isOwningSide'] === true) {
                    $method = 'set' . Inflector::classify($property);
                    $v = null;
                    if ($value != null && is_numeric($value))
                        $v = $this->_em->getRepository($map['targetEntity'])->find($value);
                    if (method_exists($object, $method)) {
                        if ($v != NULL) {
                            $object->$method($v);
                        } else {
                            //si la relacion permite nulo y en el objeto a setear viene nulo se le asigna
                            if (is_array(@$map['joinColumns']) && count($map['joinColumns']) == 1) {
                                if (@$map['joinColumns'][0]['nullable']) {
                                    $object->$method($v);
                                }
                            }
                        }
                    } else {
                        throw new LocalException("E9", array($method, $class));
                    }
                } /* relacion M-N con objetos ya existentes */ else if ($map['type'] == 8) {
                    $method = Inflector::singularize('add' . Inflector::classify($property));
                    if (!method_exists($object, $method)) {
                        throw new LocalException("E9", array($method, $class));
                    }

                    if (is_string($value)) {
                        $value = json_decode($value);
                    }
                    if (!is_array($value)) {
                        throw new LocalException("E10", array($method, $class));
                    } else {
                        $secodPart = Inflector::classify($property);
                        $removeMethod = Inflector::singularize('remove' . $secodPart);
                        $getMethod = 'get' . $secodPart;
                        if (!method_exists($object, $removeMethod)) {
                            throw new LocalException("E9", array($removeMethod, $class));
                        }
                        if (!method_exists($object, $getMethod)) {
                            throw new LocalException("E9", array($getMethod, $class));
                        }
                        $collection = $object->$getMethod();
                        if ($collection instanceof \Doctrine\Common\Collections\ArrayCollection) {
                            $collection = $collection->toArray();
                        }
                        foreach ($collection as $col) {
                            /* elimino los que no
                             *  esten en la nueva asignacion */
                            if (!in_array($col->getId(), $value)) {
                                $object->$removeMethod($col);
                            } else {
                                /* elimino los id de que ya estan asignados para
                                 * no volverselos a asignar */
                                unset($value[array_search($col->getId(), $value)]);
                            }
                        }

                        foreach ($value as $val) {
                            $v = null;
                            if ($val != null)
                                $v = $this->_em->getRepository($map['targetEntity'])->find($val);
                            if ($v != NULL) {
                                $object->$method($v);
                            }
                        }
                    }
                }
            }
        }

        return $object;
    }

    protected function getJoins() {
        return array();
    }

    public function hasRelation($relationName) {
        $meta = $this->getClassMetadata();
        return $meta->hasAssociation($relationName);
    }
     public function hasField($fieldName) {
        $meta = $this->getClassMetadata();
        return $meta->hasField($fieldName);
    }

//put your code here
}
