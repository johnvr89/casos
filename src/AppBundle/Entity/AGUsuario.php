<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
use Symfony\Component\Yaml\Yaml;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Users
 *
 * @ORM\Table(name="ag_usuario")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AGUsuarioRepository")
 * @UniqueEntity(fields={"username"}, message="Ya existe un usaurio con ese nombre",repositoryMethod="validateUnique")
 */
class AGUsuario implements UserInterface {

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
     * @ORM\Column(name="name", type="string", length=255,unique=true,nullable=false)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="correo", type="string", length=255)
     */
    private $correo;

    /**
     * @var string
     *
     * @ORM\Column(name="nombreinterfaz", type="string", length=255)
     */
    private $nombreinterfaz;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="token", type="text",nullable=true)
     */
    private $token;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=255)
     */
    private $salt;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AGCaso", mappedBy="responsable")
     */
    private $casos;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AGSeguimiento", mappedBy="responsableSeguimiento")
     */
    private $seguimiento;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AGCaso", mappedBy="intermediario")
     */
    private $casoIntermediario;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AGEmpresa", inversedBy="usuario")
     * @ORM\JoinColumn(
     *     name="id_empresa",
     *     referencedColumnName="id",
     *     nullable=true
     * )
     */
    private $empresa;

    /**
     * @ORM\ManyToMany(targetEntity="AGRol",inversedBy="usuario")
     * @ORM\JoinTable(name="ag_usuario_ag_rol",
     *          joinColumns={
     *              @ORM\JoinColumn(name="usuario_id", referencedColumnName="id",onDelete="CASCADE")
     *          },
     *          inverseJoinColumns={
     *              @ORM\JoinColumn(name="rol_id", referencedColumnName="id")
     *          }
     * )
     */
    private $roles;
      /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AGUsuario", inversedBy="usuarioCreaEntity")
     * @ORM\JoinColumn(
     *     name="id_usuario_crea",
     *     referencedColumnName="id",
     *     nullable=true,onDelete="SET NULL"
     * )
     */
    private $usuarioCrea;
    
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AGUsuario", inversedBy="usuarioModificaEntity")
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
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AGAccion", mappedBy="usuarioCrea")
     */
    private $accionCrea;
     
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AGAccion", mappedBy="usuarioModifica")
     */
    private $accionModifica;
    
    
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AGBanco", mappedBy="usuarioCrea")
     */
    private $bancoCrea;
     
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AGBanco", mappedBy="usuarioModifica")
     */
    private $bancoModifica;
    
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AGCaso", mappedBy="usuarioCrea")
     */
    private $casoCrea;
     
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AGCaso", mappedBy="usuarioModifica")
     */
    private $casoModifica;
    
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AGCiudad", mappedBy="usuarioCrea")
     */
    private $ciudadCrea;
     
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AGCiudad", mappedBy="usuarioModifica")
     */
    private $ciudadModifica;
    
     /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AGCuenta", mappedBy="usuarioCrea")
     */
    private $cuentaCrea;
     
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AGCuenta", mappedBy="usuarioModifica")
     */
    private $cuentaModifica;
    
     /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AGDetalle", mappedBy="usuarioCrea")
     */
    private $detalleCrea;
     
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AGDetalle", mappedBy="usuarioModifica")
     */
    private $detalleModifica;
    
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AGDocumento", mappedBy="usuarioCrea")
     */
    private $documentoCrea;
     
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AGDocumento", mappedBy="usuarioModifica")
     */
    private $documentoModifica;
    
    
     /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AGEmpresa", mappedBy="usuarioCrea")
     */
    private $empresaCrea;
     
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AGEmpresa", mappedBy="usuarioModifica")
     */
    private $empresaModifica;
    
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AGEstado", mappedBy="usuarioCrea")
     */
    private $estadoCrea;
     
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AGEstado", mappedBy="usuarioModifica")
     */
    private $estadoModifica;
    
     /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AGFormaPago", mappedBy="usuarioCrea")
     */
    private $formaPagoCrea;
     
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AGFormaPago", mappedBy="usuarioModifica")
     */
    private $formaPagoModifica;
    
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AGPagoRealizado", mappedBy="usuarioCrea")
     */
    private $pagoRealizadoCrea;
     
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AGPagoRealizado", mappedBy="usuarioModifica")
     */
    private $pagoRealizadoModifica;
    
     /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AGRol", mappedBy="usuarioCrea")
     */
    private $rolCrea;
     
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AGRol", mappedBy="usuarioModifica")
     */
    private $rolModifica;
    
      /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AGSeguimiento", mappedBy="usuarioCrea")
     */
    private $seguimientoCrea;
     
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AGSeguimiento", mappedBy="usuarioModifica")
     */
    private $seguimientoModifica;
    
    
      /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AGTipoCaso", mappedBy="usuarioCrea")
     */
    private $tipoCasoCrea;
     
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AGTipoCaso", mappedBy="usuarioModifica")
     */
    private $tipoCasoModifica;
    
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AGTipoCasoCaracteristica", mappedBy="usuarioCrea")
     */
    private $tipoCasoCaracteristicaCrea;
     
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AGTipoCasoCaracteristica", mappedBy="usuarioModifica")
     */
    private $tipoCasoCaracteristicaModifica;
    
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AGTipoCliente", mappedBy="usuarioCrea")
     */
    private $tipoClienteCrea;
     
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AGTipoCliente", mappedBy="usuarioModifica")
     */
    private $tipoClienteModifica;
    
     /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AGTipoCobro", mappedBy="usuarioCrea")
     */
    private $tipoCobroCrea;
     
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AGTipoCobro", mappedBy="usuarioModifica")
     */
    private $tipoCobroModifica;
    
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AGTipoDatos", mappedBy="usuarioCrea")
     */
    private $tipoDatosCrea;
     
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AGTipoDatos", mappedBy="usuarioModifica")
     */
    private $tipoDatosModifica;
    
      /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AGUsuario", mappedBy="usuarioCrea")
     */
    private $usuarioCreaEntity;
     
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AGUsuario", mappedBy="usuarioModifica")
     */
    private $usuarioModificaEntity;
    
     /**
     * @var string
     *
     * @ORM\Column(name="visible", type="integer",nullable=true,options={"default" : 1})
     */
    private $visible=1;
    
    public function userHasRole($roleId)
    {
        $role=$this->getRoles();
        foreach ( $role as $rol )
        {
            if( $rol->getId()==$roleId )
            {
                return true;
            }
        }
        return false;
    }
    
    public function eraseCredentials() {
        
    }

    public function getPassword() {
        return $this->password;
    }

    public function getRoles() {
        return $this->roles->toArray();
    }

    public function getSalt() {
        return $this->salt;
    }

    public function getUsername() {
        return $this->username;
    }

    /**
     * Constructor
     */
    public function __construct() {
        $this->casos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->casoIntermediario = new \Doctrine\Common\Collections\ArrayCollection();
        $this->roles = new \Doctrine\Common\Collections\ArrayCollection();
        $this->salt = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
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
     * Set username
     *
     * @param string $username
     *
     * @return AGUsuario
     */
    public function setUsername($username) {
        $this->username = $username;

        return $this;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return AGUsuario
     */
    public function setPassword($password) {
        if (!empty($password)) {
           
            $encode = new MessageDigestPasswordEncoder(
                   'sha512', false,1
            );

            $this->password = $encode->encodePassword($password, $this->salt);
        }
    }

    /**
     * Set token
     *
     * @param string $token
     *
     * @return AGUsuario
     */
    public function setToken($token) {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string
     */
    public function getToken() {
        return $this->token;
    }

    /**
     * Set salt
     *
     * @param string $salt
     *
     * @return AGUsuario
     */
    public function setSalt($salt) {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Add caso
     *
     * @param \AppBundle\Entity\AGCaso $caso
     *
     * @return AGUsuario
     */
    public function addCaso(\AppBundle\Entity\AGCaso $caso) {
        $this->casos[] = $caso;

        return $this;
    }

    /**
     * Remove caso
     *
     * @param \AppBundle\Entity\AGCaso $caso
     */
    public function removeCaso(\AppBundle\Entity\AGCaso $caso) {
        $this->casos->removeElement($caso);
    }

    /**
     * Get casos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCasos() {
        return $this->casos;
    }

    /**
     * Add casoIntermediario
     *
     * @param \AppBundle\Entity\AGCaso $casoIntermediario
     *
     * @return AGUsuario
     */
    public function addCasoIntermediario(\AppBundle\Entity\AGCaso $casoIntermediario) {
        $this->casoIntermediario[] = $casoIntermediario;

        return $this;
    }

    /**
     * Remove casoIntermediario
     *
     * @param \AppBundle\Entity\AGCaso $casoIntermediario
     */
    public function removeCasoIntermediario(\AppBundle\Entity\AGCaso $casoIntermediario) {
        $this->casoIntermediario->removeElement($casoIntermediario);
    }

    /**
     * Get casoIntermediario
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCasoIntermediario() {
        return $this->casoIntermediario;
    }

    /**
     * Set empresa
     *
     * @param \AppBundle\Entity\AGEmpresa $empresa
     *
     * @return AGUsuario
     */
    public function setEmpresa(\AppBundle\Entity\AGEmpresa $empresa = null) {
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
     * Add role
     *
     * @param \AppBundle\Entity\AGRol $role
     *
     * @return AGUsuario
     */
    public function addRole(\AppBundle\Entity\AGRol $role) {
        $this->roles[] = $role;

        return $this;
    }

    /**
     * Remove role
     *
     * @param \AppBundle\Entity\AGRol $role
     */
    public function removeRole(\AppBundle\Entity\AGRol $role) {
        $this->roles->removeElement($role);
    }

    /**
     * Set nombreinterfaz
     *
     * @param string $nombreinterfaz
     *
     * @return AGUsuario
     */
    public function setNombreinterfaz($nombreinterfaz) {
        $this->nombreinterfaz = $nombreinterfaz;

        return $this;
    }

    /**
     * Get nombreinterfaz
     *
     * @return string
     */
    public function getNombreinterfaz() {
        return $this->nombreinterfaz;
    }

    /**
     * Set correo
     *
     * @param string $correo
     *
     * @return AGUsuario
     */
    public function setCorreo($correo) {
        $this->correo = $correo;

        return $this;
    }

    /**
     * Get correo
     *
     * @return string
     */
    public function getCorreo() {
        return $this->correo;
    }

    /**
     * Add seguimiento
     *
     * @param \AppBundle\Entity\AGSeguimiento $seguimiento
     *
     * @return AGUsuario
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
     * Set fechaCrea
     *
     * @param \DateTime $fechaCrea
     *
     * @return AGUsuario
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
     * @return AGUsuario
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
     * @return AGUsuario
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
     * @return AGUsuario
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
     * Add accionCrea
     *
     * @param \AppBundle\Entity\AGAccion $accionCrea
     *
     * @return AGUsuario
     */
    public function addAccionCrea(\AppBundle\Entity\AGAccion $accionCrea)
    {
        $this->accionCrea[] = $accionCrea;

        return $this;
    }

    /**
     * Remove accionCrea
     *
     * @param \AppBundle\Entity\AGAccion $accionCrea
     */
    public function removeAccionCrea(\AppBundle\Entity\AGAccion $accionCrea)
    {
        $this->accionCrea->removeElement($accionCrea);
    }

    /**
     * Get accionCrea
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAccionCrea()
    {
        return $this->accionCrea;
    }

    /**
     * Add accionModifica
     *
     * @param \AppBundle\Entity\AGAccion $accionModifica
     *
     * @return AGUsuario
     */
    public function addAccionModifica(\AppBundle\Entity\AGAccion $accionModifica)
    {
        $this->accionModifica[] = $accionModifica;

        return $this;
    }

    /**
     * Remove accionModifica
     *
     * @param \AppBundle\Entity\AGAccion $accionModifica
     */
    public function removeAccionModifica(\AppBundle\Entity\AGAccion $accionModifica)
    {
        $this->accionModifica->removeElement($accionModifica);
    }

    /**
     * Get accionModifica
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAccionModifica()
    {
        return $this->accionModifica;
    }

    /**
     * Add bancoCrea
     *
     * @param \AppBundle\Entity\AGBanco $bancoCrea
     *
     * @return AGUsuario
     */
    public function addBancoCrea(\AppBundle\Entity\AGBanco $bancoCrea)
    {
        $this->bancoCrea[] = $bancoCrea;

        return $this;
    }

    /**
     * Remove bancoCrea
     *
     * @param \AppBundle\Entity\AGBanco $bancoCrea
     */
    public function removeBancoCrea(\AppBundle\Entity\AGBanco $bancoCrea)
    {
        $this->bancoCrea->removeElement($bancoCrea);
    }

    /**
     * Get bancoCrea
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBancoCrea()
    {
        return $this->bancoCrea;
    }

    /**
     * Add bancoModifica
     *
     * @param \AppBundle\Entity\AGBanco $bancoModifica
     *
     * @return AGUsuario
     */
    public function addBancoModifica(\AppBundle\Entity\AGBanco $bancoModifica)
    {
        $this->bancoModifica[] = $bancoModifica;

        return $this;
    }

    /**
     * Remove bancoModifica
     *
     * @param \AppBundle\Entity\AGBanco $bancoModifica
     */
    public function removeBancoModifica(\AppBundle\Entity\AGBanco $bancoModifica)
    {
        $this->bancoModifica->removeElement($bancoModifica);
    }

    /**
     * Get bancoModifica
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBancoModifica()
    {
        return $this->bancoModifica;
    }

    /**
     * Add casoCrea
     *
     * @param \AppBundle\Entity\AGCaso $casoCrea
     *
     * @return AGUsuario
     */
    public function addCasoCrea(\AppBundle\Entity\AGCaso $casoCrea)
    {
        $this->casoCrea[] = $casoCrea;

        return $this;
    }

    /**
     * Remove casoCrea
     *
     * @param \AppBundle\Entity\AGCaso $casoCrea
     */
    public function removeCasoCrea(\AppBundle\Entity\AGCaso $casoCrea)
    {
        $this->casoCrea->removeElement($casoCrea);
    }

    /**
     * Get casoCrea
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCasoCrea()
    {
        return $this->casoCrea;
    }

    /**
     * Add casoModifica
     *
     * @param \AppBundle\Entity\AGCaso $casoModifica
     *
     * @return AGUsuario
     */
    public function addCasoModifica(\AppBundle\Entity\AGCaso $casoModifica)
    {
        $this->casoModifica[] = $casoModifica;

        return $this;
    }

    /**
     * Remove casoModifica
     *
     * @param \AppBundle\Entity\AGCaso $casoModifica
     */
    public function removeCasoModifica(\AppBundle\Entity\AGCaso $casoModifica)
    {
        $this->casoModifica->removeElement($casoModifica);
    }

    /**
     * Get casoModifica
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCasoModifica()
    {
        return $this->casoModifica;
    }

    /**
     * Add ciudadCrea
     *
     * @param \AppBundle\Entity\AGCiudad $ciudadCrea
     *
     * @return AGUsuario
     */
    public function addCiudadCrea(\AppBundle\Entity\AGCiudad $ciudadCrea)
    {
        $this->ciudadCrea[] = $ciudadCrea;

        return $this;
    }

    /**
     * Remove ciudadCrea
     *
     * @param \AppBundle\Entity\AGCiudad $ciudadCrea
     */
    public function removeCiudadCrea(\AppBundle\Entity\AGCiudad $ciudadCrea)
    {
        $this->ciudadCrea->removeElement($ciudadCrea);
    }

    /**
     * Get ciudadCrea
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCiudadCrea()
    {
        return $this->ciudadCrea;
    }

    /**
     * Add ciudadModifica
     *
     * @param \AppBundle\Entity\AGCiudad $ciudadModifica
     *
     * @return AGUsuario
     */
    public function addCiudadModifica(\AppBundle\Entity\AGCiudad $ciudadModifica)
    {
        $this->ciudadModifica[] = $ciudadModifica;

        return $this;
    }

    /**
     * Remove ciudadModifica
     *
     * @param \AppBundle\Entity\AGCiudad $ciudadModifica
     */
    public function removeCiudadModifica(\AppBundle\Entity\AGCiudad $ciudadModifica)
    {
        $this->ciudadModifica->removeElement($ciudadModifica);
    }

    /**
     * Get ciudadModifica
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCiudadModifica()
    {
        return $this->ciudadModifica;
    }

    /**
     * Add cuentaCrea
     *
     * @param \AppBundle\Entity\AGCuenta $cuentaCrea
     *
     * @return AGUsuario
     */
    public function addCuentaCrea(\AppBundle\Entity\AGCuenta $cuentaCrea)
    {
        $this->cuentaCrea[] = $cuentaCrea;

        return $this;
    }

    /**
     * Remove cuentaCrea
     *
     * @param \AppBundle\Entity\AGCuenta $cuentaCrea
     */
    public function removeCuentaCrea(\AppBundle\Entity\AGCuenta $cuentaCrea)
    {
        $this->cuentaCrea->removeElement($cuentaCrea);
    }

    /**
     * Get cuentaCrea
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCuentaCrea()
    {
        return $this->cuentaCrea;
    }

    /**
     * Add cuentaModifica
     *
     * @param \AppBundle\Entity\AGCuenta $cuentaModifica
     *
     * @return AGUsuario
     */
    public function addCuentaModifica(\AppBundle\Entity\AGCuenta $cuentaModifica)
    {
        $this->cuentaModifica[] = $cuentaModifica;

        return $this;
    }

    /**
     * Remove cuentaModifica
     *
     * @param \AppBundle\Entity\AGCuenta $cuentaModifica
     */
    public function removeCuentaModifica(\AppBundle\Entity\AGCuenta $cuentaModifica)
    {
        $this->cuentaModifica->removeElement($cuentaModifica);
    }

    /**
     * Get cuentaModifica
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCuentaModifica()
    {
        return $this->cuentaModifica;
    }

    /**
     * Add detalleCrea
     *
     * @param \AppBundle\Entity\AGDetalle $detalleCrea
     *
     * @return AGUsuario
     */
    public function addDetalleCrea(\AppBundle\Entity\AGDetalle $detalleCrea)
    {
        $this->detalleCrea[] = $detalleCrea;

        return $this;
    }

    /**
     * Remove detalleCrea
     *
     * @param \AppBundle\Entity\AGDetalle $detalleCrea
     */
    public function removeDetalleCrea(\AppBundle\Entity\AGDetalle $detalleCrea)
    {
        $this->detalleCrea->removeElement($detalleCrea);
    }

    /**
     * Get detalleCrea
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDetalleCrea()
    {
        return $this->detalleCrea;
    }

    /**
     * Add detalleModifica
     *
     * @param \AppBundle\Entity\AGDetalle $detalleModifica
     *
     * @return AGUsuario
     */
    public function addDetalleModifica(\AppBundle\Entity\AGDetalle $detalleModifica)
    {
        $this->detalleModifica[] = $detalleModifica;

        return $this;
    }

    /**
     * Remove detalleModifica
     *
     * @param \AppBundle\Entity\AGDetalle $detalleModifica
     */
    public function removeDetalleModifica(\AppBundle\Entity\AGDetalle $detalleModifica)
    {
        $this->detalleModifica->removeElement($detalleModifica);
    }

    /**
     * Get detalleModifica
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDetalleModifica()
    {
        return $this->detalleModifica;
    }

    /**
     * Add documentoCrea
     *
     * @param \AppBundle\Entity\AGDocumento $documentoCrea
     *
     * @return AGUsuario
     */
    public function addDocumentoCrea(\AppBundle\Entity\AGDocumento $documentoCrea)
    {
        $this->documentoCrea[] = $documentoCrea;

        return $this;
    }

    /**
     * Remove documentoCrea
     *
     * @param \AppBundle\Entity\AGDocumento $documentoCrea
     */
    public function removeDocumentoCrea(\AppBundle\Entity\AGDocumento $documentoCrea)
    {
        $this->documentoCrea->removeElement($documentoCrea);
    }

    /**
     * Get documentoCrea
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDocumentoCrea()
    {
        return $this->documentoCrea;
    }

    /**
     * Add documentoModifica
     *
     * @param \AppBundle\Entity\AGDocumento $documentoModifica
     *
     * @return AGUsuario
     */
    public function addDocumentoModifica(\AppBundle\Entity\AGDocumento $documentoModifica)
    {
        $this->documentoModifica[] = $documentoModifica;

        return $this;
    }

    /**
     * Remove documentoModifica
     *
     * @param \AppBundle\Entity\AGDocumento $documentoModifica
     */
    public function removeDocumentoModifica(\AppBundle\Entity\AGDocumento $documentoModifica)
    {
        $this->documentoModifica->removeElement($documentoModifica);
    }

    /**
     * Get documentoModifica
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDocumentoModifica()
    {
        return $this->documentoModifica;
    }

    /**
     * Add empresaCrea
     *
     * @param \AppBundle\Entity\AGEmpresa $empresaCrea
     *
     * @return AGUsuario
     */
    public function addEmpresaCrea(\AppBundle\Entity\AGEmpresa $empresaCrea)
    {
        $this->empresaCrea[] = $empresaCrea;

        return $this;
    }

    /**
     * Remove empresaCrea
     *
     * @param \AppBundle\Entity\AGEmpresa $empresaCrea
     */
    public function removeEmpresaCrea(\AppBundle\Entity\AGEmpresa $empresaCrea)
    {
        $this->empresaCrea->removeElement($empresaCrea);
    }

    /**
     * Get empresaCrea
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEmpresaCrea()
    {
        return $this->empresaCrea;
    }

    /**
     * Add empresaModifica
     *
     * @param \AppBundle\Entity\AGEmpresa $empresaModifica
     *
     * @return AGUsuario
     */
    public function addEmpresaModifica(\AppBundle\Entity\AGEmpresa $empresaModifica)
    {
        $this->empresaModifica[] = $empresaModifica;

        return $this;
    }

    /**
     * Remove empresaModifica
     *
     * @param \AppBundle\Entity\AGEmpresa $empresaModifica
     */
    public function removeEmpresaModifica(\AppBundle\Entity\AGEmpresa $empresaModifica)
    {
        $this->empresaModifica->removeElement($empresaModifica);
    }

    /**
     * Get empresaModifica
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEmpresaModifica()
    {
        return $this->empresaModifica;
    }

    /**
     * Add estadoCrea
     *
     * @param \AppBundle\Entity\AGEstado $estadoCrea
     *
     * @return AGUsuario
     */
    public function addEstadoCrea(\AppBundle\Entity\AGEstado $estadoCrea)
    {
        $this->estadoCrea[] = $estadoCrea;

        return $this;
    }

    /**
     * Remove estadoCrea
     *
     * @param \AppBundle\Entity\AGEstado $estadoCrea
     */
    public function removeEstadoCrea(\AppBundle\Entity\AGEstado $estadoCrea)
    {
        $this->estadoCrea->removeElement($estadoCrea);
    }

    /**
     * Get estadoCrea
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEstadoCrea()
    {
        return $this->estadoCrea;
    }

    /**
     * Add estadoModifica
     *
     * @param \AppBundle\Entity\AGEstado $estadoModifica
     *
     * @return AGUsuario
     */
    public function addEstadoModifica(\AppBundle\Entity\AGEstado $estadoModifica)
    {
        $this->estadoModifica[] = $estadoModifica;

        return $this;
    }

    /**
     * Remove estadoModifica
     *
     * @param \AppBundle\Entity\AGEstado $estadoModifica
     */
    public function removeEstadoModifica(\AppBundle\Entity\AGEstado $estadoModifica)
    {
        $this->estadoModifica->removeElement($estadoModifica);
    }

    /**
     * Get estadoModifica
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEstadoModifica()
    {
        return $this->estadoModifica;
    }

    /**
     * Add formaPagoCrea
     *
     * @param \AppBundle\Entity\AGFormaPago $formaPagoCrea
     *
     * @return AGUsuario
     */
    public function addFormaPagoCrea(\AppBundle\Entity\AGFormaPago $formaPagoCrea)
    {
        $this->formaPagoCrea[] = $formaPagoCrea;

        return $this;
    }

    /**
     * Remove formaPagoCrea
     *
     * @param \AppBundle\Entity\AGFormaPago $formaPagoCrea
     */
    public function removeFormaPagoCrea(\AppBundle\Entity\AGFormaPago $formaPagoCrea)
    {
        $this->formaPagoCrea->removeElement($formaPagoCrea);
    }

    /**
     * Get formaPagoCrea
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFormaPagoCrea()
    {
        return $this->formaPagoCrea;
    }

    /**
     * Add formaPagoModifica
     *
     * @param \AppBundle\Entity\AGFormaPago $formaPagoModifica
     *
     * @return AGUsuario
     */
    public function addFormaPagoModifica(\AppBundle\Entity\AGFormaPago $formaPagoModifica)
    {
        $this->formaPagoModifica[] = $formaPagoModifica;

        return $this;
    }

    /**
     * Remove formaPagoModifica
     *
     * @param \AppBundle\Entity\AGFormaPago $formaPagoModifica
     */
    public function removeFormaPagoModifica(\AppBundle\Entity\AGFormaPago $formaPagoModifica)
    {
        $this->formaPagoModifica->removeElement($formaPagoModifica);
    }

    /**
     * Get formaPagoModifica
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFormaPagoModifica()
    {
        return $this->formaPagoModifica;
    }

    /**
     * Add pagoRealizadoCrea
     *
     * @param \AppBundle\Entity\AGPagoRealizado $pagoRealizadoCrea
     *
     * @return AGUsuario
     */
    public function addPagoRealizadoCrea(\AppBundle\Entity\AGPagoRealizado $pagoRealizadoCrea)
    {
        $this->pagoRealizadoCrea[] = $pagoRealizadoCrea;

        return $this;
    }

    /**
     * Remove pagoRealizadoCrea
     *
     * @param \AppBundle\Entity\AGPagoRealizado $pagoRealizadoCrea
     */
    public function removePagoRealizadoCrea(\AppBundle\Entity\AGPagoRealizado $pagoRealizadoCrea)
    {
        $this->pagoRealizadoCrea->removeElement($pagoRealizadoCrea);
    }

    /**
     * Get pagoRealizadoCrea
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPagoRealizadoCrea()
    {
        return $this->pagoRealizadoCrea;
    }

    /**
     * Add pagoRealizadoModifica
     *
     * @param \AppBundle\Entity\AGPagoRealizado $pagoRealizadoModifica
     *
     * @return AGUsuario
     */
    public function addPagoRealizadoModifica(\AppBundle\Entity\AGPagoRealizado $pagoRealizadoModifica)
    {
        $this->pagoRealizadoModifica[] = $pagoRealizadoModifica;

        return $this;
    }

    /**
     * Remove pagoRealizadoModifica
     *
     * @param \AppBundle\Entity\AGPagoRealizado $pagoRealizadoModifica
     */
    public function removePagoRealizadoModifica(\AppBundle\Entity\AGPagoRealizado $pagoRealizadoModifica)
    {
        $this->pagoRealizadoModifica->removeElement($pagoRealizadoModifica);
    }

    /**
     * Get pagoRealizadoModifica
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPagoRealizadoModifica()
    {
        return $this->pagoRealizadoModifica;
    }

    /**
     * Add rolCrea
     *
     * @param \AppBundle\Entity\AGRol $rolCrea
     *
     * @return AGUsuario
     */
    public function addRolCrea(\AppBundle\Entity\AGRol $rolCrea)
    {
        $this->rolCrea[] = $rolCrea;

        return $this;
    }

    /**
     * Remove rolCrea
     *
     * @param \AppBundle\Entity\AGRol $rolCrea
     */
    public function removeRolCrea(\AppBundle\Entity\AGRol $rolCrea)
    {
        $this->rolCrea->removeElement($rolCrea);
    }

    /**
     * Get rolCrea
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRolCrea()
    {
        return $this->rolCrea;
    }

    /**
     * Add rolModifica
     *
     * @param \AppBundle\Entity\AGRol $rolModifica
     *
     * @return AGUsuario
     */
    public function addRolModifica(\AppBundle\Entity\AGRol $rolModifica)
    {
        $this->rolModifica[] = $rolModifica;

        return $this;
    }

    /**
     * Remove rolModifica
     *
     * @param \AppBundle\Entity\AGRol $rolModifica
     */
    public function removeRolModifica(\AppBundle\Entity\AGRol $rolModifica)
    {
        $this->rolModifica->removeElement($rolModifica);
    }

    /**
     * Get rolModifica
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRolModifica()
    {
        return $this->rolModifica;
    }

    /**
     * Add seguimientoCrea
     *
     * @param \AppBundle\Entity\AGSeguimiento $seguimientoCrea
     *
     * @return AGUsuario
     */
    public function addSeguimientoCrea(\AppBundle\Entity\AGSeguimiento $seguimientoCrea)
    {
        $this->seguimientoCrea[] = $seguimientoCrea;

        return $this;
    }

    /**
     * Remove seguimientoCrea
     *
     * @param \AppBundle\Entity\AGSeguimiento $seguimientoCrea
     */
    public function removeSeguimientoCrea(\AppBundle\Entity\AGSeguimiento $seguimientoCrea)
    {
        $this->seguimientoCrea->removeElement($seguimientoCrea);
    }

    /**
     * Get seguimientoCrea
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSeguimientoCrea()
    {
        return $this->seguimientoCrea;
    }

    /**
     * Add seguimientoModifica
     *
     * @param \AppBundle\Entity\AGSeguimiento $seguimientoModifica
     *
     * @return AGUsuario
     */
    public function addSeguimientoModifica(\AppBundle\Entity\AGSeguimiento $seguimientoModifica)
    {
        $this->seguimientoModifica[] = $seguimientoModifica;

        return $this;
    }

    /**
     * Remove seguimientoModifica
     *
     * @param \AppBundle\Entity\AGSeguimiento $seguimientoModifica
     */
    public function removeSeguimientoModifica(\AppBundle\Entity\AGSeguimiento $seguimientoModifica)
    {
        $this->seguimientoModifica->removeElement($seguimientoModifica);
    }

    /**
     * Get seguimientoModifica
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSeguimientoModifica()
    {
        return $this->seguimientoModifica;
    }

    /**
     * Add tipoCasoCrea
     *
     * @param \AppBundle\Entity\AGTipoCaso $tipoCasoCrea
     *
     * @return AGUsuario
     */
    public function addTipoCasoCrea(\AppBundle\Entity\AGTipoCaso $tipoCasoCrea)
    {
        $this->tipoCasoCrea[] = $tipoCasoCrea;

        return $this;
    }

    /**
     * Remove tipoCasoCrea
     *
     * @param \AppBundle\Entity\AGTipoCaso $tipoCasoCrea
     */
    public function removeTipoCasoCrea(\AppBundle\Entity\AGTipoCaso $tipoCasoCrea)
    {
        $this->tipoCasoCrea->removeElement($tipoCasoCrea);
    }

    /**
     * Get tipoCasoCrea
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTipoCasoCrea()
    {
        return $this->tipoCasoCrea;
    }

    /**
     * Add tipoCasoModifica
     *
     * @param \AppBundle\Entity\AGTipoCaso $tipoCasoModifica
     *
     * @return AGUsuario
     */
    public function addTipoCasoModifica(\AppBundle\Entity\AGTipoCaso $tipoCasoModifica)
    {
        $this->tipoCasoModifica[] = $tipoCasoModifica;

        return $this;
    }

    /**
     * Remove tipoCasoModifica
     *
     * @param \AppBundle\Entity\AGTipoCaso $tipoCasoModifica
     */
    public function removeTipoCasoModifica(\AppBundle\Entity\AGTipoCaso $tipoCasoModifica)
    {
        $this->tipoCasoModifica->removeElement($tipoCasoModifica);
    }

    /**
     * Get tipoCasoModifica
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTipoCasoModifica()
    {
        return $this->tipoCasoModifica;
    }

    /**
     * Add tipoCasoCaracteristicaCrea
     *
     * @param \AppBundle\Entity\AGTipoCasoCaracteristica $tipoCasoCaracteristicaCrea
     *
     * @return AGUsuario
     */
    public function addTipoCasoCaracteristicaCrea(\AppBundle\Entity\AGTipoCasoCaracteristica $tipoCasoCaracteristicaCrea)
    {
        $this->tipoCasoCaracteristicaCrea[] = $tipoCasoCaracteristicaCrea;

        return $this;
    }

    /**
     * Remove tipoCasoCaracteristicaCrea
     *
     * @param \AppBundle\Entity\AGTipoCasoCaracteristica $tipoCasoCaracteristicaCrea
     */
    public function removeTipoCasoCaracteristicaCrea(\AppBundle\Entity\AGTipoCasoCaracteristica $tipoCasoCaracteristicaCrea)
    {
        $this->tipoCasoCaracteristicaCrea->removeElement($tipoCasoCaracteristicaCrea);
    }

    /**
     * Get tipoCasoCaracteristicaCrea
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTipoCasoCaracteristicaCrea()
    {
        return $this->tipoCasoCaracteristicaCrea;
    }

    /**
     * Add tipoCasoCaracteristicaModifica
     *
     * @param \AppBundle\Entity\AGTipoCasoCaracteristica $tipoCasoCaracteristicaModifica
     *
     * @return AGUsuario
     */
    public function addTipoCasoCaracteristicaModifica(\AppBundle\Entity\AGTipoCasoCaracteristica $tipoCasoCaracteristicaModifica)
    {
        $this->tipoCasoCaracteristicaModifica[] = $tipoCasoCaracteristicaModifica;

        return $this;
    }

    /**
     * Remove tipoCasoCaracteristicaModifica
     *
     * @param \AppBundle\Entity\AGTipoCasoCaracteristica $tipoCasoCaracteristicaModifica
     */
    public function removeTipoCasoCaracteristicaModifica(\AppBundle\Entity\AGTipoCasoCaracteristica $tipoCasoCaracteristicaModifica)
    {
        $this->tipoCasoCaracteristicaModifica->removeElement($tipoCasoCaracteristicaModifica);
    }

    /**
     * Get tipoCasoCaracteristicaModifica
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTipoCasoCaracteristicaModifica()
    {
        return $this->tipoCasoCaracteristicaModifica;
    }

    /**
     * Add tipoClienteCrea
     *
     * @param \AppBundle\Entity\AGTipoCliente $tipoClienteCrea
     *
     * @return AGUsuario
     */
    public function addTipoClienteCrea(\AppBundle\Entity\AGTipoCliente $tipoClienteCrea)
    {
        $this->tipoClienteCrea[] = $tipoClienteCrea;

        return $this;
    }

    /**
     * Remove tipoClienteCrea
     *
     * @param \AppBundle\Entity\AGTipoCliente $tipoClienteCrea
     */
    public function removeTipoClienteCrea(\AppBundle\Entity\AGTipoCliente $tipoClienteCrea)
    {
        $this->tipoClienteCrea->removeElement($tipoClienteCrea);
    }

    /**
     * Get tipoClienteCrea
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTipoClienteCrea()
    {
        return $this->tipoClienteCrea;
    }

    /**
     * Add tipoClienteModifica
     *
     * @param \AppBundle\Entity\AGTipoCliente $tipoClienteModifica
     *
     * @return AGUsuario
     */
    public function addTipoClienteModifica(\AppBundle\Entity\AGTipoCliente $tipoClienteModifica)
    {
        $this->tipoClienteModifica[] = $tipoClienteModifica;

        return $this;
    }

    /**
     * Remove tipoClienteModifica
     *
     * @param \AppBundle\Entity\AGTipoCliente $tipoClienteModifica
     */
    public function removeTipoClienteModifica(\AppBundle\Entity\AGTipoCliente $tipoClienteModifica)
    {
        $this->tipoClienteModifica->removeElement($tipoClienteModifica);
    }

    /**
     * Get tipoClienteModifica
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTipoClienteModifica()
    {
        return $this->tipoClienteModifica;
    }

    /**
     * Add tipoCobroCrea
     *
     * @param \AppBundle\Entity\AGTipoCobro $tipoCobroCrea
     *
     * @return AGUsuario
     */
    public function addTipoCobroCrea(\AppBundle\Entity\AGTipoCobro $tipoCobroCrea)
    {
        $this->tipoCobroCrea[] = $tipoCobroCrea;

        return $this;
    }

    /**
     * Remove tipoCobroCrea
     *
     * @param \AppBundle\Entity\AGTipoCobro $tipoCobroCrea
     */
    public function removeTipoCobroCrea(\AppBundle\Entity\AGTipoCobro $tipoCobroCrea)
    {
        $this->tipoCobroCrea->removeElement($tipoCobroCrea);
    }

    /**
     * Get tipoCobroCrea
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTipoCobroCrea()
    {
        return $this->tipoCobroCrea;
    }

    /**
     * Add tipoCobroModifica
     *
     * @param \AppBundle\Entity\AGTipoCobro $tipoCobroModifica
     *
     * @return AGUsuario
     */
    public function addTipoCobroModifica(\AppBundle\Entity\AGTipoCobro $tipoCobroModifica)
    {
        $this->tipoCobroModifica[] = $tipoCobroModifica;

        return $this;
    }

    /**
     * Remove tipoCobroModifica
     *
     * @param \AppBundle\Entity\AGTipoCobro $tipoCobroModifica
     */
    public function removeTipoCobroModifica(\AppBundle\Entity\AGTipoCobro $tipoCobroModifica)
    {
        $this->tipoCobroModifica->removeElement($tipoCobroModifica);
    }

    /**
     * Get tipoCobroModifica
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTipoCobroModifica()
    {
        return $this->tipoCobroModifica;
    }

    /**
     * Add tipoDatosCrea
     *
     * @param \AppBundle\Entity\AGTipoDatos $tipoDatosCrea
     *
     * @return AGUsuario
     */
    public function addTipoDatosCrea(\AppBundle\Entity\AGTipoDatos $tipoDatosCrea)
    {
        $this->tipoDatosCrea[] = $tipoDatosCrea;

        return $this;
    }

    /**
     * Remove tipoDatosCrea
     *
     * @param \AppBundle\Entity\AGTipoDatos $tipoDatosCrea
     */
    public function removeTipoDatosCrea(\AppBundle\Entity\AGTipoDatos $tipoDatosCrea)
    {
        $this->tipoDatosCrea->removeElement($tipoDatosCrea);
    }

    /**
     * Get tipoDatosCrea
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTipoDatosCrea()
    {
        return $this->tipoDatosCrea;
    }

    /**
     * Add tipoDatosModifica
     *
     * @param \AppBundle\Entity\AGTipoDatos $tipoDatosModifica
     *
     * @return AGUsuario
     */
    public function addTipoDatosModifica(\AppBundle\Entity\AGTipoDatos $tipoDatosModifica)
    {
        $this->tipoDatosModifica[] = $tipoDatosModifica;

        return $this;
    }

    /**
     * Remove tipoDatosModifica
     *
     * @param \AppBundle\Entity\AGTipoDatos $tipoDatosModifica
     */
    public function removeTipoDatosModifica(\AppBundle\Entity\AGTipoDatos $tipoDatosModifica)
    {
        $this->tipoDatosModifica->removeElement($tipoDatosModifica);
    }

    /**
     * Get tipoDatosModifica
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTipoDatosModifica()
    {
        return $this->tipoDatosModifica;
    }

    /**
     * Add usuarioCreaEntity
     *
     * @param \AppBundle\Entity\AGUsuario $usuarioCreaEntity
     *
     * @return AGUsuario
     */
    public function addUsuarioCreaEntity(\AppBundle\Entity\AGUsuario $usuarioCreaEntity)
    {
        $this->usuarioCreaEntity[] = $usuarioCreaEntity;

        return $this;
    }

    /**
     * Remove usuarioCreaEntity
     *
     * @param \AppBundle\Entity\AGUsuario $usuarioCreaEntity
     */
    public function removeUsuarioCreaEntity(\AppBundle\Entity\AGUsuario $usuarioCreaEntity)
    {
        $this->usuarioCreaEntity->removeElement($usuarioCreaEntity);
    }

    /**
     * Get usuarioCreaEntity
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsuarioCreaEntity()
    {
        return $this->usuarioCreaEntity;
    }

    /**
     * Add usuarioModificaEntity
     *
     * @param \AppBundle\Entity\AGUsuario $usuarioModificaEntity
     *
     * @return AGUsuario
     */
    public function addUsuarioModificaEntity(\AppBundle\Entity\AGUsuario $usuarioModificaEntity)
    {
        $this->usuarioModificaEntity[] = $usuarioModificaEntity;

        return $this;
    }

    /**
     * Remove usuarioModificaEntity
     *
     * @param \AppBundle\Entity\AGUsuario $usuarioModificaEntity
     */
    public function removeUsuarioModificaEntity(\AppBundle\Entity\AGUsuario $usuarioModificaEntity)
    {
        $this->usuarioModificaEntity->removeElement($usuarioModificaEntity);
    }

    /**
     * Get usuarioModificaEntity
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsuarioModificaEntity()
    {
        return $this->usuarioModificaEntity;
    }
    
    public function hasRoleName($role){
        $roles=$this->roles->toArray();
        foreach ($roles as $rol){
            if($rol->getNombre()==$role)
                return true;
        }
        return false;
    }

    /**
     * Set visible
     *
     * @param integer $visible
     *
     * @return AGUsuario
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
