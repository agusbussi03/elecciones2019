<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Operaciones
 *
 * @ORM\Table(name="operaciones", indexes={@ORM\Index(name="fk_operaciones_cuenta1_idx", columns={"cuenta_id"})})
 * @ORM\Entity
 */
class Operaciones
{
    /**
     * @var string
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
    function getFecha() {
        return $this->fecha;
    }

    function getDetalle() {
        return $this->detalle;
    }

    function getImporte() {
        return $this->importe;
    }

    function getId() {
        return $this->id;
    }

    function getCuenta(): \AppBundle\Entity\Cuenta {
        return $this->cuenta;
    }

    function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    function setDetalle($detalle) {
        $this->detalle = $detalle;
    }

    function setImporte($importe) {
        $this->importe = $importe;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setCuenta(\AppBundle\Entity\Cuenta $cuenta) {
        $this->cuenta = $cuenta;
    }



}

