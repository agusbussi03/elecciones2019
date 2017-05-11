<?php

/**
 * @author Pablo Bussi <pbussi@gmail.com>
 * @since 2.0
 */
class Mesa {

    private $nro = '';
    private $sec = 0;
    private $cirnro = 0;
    private $cirlet = '';
    private $electo = '';
    private $testigo = '';
    private $usuario = '';
    private $app;

    function __construct($nro, $app) {
        $this->app = $app;
        $this->nro = $nro;
        $datos = $this->app['db']->fetchAssoc("SELECT * from mesas where mesa=$this->nro");

        $this->electo = $datos['electo'];
        $this->sec = $datos['sec'];
        $this->cirnro = $datos['cirnro'];
        $this->cirlet = $datos['cirlet'];
        $this->testigo = $datos['testigo'];
        $this->usuario = $datos['usuario'];
    }

    function getnro() {
        return $this->nro;
    }

    function getSec() {
        return $this->sec;
    }

    function getCirnro() {
        return $this->cirnro;
    }

    function getCirlet() {
        return $this->cirlet;
    }

    function getElecto() {
        return $this->electo;
    }

    function getApp() {
        return $this->app;
    }

    function getTestigo() {
        return $this->testigo;
    }

    function getUsuario() {
        return $this->usuario;
    }

    function getMascara() {
        $sql = "SELECT * FROM actapartido WHERE sec=? and cirnro=? and cirlet=?";
        $mascara = $this->app['db']->fetchAll($sql, array($this->sec, $this->cirnro, $this->cirlet));
        $blancos = $nulos = $otros = $mascara[0];
        $blancos['pspar'] = 9997;
        $blancos['parnombre'] = 'BLANCOS';
        $blancos['pslista'] = 0;
        $blancos['nombre'] = '';
        $nulos['pspar'] = 9998;
        $nulos['parnombre'] = 'NULOS';
        $nulos['pslista'] = 0;
        $nulos['nombre'] = '';
        $otros['pspar'] = 9999;
        $otros['parnombre'] = 'OTROS';
        $otros['pslista'] = 0;
        $otros['nombre'] = '';
        $blancos['psgob'] = $nulos['psgob'] = $otros['psgob'] = 'R';
        $blancos['psdip'] = $nulos['psdip'] = $otros['psdip'] = 'R';
        $blancos['pssen'] = $nulos['pssen'] = $otros['pssen'] = 'R';
        $blancos['psint'] = $nulos['psint'] = $otros['psint'] = 'R';
        $blancos['pscon'] = $nulos['pscon'] = $otros['pscon'] = 'R';
        $mascara[] = $blancos;
        $mascara[] = $nulos;
        $mascara[] = $otros;
        return array($mascara);
    }

    function procesar($datos) {
        $sql = "DELETE from filtros "
                . "WHERE sec=? and cirnro=? and cirlet=? and tipo=?";
        $this->app['db']->executeQuery($sql, array((int) $this->sec, (int) $this->cirnro, $this->cirlet, $this->tipo));

        foreach ($datos as $dato => $valor) {
            $dato = explode("-", $dato);
            $sql = "INSERT INTO filtros VALUES (?,?,?,?,?,?);";
            $this->app['db']->executeQuery($sql, array((int) $this->sec, (int) $this->cirnro, $this->cirlet, (int) $dato[0], (int) $dato[1], $this->tipo));
        }
        return "Datos modificados";
    }

    function sumavotos() {
        $sql = "SELECT count(*),sum(gob),sum(dip),sum(sen),sum(inte),sum(con),sum(mco) from renglon "
                . "WHERE mesa=?";
        $sumavotos = $this->app['db']->fetchArray($sql, array((int) $this->nro));
        if ($sumavotos[0] == 0) {
            $sql = "INSERT renglon SELECT ?,'',renglon,sec,cirnro,cirlet,pspar,parnombre,pslista,nombre,0,0,0,0,0,0,sortp,sortl 
                    from actapartido WHERE sec=? and cirnro=? and cirlet=?";
            $this->app['db']->executeQuery($sql, array((int) $this->nro, (int) $this->sec, (int) $this->cirnro, $this->cirlet));

//// BLANCOS 
            $sql = "INSERT renglon VALUES (?,'',97,?,?,?,9997,'BLANCOS',0,'',0,0,0,0,0,0,0,0);";
            $this->app['db']->executeQuery($sql, array((int) $this->nro, (int) $this->sec, (int) $this->cirnro, $this->cirlet));

//// NULOS
            $sql = "INSERT renglon VALUES (?,'',98,?,?,?,9998,'NULOS',0,'',0,0,0,0,0,0,0,0);";
            $this->app['db']->executeQuery($sql, array((int) $this->nro, (int) $this->sec, (int) $this->cirnro, $this->cirlet));

            //// OTROS
            $sql = "INSERT renglon VALUES (?,'',99,?,?,?,9999,'OTROS',0,'',0,0,0,0,0,0,0,0);";
            $this->app['db']->executeQuery($sql, array((int) $this->nro, (int) $this->sec, (int) $this->cirnro, $this->cirlet));
        }
        return $sumavotos;
    }

    function actualiza($votos) {
        $columnas = array('G' => 'gob', 'D' => 'dip', 'S' => 'sen', 'I' => 'inte', 'C' => 'con');
        foreach ($votos as $clave => $valor) {
            $dato = explode(",", $clave);
            $columna = $columnas[$dato[0]];
            $partido = $dato[1];
            $lista = $dato[2];
            $sql = "UPDATE renglon set $columna=? where pspar=? and pslista=? and mesa=?";

            $this->app['db']->executeQuery($sql, array((int) $valor, (int) $partido, (int) $lista, (int) $this->nro));
        }
        return;
    }

    function setTestigo() {
        $sql = "UPDATE mesas SET testigo=1 where mesa=$this->nro and tipo=''";
        $this->app['db']->executeQuery($sql);
        $this->testigo = 1;
    }

    function unsetTestigo() {
        $sql = "UPDATE mesas SET testigo=0 where mesa=$this->nro and tipo=''";
        $this->app['db']->executeQuery($sql);
        $this->testigo = 0;
    }

    static function testigos($app) {
        $sql = "SELECT * FROM mesas where testigo=1";
        $resultado = $app['db']->fetchAll($sql);
        return $resultado;
    }

}
