<?php

namespace AppBundle\Libs\TraitMyCase;

trait ValidateEntity {

    public function validateUnique($criteria) {
        $criteria['visible'] = 1;
        return $this->findBy($criteria);
    }

}
