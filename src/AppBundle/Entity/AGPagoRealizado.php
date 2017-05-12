<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AGPagoRealizado
 *
 * @ORM\Table(name="ag_pago_realizado")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AGPagoRealizadoRepository")
 */
class AGPagoRealizado {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var float
     *
     * @ORM\Column(name="valorPagado", type="float")
     */
    private $valorPagado;

    /**
     * @var \Date
     *
     * @ORM\Column(name="fechaProximoCobro", type="date",nullable=true)
     */
    private $fechaProximoCobro;

    /**
     * @var bool
     *
     * @ORM\Column(name="pagoFinal", type="boolean")
     */
    private $pagoFinal;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AGCuenta", inversedBy="pagoRealizado")
     * @ORM\JoinColumn(
     *     name="id_cuenta",
     *     referencedColumnName="id",
     *     nullable=true
     * )
     */
    private $cuenta;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AGFormaPago", inversedBy="pagoRealizado")
     * @ORM\JoinColumn(
     *     name="id_forma_pago",
     *     referencedColumnName="id",
     *     nullable=false
     * )
     */
    private $formaPago;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AGTipoCobro", inversedBy="pagosRealizados")
     * @ORM\JoinColumn(
     *     name="id_tipo_cobro",
     *     referencedColumnName="id",
     *     nullable=false
     * )
     */
    private $tipoCobro;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AGCaso", inversedBy="pagoRealizado")
     * @ORM\JoinColumn(
     *     name="id_caso",
     *     referencedColumnName="id",
     *     nullable=false,
     *     onDelete="CASCADE"
     * )
     */
    private $caso;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AGUsuario", inversedBy="pagoRealizadoCrea")
     * @ORM\JoinColumn(
     *     name="id_usuario_crea",
     *     referencedColumnName="id",
     *    nullable=true,onDelete="SET NULL"
     * )
     */
    private $usuarioCrea;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AGUsuario", inversedBy="pagoRealizadoModifica")
     * @ORM\JoinColumn(
     *     name="id_usuario_modifica",
     *     referencedColumnName="id",
     *     nullable=true,onDelete="SET NULL"
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
     * Set valorPagado
     *
     * @param float $valorPagado
     *
     * @return AGPagoRealizado
     */
    public function setValorPagado($valorPagado) {
        $this->valorPagado = $valorPagado;

        return $this;
    }

    /**
     * Get valorPagado
     *
     * @return float
     */
    public function getValorPagado() {
        return $this->valorPagado;
    }

    /**
     * Set fechaProximoCobro
     *
     * @param \DateTime $fechaProximoCobro
     *
     * @return AGPagoRealizado
     */
    public function setFechaProximoCobro($fechaProximoCobro) {
        $this->fechaProximoCobro = $fechaProximoCobro;

        return $this;
    }

    /**
     * Get fechaProximoCobro
     *
     * @return \DateTime
     */
    public function getFechaProximoCobro() {

        return $this->fechaProximoCobro;
    }

    /**
     * Set pagoFinal
     *
     * @param boolean $pagoFinal
     *
     * @return AGPagoRealizado
     */
    public function setPagoFinal($pagoFinal) {
        $this->pagoFinal = $pagoFinal;

        return $this;
    }

    /**
     * Get pagoFinal
     *
     * @return boolean
     */
    public function getPagoFinal() {
        return $this->pagoFinal;
    }

    /**
     * Set cuenta
     *
     * @param \AppBundle\Entity\AGCuenta $cuenta
     *
     * @return AGPagoRealizado
     */
    public function setCuenta(\AppBundle\Entity\AGCuenta $cuenta) {
        $this->cuenta = $cuenta;

        return $this;
    }

    /**
     * Get cuenta
     *
     * @return \AppBundle\Entity\AGCuenta
     */
    public function getCuenta() {
        return $this->cuenta;
    }

    /**
     * Set formaPago
     *
     * @param \AppBundle\Entity\AGFormaPago $formaPago
     *
     * @return AGPagoRealizado
     */
    public function setFormaPago(\AppBundle\Entity\AGFormaPago $formaPago) {
        $this->formaPago = $formaPago;

        return $this;
    }

    /**
     * Get formaPago
     *
     * @return \AppBundle\Entity\AGFormaPago
     */
    public function getFormaPago() {
        return $this->formaPago;
    }

    /**
     * Set tipoCobro
     *
     * @param \AppBundle\Entity\AGTipoCobro $tipoCobro
     *
     * @return AGPagoRealizado
     */
    public function setTipoCobro(\AppBundle\Entity\AGTipoCobro $tipoCobro) {
        $this->tipoCobro = $tipoCobro;

        return $this;
    }

    /**
     * Get tipoCobro
     *
     * @return \AppBundle\Entity\AGTipoCobro
     */
    public function getTipoCobro() {
        return $this->tipoCobro;
    }

    /**
     * Set caso
     *
     * @param \AppBundle\Entity\AGCaso $caso
     *
     * @return AGPagoRealizado
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
     * Set fechaCrea
     *
     * @param \DateTime $fechaCrea
     *
     * @return AGPagoRealizado
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
     * @return AGPagoRealizado
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
     * @return AGPagoRealizado
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
     * @return AGPagoRealizado
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
     * @return AGPagoRealizado
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

    public function estaAtrazado() {
        $fechaProximoCobro = $this->getFechaProximoCobro();
        if ($fechaProximoCobro&&$this->getVisible()) {
            $fecha = \DateTime::createFromFormat('Y-m-d', $fechaProximoCobro->format('Y-m-d'));
            $fechaActual = new \DateTime('now');
            $fechaActual = \DateTime::createFromFormat('Y-m-d', $fechaActual->format('Y-m-d'));
            if ($fecha < $fechaActual) {
                return true;
            }
            return false;
        }
        return false;
    }
    public function estaEnRango($inicio,$fin){
        $fechaProximoCobro = $this->getFechaProximoCobro();
        if($fechaProximoCobro&&$this->getVisible()){
           $fecha = \DateTime::createFromFormat('Y-m-d', $fechaProximoCobro->format('Y-m-d')); 
           if($fecha>=$inicio&&$fecha<$fin){
               return true;
           }
           return false;
        }
        return false;
    }

}
