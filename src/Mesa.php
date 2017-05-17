<?php

/**
 * @author Pablo Bussi <pbussi@gmail.com>
 * @since 2.0
 */
class Mesa {

    private $numero = 0;
    private $electores_provincia = 0;
    private $electores_nacion = 0;
    private $circuito = 0;
    private $circuito_nombre = '';
    private $seccion = 0;
    private $seccion_nombre = '';
    private $provincia = 0;
    private $provincia_nombre = '';
    private $seccional = 0;
    private $intendente = 0;
    private $app;

    function __construct($numero, $app) {
        $this->app = $app;
        $this->numero = $numero;
        $datos = $this->app['db']->fetchAssoc("SELECT m.*,c.id as c_id,c.nombre as c_nombre,c.intendente as intendente, s.id as s_id ,s.nombre as s_nombre,p.id as p_id, p.nombre as p_nombre "
                . "FROM mesa m,circuito c,seccion s,provincia p "
                . "WHERE m.numero=$this->numero and m.circuito_id=c.id and c.seccion_id=s.id and s.provincia_id=p.id ");

        if (!($datos))
            throw new Exception("Mesa no existe");
        $this->electores_provincia = $datos['electores_provincia'];
        $this->electores_nacion = $datos['electores_nacion'];
        $this->circuito = $datos['c_id'];
        $this->circuito_nombre = $datos['c_nombre'];
        $this->seccion = $datos['s_id'];
        $this->seccion_nombre = $datos['s_nombre'];
        $this->provincia = $datos['p_id'];
        $this->provincia_nombre = $datos['p_nombre'];
        $this->intendente = $datos['intendente'];
    }

    function getNumero() {
        return $this->numero;
    }

    function getElectores_provincia() {
        return $this->electores_provincia;
    }

    function getElectores_nacion() {
        return $this->electores_nacion;
    }

    function getCircuito() {
        return $this->circuito;
    }

    function getCircuito_nombre() {
        return $this->circuito_nombre;
    }

    function getSeccion() {
        return $this->seccion;
    }

    function getSeccion_nombre() {
        return $this->seccion_nombre;
    }

    function getProvincia() {
        return $this->provincia;
    }

    function getProvincia_nombre() {
        return $this->provincia_nombre;
    }

    function getSeccional() {
        return $this->seccional;
    }

    function getIntendente() {
        return $this->intendente;
    }

    function getApp() {
        return $this->app;
    }

    function getMascara() {

        $cargo_sql = "SELECT * FROM cargo_provincial c,partido_lista p WHERE provincia_id=? and c.lista_id=p.id ";
        $cargos = $this->app['db']->fetchAll($cargo_sql, array($this->provincia));
        $mascara=array();
        foreach ($cargos as $item) {
            $mascara[str_pad($item['id_partido'], 4, "0", STR_PAD_LEFT) . '-' . str_pad($item['id_lista'], 4, "0", STR_PAD_LEFT)]["datos"] = array("id_partido" => $item['id_partido'],
                'nombre_partido' => $item['nombre_partido'], "id_lista" => $item['id_lista'], 'nombre_lista' => $item['nombre_lista']);
            $mascara[str_pad($item['id_partido'], 4, "0", STR_PAD_LEFT) . '-' .str_pad($item['id_lista'], 4, "0", STR_PAD_LEFT)]["cargos"][] = $item['tipo'];
        }
        $cargo_sql = "SELECT * FROM cargo_departamental c,partido_lista p WHERE seccion_id=? and c.lista_id=p.id ";
        $cargos = $this->app['db']->fetchAll($cargo_sql, array($this->seccion));
        foreach ($cargos as $item) {
            $mascara[str_pad($item['id_partido'], 4, "0", STR_PAD_LEFT). '-' . str_pad($item['id_lista'], 4, "0", STR_PAD_LEFT)]["datos"] = array("id_partido" => $item['id_partido'],
                'nombre_partido' => $item['nombre_partido'], "id_lista" => $item['id_lista'], 'nombre_lista' => $item['nombre_lista']);
            $mascara[str_pad($item['id_partido'], 4, "0", STR_PAD_LEFT) . '-' . str_pad($item['id_lista'], 4, "0", STR_PAD_LEFT)]["cargos"][] = $item['tipo'];
        }
        $cargo_sql = "SELECT * FROM cargo_local c,partido_lista p WHERE circuito_id=? and c.lista_id=p.id ";
        $cargos = $this->app['db']->fetchAll($cargo_sql, array($this->circuito));
        foreach ($cargos as $item) {
            $mascara[str_pad($item['id_partido'], 4, "0", STR_PAD_LEFT) . '-' . str_pad($item['id_lista'], 4, "0", STR_PAD_LEFT)]["datos"] = array("id_partido" => $item['id_partido'],
                'nombre_partido' => $item['nombre_partido'], "id_lista" => $item['id_lista'], 'nombre_lista' => $item['nombre_lista']);
            $mascara[str_pad($item['id_partido'], 4, "0", STR_PAD_LEFT) . '-' . str_pad($item['id_lista'], 4, "0", STR_PAD_LEFT)]["cargos"][] = $item['tipo'];
        }
        ksort($mascara);
        return $mascara;
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
        $sql = "insert into log (usuario,texto,datos) "
                . "values ('" . $_SESSION['usuario'] . "','actualiza mesa $this->nro','" . print_r($votos, 1) . "');";
        $this->app['db']->executeQuery($sql);
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
        $sql = "SELECT m.*,c.id as c_id,c.nombre as c_nombre,s.id as s_id ,s.nombre as s_nombre,p.id as p_id, p.nombre as p_nombre "
                . "FROM mesa m,circuito c,seccion s,provincia p "
                . "WHERE m.circuito_id=c.id and c.seccion_id=s.id and s.provincia_id=p.id ";
        $resultado = $app['db']->fetchAll($sql);
        return $resultado;
    }

}
