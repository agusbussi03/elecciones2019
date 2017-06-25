<?php

/**
 * @author Pablo Bussi <pbussi@gmail.com>
 * @since 2.0
 */
class MesaNacional {

    private $numero = '';
    private $electores_nacion = '';
    private $testigo = '';
    private $usuario = '';
    private $intendente = 0;
    private $app;

    function __construct($nro, $app) {
        $this->app = $app;
        $this->numero = $nro;
        $datos = $this->app['db']->fetchAssoc("SELECT * from mesa where numero=$this->numero");
        if (!($datos['id'] > 0))
            throw new Exception("Mesa no existe");
        $this->id=$datos['id'];
        $this->electores_nacion = $datos['electores_nacion'];

    }

    function getNumero() {
        return $this->numero;
    }

    function getElectores_nacion() {
        return $this->electores_nacion;
    }

    function getIntendente() {
        return $this->intendente;
    }

        function getTestigo() {
        return $this->testigo;
    }

    function getUsuario() {
        return $this->usuario;
    }

    function getMascara() {
         $cargo_sql = "SELECT * FROM cargo_nacional c,partido_lista_nacional p WHERE  c.lista_nacional_id=p.id ";
        $cargos = $this->app['db']->fetchAll($cargo_sql, array());
        $mascara = array();
        foreach ($cargos as $item) {
            $mascara[str_pad($item['id_partido'], 4, "0", STR_PAD_LEFT) . '-' . str_pad($item['id_lista'], 4, "0", STR_PAD_LEFT)]["datos"] = array("id" => $item['id'], "id_partido" => $item['id_partido'],
                'nombre_partido' => $item['nombre_partido'], "id_lista" => $item['id_lista'], 'nombre_lista' => $item['nombre_lista']);
            $mascara[str_pad($item['id_partido'], 4, "0", STR_PAD_LEFT) . '-' . str_pad($item['id_lista'], 4, "0", STR_PAD_LEFT)]["cargos"][] = $item['tipo'];
        }
        $cargo_sql = "SELECT * FROM partido_lista_nacional p WHERE p.especial=1 ";
        $cargos = $this->app['db']->fetchAll($cargo_sql);
        foreach ($cargos as $item) {
            $mascara[str_pad($item['id_partido'], 4, "0", STR_PAD_LEFT) . '-' . str_pad($item['id_lista'], 4, "0", STR_PAD_LEFT)]["datos"] = array("id" => $item['id'], "id_partido" => $item['id_partido'],
                'nombre_partido' => $item['nombre_partido'], "id_lista" => $item['id_lista'], 'nombre_lista' => $item['nombre_lista']);
            $mascara[str_pad($item['id_partido'], 4, "0", STR_PAD_LEFT) . '-' . str_pad($item['id_lista'], 4, "0", STR_PAD_LEFT)]["cargos"] = array( "D", "S");
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
        $sql = "SELECT count(*) as cuenta,sum(diputado),sum(senador) from renglon_nacional WHERE mesa_id=?";
        $sumavotos = $this->app['db']->fetchAssoc($sql, array((int) $this->id));
        if ($sumavotos['cuenta'] == 0) {
            $mascara = $this->getMascara();
            foreach ($mascara as $item) {
                $sql = "INSERT renglon_nacional (mesa_id,lista_nacional_id) VALUES (?,?)";
                $this->app['db']->executeQuery($sql, array((int) $this->id, (int)$item['datos']['id']));
            }
        }
        return $sumavotos;
    }
 function votos() {
        $sql = "SELECT * from renglon_nacional WHERE mesa_id=?";
        $votos = array();
        $resultado = $this->app['db']->fetchAll($sql, array((int) $this->id));

        foreach ($resultado as $item) {
            $votos[$item['lista_nacional_id']] = $item;
        }
        return $votos;
    }
    function actualiza($votos) {
        $columnas = array( 'D' => 'diputado', 'S' => 'senador');
        unset($votos['total_votos']);
        foreach ($votos as $clave => $valor) {
            $dato = explode(",", $clave);
            $columna = $columnas[$dato[0]];
            $partido_lista = $dato[1];
            $sql = "UPDATE renglon_nacional set $columna=? where lista_nacional_id=? and mesa_id=?";
            $this->app['db']->executeQuery($sql, array((int) $valor, (int) $partido_lista, (int) $this->id));
        }
        $sql = "insert into log (usuario,texto,datos) "
                . "values ('" . $_SESSION['usuario'] . "','$this->numero','" . print_r($votos, 1) . "');";
        $this->app['db']->executeQuery($sql);
        return;
    }

   

    static function testigos($app) {
        $sql = "SELECT * FROM mesas where testigo=1";
        $resultado = $app['db']->fetchAll($sql);
        return $resultado;
    }

}
