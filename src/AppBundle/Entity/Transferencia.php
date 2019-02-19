<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Transferencia
 *
 * @ORM\Table(name="transferencia", indexes={@ORM\Index(name="fk_transferencia_cuenta1_idx", columns={"cuenta_id"})})
 * @ORM\Entity
 */
class Transferencia
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
     * @ORM\Column(name="importe", type="float", precision=10, scale=0, nullable=false)
     */
    private $importe;

 /**
     * @var integer
     *
     * @ORM\Column(name="estado", type="integer", precision=10, scale=0, nullable=true)
     */
    private $estado;    
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="confirmacion", type="datetime", nullable=true)
     */
    private $confirmacion;

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
     *   @ORM\JoinColumn(name="cuenta_id", referencedColumnName="id")
     * })
     */
    private $cuenta;
    function getFecha(): \DateTime {
        return $this->fecha;
    }

    function getDetalle() {
        return $this->detalle;
    }

    function getImporte() {
        return $this->importe;
    }

    function getConfirmacion() {
        return $this->confirmacion;
    }

    function getId() {
        return $this->id;
    }

    function getCuenta(): \AppBundle\Entity\Cuenta {
        return $this->cuenta;
    }

    function setFecha(\DateTime $fecha) {
        $this->fecha = $fecha;
    }

    function setDetalle($detalle) {
        $this->detalle = $detalle;
    }

    function setImporte($importe) {
        $this->importe = $importe;
    }

    function setConfirmacion(\DateTime $confirmacion) {
        $this->confirmacion = $confirmacion;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setCuenta(\AppBundle\Entity\Cuenta $cuenta) {
        $this->cuenta = $cuenta;
    }

    function getEstado() {
        return $this->estado;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }



}

