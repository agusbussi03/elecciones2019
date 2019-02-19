<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Transacciones
 *
 * @ORM\Table(name="transacciones", indexes={@ORM\Index(name="fk_transacciones_operaciones1_idx", columns={"operaciones_id"})})
 * @ORM\Entity
 */
class Transacciones
{
    /**
     * @var string
     *
     * @ORM\Column(name="txid", type="text", length=65535, nullable=true)
     */
    private $txid;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Operaciones
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Operaciones")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="operaciones_id", referencedColumnName="id")
     * })
     */
    private $operaciones;

    function getTxid() {
        return $this->txid;
    }

    function getOperaciones(): \AppBundle\Entity\Operaciones {
        return $this->operaciones;
    }

    function setTxid($txid) {
        $this->txid = $txid;
    }

    function setOperaciones(\AppBundle\Entity\Operaciones $operaciones) {
        $this->operaciones = $operaciones;
    }


}

