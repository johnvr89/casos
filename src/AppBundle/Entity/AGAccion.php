<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping AS ORM;
use Doctrine\Common\Collections\Criteria;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AGAccionRepository")
 * @ORM\Table(name="ag_action")
 */
class AGAccion
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50, nullable=false, name="nombre")
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=50, nullable=false, name="controlador")
     */
    private $controlador;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $descripcion;

    /**
     * @ORM\Column(type="string", length=250, nullable=false, name="alias")
     */
    private $alias;
    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $aliasContrador;
     /**
     * @ORM\Column(type="integer", name="posicion")
     */
    private $posicion;
    
    



    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\AGRol", mappedBy="accion")
     */
    private $rol;
    
     /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AGUsuario", inversedBy="accionCrea")
     * @ORM\JoinColumn(
     *     name="id_usuario_crea",
     *     referencedColumnName="id",
     *     nullable=true,onDelete="SET NULL"
     * )
     */
    private $usuarioCrea;
    
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AGUsuario", inversedBy="accionModifica")
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
        $this->rol = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return AGAccion
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
     * Set controlador
     *
     * @param string $controlador
     *
     * @return AGAccion
     */
    public function setControlador($controlador)
    {
        $this->controlador = $controlador;

        return $this;
    }

    /**
     * Get controlador
     *
     * @return string
     */
    public function getControlador()
    {
        return $this->controlador;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return AGAccion
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
     * Set alias
     *
     * @param string $alias
     *
     * @return AGAccion
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * Get alias
     *
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * Add rol
     *
     * @param \AppBundle\Entity\AGRol $rol
     *
     * @return AGAccion
     */
    public function addRol(\AppBundle\Entity\AGRol $rol)
    {
        $this->rol[] = $rol;

        return $this;
    }

    /**
     * Remove rol
     *
     * @param \AppBundle\Entity\AGRol $rol
     */
    public function removeRol(\AppBundle\Entity\AGRol $rol)
    {
        $this->rol->removeElement($rol);
    }

    /**
     * Get rol
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRol()
    {
        return $this->rol;
    }

    /**
     * Set fechaCrea
     *
     * @param \DateTime $fechaCrea
     *
     * @return AGAccion
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
     * @return AGAccion
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
     * @return AGAccion
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
     * @return AGAccion
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
     * Set aliasContrador
     *
     * @param string $aliasContrador
     *
     * @return AGAccion
     */
    public function setAliasContrador($aliasContrador)
    {
        $this->aliasContrador = $aliasContrador;

        return $this;
    }

    /**
     * Get aliasContrador
     *
     * @return string
     */
    public function getAliasContrador()
    {
        return $this->aliasContrador;
    }

    /**
     * Set posicion
     *
     * @param integer $posicion
     *
     * @return AGAccion
     */
    public function setPosicion($posicion)
    {
        $this->posicion = $posicion;

        return $this;
    }

    /**
     * Get posicion
     *
     * @return integer
     */
    public function getPosicion()
    {
        return $this->posicion;
    }
}
