<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * aAGTipoCobro
 *
 * @ORM\Table(name="ag_tipo_cobro")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AGTipoCobroRepository")
 */
class AGTipoCobro
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
    * @ORM\OneToMany(targetEntity="AppBundle\Entity\AGPagoRealizado", mappedBy="tipoCobro")
    */
    private $pagosRealizados;
    
      /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AGUsuario", inversedBy="tipoCobroCrea")
     * @ORM\JoinColumn(
     *     name="id_usuario_crea",
     *     referencedColumnName="id",
     *    nullable=true,onDelete="SET NULL"
     * )
     */
    private $usuarioCrea;
    
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AGUsuario", inversedBy="tipoCobroModifica")
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
     * Get id
     *
     * @return int
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
     * @return aAGTipoCobro
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
     * Constructor
     */
    public function __construct()
    {
        $this->pagosRealizados = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add pagosRealizado
     *
     * @param \AppBundle\Entity\AGPagoRealizado $pagosRealizado
     *
     * @return AGTipoCobro
     */
    public function addPagosRealizado(\AppBundle\Entity\AGPagoRealizado $pagosRealizado)
    {
        $this->pagosRealizados[] = $pagosRealizado;

        return $this;
    }

    /**
     * Remove pagosRealizado
     *
     * @param \AppBundle\Entity\AGPagoRealizado $pagosRealizado
     */
    public function removePagosRealizado(\AppBundle\Entity\AGPagoRealizado $pagosRealizado)
    {
        $this->pagosRealizados->removeElement($pagosRealizado);
    }

    /**
     * Get pagosRealizados
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPagosRealizados()
    {
        return $this->pagosRealizados;
    }

    /**
     * Set fechaCrea
     *
     * @param \DateTime $fechaCrea
     *
     * @return AGTipoCobro
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
     * @return AGTipoCobro
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
     * @return AGTipoCobro
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
     * @return AGTipoCobro
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
