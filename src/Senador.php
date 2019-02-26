<?php

/**
 * Description of diputados
 *
 * @author pablo
 */
class Senador {

    private $id = 0;
    private $app;
    private $localidades = 0;

    function __construct($id, $app) {
        $this->app = $app;
        $this->id = $id;
        $criterio = $id;
        if ($criterio = 9)
            $criterio = "9,10";
        if ($criterio = 13)
            $criterio = "13,14,15";
        $localidades = $this->app['db']->fetchAssoc("SELECT id,nombre "
                . "FROM `circuito` WHERE seccion_id in (?) "
                . "UNION select id,nombre "
                . "from seccional where circuito_id in (select id from circuito "
                . "where seccion_id in (?))", array($criterio, $criterio));
        $this->localidades = count($localidades);
    }

    function getResultados() {
        $sql = "SELECT sec.nombre,sec.id,p.nombre_partido,p.id as plid,p.id_partido,p.id_lista,"
                . "p.nombre_lista,sum(r.senador) as suma,count(m.id) as cuenta "
                . "FROM renglon r, mesa m, seccion sec, partido_lista p, "
                . "cargo_departamental car "
                . "WHERE r.mesa_id=m.id and r.lista_id=p.id and "
                . "m.circuito_id in (select id from circuito c1 where c1.seccion_id=sec.id) and "
                . "r.senador>0 and car.lista_id=r.lista_id and car.tipo='S' "
                . "group by sec.nombre,sec.id,p.id_partido,p.nombre_partido,p.id,p.id_lista,p.nombre_lista "
                . "ORDER BY sec.nombre asc,`p`.`id_partido` ASC, p.nombre_lista asc  ";
        $votos = $this->app['db']->fetchAll($sql, array((int) $this->id));
        $resultado = $totales = array();
        foreach ($votos as $item) {
            $resultado[$item['id']][$item['nombre_partido'] . "-" . $item['id_lista'] . "-" . $item['nombre_lista']]['votos'] = $item['suma'];
            $resultado[$item['id']][$item['nombre_partido'] . "-" . $item['id_lista'] . "-" . $item['nombre_lista']]['id'] = $item['plid'];

            if (isset($totales[$item['nombre_partido'] . "-" . $item['id_lista'] . "-" . $item['nombre_lista']]))
                $totales[$item['nombre_partido'] . "-" . $item['id_lista'] . "-" . $item['nombre_lista']]['votos'] += $item['suma'];
            else
                $totales[$item['nombre_partido'] . "-" . $item['id_lista'] . "-" . $item['nombre_lista']]['votos'] = $item['suma'];
            $totales[$item['nombre_partido'] . "-" . $item['id_lista'] . "-" . $item['nombre_lista']]['id'] = $item['plid'];
        }
        //especiales
        $sql = "SELECT sec.nombre,sec.id,p.nombre_partido,p.id as plid,p.id_partido,p.id_lista,"
                . "p.nombre_lista,sum(r.senador) as suma,count(m.id) as cuenta "
                . "FROM renglon r, mesa m,seccion sec, partido_lista p "
                . "WHERE r.mesa_id=m.id and r.lista_id=p.id and "
                . "m.circuito_id in (select id from circuito c1 where c1.seccion_id=sec.id) and "
                . "r.senador>0 and p.especial=1 group by sec.nombre,sec.id,p.id_partido,p.nombre_partido,"
                . "p.id,p.id_lista,p.nombre_lista ORDER BY sec.nombre asc,`p`.`id_partido` ASC,"
                . " p.nombre_lista asc ";


        $votos = $this->app['db']->fetchAll($sql, array((int) $this->id));
        foreach ($votos as $item) {
            $resultado[$item['id']][$item['nombre_partido'] . "-" . $item['id_lista'] . "-" . $item['nombre_lista']]['votos'] = $item['suma'];
            $resultado[$item['id']][$item['nombre_partido'] . "-" . $item['id_lista'] . "-" . $item['nombre_lista']]['id'] = $item['plid'];
            if (isset($totales[$item['nombre_partido'] . "-" . $item['id_lista'] . "-" . $item['nombre_lista']]))
                $totales[$item['nombre_partido'] . "-" . $item['id_lista'] . "-" . $item['nombre_lista']]['votos'] += $item['suma'];
            else
                $totales[$item['nombre_partido'] . "-" . $item['id_lista'] . "-" . $item['nombre_lista']]['votos'] = $item['suma'];
            $totales[$item['nombre_partido'] . "-" . $item['id_lista'] . "-" . $item['nombre_lista']]['id'] = $item['plid'];
        }
        return(array('votos' => $resultado, 'totales' => $totales));
    }

