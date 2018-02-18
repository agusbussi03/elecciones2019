<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Operaciones
 *
 * @ORM\Table(name="operaciones", indexes={@ORM\Index(name="fk_operaciones_cuenta1_idx", columns={"origen_cuenta_id"}), @ORM\Index(name="fk_operaciones_cuenta2_idx", columns={"destino_cuenta_id"})})
 * @ORM\Entity
 */
class Operaciones
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime", nullable=false)
     */
    private $fecha;

    /**
     * @var string
     *
     * @ORM\Column(name="detalle", type="string", length=45, nullable=false)
     */
    private $detalle;

    /**
     * @var float
     *
     * @ORM\Column(name="origen_importe", type="float", precision=10, scale=0, nullable=true)
     */
    private $origenImporte;

    /**
     * @var float
     *
     * @ORM\Column(name="destino_importe", type="float", precision=10, scale=0, nullable=true)
     */
    private $destinoImporte;

    /**
     * @var float
     *
     * @ORM\Column(name="cotizacion", type="float", precision=10, scale=0, nullable=true)
     */
    private $cotizacion;

    /**
     * @var float
     *
     * @ORM\Column(name="comision", type="float", precision=10, scale=0, nullable=true)
     */
    private $comision;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Cuenta
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Cuenta")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="origen_cuenta_id", referencedColumnName="id")
     * })
     */
    private $origenCuenta;

    /**
     * @var \AppBundle\Entity\Cuenta
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Cuenta")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="destino_cuenta_id", referencedColumnName="id")
     * })
     */
    private $destinoCuenta;
    function getFecha(): \DateTime {
        return $this->fecha;
    }

    function getDetalle() {
        return $this->detalle;
    }

    function getOrigenImporte() {
        return $this->origenImporte;
    }

    function getDestinoImporte() {
        return $this->destinoImporte;
    }

    function getCotizacion() {
        return $this->cotizacion;
    }

    function getComision() {
        return $this->comision;
    }

    function getId() {
        return $this->id;
    }

    function getOrigenCuenta() {
        return $this->origenCuenta;
    }

    function getDestinoCuenta(): \AppBundle\Entity\Cuenta {
        return $this->destinoCuenta;
    }

    function setFecha(\DateTime $fecha) {
        $this->fecha = $fecha;
    }

    function setDetalle($detalle) {
        $this->detalle = $detalle;
    }

    function setOrigenImporte($origenImporte) {
        $this->origenImporte = $origenImporte;
    }

    function setDestinoImporte($destinoImporte) {
        $this->destinoImporte = $destinoImporte;
    }

    function setCotizacion($cotizacion) {
        $this->cotizacion = $cotizacion;
    }

    function setComision($comision) {
        $this->comision = $comision;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setOrigenCuenta(\AppBundle\Entity\Cuenta $origenCuenta) {
        $this->origenCuenta = $origenCuenta;
    }

    function setDestinoCuenta(\AppBundle\Entity\Cuenta $destinoCuenta) {
        $this->destinoCuenta = $destinoCuenta;
    }



}

