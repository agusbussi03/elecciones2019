<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Moneda
 *
 * @ORM\Table(name="moneda")
 * @ORM\Entity
 */
class Moneda
{    
    const ARS = 1;
    const BTC = 2;
    
    function getSimbolo() {
        return $this->simbolo;
    }

    function setSimbolo($simbolo) {
        $this->simbolo = $simbolo;
    }

        /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=45, nullable=false)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="simbolo", type="string", length=5, nullable=false)
     */
    private $simbolo;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

public function getnombre(){
  return $this->nombre;
}
public function getid(){
  return $this->id;
}
}
