<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AGCaso
 *
 * @ORM\Table(name="ag_caso")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AGCasoRepository")
 */
class AGCaso {

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
     * @ORM\Column(name="honorarios", type="float")
     */
    private $honorarios;

    /**
     * @var text
     *
     * @ORM\Column(name="observacion", type="text")
     */
    private $observacion;

    /**
     * @var text
     *
     * @ORM\Column(name="resolucion", type="text")
     */
    private $resolucion;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AGCiudad", inversedBy="caso")
     * @ORM\JoinColumn(
     *     name="id_ciudad",
     *     referencedColumnName="id",
     *     nullable=false
     * )
     */
    private $ciudad;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AGEstado", inversedBy="caso")
     * @ORM\JoinColumn(
     *     name="id_estado",
     *     referencedColumnName="id",
     *     nullable=false
     * )
     */
    private $estado;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AGTipoCaso", inversedBy="casos")
     * @ORM\JoinColumn(
     *     name="id_tipo_caso",
     *     referencedColumnName="id",
     *     nullable=false
     * )
     */
    private $tipocaso;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AGEmpresa", inversedBy="casos")
     * @ORM\JoinColumn(
     *     name="id_empresa",
     *     referencedColumnName="id",
     *     nullable=false
     * )
     */
    private $empresa;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AGEmpresa", inversedBy="casosRectores")
     * @ORM\JoinColumn(
     *     name="id_empresa_rectora",
     *     referencedColumnName="id",
     *     nullable=true
     * )
     */
    private $empresaRectora;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AGUsuario", inversedBy="casos")
     * @ORM\JoinColumn(
     *     name="id_usuario",
     *     referencedColumnName="id",
     *     nullable=false
     * )
     */
    private $responsable;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AGUsuario", inversedBy="casoIntermediario")
     * @ORM\JoinColumn(
     *     name="id_intermediario",
     *     referencedColumnName="id",
     *     nullable=true
     * )
     */
    private $intermediario;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AGDetalle", mappedBy="caso")
     */
    private $detalles;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AGSeguimiento", mappedBy="caso")
     */
    private $seguimiento;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AGPagoRealizado", mappedBy="caso")
     * @ORM\OrderBy({"id" = "ASC"})
     */
    private $pagoRealizado;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AGUsuario", inversedBy="casoCrea")
     * @ORM\JoinColumn(
     *     name="id_usuario_crea",
     *     referencedColumnName="id",
     *    nullable=true,onDelete="SET NULL"
     * )
     */
    private $usuarioCrea;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AGUsuario", inversedBy="casoModifica")
     * @ORM\JoinColumn(
     *     name="id_usuario_modifica",
     *     referencedColumnName="id",
     *     nullable=true,onDelete="SET NULL"
     * )
     */
    private $usuarioModifica;

    /**
     * @ORM\Column(type="date", nullable=true,name="fecha_crea")
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
        $this->detalles = new \Doctrine\Common\Collections\ArrayCollection();
        $this->seguimiento = new \Doctrine\Common\Collections\ArrayCollection();
        $this->pagoRealizado = new \Doctrine\Common\Collections\ArrayCollection();
        $this->documento = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return AGCaso
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
     * Set honorarios
     *
     * @param float $honorarios
     *
     * @return AGCaso
     */
    public function setHonorarios($honorarios) {
        $this->honorarios = $honorarios;

        return $this;
    }

    /**
     * Get honorarios
     *
     * @return float
     */
    public function getHonorarios() {
        return $this->honorarios;
    }

    /**
     * Set observacion
     *
     * @param string $observacion
     *
     * @return AGCaso
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
     * Set resolucion
     *
     * @param string $resolucion
     *
     * @return AGCaso
     */
    public function setResolucion($resolucion) {
        $this->resolucion = $resolucion;

        return $this;
    }

    /**
     * Get resolucion
     *
     * @return string
     */
    public function getResolucion() {
        return $this->resolucion;
    }

    /**
     * Set ciudad
     *
     * @param \AppBundle\Entity\AGCiudad $ciudad
     *
     * @return AGCaso
     */
    public function setCiudad(\AppBundle\Entity\AGCiudad $ciudad) {
        $this->ciudad = $ciudad;

        return $this;
    }

    /**
     * Get ciudad
     *
     * @return \AppBundle\Entity\AGCiudad
     */
    public function getCiudad() {
        return $this->ciudad;
    }

