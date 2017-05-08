<?php

namespace Proxies\__CG__\AppBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class AGTipoDatos extends \AppBundle\Entity\AGTipoDatos implements \Doctrine\ORM\Proxy\Proxy
{
    /**
     * @var \Closure the callback responsible for loading properties in the proxy object. This callback is called with
     *      three parameters, being respectively the proxy object to be initialized, the method that triggered the
     *      initialization process and an array of ordered parameters that were passed to that method.
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setInitializer
     */
    public $__initializer__;

    /**
     * @var \Closure the callback responsible of loading properties that need to be copied in the cloned object
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setCloner
     */
    public $__cloner__;

    /**
     * @var boolean flag indicating if this object was already initialized
     *
     * @see \Doctrine\Common\Persistence\Proxy::__isInitialized
     */
    public $__isInitialized__ = false;

    /**
     * @var array properties to be lazy loaded, with keys being the property
     *            names and values being their default values
     *
     * @see \Doctrine\Common\Persistence\Proxy::__getLazyProperties
     */
    public static $lazyPropertiesDefaults = [];



    /**
     * @param \Closure $initializer
     * @param \Closure $cloner
     */
    public function __construct($initializer = null, $cloner = null)
    {

        $this->__initializer__ = $initializer;
        $this->__cloner__      = $cloner;
    }







    /**
     * 
     * @return array
     */
    public function __sleep()
    {
        if ($this->__isInitialized__) {
            return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\AGTipoDatos' . "\0" . 'id', '' . "\0" . 'AppBundle\\Entity\\AGTipoDatos' . "\0" . 'nombre', '' . "\0" . 'AppBundle\\Entity\\AGTipoDatos' . "\0" . 'tipoCasoCaracteristica', '' . "\0" . 'AppBundle\\Entity\\AGTipoDatos' . "\0" . 'usuarioCrea', '' . "\0" . 'AppBundle\\Entity\\AGTipoDatos' . "\0" . 'usuarioModifica', '' . "\0" . 'AppBundle\\Entity\\AGTipoDatos' . "\0" . 'fechaCrea', '' . "\0" . 'AppBundle\\Entity\\AGTipoDatos' . "\0" . 'fechaModifica'];
        }

        return ['__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\AGTipoDatos' . "\0" . 'id', '' . "\0" . 'AppBundle\\Entity\\AGTipoDatos' . "\0" . 'nombre', '' . "\0" . 'AppBundle\\Entity\\AGTipoDatos' . "\0" . 'tipoCasoCaracteristica', '' . "\0" . 'AppBundle\\Entity\\AGTipoDatos' . "\0" . 'usuarioCrea', '' . "\0" . 'AppBundle\\Entity\\AGTipoDatos' . "\0" . 'usuarioModifica', '' . "\0" . 'AppBundle\\Entity\\AGTipoDatos' . "\0" . 'fechaCrea', '' . "\0" . 'AppBundle\\Entity\\AGTipoDatos' . "\0" . 'fechaModifica'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (AGTipoDatos $proxy) {
                $proxy->__setInitializer(null);
                $proxy->__setCloner(null);

                $existingProperties = get_object_vars($proxy);

                foreach ($proxy->__getLazyProperties() as $property => $defaultValue) {
                    if ( ! array_key_exists($property, $existingProperties)) {
                        $proxy->$property = $defaultValue;
                    }
                }
            };

        }
    }

    /**
     * 
     */
    public function __clone()
    {
        $this->__cloner__ && $this->__cloner__->__invoke($this, '__clone', []);
    }

    /**
     * Forces initialization of the proxy
     */
    public function __load()
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__load', []);
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitialized($initialized)
    {
        $this->__isInitialized__ = $initialized;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitializer(\Closure $initializer = null)
    {
        $this->__initializer__ = $initializer;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __getInitializer()
    {
        return $this->__initializer__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setCloner(\Closure $cloner = null)
    {
        $this->__cloner__ = $cloner;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific cloning logic
     */
    public function __getCloner()
    {
        return $this->__cloner__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     * @static
     */
    public function __getLazyProperties()
    {
        return self::$lazyPropertiesDefaults;
    }

    
    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getId();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getId', []);

        return parent::getId();
    }

    /**
     * {@inheritDoc}
     */
    public function setNombre($nombre)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setNombre', [$nombre]);

        return parent::setNombre($nombre);
    }

    /**
     * {@inheritDoc}
     */
    public function getNombre()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNombre', []);

        return parent::getNombre();
    }

    /**
     * {@inheritDoc}
     */
    public function addTipoCasoCaracteristica(\AppBundle\Entity\AGTipoCasoCaracteristica $tipoCasoCaracteristica)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addTipoCasoCaracteristica', [$tipoCasoCaracteristica]);

        return parent::addTipoCasoCaracteristica($tipoCasoCaracteristica);
    }

    /**
     * {@inheritDoc}
     */
    public function removeTipoCasoCaracteristica(\AppBundle\Entity\AGTipoCasoCaracteristica $tipoCasoCaracteristica)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'removeTipoCasoCaracteristica', [$tipoCasoCaracteristica]);

        return parent::removeTipoCasoCaracteristica($tipoCasoCaracteristica);
    }

    /**
     * {@inheritDoc}
     */
    public function getTipoCasoCaracteristica()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTipoCasoCaracteristica', []);

        return parent::getTipoCasoCaracteristica();
    }

    /**
     * {@inheritDoc}
     */
    public function setFechaCrea($fechaCrea)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFechaCrea', [$fechaCrea]);

        return parent::setFechaCrea($fechaCrea);
    }

    /**
     * {@inheritDoc}
     */
    public function getFechaCrea()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFechaCrea', []);

        return parent::getFechaCrea();
    }

    /**
     * {@inheritDoc}
     */
    public function setFechaModifica($fechaModifica)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFechaModifica', [$fechaModifica]);

        return parent::setFechaModifica($fechaModifica);
    }

    /**
     * {@inheritDoc}
     */
    public function getFechaModifica()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFechaModifica', []);

        return parent::getFechaModifica();
    }

    /**
     * {@inheritDoc}
     */
    public function setUsuarioCrea(\AppBundle\Entity\AGUsuario $usuarioCrea = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUsuarioCrea', [$usuarioCrea]);

        return parent::setUsuarioCrea($usuarioCrea);
    }

    /**
     * {@inheritDoc}
     */
    public function getUsuarioCrea()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUsuarioCrea', []);

        return parent::getUsuarioCrea();
    }

    /**
     * {@inheritDoc}
     */
    public function setUsuarioModifica(\AppBundle\Entity\AGUsuario $usuarioModifica = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUsuarioModifica', [$usuarioModifica]);

        return parent::setUsuarioModifica($usuarioModifica);
    }

    /**
     * {@inheritDoc}
     */
    public function getUsuarioModifica()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUsuarioModifica', []);

        return parent::getUsuarioModifica();
    }

}
