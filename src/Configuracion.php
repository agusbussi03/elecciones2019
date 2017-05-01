<?php

/**
 * Description of Filtros
 *
 * @author pablo
 */
class Configuracion {

    private $ano = '';
    private $tipo = 0;
    private $intermedia = 0;
    private $partido_principal = 0;
    private $lista_principal = 0;
    private $app;

    function __construct($app) {
        $this->app = $app;
        $configuracion = $this->app['db']->fetchAssoc("SELECT * FROM configuracion");
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
        $this->app['db']->executeQuery($sql, array((int) $this->ano, (int) $this->tipo,(int) $this->intermedia,
            (int) $this->partido_principal, (int) $this->lista_principal));
        return "Datos modificados";
    }

    function getAno() {
        return $this->ano;
    }

    function getTipo() {
        return $this->tipo;
    }

    function getIntermedia() {
        return $this->intermedia;
    }

    function getPartido_principal() {
        return $this->partido_principal;
    }

    function getLista_principal() {
        return $this->lista_principal;
    }

    function getApp() {
        return $this->app;
    }

}
