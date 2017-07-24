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
        $sql = "SELECT count(*)  from mesa where gobernador+diputado+senador+intendente+concejal>=1 ";
        $resultado = $app['db']->fetchArray($sql);
        $estado['mesas_testigo'] = $resultado[0];
        $sql = "SELECT count(distinct mesa_id) FROM `renglon` ";
        $resultado = $app['db']->fetchArray($sql);
        $estado['mesas_con_carga'] = $resultado[0];
         $sql = "SELECT * FROM log  order by id desc limit 0,5";
        $resultado = $app['db']->fetchAll($sql);
        $estado['log'] = $resultado;
         $sql = "SELECT count(*)  from mesa where diputado_nacional+senador_nacional>=1 ";
        $resultado = $app['db']->fetchArray($sql);
        $estado['mesas_testigo_nacional'] = $resultado[0];
        $sql = "SELECT count(distinct mesa_id) FROM `renglon_nacional` ";
        $resultado = $app['db']->fetchArray($sql);
        $estado['mesas_con_carga_nacional'] = $resultado[0];
        return $estado;
    }

}
