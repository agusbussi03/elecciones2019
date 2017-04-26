<?php
namespace Elecciones\Common;
/**
 * @author Pablo Bussi <pbussi@gmail.com>
 * @since 2.0
 */
class Mesa
{
    /**
     * Identificador.
     * @var string
     */
    protected $id = '';

    /**
     * Crea nueva mesa
     * @param string|null $id          Numero y tipo de mesa: '' para nacional, 'E' para extranjera
     */
    public function __construct($id = null)
    {
        $this->id = $id."E";
    }

    public function getId()
    {
      $zonas=$app['db']->fetchAll('SELECT * FROM zonas');
        return serialize($zonas);
    }





}





 ?>