    function getPorcentajes() {
        $porcentajes = $totales_porcentajes = array();
        $totales_porcentajes['EMITIDOS'] = 0;
        $general = 0;
        $resultado = $this->getResultados();
        foreach ($resultado['votos'] as $clave => $valor) {
            if ($_SESSION['tiporeporte'] == 'VALIDOS')
                $suma = sumavalidos($valor);
            elseif ($_SESSION['tiporeporte'] == 'AFIRMATIVOS')
                $suma = sumaafirmativos($valor);
            else
                $suma = suma($valor);
            $general += $suma;
            $porcentajes[$clave]['EMITIDOS'] = $suma;
            foreach ($valor as $clave2 => $valor2) {
                $porcentajes[$clave][$clave2]['porcentaje'] = ($suma > 0) ? $valor2['votos'] / $suma * 100 : 0;
                $porcentajes[$clave][$clave2]['id'] = $valor2['id'];
                if (!isset($totales_porcentajes[$clave2]))
                    $totales_porcentajes[$clave2]['porcentaje'] = ($suma > 0) ? $valor2['votos'] / $suma * 100 : 0;
                else
                    $totales_porcentajes[$clave2]['porcentaje'] += ($suma > 0) ? $valor2['votos'] / $suma * 100 : 0;
                $totales_porcentajes[$clave2]['id'] = $valor2['id'];
            }
        }
        $totales_porcentajes['EMITIDOS'] = $general;
        /* foreach ($resultado['totales'] as $clave => $valor) {
          $totales_porcentajes[$clave]['porcentaje'] = $valor['votos'] / $general * 100;
          $totales_porcentajes[$clave]['id']=$valor['id'];
          }
         */
        return(array('porcentajes' => $porcentajes, 'totales_porcentajes' => $totales_porcentajes));
    }

    function getPorcentajeponderado() {
        $seccionales = $this->getDepartamentos();
        $resultado = $this->getPorcentajes();
        $resultado = $resultado['porcentajes'];
        $porcentajes_peso = array();
        foreach ($resultado as $clave => $item) {
            foreach ($item as $clave2 => $item2) {
                /* if ($clave2 != 'EMITIDOS' && $clave2 != 'BLANCOS--' && $clave2 != 'NULOS--' && $clave2 != 'OTROS--') { */
                if (!isset($porcentajes_peso[$clave2]))
                    $porcentajes_peso[$clave2]['porcentaje'] = $item2['porcentaje'] * $seccionales[$clave]['peso'] / 100;
                else
                    $porcentajes_peso[$clave2]['porcentaje'] += $item2['porcentaje'] * $seccionales[$clave]['peso'] / 100;
                $porcentajes_peso[$clave2]['id'] = $item2['id'];
                /* } */
            }
        }
        //print_r($porcentajes_peso);
        return($porcentajes_peso);
    }

