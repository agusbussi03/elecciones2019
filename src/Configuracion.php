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
    private $senadores_nacionales = 0;
    private $cerrada;
    private $app;

    function __construct($app) {
        $this->app = $app;
        $configuracion = $this->app['db']->fetchAssoc("SELECT * FROM configuracion");
        $this->tipo = $configuracion['tipo'];
        $this->ano = $configuracion['ano'];
        $this->intermedia = $configuracion['intermedia'];
        $this->partido_principal = $configuracion['partido_principal'];
        $this->lista_principal = $configuracion['lista_principal'];
        $this->senadores_nacionales = $configuracion['senadores_nacionales'];
        $this->cerrada = $configuracion['cerrada'];
    }

    function grabar($datos) {
        $this->ano = $datos['ano'];
        $this->tipo = $datos['tipo'];
        $this->intermedia = $datos['intermedia'];
        $this->partido_principal = $datos['partido_principal'];
        $this->lista_principal = $datos['lista_principal'];
        $this->senadores_nacionales = $datos['senadores_nacionales'];
        $this->cerrada = $datos['cerrada'];
        $sql = "UPDATE configuracion "
                . "SET ano=?,tipo=?,intermedia=?,partido_principal=?,lista_principal=?,senadores_nacionales=?,cerrada=?;";
        $this->app['db']->executeQuery($sql, array((int) $this->ano, (int) $this->tipo, (int) $this->intermedia,
            (int) $this->partido_principal, (int) $this->lista_principal, (int) $this->senadores_nacionales, (int) $this->cerrada));
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

    function getSenadores_nacionales() {
        return $this->senadores_nacionales;
    }

    function getCerrada() {
        return $this->cerrada;
    }

    function getUsuarioConectado() {
        session_start();
        return $_SESSION['usuario'];
    }
    function getUltimaactualizacion() {
       $hora = $this->app['db']->fetchAssoc("SELECT DATE_FORMAT(tiempo,'%d/%m/%Y %H:%m') as hora FROM log order by tiempo desc LIMIT 1 ");
       return $hora['hora'];
    }
    
    function getObtieneconcejal($nombre){
        $candidato = $this->app['db']->fetchAssoc("SELECT * FROM cargo_local c left join candidato can on c.candidato_id=can.id ,"
                . "partido_lista l where tipo='C' and c.lista_id=l.id and concat(l.nombre_partido,'-',l.id_lista,'-',l.nombre_lista)='$nombre' ");
      if ($candidato['apellido']=="")  return "Candidato no cargado";
      return $candidato['apellido']; 
    }
        function getObtieneconcejalfoto($nombre){
        $candidato = $this->app['db']->fetchAssoc("SELECT * FROM cargo_local c left join candidato can on c.candidato_id=can.id ,"
                . "partido_lista l where tipo='C' and c.lista_id=l.id and concat(l.nombre_partido,'-',l.id_lista,'-',l.nombre_lista)='$nombre' ");
      if ($candidato['apellido']=="")  return base64_encode(file_get_contents("imagenes/default.jpg"));
      return base64_encode($candidato['foto']); 
    }
}
