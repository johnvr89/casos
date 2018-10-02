<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * AGCuenta
 *
 * @ORM\Table(name="ag_cuenta")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AGCuentaRepository")
 * @UniqueEntity(fields={"numero"}, message="unique.cuenta",repositoryMethod="validateUnique")
 */
class AGCuenta
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
     * @ORM\Column(name="nombre", type="string", length=255,nullable=false)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="numero", type="string", length=30,nullable=false)
     */
    private $numero;
    
     /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AGBanco", inversedBy="cuenta")
     * @ORM\JoinColumn(
     *     name="id_banco",
     *     referencedColumnName="id",
     *     nullable=false
     * )
     */
    private $banco;

    /**
     * @var string
     *
     * @ORM\Column(name="tipoCuenta", type="string", length=255,nullable=false)
     */
    private $tipoCuenta;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AGPagoRealizado", mappedBy="cuenta")
     */
    private $pagoRealizado;
      /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AGUsuario", inversedBy="cuentaCrea")
     * @ORM\JoinColumn(
     *     name="id_usuario_crea",
     *     referencedColumnName="id",
     *     nullable=true,onDelete="SET NULL"
     * )
     */
    private $usuarioCrea;
    
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AGUsuario", inversedBy="cuentaModifica")
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
     * @var integer
     *
     * @ORM\Column(name="empresa_id", type="integer")
     */
    private $empresaId;    


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->pagoRealizado = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return AGCuenta
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
     * Set numero
     *
     * @param string $numero
     *
     * @return AGCuenta
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return string
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set tipoCuenta
     *
     * @param string $tipoCuenta
     *
     * @return AGCuenta
     */
    public function setTipoCuenta($tipoCuenta)
    {
        $this->tipoCuenta = $tipoCuenta;

        return $this;
    }

    /**
     * Get tipoCuenta
     *
     * @return string
     */
    public function getTipoCuenta()
    {
        return $this->tipoCuenta;
    }

    /**
     * Set banco
     *
     * @param \AppBundle\Entity\AGBanco $banco
     *
     * @return AGCuenta
     */
    public function setBanco(\AppBundle\Entity\AGBanco $banco)
    {
        $this->banco = $banco;

        return $this;
    }

    /**
     * Get banco
     *
     * @return \AppBundle\Entity\AGBanco
     */
    public function getBanco()
    {
        return $this->banco;
    }

    /**
     * Add pagoRealizado
     *
     * @param \AppBundle\Entity\AGPagoRealizado $pagoRealizado
     *
     * @return AGCuenta
     */
    public function addPagoRealizado(\AppBundle\Entity\AGPagoRealizado $pagoRealizado)
    {
        $this->pagoRealizado[] = $pagoRealizado;

        return $this;
    }

    /**
     * Remove pagoRealizado
     *
     * @param \AppBundle\Entity\AGPagoRealizado $pagoRealizado
     */
    public function removePagoRealizado(\AppBundle\Entity\AGPagoRealizado $pagoRealizado)
    {
        $this->pagoRealizado->removeElement($pagoRealizado);
    }

    /**
     * Get pagoRealizado
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPagoRealizado()
    {
        return $this->pagoRealizado;
    }

    /**
     * Set fechaCrea
     *
     * @param \DateTime $fechaCrea
     *
     * @return AGCuenta
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
     * @return AGCuenta
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
     * @return AGCuenta
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
     * @return AGCuenta
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
     * @return AGCuenta
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
    
    /**
     * Set empresaId
     *
     * @param integer $empresaId
     *
     * @return AGCuenta
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
}
