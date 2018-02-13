<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cuenta
 *
 * @ORM\Table(name="cuenta", indexes={@ORM\Index(name="fk_cuenta_fos_user1_idx", columns={"fos_user_id"}), @ORM\Index(name="fk_cuenta_moneda1_idx", columns={"moneda_id"})})
 * @ORM\Entity
 */
class Cuenta
{
    /**
     * @var float
     *
     * @ORM\Column(name="saldo", type="float", precision=10, scale=0, nullable=false)
     */
    private $saldo;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="text", length=65535, nullable=true)
     */
    private $direccion;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\FosUser
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\FosUser")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fos_user_id", referencedColumnName="id")
     * })
     */
    private $fosUser;

    /**
     * @var \AppBundle\Entity\Moneda
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Moneda")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="moneda_id", referencedColumnName="id")
     * })
     */
    private $moneda;


}