    function getDistribucion($id) {
        $partidos = $this->getPartidos();
        $porcentajes_peso = $this->getPorcentajeponderado();
        $total_partido = 0;
        if ($id != 0) {
            foreach ($porcentajes_peso as $item) {
                if ($item['id'] > 0 && isset($partidos[$item['id']]) && $partidos[$item['id']]['id_partido'] == $id)
                    $total_partido += $item['porcentaje'];
            }
        }
        $provincia = $this->app['db']->fetchAssoc("SELECT * FROM provincia where id=" . $this->id);
        $titulares = $provincia['dip_titular'];
        $suplentes = $provincia['dip_suplente'];
        $dhont = array();
        $total_concejales = $titulares + $suplentes;
        $i = 1;
        while ($i <= $total_concejales) {
            foreach ($porcentajes_peso as $clave => $item) {
                if ($clave != "OTROS--" && $clave != "NULOS--" && $clave != "BLANCOS--") {
                    if ($id > 0) {
                        if ($item['id'] > 0 && isset($partidos[$item['id']]) && $partidos[$item['id']]['id_partido'] == $id)
                            $dhont[] = array('partido' => $clave, 'orden' => $i, "valor" => ($item['porcentaje'] / $i * 100 / $total_partido), "logo" => buscarfoto($partidos, $clave));
                    } else
                        $dhont[] = array('partido' => $clave, 'orden' => $i, "valor" => $item['porcentaje'] / $i, "logo" => buscarfoto($partidos, $clave));
                }
            }
            $i++;
        }
        usort($dhont, 'ordena_dhont');
        $dhont = array_slice($dhont, 0, $total_concejales);
        //print_r($dhont);
        $primaria = FALSE;

        if ($primaria) {
            
        } else {
            /////////////// GENERAL'
            // print_r($resultado);
            // print_r($seccionales);
        }

        return($dhont);
    }

    function getSeccionales() {
        $total = 0;
        $resultado = array();
         if ($this->id == 9)
            $criterio = "2021";
        if ($this->id == 13)
            $criterio = "2069";
        $sql = "SELECT * FROM seccional WHERE circuito_id=? and id in (select seccionales_id from mesa,renglon "
                . "where mesa.id=renglon.mesa_id and  mesa.senador>0 and renglon.senador>0)";
        $seccionales = $this->app['db']->fetchAll($sql, array((int) $criterio));
        foreach ($seccionales as $item) {
            $total += $item['electores_provincia'];
        }
        foreach ($seccionales as $item) {
            $sql2 = "select count(distinct numero) as cuenta from mesa, renglon where renglon.mesa_id=mesa.id and mesa.seccionales_id=? and renglon.intendente>0 ";
            $cargadas = $this->app['db']->fetchAssoc($sql2, array((int) $item['id']));
            $resultado[$item['id']] = array('id' => $item['id'], 'nombre' => $item['nombre'],
                'mesas_cargadas' => $cargadas['cuenta'],
                'electores' => $item['electores_provincia'], 'peso' => round($item['electores_provincia'] / $total * 100, 200));
        }


        return($resultado);
    }

    function getPartidos() {
        $sql = "SELECT partido_lista.* FROM partido_lista pl,cargo_departamental cd,seccion s"
                . "where pl.id=cd.lista_id "
                . "and cd.seccion_id=s.id and s.provincia_id=?";
        $partidos = $this->app['db']->fetchAll($sql, array((int) $this->id));
        $resultado = array();
        foreach ($partidos as $item) {
            $item['logo'] = base64_encode($item['logo']);
            $resultado[$item['id']] = $item;
        }

        return($resultado);
    }

