<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AGTipoDatos
 *
 * @ORM\Table(name="ag_tipo_datos")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AGTipoDatosRepository")
 */
class AGTipoDatos
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
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="AGTipoCasoCaracteristica", mappedBy="tipoCampo")
     */
    private $tipoCasoCaracteristica;
    
      /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AGUsuario", inversedBy="tipoDatosCrea")
     * @ORM\JoinColumn(
     *     name="id_usuario_crea",
     *     referencedColumnName="id",
     *     nullable=true,onDelete="SET NULL"
     * )
     */
    private $usuarioCrea;
    
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AGUsuario", inversedBy="tipoDatosModifica")
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
     * Constructor
     */
    public function __construct()
    {
        $this->tipoCasoCaracteristica = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return AGTipoDatos
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Add tipoCasoCaracteristica
     *
     * @param \AppBundle\Entity\AGTipoCasoCaracteristica $tipoCasoCaracteristica
     *
     * @return AGTipoDatos
     */
    public function addTipoCasoCaracteristica(\AppBundle\Entity\AGTipoCasoCaracteristica $tipoCasoCaracteristica)
    {
        $this->tipoCasoCaracteristica[] = $tipoCasoCaracteristica;

        return $this;
    }

    /**
     * Remove tipoCasoCaracteristica
     *
     * @param \AppBundle\Entity\AGTipoCasoCaracteristica $tipoCasoCaracteristica
     */
    public function removeTipoCasoCaracteristica(\AppBundle\Entity\AGTipoCasoCaracteristica $tipoCasoCaracteristica)
    {
        $this->tipoCasoCaracteristica->removeElement($tipoCasoCaracteristica);
    }

    /**
     * Get tipoCasoCaracteristica
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTipoCasoCaracteristica()
    {
        return $this->tipoCasoCaracteristica;
    }

    /**
     * Set fechaCrea
     *
     * @param \DateTime $fechaCrea
     *
     * @return AGTipoDatos
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
     * @return AGTipoDatos
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
     * @return AGTipoDatos
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
     * @return AGTipoDatos
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
}
