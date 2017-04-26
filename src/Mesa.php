<?php
namespace Elecciones\Common;
/**
 * @author Pablo Bussi <pbussi@gmail.com>
 * @since 2.0
 */
class Mesa
{
   
    private $tipo = '';
    private $sec = 0;
    private $cirnro = 0;
    private $cirlet = '';
    private $app;

    function __construct($tipo, $sec, $cirnro, $cirlet, $app) {
        $this->app = $app;
        $this->tipo = $tipo;
        $this->sec = $sec;
        $this->cirnro = $cirnro;
        $this->cirlet = $cirlet;
    }

    function getFiltros() {
        switch ($this->tipo) {
            case 'G': $sql = "SELECT distinct pspar,parnombre,pslista,nombre FROM `actapartido` WHERE psgob='R'";
                break;
            case 'D': $sql = "SELECT distinct pspar,parnombre,pslista,nombre FROM `actapartido` WHERE psdip='R'";
                break;
            case 'S': $sql = "SELECT distinct pspar,parnombre,pslista,nombre FROM `actapartido` WHERE pssen='R' and sec=".$this->sec;
                break;
            case 'I': $sql = "SELECT distinct pspar,parnombre,pslista,nombre FROM `actapartido` WHERE pssen='R' and sec=$this->sec and cirnro=$this->cirnro and cirlet='$this->cirlet'";
                break;
            case 'C': $sql = "SELECT distinct pspar,parnombre,pslista,nombre FROM `actapartido` WHERE pssen='R' and sec=$this->sec and cirnro=$this->cirnro and cirlet='$this->cirlet'";
                break;
        }
        $disponibles = $this->app['db']->fetchAll($sql);
        $filtros = $this->app['db']->fetchAll("SELECT * FROM `filtros` WHERE tipo='$this->tipo'"
                . " and sec='$this->sec' and cirnro='$this->cirnro' and cirlet='$this->cirlet'");
        return array('disponibles' => $disponibles, 'filtros' => $filtros);
    }

    function procesar($datos) {
        $sql = "DELETE from filtros "
                . "WHERE sec=? and cirnro=? and cirlet=? and tipo=?";
        $this->app['db']->executeQuery($sql, array((int) $this->sec, (int) $this->cirnro, $this->cirlet, $this->tipo));

        foreach ($datos as $dato => $valor) {
            $dato = explode("-", $dato);
            //print_r($dato);
            $sql = "INSERT INTO filtros VALUES (?,?,?,?,?,?);";
            $this->app['db']->executeQuery($sql, array((int) $this->sec, (int) $this->cirnro, $this->cirlet, (int) $dato[0], (int) $dato[1], $this->tipo));
        }
        return "Datos modificados";
    }

}

