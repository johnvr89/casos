<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * AGTipoCaso
 *
 * @ORM\Table(name="ag_tipo_caso")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AGTipoCasoRepository")
 * @UniqueEntity(fields={"nombre"}, message="unique.tipocaso",repositoryMethod="validateUnique")
 */
class AGTipoCaso {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255)
     */
    private $descripcion;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AGCaso", mappedBy="tipocaso")
     */
    private $casos;

    /**
     * @ORM\OneToMany(targetEntity="AGTipoCasoCaracteristica", mappedBy="tipoCaso")
     */
    private $tipoCasoCaracteristica;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AGUsuario", inversedBy="tipoCasoCrea")
     * @ORM\JoinColumn(
     *     name="id_usuario_crea",
     *     referencedColumnName="id",
     *    nullable=true,onDelete="SET NULL"
     * )
     */
    private $usuarioCrea;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AGUsuario", inversedBy="tipoCasoModifica")
     * @ORM\JoinColumn(
     *     name="id_usuario_modifica",
     *     referencedColumnName="id",
     *    nullable=true,onDelete="SET NULL"
     * )
     */
    private $usuarioModifica;

    /**
     * @ORM\Column(type="datetime", nullable=true,name="fecha_crea")
     */
    private $fechaCrea;

    /**
     * @ORM\Column(type="datetime", nullable=true,name="fecha_modifica")
     */
    private $fechaModifica;

    /**
     * @var string
     *
     * @ORM\Column(name="visible", type="integer",nullable=true,options={"default" : 1})
     */
    private $visible = 1;

    /**
     * Constructor
     */
    public function __construct() {
        $this->casos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tipoCasoCaracteristica = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return AGTipoCaso
     */
    public function setNombre($nombre) {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre() {
        return $this->nombre;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return AGTipoCaso
     */
    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion() {
        return $this->descripcion;
    }

    /**
     * Add caso
     *
     * @param \AppBundle\Entity\AGCaso $caso
     *
     * @return AGTipoCaso
     */
    public function addCaso(\AppBundle\Entity\AGCaso $caso) {
        $this->casos[] = $caso;

        return $this;
    }

    /**
     * Remove caso
     *
     * @param \AppBundle\Entity\AGCaso $caso
     */
    public function removeCaso(\AppBundle\Entity\AGCaso $caso) {
        $this->casos->removeElement($caso);
    }

    /**
     * Get casos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCasos() {
        return $this->casos;
    }

    /**
     * Add tipoCasoCaracteristica
     *
     * @param \AppBundle\Entity\AGTipoCasoCaracteristica $tipoCasoCaracteristica
     *
     * @return AGTipoCaso
     */
    public function addTipoCasoCaracteristica(\AppBundle\Entity\AGTipoCasoCaracteristica $tipoCasoCaracteristica) {
        $this->tipoCasoCaracteristica[] = $tipoCasoCaracteristica;

        return $this;
    }

    /**
     * Remove tipoCasoCaracteristica
     *
     * @param \AppBundle\Entity\AGTipoCasoCaracteristica $tipoCasoCaracteristica
     */
    public function removeTipoCasoCaracteristica(\AppBundle\Entity\AGTipoCasoCaracteristica $tipoCasoCaracteristica) {
        $this->tipoCasoCaracteristica->removeElement($tipoCasoCaracteristica);
    }

    /**
     * Get tipoCasoCaracteristica
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTipoCasoCaracteristica() {
        return $this->tipoCasoCaracteristica;
    }

    /**
     * Set fechaCrea
     *
     * @param \DateTime $fechaCrea
     *
     * @return AGTipoCaso
     */
    public function setFechaCrea($fechaCrea) {
        $this->fechaCrea = $fechaCrea;

        return $this;
    }

    /**
     * Get fechaCrea
     *
     * @return \DateTime
     */
    public function getFechaCrea() {
        return $this->fechaCrea;
    }

    /**
     * Set fechaModifica
     *
     * @param \DateTime $fechaModifica
     *
     * @return AGTipoCaso
     */
    public function setFechaModifica($fechaModifica) {
        $this->fechaModifica = $fechaModifica;

        return $this;
    }

    /**
     * Get fechaModifica
     *
     * @return \DateTime
     */
    public function getFechaModifica() {
        return $this->fechaModifica;
    }

    /**
     * Set usuarioCrea
     *
     * @param \AppBundle\Entity\AGUsuario $usuarioCrea
     *
     * @return AGTipoCaso
     */
    public function setUsuarioCrea(\AppBundle\Entity\AGUsuario $usuarioCrea = null) {
        $this->usuarioCrea = $usuarioCrea;

        return $this;
    }

    /**
     * Get usuarioCrea
     *
     * @return \AppBundle\Entity\AGUsuario
     */
    public function getUsuarioCrea() {
        return $this->usuarioCrea;
    }

    /**
     * Set usuarioModifica
     *
     * @param \AppBundle\Entity\AGUsuario $usuarioModifica
     *
     * @return AGTipoCaso
     */
    public function setUsuarioModifica(\AppBundle\Entity\AGUsuario $usuarioModifica = null) {
        $this->usuarioModifica = $usuarioModifica;

        return $this;
    }

    /**
     * Get usuarioModifica
     *
     * @return \AppBundle\Entity\AGUsuario
     */
    public function getUsuarioModifica() {
        return $this->usuarioModifica;
    }

    /**
     * Set visible
     *
     * @param integer $visible
     *
     * @return AGTipoCaso
     */
    public function setVisible($visible) {
        $this->visible = $visible;

        return $this;
    }

    /**
     * Get visible
     *
     * @return integer
     */
    public function getVisible() {
        return $this->visible;
    }

    public function hasCase() {
        $cases = $this->casos->toArray();
        $total = 0;
        foreach ($cases as $case) {
            if ($case->getVisible() == 1) {
                $total++;
            }
        }
        return $total > 0;
    }

}
