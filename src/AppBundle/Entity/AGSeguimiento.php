<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AGCaso
 *
 * @ORM\Table(name="ag_seguimiento")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AGSeguimientoRepository")
 */
class AGSeguimiento {

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
     * @var float
     *
     * @ORM\Column(name="cambio_estado", type="boolean")
     */
    private $cambioEstado;

    /**
     * @var text
     *
     * @ORM\Column(name="observacion", type="text")
     */
    private $observacion;

    /**
     * @var text
     *
     * @ORM\Column(name="descripcion", type="text")
     */
    private $descripcion;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AGCaso", inversedBy="seguimiento")
     * @ORM\JoinColumn(
     *     name="id_caso",
     *     referencedColumnName="id",
     *     nullable=false,
     *    onDelete="CASCADE"
     * )
     */
    private $caso;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AGUsuario", inversedBy="seguimiento")
     * @ORM\JoinColumn(
     *     name="id_usuario",
     *     referencedColumnName="id",
     *     nullable=false
     * )
     */
    private $responsableSeguimiento;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AGUsuario", inversedBy="seguimientoCrea")
     * @ORM\JoinColumn(
     *     name="id_usuario_crea",
     *     referencedColumnName="id",
     *     nullable=true,onDelete="SET NULL"
     * )
     */
    private $usuarioCrea;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AGUsuario", inversedBy="seguimientoModifica")
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
     * @return AGSeguimiento
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
     * Set cambioEstado
     *
     * @param boolean $cambioEstado
     *
     * @return AGSeguimiento
     */
    public function setCambioEstado($cambioEstado) {
        $this->cambioEstado = $cambioEstado;

        return $this;
    }

    /**
     * Get cambioEstado
     *
     * @return boolean
     */
    public function getCambioEstado() {
        return $this->cambioEstado;
    }

    /**
     * Set observacion
     *
     * @param string $observacion
     *
     * @return AGSeguimiento
     */
    public function setObservacion($observacion) {
        $this->observacion = $observacion;

        return $this;
    }

    /**
     * Get observacion
     *
     * @return string
     */
    public function getObservacion() {
        return $this->observacion;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return AGSeguimiento
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
     * Set fechaCrea
     *
     * @param \DateTime $fechaCrea
     *
     * @return AGSeguimiento
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
     * @return AGSeguimiento
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
     * Set caso
     *
     * @param \AppBundle\Entity\AGCaso $caso
     *
     * @return AGSeguimiento
     */
    public function setCaso(\AppBundle\Entity\AGCaso $caso) {
        $this->caso = $caso;

        return $this;
    }

    /**
     * Get caso
     *
     * @return \AppBundle\Entity\AGCaso
     */
    public function getCaso() {
        return $this->caso;
    }

    /**
     * Set responsableSeguimiento
     *
     * @param \AppBundle\Entity\AGUsuario $responsableSeguimiento
     *
     * @return AGSeguimiento
     */
    public function setResponsableSeguimiento(\AppBundle\Entity\AGUsuario $responsableSeguimiento) {
        $this->responsableSeguimiento = $responsableSeguimiento;

        return $this;
    }

    /**
     * Get responsableSeguimiento
     *
     * @return \AppBundle\Entity\AGUsuario
     */
    public function getResponsableSeguimiento() {
        return $this->responsableSeguimiento;
    }

    /**
     * Set usuarioCrea
     *
     * @param \AppBundle\Entity\AGUsuario $usuarioCrea
     *
     * @return AGSeguimiento
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
     * @return AGSeguimiento
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
     * @return AGSeguimiento
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;

        return $this;
    }

    /**
     * Get visible
     *
     * @return integer
     */
    public function getVisible()
    {
        return $this->visible;
    }
}
