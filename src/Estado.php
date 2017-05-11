<?php

/**
 * Description of Filtros
 *
 * @author pablo
 */
class Estado {

    function __construct($tipo, $sec, $cirnro, $cirlet, $app) {
        $this->app = $app;
        $this->tipo = $tipo;
        $this->sec = $sec;
        $this->cirnro = $cirnro;
        $this->cirlet = $cirlet;
    }

    static function getEstado($app) {
        $estado = array();
        $sql = "SELECT count(*)  from mesas where testigo=1";
        $resultado = $app['db']->fetchArray($sql);
        $estado['mesas_testigo'] = $resultado[0];
        $sql = "SELECT count(distinct mesa) FROM `renglon` ";
        $resultado = $app['db']->fetchArray($sql);
        $estado['mesas_con_carga'] = $resultado[0];
        return $estado;
    }

}