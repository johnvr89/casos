<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * AGEmpresa
 *
 * @ORM\Table(name="ag_empresa")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AGEmpresaRepository")
 * @UniqueEntity(fields={"nombre"}, message="unique.company",repositoryMethod="validateUnique")
 */
class AGEmpresa
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
     * @var string
     *
     * @ORM\Column(name="razonSocial", type="text", nullable=true)
     */
    private $razonSocial;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text")
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="text")
     */
    private $direccion;

    /**
     * @var string
     *
     * @ORM\Column(name="tipoIdentificacion", type="string", length=255)
     */
    private $tipoIdentificacion;

    /**
     * @var string
     *
     * @ORM\Column(name="numeroIdentificacion", type="string", length=255)
     */
    private $numeroIdentificacion;

    /**
     * @var string
     *
     * @ORM\Column(name="claveSri", type="string", length=255)
     */
    private $claveSri;
    /**
     * @var string
     *
     * @ORM\Column(name="logo", type="string",length=255,nullable=true)
     */
    private $logo;

    /**
     * @var string
     *
     * @ORM\Column(name="representante", type="string", length=255, nullable=true)
     */
    private $representante;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=255)
     */
    private $telefono;

    /**
     * @var string
     *
     * @ORM\Column(name="correo", type="string", length=255)
     */
    private $correo;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AGCiudad", inversedBy="empresa")
     * @ORM\JoinColumn(
     *     name="id_ciudad",
     *     referencedColumnName="id",
     *     nullable=false
     * )
     */
    private $ciudad;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AGTipoCliente", inversedBy="empresa")
     * @ORM\JoinColumn(
     *     name="id_tipo_cliente",
     *     referencedColumnName="id",
     *     nullable=false
     * )
     */
    private $tipoCliente;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AGCaso", mappedBy="empresa")
     */
    private $casos;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AGCaso", mappedBy="empresaRectora")
     */
    private $casosRectores;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AGUsuario", mappedBy="empresa")
     */
    private $usuario;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AGUsuario", inversedBy="empresaCrea")
     * @ORM\JoinColumn(
     *     name="id_usuario_crea",
     *     referencedColumnName="id",
     *     nullable=true,onDelete="SET NULL"
     * )
     */
    private $usuarioCrea;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AGUsuario", inversedBy="empresaModifica")
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
     * @var integer
     *
     * @ORM\Column(name="empresa_id", type="integer",nullable=true)
     */
    private $empresaId;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->casos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->casosRectores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->usuario = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return AGEmpresa
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
     * Set razonSocial
     *
     * @param string $razonSocial
     *
     * @return AGEmpresa
     */
    public function setRazonSocial($razonSocial)
    {
        $this->razonSocial = $razonSocial;

        return $this;
    }

    /**
     * Get razonSocial
     *
     * @return string
     */
    public function getRazonSocial()
    {
        return $this->razonSocial;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return AGEmpresa
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
     * Set direccion
     *
     * @param string $direccion
     *
     * @return AGEmpresa
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return string
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set tipoIdentificacion
     *
     * @param string $tipoIdentificacion
     *
     * @return AGEmpresa
     */
    public function setTipoIdentificacion($tipoIdentificacion)
    {
        $this->tipoIdentificacion = $tipoIdentificacion;

        return $this;
    }

    /**
     * Get tipoIdentificacion
     *
     * @return string
     */
    public function getTipoIdentificacion()
    {
        return $this->tipoIdentificacion;
    }

    /**
     * Set numeroIdentificacion
     *
     * @param string $numeroIdentificacion
     *
     * @return AGEmpresa
     */
    public function setNumeroIdentificacion($numeroIdentificacion)
    {
        $this->numeroIdentificacion = $numeroIdentificacion;

        return $this;
    }

    /**
     * Get numeroIdentificacion
     *
     * @return string
     */
    public function getNumeroIdentificacion()
    {
        return $this->numeroIdentificacion;
    }

    /**
     * Set claveSri
     *
     * @param string $claveSri
     *
     * @return AGEmpresa
     */
    public function setClaveSri($claveSri)
    {
        $this->claveSri = $claveSri;

        return $this;
    }

    /**
     * Get claveSri
     *
     * @return string
     */
    public function getClaveSri()
    {
        return $this->claveSri;
    }

    /**
     * Set logo
     *
     * @param string $logo
     *
     * @return AGEmpresa
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get logo
     *
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Set representante
     *
     * @param string $representante
     *
     * @return AGEmpresa
     */
    public function setRepresentante($representante)
    {
        $this->representante = $representante;

        return $this;
    }

    /**
     * Get representante
     *
     * @return string
     */
    public function getRepresentante()
    {
        return $this->representante;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     *
     * @return AGEmpresa
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set correo
     *
     * @param string $correo
     *
     * @return AGEmpresa
     */
    public function setCorreo($correo)
    {
        $this->correo = $correo;

        return $this;
    }

    /**
     * Get correo
     *
     * @return string
     */
    public function getCorreo()
    {
        return $this->correo;
    }

    /**
     * Set fechaCrea
     *
     * @param \DateTime $fechaCrea
     *
     * @return AGEmpresa
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
     * Set empresaId
     *
     * @param integer $empresaId
     *
     * @return AGEmpresa
     */
    public function setEmpresaId($empresaId)
    {
        $this->empresaId = $empresaId;

        return $this;
    }

    /**
     * Get empresaId
     *
     * @return integer
     */
    public function getEmpresaId()
    {
        return $this->empresaId;
    }    

    /**
     * Set fechaModifica
     *
     * @param \DateTime $fechaModifica
     *
     * @return AGEmpresa
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
     * Set ciudad
     *
     * @param \AppBundle\Entity\AGCiudad $ciudad
     *
     * @return AGEmpresa
     */
    public function setCiudad(\AppBundle\Entity\AGCiudad $ciudad)
    {
        $this->ciudad = $ciudad;

        return $this;
    }

    /**
     * Get ciudad
     *
     * @return \AppBundle\Entity\AGCiudad
     */
    public function getCiudad()
    {
        return $this->ciudad;
    }

    /**
     * Set tipoCliente
     *
     * @param \AppBundle\Entity\AGTipoCliente $tipoCliente
     *
     * @return AGEmpresa
     */
    public function setTipoCliente(\AppBundle\Entity\AGTipoCliente $tipoCliente)
    {
        $this->tipoCliente = $tipoCliente;

        return $this;
    }

    /**
     * Get tipoCliente
     *
     * @return \AppBundle\Entity\AGTipoCliente
     */
    public function getTipoCliente()
    {
        return $this->tipoCliente;
    }

    /**
     * Add caso
     *
     * @param \AppBundle\Entity\AGCaso $caso
     *
     * @return AGEmpresa
     */
    public function addCaso(\AppBundle\Entity\AGCaso $caso)
    {
        $this->casos[] = $caso;

        return $this;
    }

    /**
     * Remove caso
     *
     * @param \AppBundle\Entity\AGCaso $caso
     */
    public function removeCaso(\AppBundle\Entity\AGCaso $caso)
    {
        $this->casos->removeElement($caso);
    }

    /**
     * Get casos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCasos()
    {
        return $this->casos;
    }

    /**
     * Add casosRectore
     *
     * @param \AppBundle\Entity\AGCaso $casosRectore
     *
     * @return AGEmpresa
     */
    public function addCasosRectore(\AppBundle\Entity\AGCaso $casosRectore)
    {
        $this->casosRectores[] = $casosRectore;

        return $this;
    }

    /**
     * Remove casosRectore
     *
     * @param \AppBundle\Entity\AGCaso $casosRectore
     */
    public function removeCasosRectore(\AppBundle\Entity\AGCaso $casosRectore)
    {
        $this->casosRectores->removeElement($casosRectore);
    }

    /**
     * Get casosRectores
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCasosRectores()
    {
        return $this->casosRectores;
    }

    /**
     * Add usuario
     *
     * @param \AppBundle\Entity\AGUsuario $usuario
     *
     * @return AGEmpresa
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
     * Set usuarioCrea
     *
     * @param \AppBundle\Entity\AGUsuario $usuarioCrea
     *
     * @return AGEmpresa
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
     * @return AGEmpresa
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
     * @return AGEmpresa
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

    public function getCasosReales()
    {
        $case = array();
        $caseCompany = $this->casos->toArray();
        foreach ($caseCompany as $value) {
            if ($value->getVisible() == 1) {
                $case[] = $value;
            }

        }
        return $case;
    }

    public function getTotalDeuda(){
        $total=0;
        $pago=0;
        $cases=$this->getCasosReales();
        foreach ($cases as $case){
            $total+=$case->getHonorarios();
            $pago+=$case->getDineroPagado();
        }
        return  $total-$pago;
    }
}