    function getAvance() {
        // primero saca las faltantes del resto del departamento
        if ($this->id == 9)
            $criterio = "10";
        if ($this->id == 13)
            $criterio = "15";
        $sql = "SELECT circuito.id as id,circuito.nombre as nombre,count(*) as mesas "
                . "from mesa,circuito where mesa.circuito_id=circuito.id and mesa.senador=1 "
                . "and circuito.seccion_id=" . $criterio . " group by circuito.id,circuito.nombre ";
        $_seccionales = $this->app['db']->fetchAll($sql, array((int) $this->id));
        foreach ($_seccionales as $item) {
            $sql = "select mesa.* from mesa,circuito where circuito.id=" . $item['id']
                    . " and mesa.circuito_id=circuito.id and mesa.senador=1 "
                    . " and mesa.id not in (select renglon.mesa_id "
                    . " from renglon where renglon.senador>0 )";
            $faltantes = $this->app['db']->fetchAll($sql, array((int) $this->id));
            $item['faltantes'] = $faltantes;
            $seccionales[] = $item;
        }
        // saca de las seccionales 

        if ($this->id == 9)
            $criterio = "2021";
        if ($this->id == 13)
            $criterio = "2069";
        $sql = "SELECT seccional.id as id,seccional.nombre as nombre,count(*) as mesas "
                . "from mesa,seccional where  mesa.senador=1 and mesa.seccionales_id=seccional.id "
                . "and seccional.circuito_id=" . $criterio . " group by seccional.id,seccional.nombre ";
        $_seccionales = $this->app['db']->fetchAll($sql, array((int) $this->id));
        foreach ($_seccionales as $item) {

            $sql = "select mesa.* from mesa where mesa.seccionales_id=" . $item['id']
                    . " and mesa.senador=1 "
                    . " and mesa.id  in (select renglon.mesa_id "
                    . " from renglon where renglon.senador>0 )";
            $faltantes = $this->app['db']->fetchAll($sql, array((int) $this->id));
            $item['faltantes'] = $faltantes;
            $seccionales[] = $item;
        }
        return $seccionales;
    }

    function getFaltante() {
        // primero saca las faltantes del resto del departamento
        if ($this->id == 9)
            $criterio = "10";
        if ($this->id == 13)
            $criterio = "15";
        $sql = "SELECT circuito.id as id,circuito.nombre as nombre,count(*) as mesas "
                . "from mesa,circuito where mesa.circuito_id=circuito.id and mesa.senador=1 "
                . "and circuito.seccion_id=" . $criterio . " group by circuito.id,circuito.nombre ";
        $_seccionales = $this->app['db']->fetchAll($sql, array((int) $this->id));
        foreach ($_seccionales as $item) {
            $sql = "select mesa.* from mesa,circuito where circuito.id=" . $item['id']
                    . " and mesa.circuito_id=circuito.id and mesa.senador=1 "
                    . " and mesa.id not in (select renglon.mesa_id "
                    . " from renglon where renglon.senador>0 )";
            $faltantes = $this->app['db']->fetchAll($sql, array((int) $this->id));
            $item['faltantes'] = $faltantes;
            $seccionales[] = $item;
        }
        // saca de las seccionales 

        if ($this->id == 9)
            $criterio = "2021";
        if ($this->id == 13)
            $criterio = "2069";
        $sql = "SELECT seccional.id as id,seccional.nombre as nombre,count(*) as mesas "
                . "from mesa,seccional where  mesa.senador=1 and mesa.seccionales_id=seccional.id "
                . "and seccional.circuito_id=" . $criterio . " group by seccional.id,seccional.nombre ";
        $_seccionales = $this->app['db']->fetchAll($sql, array((int) $this->id));
        foreach ($_seccionales as $item) {

            $sql = "select mesa.* from mesa where mesa.seccionales_id=" . $item['id']
                    . " and mesa.senador=1 "
                    . " and mesa.id not in (select renglon.mesa_id "
                    . " from renglon where renglon.senador>0 )";
            $faltantes = $this->app['db']->fetchAll($sql, array((int) $this->id));
            $item['faltantes'] = $faltantes;
            $seccionales[] = $item;
        }
        return $seccionales;
    }

}

function ordena_dhont($a, $b) { {
        if ($a['valor'] == $b['valor']) {
            return 0;
        }
        return ($a['valor'] > $b['valor']) ? -1 : 1;
    }
}

function buscarfoto($partido, $patron) {
    foreach ($partido as $item) {
        if ($item['nombre_partido'] . "-" . $item['id_lista'] . "-" . $item['nombre_lista'] == $patron)
            return($item['logo']);
    }
    return "";
}
