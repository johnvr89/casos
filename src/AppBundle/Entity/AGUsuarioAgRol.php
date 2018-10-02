<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
use Symfony\Component\Yaml\Yaml;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Users
 *
 * @ORM\Table(name="ag_usuario_ag_rol")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AGUsuarioAgRolRepository") 
 */
class AGUsuarioAgRol {
    
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;    

    /**
     * @var integer
     *
     * @ORM\Column(name="usuario_id", type="integer", length=11)
     */
    private $usuarioId;

    /**
     * @var integer
     *
     * @ORM\Column(name="rol_id", type="integer", length=11)
     */
    private $rolId;

    
    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    
    /**
     * Set usuarioId
     *
     * @param string $usuarioId
     *
     * @return AGUsuarioAgRol
     */
    public function setUsuarioId($usuarioId) {
        $this->usuarioId = $usuarioId;

        return $this;
    }

    /**
     * Get usuarioId
     *
     * @return string
     */
    public function getUsuarioId() {
        return $this->usuarioId;
    }

    /**
     * Set rolId
     *
     * @param string $rolId
     *
     * @return AGUsuarioAgRol
     */
    public function setRolId($rolId) {
        $this->rolId = $rolId;

        return $this;
    }

    /**
     * Get rolId
     *
     * @return string
     */
    public function getRolId() {
        return $this->rolId;
    }

}