    /**
     * Set estado
     *
     * @param \AppBundle\Entity\AGEstado $estado
     *
     * @return AGCaso
     */
    public function setEstado(\AppBundle\Entity\AGEstado $estado) {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return \AppBundle\Entity\AGEstado
     */
    public function getEstado() {
        return $this->estado;
    }

    /**
     * Set tipocaso
     *
     * @param \AppBundle\Entity\AGTipoCaso $tipocaso
     *
     * @return AGCaso
     */
    public function setTipocaso(\AppBundle\Entity\AGTipoCaso $tipocaso) {
        $this->tipocaso = $tipocaso;

        return $this;
    }

    /**
     * Get tipocaso
     *
     * @return \AppBundle\Entity\AGTipoCaso
     */
    public function getTipocaso() {
        return $this->tipocaso;
    }

    /**
     * Set empresa
     *
     * @param \AppBundle\Entity\AGEmpresa $empresa
     *
     * @return AGCaso
     */
    public function setEmpresa(\AppBundle\Entity\AGEmpresa $empresa) {
        $this->empresa = $empresa;

        return $this;
    }

    /**
     * Get empresa
     *
     * @return \AppBundle\Entity\AGEmpresa
     */
    public function getEmpresa() {
        return $this->empresa;
    }

    /**
     * Set responsable
     *
     * @param \AppBundle\Entity\AGUsuario $responsable
     *
     * @return AGCaso
     */
    public function setResponsable(\AppBundle\Entity\AGUsuario $responsable) {
        $this->responsable = $responsable;

        return $this;
    }

    /**
     * Get responsable
     *
     * @return \AppBundle\Entity\AGUsuario
     */
    public function getResponsable() {
        return $this->responsable;
    }

    /**
     * Set intermediario
     *
     * @param \AppBundle\Entity\AGUsuario $intermediario
     *
     * @return AGCaso
     */
    public function setIntermediario(\AppBundle\Entity\AGUsuario $intermediario = null) {
        $this->intermediario = $intermediario;

        return $this;
    }

    /**
     * Get intermediario
     *
     * @return \AppBundle\Entity\AGUsuario
     */
    public function getIntermediario() {
        return $this->intermediario;
    }

    /**
     * Add detalle
     *
     * @param \AppBundle\Entity\AGDetalle $detalle
     *
     * @return AGCaso
     */
    public function addDetalle(\AppBundle\Entity\AGDetalle $detalle) {
        $this->detalles[] = $detalle;

        return $this;
    }

    /**
     * Remove detalle
     *
     * @param \AppBundle\Entity\AGDetalle $detalle
     */
    public function removeDetalle(\AppBundle\Entity\AGDetalle $detalle) {
        $this->detalles->removeElement($detalle);
    }

    /**
     * Get detalles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDetalles() {
        return $this->detalles;
    }

    /**
     * Add seguimiento
     *
     * @param \AppBundle\Entity\AGSeguimiento $seguimiento
     *
     * @return AGCaso
     */
    public function addSeguimiento(\AppBundle\Entity\AGSeguimiento $seguimiento) {
        $this->seguimiento[] = $seguimiento;

        return $this;
    }

    /**
     * Remove seguimiento
     *
     * @param \AppBundle\Entity\AGSeguimiento $seguimiento
     */
    public function removeSeguimiento(\AppBundle\Entity\AGSeguimiento $seguimiento) {
        $this->seguimiento->removeElement($seguimiento);
    }

    /**
     * Get seguimiento
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSeguimiento() {
        return $this->seguimiento;
    }

    /**
     * Add pagoRealizado
     *
     * @param \AppBundle\Entity\AGPagoRealizado $pagoRealizado
     *
     * @return AGCaso
     */
    public function addPagoRealizado(\AppBundle\Entity\AGPagoRealizado $pagoRealizado) {
        $this->pagoRealizado[] = $pagoRealizado;

        return $this;
    }

    /**
     * Remove pagoRealizado
     *
     * @param \AppBundle\Entity\AGPagoRealizado $pagoRealizado
     */
    public function removePagoRealizado(\AppBundle\Entity\AGPagoRealizado $pagoRealizado) {
        $this->pagoRealizado->removeElement($pagoRealizado);
    }

    /**
     * Get pagoRealizado
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPagoRealizado() {
        return $this->pagoRealizado;
    }

    /**
     * Set fechaCrea
     *
     * @param \DateTime $fechaCrea
     *
     * @return AGCaso
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
     * @return AGCaso
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
     * @return AGCaso
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
     * @return AGCaso
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

    public function getDineroPagado() {
        $pagos = $this->pagoRealizado->toArray();
        $sum = 0;
        foreach ($pagos as $pago) {
            if ($pago->getVisible()) {
                $sum += $pago->getValorPagado();
            }
        }
        return $sum;
    }

    public function getPagosReales() {
        $pagos = array();
        $result = $this->pagoRealizado->toArray();
        foreach ($result as $value) {
           if($value->getVisible()){
              $pagos[]=$value; 
           } 
        }
        return $pagos;
    }

    public function getProximoPago() {
        $idEstado = $this->getEstado()->getId();
        $pagosreales=$this->getPagosReales();
        $totalPagos = count($pagosreales);
        if ($idEstado >= 2 && $idEstado < 5 && $totalPagos > 0) {
            $fecha = $pagosreales[$totalPagos - 1]->getFechaProximoCobro();

            if ($fecha)
                return $fecha->format('Y-m-d');
        }
        return '';
    }

    public function tienePagosPendientes() {
        $fecha = $this->getProximoPago();
        if ($fecha) {
            $fecha = \DateTime::createFromFormat('Y-m-d', $fecha);
            $fechaActual = new \DateTime('now');
            $fechaActual = \DateTime::createFromFormat('Y-m-d', $fechaActual->format('Y-m-d'));
            if ($fecha < $fechaActual) {
                return 'Si';
            }
            return 'No';
        }
        return 'No';
    }

    /**
     * Set empresaRectora
     *
     * @param \AppBundle\Entity\AGEmpresa $empresaRectora
     *
     * @return AGCaso
     */
    public function setEmpresaRectora(\AppBundle\Entity\AGEmpresa $empresaRectora = null) {
        $this->empresaRectora = $empresaRectora;

        return $this;
    }

    /**
     * Get empresaRectora
     *
     * @return \AppBundle\Entity\AGEmpresa
     */
    public function getEmpresaRectora() {
        return $this->empresaRectora;
    }

    /**
     * Set visible
     *
     * @param integer $visible
     *
     * @return AGCaso
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

}
