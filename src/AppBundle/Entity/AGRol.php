<?php

namespace AppBundle\Entity;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Role
 *
 * @ORM\Table(name ="ag_rol")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AGRolRepository")
 * @UniqueEntity(fields={"nombre"}, message="unique.role",repositoryMethod="validateUnique")
 */
class AGRol implements \Symfony\Component\Security\Core\Role\RoleInterface
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="nombre", type="string", length=100,nullable=false)
     *
     */
    private $nombre;


    /**
     * @ORM\Column(name="descripcion", type="string", length=255,nullable=false)
     *
     */
    private $descripcion;


    /**
     * @ORM\ManyToMany(targetEntity="AGUsuario", mappedBy="roles")
     */
    private $usuario;


    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\AGAccion", inversedBy="rol")
     * @ORM\JoinTable(
     *     name="ag_rol_ag_accion",
     *     joinColumns={@ORM\JoinColumn(name="id_rol", referencedColumnName="id", nullable=false,onDelete="CASCADE")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="id_accion", referencedColumnName="id", nullable=false)}
     * )
     */
    private $accion;
    
      /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AGUsuario", inversedBy="rolCrea")
     * @ORM\JoinColumn(
     *     name="id_usuario_crea",
     *     referencedColumnName="id",
     *     nullable=true,onDelete="SET NULL"
     * )
     */
    private $usuarioCrea;
    
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AGUsuario", inversedBy="rolModifica")
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


    public function getRole()
    {
        return $this->getNombre();
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->usuario = new \Doctrine\Common\Collections\ArrayCollection();
        $this->accion = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return AGRol
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
     * @return AGRol
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
     * Add usuario
     *
     * @param \AppBundle\Entity\AGUsuario $usuario
     *
     * @return AGRol
     */
    public function addUsuario(\AppBundle\Entity\AGUsuario $usuario)
    {
        $this->usuario[] = $usuario;

        return $this;
    }

    /**
     * Remove usuario
     *
     * @param \AppBundle\Entity\AGUsuario $usuario
     */
    public function removeUsuario(\AppBundle\Entity\AGUsuario $usuario)
    {
        $this->usuario->removeElement($usuario);
    }

    /**
     * Get usuario
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Add accion
     *
     * @param \AppBundle\Entity\AGAccion $accion
     *
     * @return AGRol
     */
    public function addAccion(\AppBundle\Entity\AGAccion $accion)
    {
        $this->accion[] = $accion;

        return $this;
    }

    /**
     * Remove accion
     *
     * @param \AppBundle\Entity\AGAccion $accion
     */
    public function removeAccion(\AppBundle\Entity\AGAccion $accion)
    {
        $this->accion->removeElement($accion);
    }

    /**
     * Get accion
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAccion()
    {
        return $this->accion;
    }
    
    public function containsActionById($id){
        $actions=$this->accion->toArray();
        foreach ($actions as $act){
            if($act->getId()==$id){
                return true;
            }
        }
        return false;
    }

    /**
     * Set fechaCrea
     *
     * @param \DateTime $fechaCrea
     *
     * @return AGRol
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
     * @return AGRol
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
     * @return AGRol
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
     * @return AGRol
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
     * @return AGRol
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
