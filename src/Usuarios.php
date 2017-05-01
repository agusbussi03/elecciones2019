<?php

/**
 * Description of Filtros
 *
 * @author pablo
 */
class Usuarios {

    private $id = '';
    private $usuario = 0;
    private $nombreyapellido = 0;
    private $admin = 0;
    private $carga = 0;
    private $lectura = 0;
    private $app;

    function __construct($app) {
        $this->app = $app;
        $configuracion = $this->app['db']->fetchAssoc("SELECT * FROM usuarios");
        $this->tipo = $configuracion['tipo'];
        $this->ano = $configuracion['ano'];
        $this->intermedia = $configuracion['intermedia'];
        $this->partido_principal = $configuracion['partido_principal'];
        $this->lista_principal = $configuracion['lista_principal'];
    }

    function grabar($datos) {
        $this->ano = $datos['ano'];
        $this->tipo = $datos['tipo'];
        $this->intermedia = $datos['intermedia'];
        $this->partido_principal = $datos['partido_principal'];
        $this->lista_principal = $datos['lista_principal'];
        ;
        $sql = "UPDATE configuracion SET ano=?,tipo=?,intermedia=?,partido_principal=?,lista_principal=?;";
        $this->app['db']->executeQuery($sql, array((int) $this->ano, (int) $this->tipo, (int) $this->intermedia,
            (int) $this->partido_principal, (int) $this->lista_principal));
        return "Datos modificados";
    }
    
     static function getAll($app) {
        return $app['db']->fetchAll("SELECT * FROM usuarios");  
    }
    
    function getId() {
        return $this->id;
    }

    function getUsuario() {
        return $this->usuario;
    }

    function getNombreyapellido() {
        return $this->nombreyapellido;
    }

    function getAdmin() {
        return $this->admin;
    }

    function getCarga() {
        return $this->carga;
    }

    function getLectura() {
        return $this->lectura;
    }

    function getApp() {
        return $this->app;
    }



}
