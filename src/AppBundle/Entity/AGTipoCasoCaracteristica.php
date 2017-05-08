<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AGTipoCasoCaracteristica
 *
 * @ORM\Table(name="ag_tipo_caso_caracteristica")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AGTipoCasoCaracteristicaRepository")
 */
class AGTipoCasoCaracteristica
{
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
     * @ORM\Column(name="nombreCampo", type="string", length=255)
     */
    private $nombreCampo;


       /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AGDetalle", mappedBy="tipoCasoCaracteristica")
     */
    private $detalle;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AGTipoCaso", inversedBy="tipoCasoCaracteristica")
     * @ORM\JoinColumn(
     *     name="id_tipo_caso",
     *     referencedColumnName="id",
     *     nullable=false,
     *     onDelete="CASCADE"
     * )
     */
    private $tipoCaso;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AGTipoDatos", inversedBy="tipoCasoCaracteristica")
     * @ORM\JoinColumn(
     *     name="id_tipo_dato",
     *     referencedColumnName="id",
     *     nullable=false
     * )
     */
    private $tipoCampo;
    
      /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AGUsuario", inversedBy="tipoCasoCaracteristicaCrea")
     * @ORM\JoinColumn(
     *     name="id_usuario_crea",
     *     referencedColumnName="id",
     *    nullable=true,onDelete="SET NULL"
     * )
     */
    private $usuarioCrea;
    
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AGUsuario", inversedBy="tipoCasoCaracteristicaModifica")
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
    private $visible=1;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->detalle = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombreCampo
     *
     * @param string $nombreCampo
     *
     * @return AGTipoCasoCaracteristica
     */
    public function setNombreCampo($nombreCampo)
    {
        $this->nombreCampo = $nombreCampo;

        return $this;
    }

    /**
     * Get nombreCampo
     *
     * @return string
     */
    public function getNombreCampo()
    {
        return $this->nombreCampo;
    }

    /**
     * Add detalle
     *
     * @param \AppBundle\Entity\AGDetalle $detalle
     *
     * @return AGTipoCasoCaracteristica
     */
    public function addDetalle(\AppBundle\Entity\AGDetalle $detalle)
    {
        $this->detalle[] = $detalle;

        return $this;
    }

    /**
     * Remove detalle
     *
     * @param \AppBundle\Entity\AGDetalle $detalle
     */
    public function removeDetalle(\AppBundle\Entity\AGDetalle $detalle)
    {
        $this->detalle->removeElement($detalle);
    }

    /**
     * Get detalle
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDetalle()
    {
        return $this->detalle;
    }

    /**
     * Set tipoCaso
     *
     * @param \AppBundle\Entity\AGTipoCaso $tipoCaso
     *
     * @return AGTipoCasoCaracteristica
     */
    public function setTipoCaso(\AppBundle\Entity\AGTipoCaso $tipoCaso)
    {
        $this->tipoCaso = $tipoCaso;

        return $this;
    }

    /**
     * Get tipoCaso
     *
     * @return \AppBundle\Entity\AGTipoCaso
     */
    public function getTipoCaso()
    {
        return $this->tipoCaso;
    }

    /**
     * Set tipoCampo
     *
     * @param \AppBundle\Entity\AGTipoDatos $tipoCampo
     *
     * @return AGTipoCasoCaracteristica
     */
    public function setTipoCampo(\AppBundle\Entity\AGTipoDatos $tipoCampo)
    {
        $this->tipoCampo = $tipoCampo;

        return $this;
    }

    /**
     * Get tipoCampo
     *
     * @return \AppBundle\Entity\AGTipoDatos
     */
    public function getTipoCampo()
    {
        return $this->tipoCampo;
    }

    /**
     * Set fechaCrea
     *
     * @param \DateTime $fechaCrea
     *
     * @return AGTipoCasoCaracteristica
     */
    public function setFechaCrea($fechaCrea)
    {
        $this->fechaCrea = $fechaCrea;

        return $this;
    }

    /**
     * Get fechaCrea
     *
     * @return \DateTime
     */
    public function getFechaCrea()
    {
        return $this->fechaCrea;
    }

    /**
     * Set fechaModifica
     *
     * @param \DateTime $fechaModifica
     *
     * @return AGTipoCasoCaracteristica
     */
    public function setFechaModifica($fechaModifica)
    {
        $this->fechaModifica = $fechaModifica;

        return $this;
    }

    /**
     * Get fechaModifica
     *
     * @return \DateTime
     */
    public function getFechaModifica()
    {
        return $this->fechaModifica;
    }

    /**
     * Set usuarioCrea
     *
     * @param \AppBundle\Entity\AGUsuario $usuarioCrea
     *
     * @return AGTipoCasoCaracteristica
     */
    public function setUsuarioCrea(\AppBundle\Entity\AGUsuario $usuarioCrea = null)
    {
        $this->usuarioCrea = $usuarioCrea;

        return $this;
    }

    /**
     * Get usuarioCrea
     *
     * @return \AppBundle\Entity\AGUsuario
     */
    public function getUsuarioCrea()
    {
        return $this->usuarioCrea;
    }

    /**
     * Set usuarioModifica
     *
     * @param \AppBundle\Entity\AGUsuario $usuarioModifica
     *
     * @return AGTipoCasoCaracteristica
     */
    public function setUsuarioModifica(\AppBundle\Entity\AGUsuario $usuarioModifica = null)
    {
        $this->usuarioModifica = $usuarioModifica;

        return $this;
    }

    /**
     * Get usuarioModifica
     *
     * @return \AppBundle\Entity\AGUsuario
     */
    public function getUsuarioModifica()
    {
        return $this->usuarioModifica;
    }

    /**
     * Set visible
     *
     * @param integer $visible
     *
     * @return AGTipoCasoCaracteristica
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
