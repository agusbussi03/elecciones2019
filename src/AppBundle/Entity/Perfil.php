<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Perfil
 *
 * @ORM\Table(name="perfil", indexes={@ORM\Index(name="fk_perfil_fos_user_idx", columns={"fos_user_id"})})
 * @ORM\Entity
 */
class Perfil
{
    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=255, nullable=true)
     */
    private $direccion;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=45, nullable=true)
     */
    private $telefono;

    /**
     * @var string
     *
     * @ORM\Column(name="foto", type="string", length=45, nullable=true)
     */
    private $foto;

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


}

