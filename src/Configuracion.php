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

    function getUltimaactualizacion($tipo="",$circuito=0) {
        $where="";
        if ($tipo!="") $where=" where datos like '%[$tipo%' ";
        if ($circuito>0) $where.=" and texto in (select numero from mesa where circuito_id=$circuito) ";
        $hora = $this->app['db']->fetchAssoc("SELECT DATE_FORMAT(tiempo,'%d/%m/%Y %H:%i') as hora "
                . "FROM log $where order by tiempo desc LIMIT 1 ");
        return $hora['hora'];
    }

    function getNombreSeccional($id) {
        if (!($id > 0))
            return "";
        $seccional = $this->app['db']->fetchAssoc("SELECT * FROM seccional where id=" . $id);
        return $seccional['nombre'];
    }

    function getObtieneconcejal($nombre) {
        $datos = explode("-", $nombre);
        $candidato = $this->app['db']->fetchAssoc("SELECT * FROM cargo_local c left join candidato can on c.candidato_id=can.id ,"
                . "partido_lista l where tipo='C' and c.lista_id=l.id and concat(l.nombre_partido,'-',l.id_lista,'-',l.nombre_lista)='$nombre' ");
        if ($candidato['apellido'] == "")
            return "Candidato " . "($datos[0])";
        return $candidato['apellido'] . "($datos[0])";
    }

    function getObtieneconcejalfoto($nombre) {
        $candidato = $this->app['db']->fetchAssoc("SELECT * FROM cargo_local c left join candidato can on c.candidato_id=can.id ,"
                . "partido_lista l where tipo='C' and c.lista_id=l.id and concat(l.nombre_partido,'-',l.id_lista,'-',l.nombre_lista)='$nombre' ");
        if ($candidato['apellido'] == "")
            return base64_encode(file_get_contents("imagenes/default.jpg"));
        return base64_encode($candidato['foto']);
    }

    function getObtienedipnac($nombre) {
        $datos = explode("-", $nombre);
        $candidato = $this->app['db']->fetchAssoc("SELECT * FROM cargo_nacional c left join candidato can on c.candidato_id=can.id ,"
                . "partido_lista_nacional l where tipo='D' and c.lista_nacional_id=l.id and concat(l.nombre_partido,'-',l.id_lista,'-',l.nombre_lista)='$nombre' ");
        if ($candidato['apellido'] == "")
            return "" . "($datos[0])";
        return $candidato['apellido'] . "($datos[0])";
    }

    function getObtienedipnacfoto($nombre) {
        $candidato = $this->app['db']->fetchAssoc("SELECT * FROM cargo_nacional c left join candidato can on c.candidato_id=can.id ,"
                . "partido_lista_nacional l where tipo='D' and c.lista_nacional_id=l.id and concat(l.nombre_partido,'-',l.id_lista,'-',l.nombre_lista)='$nombre' ");
        if ($candidato['apellido'] == "")
            return base64_encode(file_get_contents("imagenes/default.jpg"));
        return base64_encode($candidato['foto']);
    }

    function getLocalmesa($numero) {
        require_once 'Mesa.php';
        $mesa = new Mesa($numero, $this->app);
        $localidad = $mesa->getCircuito_nombre();
        $seccional = $mesa->getSeccional();
        if ($seccional > 0) {
            $seccional = $this->app['db']->fetchAssoc("SELECT nombre FROM seccional where id=$seccional ");
            $seccional = $seccional['nombre'] . "/";
        }
        return $localidad . "/" . $seccional . $mesa->getLocal();
    }

    function getResponsableLocalmesa($numero) {
        require_once 'Mesa.php';
        $escuela = $this->app['db']->fetchAssoc("SELECT * FROM locales where mesadesde<=$numero and mesahasta>=$numero ");
            
        if (isset($escuela['contacto']) and $escuela['contacto']!="") return " (".$escuela['contacto']." - ".$escuela['telefono'].")";
        return "";
    }
    
     function getAvanceConcejal($numero) {
    $carga = $this->app['db']->fetchAssoc("
        SELECT count(distinct mesa1.id) as cargada,count(distinct mesa2.id) as no_cargada 
        FROM mesa as mesa1,mesa as mesa2 where mesa1.circuito_id=$numero and mesa2.circuito_id=$numero 
        and mesa1.concejal=1 and mesa2.concejal=1 and mesa1.id  in 
        (select mesa_id from renglon where concejal>0) and 
        mesa2.id not in (select mesa_id from renglon where concejal>0)");
    return number_format($carga['cargada']/($carga['cargada']+$carga['no_cargada'])*100,2,",",".");
    
    
     }
    
    function getOrdenaCandidatos($arreglo) {
        $divididos = array();
        //print_r($arreglo);
        foreach ($arreglo as $clave => $valor) {
            $partido = explode("-", $clave);
            $divididos[$partido[0]][$clave] = $valor;
            uasort($divididos[$partido[0]], 'cmp');
        }
        //print_r($divididos);
        $unidos = array();
        foreach ($divididos as $item) {
            foreach ($item as $clave2 => $item2) {
                $unidos[$clave2] = $item2;
            }
        }
        //print_r($unidos);die;
        return $unidos;
    }

    function getLimpianombre($clave) {
        $clave2 = explode("-", $clave);
        if (isset($clave2[2]))  return $clave2[0] . "/" . $clave2[2];
        return $clave;
    }

}

function cmp($a, $b) {
    if ($a['porcentaje'] == $b['porcentaje']) {
        return 0;
    }
    return ($a['porcentaje'] > $b['porcentaje']) ? -1 : 1;
}
