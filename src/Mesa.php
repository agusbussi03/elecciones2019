<?php

/**
 * @author Pablo Bussi <pbussi@gmail.com>
 * @since 2.0
 */
class Mesa {

    private $numero = 0;
    private $id;
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
        $this->id = $datos['id'];
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

    function getId() {
        return $this->id;
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

        $cargo_sql = "SELECT * FROM cargo_provincial c,partido_lista p WHERE c.provincia_id=? and c.lista_id=p.id ";
        $cargos = $this->app['db']->fetchAll($cargo_sql, array($this->provincia));
        $mascara = array();
        foreach ($cargos as $item) {
            $mascara[str_pad($item['id_partido'], 4, "0", STR_PAD_LEFT) . '-' . str_pad($item['id_lista'], 4, "0", STR_PAD_LEFT)]["datos"] = array("id" => $item['id'], "id_partido" => $item['id_partido'],
                'nombre_partido' => $item['nombre_partido'], "id_lista" => $item['id_lista'], 'nombre_lista' => $item['nombre_lista']);
            $mascara[str_pad($item['id_partido'], 4, "0", STR_PAD_LEFT) . '-' . str_pad($item['id_lista'], 4, "0", STR_PAD_LEFT)]["cargos"][] = $item['tipo'];
        }
        $cargo_sql = "SELECT * FROM cargo_departamental c,partido_lista p WHERE seccion_id=? and c.lista_id=p.id ";
        $cargos = $this->app['db']->fetchAll($cargo_sql, array($this->seccion));
        foreach ($cargos as $item) {
            $mascara[str_pad($item['id_partido'], 4, "0", STR_PAD_LEFT) . '-' . str_pad($item['id_lista'], 4, "0", STR_PAD_LEFT)]["datos"] = array("id" => $item['id'], "id_partido" => $item['id_partido'],
                'nombre_partido' => $item['nombre_partido'], "id_lista" => $item['id_lista'], 'nombre_lista' => $item['nombre_lista']);
            $mascara[str_pad($item['id_partido'], 4, "0", STR_PAD_LEFT) . '-' . str_pad($item['id_lista'], 4, "0", STR_PAD_LEFT)]["cargos"][] = $item['tipo'];
        }
        $cargo_sql = "SELECT * FROM cargo_local c,partido_lista p WHERE circuito_id=? and c.lista_id=p.id ";
        $cargos = $this->app['db']->fetchAll($cargo_sql, array($this->circuito));
        foreach ($cargos as $item) {
            $mascara[str_pad($item['id_partido'], 4, "0", STR_PAD_LEFT) . '-' . str_pad($item['id_lista'], 4, "0", STR_PAD_LEFT)]["datos"] = array("id" => $item['id'], "id_partido" => $item['id_partido'],
                'nombre_partido' => $item['nombre_partido'], "id_lista" => $item['id_lista'], 'nombre_lista' => $item['nombre_lista']);
            $mascara[str_pad($item['id_partido'], 4, "0", STR_PAD_LEFT) . '-' . str_pad($item['id_lista'], 4, "0", STR_PAD_LEFT)]["cargos"][] = $item['tipo'];
        }
        $cargo_sql = "SELECT * FROM partido_lista p WHERE p.especial=1 ";
        $cargos = $this->app['db']->fetchAll($cargo_sql);
        foreach ($cargos as $item) {
            $mascara[str_pad($item['id_partido'], 4, "0", STR_PAD_LEFT) . '-' . str_pad($item['id_lista'], 4, "0", STR_PAD_LEFT)]["datos"] = array("id" => $item['id'], "id_partido" => $item['id_partido'],
                'nombre_partido' => $item['nombre_partido'], "id_lista" => $item['id_lista'], 'nombre_lista' => $item['nombre_lista']);
            $mascara[str_pad($item['id_partido'], 4, "0", STR_PAD_LEFT) . '-' . str_pad($item['id_lista'], 4, "0", STR_PAD_LEFT)]["cargos"] = array("G", "D", "S", "I", "C");
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
        $sql = "SELECT count(*) as cuenta,sum(gobernador),sum(diputado),sum(senador),"
                . "sum(intendente),sum(concejal) from renglon WHERE mesa_id=?";
        $sumavotos = $this->app['db']->fetchAssoc($sql, array((int) $this->id));
        if ($sumavotos['cuenta'] == 0) {
            $mascara = $this->getMascara();
            foreach ($mascara as $item) {
                $sql = "INSERT renglon (mesa_id,lista_id) VALUES (?,?)";
                $this->app['db']->executeQuery($sql, array((int) $this->id, $item['datos']['id']));
            }
        }
        return $sumavotos;
    }

    function votos() {
        $sql = "SELECT * from renglon WHERE mesa_id=?";
        $votos = array();
        $resultado = $this->app['db']->fetchAll($sql, array((int) $this->id));

        foreach ($resultado as $item) {
            $votos[$item['lista_id']] = $item;
        }
        return $votos;
    }

    function actualiza($votos) {
        $columnas = array('G' => 'gobernador', 'D' => 'diputado', 'S' => 'senador', 'I' => 'intendente', 'C' => 'concejal');
        unset($votos['total_votos']);
        foreach ($votos as $clave => $valor) {
            $dato = explode(",", $clave);
            $columna = $columnas[$dato[0]];
            $partido_lista = $dato[1];
            $sql = "UPDATE renglon set $columna=? where lista_id=? and mesa_id=?";
            $this->app['db']->executeQuery($sql, array((int) $valor, (int) $partido_lista, (int) $this->id));
        }
        $sql = "insert into log (usuario,texto,datos) "
                . "values ('" . $_SESSION['usuario'] . "','actualiza mesa $this->numero','" . print_r($votos, 1) . "');";
        $this->app['db']->executeQuery($sql);
        return;
    }

    static function setTestigo($numero, $electores_provincia, $electores_nacion, $circuito, $seccional, $app) {
        if ($seccional > 0) {
            $sql = "INSERT INTO mesa VALUES (NULL,?,?,?,?,?)";
            $app['db']->executeQuery($sql, array($numero, $electores_provincia, $electores_nacion, $circuito, $seccional));
        } else {
            $sql = "INSERT INTO mesa VALUES (NULL,?,?,?,?,NULL)";
            $app['db']->executeQuery($sql, array($numero, $electores_provincia, $electores_nacion, $circuito));
        }
    }

    static function unsetTestigo($id, $app) {
        $sql = "DELETE FROM mesa where id=$id";
        $app['db']->executeQuery($sql);
    }

    static function testigos($app) {
        $sql = "SELECT m.*,c.id as c_id,c.nombre as c_nombre,s.id as s_id ,s.nombre as s_nombre,p.id as p_id, p.nombre as p_nombre , sec.id as sec_id, sec.nombre as sec_nombre "
                . "FROM circuito c,seccion s,provincia p, mesa m LEFT join seccional sec on seccionales_id=sec.id "
                . "WHERE m.circuito_id=c.id and c.seccion_id=s.id and s.provincia_id=p.id ";
        $resultado = $app['db']->fetchAll($sql);
        return $resultado;
    }

    static function testigosporcircuito($circuito, $app) {
        $sql = "SELECT m.*,c.id as c_id,c.nombre as c_nombre,s.id as s_id ,s.nombre as s_nombre,p.id as p_id, p.nombre as p_nombre , sec.id as sec_id, sec.nombre as sec_nombre "
                . "FROM circuito c,seccion s,provincia p, mesa m LEFT join seccional sec on seccionales_id=sec.id "
                . "WHERE m.circuito_id=c.id and c.seccion_id=s.id and s.provincia_id=p.id and c.id=$circuito ";
        $resultado = $app['db']->fetchAll($sql);
        return $resultado;
    }

}
