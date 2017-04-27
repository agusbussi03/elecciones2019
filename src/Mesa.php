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
    private $app;

    function __construct($nro, $app) {
        $this->app = $app;
        $this->nro = $nro;
        $datos = $this->app['db']->fetchAssoc("SELECT * from mesas where mes=$this->nro");

        $this->electo = $datos['electo'];
        $this->sec = $datos['sec'];
        $this->cirnro = $datos['cirnro'];
        $this->cirlet = $datos['cirlet'];
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

        
    
    
    function getMascara() {
        $sql = "SELECT * FROM actapartido WHERE sec=? and cirnro=? and cirlet=?";

        $mascara = $this->app['db']->fetchAll($sql, array($this->sec, $this->cirnro, $this->cirlet));
        //print_r($mascara);
        return array($mascara);
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
