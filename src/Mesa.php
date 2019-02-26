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
    private $intendente_elige = 0;
    private $app;
    private $gobernador = 0;
    private $diputado = 0;
    private $senador = 0;
    private $intendente = 0;
    private $concejal = 0;
    private $diputado_nacional = 0;
    private $senador_nacional = 0;

    function __construct($numero, $app) {
        $this->app = $app;
        $this->numero = $numero;
        $datos = $this->app['db']->fetchAssoc("SELECT m.*,c.id as c_id,c.nombre as c_nombre,c.intendente as intendente_elige, s.id as s_id ,s.nombre as s_nombre,p.id as p_id, p.nombre as p_nombre "
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
        $this->intendente_elige = $datos['intendente_elige'];
        $this->gobernador = $datos['gobernador'];
        $this->diputado = $datos['diputado'];
        $this->senador = $datos['senador'];
        $this->intendente = $datos['intendente'];
        $this->concejal = $datos['concejal'];
        $this->diputado_nacional = $datos['diputado_nacional'];
        $this->senador_nacional = $datos['senador_nacional'];
        $this->seccional = $datos['seccionales_id'];
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

    function getIntendente_elige() {
        return $this->intendente_elige;
    }

    function getGobernador() {
        return $this->gobernador;
    }

    function getDiputado() {
        return $this->diputado;
    }

    function getSenador() {
        return $this->senador;
    }

    function getConcejal() {
        return $this->concejal;
    }

    function getDiputado_nacional() {
        return $this->diputado_nacional;
    }

    function getSenador_nacional() {
        return $this->senador_nacional;
    }

    function setIntendente_elige($intendente_elige) {
        $this->intendente_elige = $intendente_elige;
    }

    function setGobernador($gobernador) {
        $this->gobernador = $gobernador;
    }

    function setDiputado($diputado) {
        $this->diputado = $diputado;
    }

    function setSenador($senador) {
        $this->senador = $senador;
    }

    function setConcejal($concejal) {
        $this->concejal = $concejal;
    }

    function setDiputado_nacional($diputado_nacional) {
        $this->diputado_nacional = $diputado_nacional;
    }

    function setSenador_nacional($senador_nacional) {
        $this->senador_nacional = $senador_nacional;
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
        $criterio=$this->seccion;
        if ($criterio==9) $criterio="9,10";
        if ($criterio==10) $criterio="13,14,15";
        if ($criterio==13) $criterio="13,14,15";
        if ($criterio==15) $criterio="13,14,15";
        $cargo_sql = "SELECT * FROM cargo_departamental c,partido_lista p WHERE seccion_id in (?) and c.lista_id=p.id ";
        //echo $cargo_sql;
        $cargos = $this->app['db']->fetchAll($cargo_sql, array($criterio));
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
function getLocal() {
        $sql = "SELECT * from locales WHERE mesahasta>=? and mesadesde<=?";
       $resultado = $this->app['db']->fetchAssoc($sql, array((int) $this->numero,(int) $this->numero));

        if (isset($resultado['nombre']))  return $resultado['nombre'];
        return "";
    }
    function regenera() {
        $mascara = $this->getMascara();
        $sql = "DELETE FROM renglon WHERE mesa_id=?";
        $this->app['db']->executeQuery($sql, array((int) $this->id));
        foreach ($mascara as $item) {
            $sql = "INSERT renglon (mesa_id,lista_id) VALUES (?,?)";
            $this->app['db']->executeQuery($sql, array((int) $this->id, $item['datos']['id']));
        }

        return;
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

    function votosporcargo($cargo) {
        $columnas = array('G' => 'gobernador', 'D' => 'diputado', 'S' => 'senador', 'I' => 'intendente', 'C' => 'concejal');
        $cargo = $columnas[$cargo];
        $sql = "SELECT sum($cargo) as suma from renglon WHERE mesa_id=?";
        $resultado = $this->app['db']->fetchAssoc($sql, array((int) $this->id));
        return $resultado['suma'];
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
                . "values ('" . $_SESSION['usuario'] . "','$this->numero','" . print_r($votos, 1) . "');";
        $this->app['db']->executeQuery($sql);
        return;
    }

     
    
    static function setTestigo($numero, $electores_provincia, $electores_nacion, $circuito, $seccional, $app) {
        if ($seccional > 0) {
            $sql = "INSERT INTO mesa (id,numero,electores_provincia,electores_nacion,circuito_id,seccionales_id) VALUES (NULL,?,?,?,?,?)";
            $app['db']->executeQuery($sql, array($numero, $electores_provincia, $electores_nacion, $circuito, $seccional));
        } else {
            $sql = "INSERT INTO mesa (id,numero,electores_provincia,electores_nacion,circuito_id,seccionales_id) VALUES (NULL,?,?,?,?,NULL)";
            $app['db']->executeQuery($sql, array($numero, $electores_provincia, $electores_nacion, $circuito));
        }
    }

    static function unsetTestigo($id, $app) {
        $sql = "DELETE FROM renglon where mesa_id=$id";
        $app['db']->executeQuery($sql);
        $sql = "DELETE FROM renglon_nacional where mesa_id=$id";
        $app['db']->executeQuery($sql);
        $sql = "DELETE FROM mesa where id=$id";
        $app['db']->executeQuery($sql);
    }

    static function testigos($provincia, $app) {
        $sql = "SELECT m.*,c.id as c_id,c.nombre as c_nombre,s.id as s_id ,s.nombre as s_nombre,p.id as p_id, p.nombre as p_nombre , sec.id as sec_id, sec.nombre as sec_nombre "
                . "FROM circuito c,seccion s,provincia p, mesa m LEFT join seccional sec on seccionales_id=sec.id "
                . "WHERE m.circuito_id=c.id and c.seccion_id=s.id and s.provincia_id=p.id and p.id=$provincia";
        $resultado = $app['db']->fetchAll($sql);
        return $resultado;
    }

    static function testigosprovincia($provincia, $app) {
        $sql = "SELECT m.*,c.id as c_id,c.nombre as c_nombre,s.id as s_id ,s.nombre as s_nombre,p.id as p_id, p.nombre as p_nombre , sec.id as sec_id, sec.nombre as sec_nombre "
                . "FROM circuito c,seccion s,provincia p, mesa m LEFT join seccional sec on seccionales_id=sec.id "
                . "WHERE (1) and m.circuito_id=c.id and c.seccion_id=s.id and s.provincia_id=p.id and p.id=$provincia";
        $resultado = $app['db']->fetchAll($sql);
        return $resultado;
    }

    static function testigosporcircuito($circuito, $filtro="",$app) {
        $where="";
        if ($filtro!="") $where= " m.$filtro=1 and ";
        $sql = "SELECT m.*,c.id as c_id,c.nombre as c_nombre,s.id as s_id ,s.nombre as s_nombre,p.id as p_id, p.nombre as p_nombre , sec.id as sec_id, sec.nombre as sec_nombre "
                . "FROM circuito c,seccion s,provincia p, mesa m LEFT join seccional sec on seccionales_id=sec.id "
                . "WHERE $where m.circuito_id=c.id and c.seccion_id=s.id and s.provincia_id=p.id and c.id=$circuito ";
        $resultado = $app['db']->fetchAll($sql);
        return $resultado;
    }

    static function cargoagregar($datos, $app) {
        $columnas = array('G' => 'gobernador', 'D' => 'diputado', 'S' => 'senador',
            'I' => 'intendente', 'C' => 'concejal', 'DN' => 'diputado_nacional', 'SN' => 'senador_nacional');
        $dato = explode(",", $datos);
        $columna = $columnas[$dato[0]];
        $id = $dato[1];
        $sql = "UPDATE mesa set $columna=1 where id=?";
        $app['db']->executeQuery($sql, array((int) $id));
        return json_encode("OK");
    }
    static function setResponsable($mesa,$responsable, $app) {
        $sql = "UPDATE mesa set responsable=? where id=?";
        $app['db']->executeQuery($sql, array($responsable,(int) $mesa));
        return;
    }
     static function setTelefono($mesa,$telefono, $app) {
        $sql = "UPDATE mesa set telefono=? where id=?";
        $app['db']->executeQuery($sql, array($telefono,(int) $mesa));
        return;
    }
     static function setMail($mesa,$mail, $app) {
        $sql = "UPDATE mesa set mail=? where id=?";
        $app['db']->executeQuery($sql, array($mail,(int) $mesa));
        return;
    }
    static function cargoquitar($datos, $app) {
        $columnas = array('G' => 'gobernador', 'D' => 'diputado', 'S' => 'senador',
            'I' => 'intendente', 'C' => 'concejal', 'DN' => 'diputado_nacional', 'SN' => 'senador_nacional');
        $dato = explode(",", $datos);
        $columna = $columnas[$dato[0]];
        $id = $dato[1];
        $sql = "UPDATE mesa set $columna=0 where id=?";
        $app['db']->executeQuery($sql, array((int) $id));
        return json_encode("OK");
    }

}
