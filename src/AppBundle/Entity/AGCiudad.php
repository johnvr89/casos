<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AGCiudad
 *
 * @ORM\Table(name="ag_ciudad")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AGCiudadRepository")
 */
class AGCiudad
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
     * @ORM\Column(name="nombre", type="string", length=255, unique=true)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text",nullable=true)
     */
    private $descripcion;
    
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AGEmpresa", mappedBy="ciudad")
     */
    private $empresa;
    
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AGCaso", mappedBy="ciudad")
     */
    private $caso;
    
      /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AGUsuario", inversedBy="ciudadCrea")
     * @ORM\JoinColumn(
     *     name="id_usuario_crea",
     *     referencedColumnName="id",
     *    nullable=true,onDelete="SET NULL"
     * )
     */
    private $usuarioCrea;
    
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AGUsuario", inversedBy="ciudadModifica")
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
     * Constructor
     */
    public function __construct()
    {
        $this->empresa = new \Doctrine\Common\Collections\ArrayCollection();
        $this->caso = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return AGCiudad
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
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return AGCiudad
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Add empresa
     *
     * @param \AppBundle\Entity\AGEmpresa $empresa
     *
     * @return AGCiudad
     */
    public function addEmpresa(\AppBundle\Entity\AGEmpresa $empresa)
    {
        $this->empresa[] = $empresa;

        return $this;
    }

    /**
     * Remove empresa
     *
     * @param \AppBundle\Entity\AGEmpresa $empresa
     */
    public function removeEmpresa(\AppBundle\Entity\AGEmpresa $empresa)
    {
        $this->empresa->removeElement($empresa);
    }

    /**
     * Get empresa
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEmpresa()
    {
        return $this->empresa;
    }

    /**
     * Add caso
     *
     * @param \AppBundle\Entity\AGCaso $caso
     *
     * @return AGCiudad
     */
    public function addCaso(\AppBundle\Entity\AGCaso $caso)
    {
        $this->caso[] = $caso;

        return $this;
    }

    /**
     * Remove caso
     *
     * @param \AppBundle\Entity\AGCaso $caso
     */
    public function removeCaso(\AppBundle\Entity\AGCaso $caso)
    {
        $this->caso->removeElement($caso);
    }

    /**
     * Get caso
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCaso()
    {
        return $this->caso;
    }

    /**
     * Set fechaCrea
     *
     * @param \DateTime $fechaCrea
     *
     * @return AGCiudad
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
     * @return AGCiudad
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
     * @return AGCiudad
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
     * @return AGCiudad
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
