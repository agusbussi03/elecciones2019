<?php

/**
 * Description of intendente
 *
 * @author pablo
 */
class Intendente {

    private $id = 0;
    private $app;
    private $seccionales = 0;

    function __construct($id, $app) {
        $this->app = $app;
        $this->id = $id;
        $seccionales = $this->app['db']->fetchAssoc("SELECT count(*) as cuenta from seccional where circuito_id=?", array((int) $this->id));
        $this->seccionales = $seccionales['cuenta'];
    }

    function getResultados() {
        $sql = "SELECT sec.nombre,sec.id,p.nombre_partido,p.id as plid,p.id_partido,p.id_lista,p.nombre_lista,sum(r.intendente) as suma,count(m.id) as cuenta "
                . "FROM renglon r, mesa m, seccional sec, partido_lista p, cargo_local car "
                . "WHERE r.mesa_id=m.id and m.seccionales_id=sec.id and r.lista_id=p.id "
                . "and m.circuito_id=? and r.intendente>=0 and car.lista_id=r.lista_id "
                . "and car.circuito_id=m.circuito_id and car.tipo='I' and "
                . " mesa_id in ("
                . "select mesa_id from renglon where intendente>0 ) "
                . "group by sec.nombre,sec.id,p.id_partido,p.nombre_partido,p.id,p.id_lista,p.nombre_lista "
                . "ORDER BY sec.nombre asc,`p`.`id_partido` ASC, p.nombre_lista asc  ";
        if ($this->seccionales == 0) {
            $sql = "SELECT 'LOCALIDAD','1' as id,p.nombre_partido,p.id as plid,p.id_partido,p.id_lista,p.nombre_lista,sum(r.intendente) as suma,
                    count(m.id) as cuenta 
                    FROM renglon r, mesa m,partido_lista p, cargo_local car 
                    WHERE r.mesa_id=m.id and r.lista_id=p.id and m.circuito_id=? and r.intendente>=0 and car.lista_id=r.lista_id 
                    and car.circuito_id=m.circuito_id and car.tipo='I' group by 'LOCALIDAD','',p.id_partido,p.nombre_partido,
                    p.id,p.id_lista,p.nombre_lista ORDER BY `p`.`id_partido` ASC, p.nombre_lista asc ";
        }
        $votos = $this->app['db']->fetchAll($sql, array((int) $this->id));
        //print_r($votos);
        $seccionales = $this->getSeccionales();
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
        $sql = "SELECT sec.nombre,sec.id,p.nombre_partido,p.id as plid,p.id_partido,p.id_lista,p.nombre_lista,sum(r.intendente) as suma,count(m.id) as cuenta "
                . "FROM renglon r, mesa m, seccional sec, partido_lista p "
                . "WHERE r.mesa_id=m.id and m.seccionales_id=sec.id and r.lista_id=p.id "
                . "and m.circuito_id=? and r.intendente>=0 and p.especial=1 "
                . "group by sec.nombre,sec.id,p.id_partido,p.nombre_partido,p.id,p.id_lista,p.nombre_lista "
                . "ORDER BY sec.nombre asc,`p`.`id_partido` ASC, p.nombre_lista asc  ";
        if ($this->seccionales == 0) {
            $sql = "SELECT 'LOCALIDAD','1' as id,p.nombre_partido,p.id as plid,p.id_partido,p.id_lista,p.nombre_lista,sum(r.intendente) as suma,count(m.id) as cuenta "
                    . "FROM renglon r, mesa m, partido_lista p "
                    . "WHERE r.mesa_id=m.id and r.lista_id=p.id and m.circuito_id=296 and r.intendente>=0 and p.especial=1 "
                    . "group by 'LOCALIDAD','1',p.nombre_partido,p.id,p.id_lista,p.nombre_lista "
                    . "ORDER BY p.id_partido ASC, p.nombre_lista asc ";
        }
        $votos = $this->app['db']->fetchAll($sql, array((int) $this->id));
        foreach ($votos as $item) {
            if (isset($seccionales[$item['id']])) {
                $resultado[$item['id']][$item['nombre_partido'] . "-" . $item['id_lista'] . "-" . $item['nombre_lista']]['votos'] = $item['suma'];
                $resultado[$item['id']][$item['nombre_partido'] . "-" . $item['id_lista'] . "-" . $item['nombre_lista']]['id'] = $item['plid'];
                if (isset($totales[$item['nombre_partido'] . "-" . $item['id_lista'] . "-" . $item['nombre_lista']]))
                    $totales[$item['nombre_partido'] . "-" . $item['id_lista'] . "-" . $item['nombre_lista']]['votos'] += $item['suma'];
                else
                    $totales[$item['nombre_partido'] . "-" . $item['id_lista'] . "-" . $item['nombre_lista']]['votos'] = $item['suma'];
                $totales[$item['nombre_partido'] . "-" . $item['id_lista'] . "-" . $item['nombre_lista']]['id'] = $item['plid'];
            }
        }
        return(array('votos' => $resultado, 'totales' => $totales));
    }

    function getPorcentajes() {
        $seccionales = $this->getSeccionales();
        $porcentajes = $totales_porcentajes = array();
        $totales_porcentajes['EMITIDOS'] = 0;
        $general = 0;
        $resultado = $this->getResultados();
        foreach ($resultado['votos'] as $clave => $valor) {
            if (isset($seccionales[$clave])) {
                if ($_SESSION['tiporeporte'] == 'VALIDOS')
                    $suma = sumavalidos($valor);
                elseif ($_SESSION['tiporeporte'] == 'AFIRMATIVOS')
                    $suma = sumaafirmativos($valor);
                else
                    $suma = suma($valor);
                $general += $suma;
                $porcentajes[$clave]['EMITIDOS'] = $suma;
                foreach ($valor as $clave2 => $valor2) {
                    $porcentajes[$clave][$clave2]['porcentaje'] = ($suma > 0) ? round($valor2['votos'] / $suma * 100, 200) : 0;
                    $porcentajes[$clave][$clave2]['id'] = $valor2['id'];
                    if (!isset($totales_porcentajes[$clave2]))
                        $totales_porcentajes[$clave2]['porcentaje'] = ($suma > 0) ? round($valor2['votos'] / $suma * 100, 200) : 0;
                    else
                        $totales_porcentajes[$clave2]['porcentaje'] += ($suma > 0) ? round($valor2['votos'] / $suma * 100, 200) : 0;
                    $totales_porcentajes[$clave2]['id'] = $valor2['id'];
                }
            }
        }
        $totales_porcentajes['EMITIDOS'] = $general;
        return(array('porcentajes' => $porcentajes, 'totales_porcentajes' => $totales_porcentajes));
    }

    function getPorcentajeponderado() {
        $seccionales = $this->getSeccionales();
        $resultado = $this->getPorcentajes();
        $resultado = $resultado['porcentajes'];
        $porcentajes_peso = array();
        foreach ($resultado as $clave => $item) {
            if (isset($seccionales[$clave]))
                foreach ($item as $clave2 => $item2) {
                    /* if ($clave2 != 'EMITIDOS' && $clave2 != 'BLANCOS--' && $clave2 != 'NULOS--' && $clave2 != 'OTROS--') { */

                    if (!isset($porcentajes_peso[$clave2]))
                        $porcentajes_peso[$clave2]['porcentaje'] = round($item2['porcentaje'] * $seccionales[$clave]['peso'] / 100, 200);
                    else
                        $porcentajes_peso[$clave2]['porcentaje'] += round($item2['porcentaje'] * $seccionales[$clave]['peso'] / 100, 200);
                    $porcentajes_peso[$clave2]['id'] = $item2['id'];
                    /* } */
                }
        }
        return($porcentajes_peso);
    }

    function getDistribucion($id) {
        //$porcentajes_peso = $this->getPorcentajeponderado();
        $_porcentajes_peso = $this->getPorcentajeponderado();
        $porcentajes_peso = array();
        foreach ($_porcentajes_peso as $clave => $pp) {
            if ($pp['porcentaje'] > 3)
                $porcentajes_peso[$clave] = $pp;
        }
        $partidos = $this->getPartidos();
        $total_partido = 0;

        if ($id != 0) {
            foreach ($porcentajes_peso as $item) {
                if ($item['id'] > 0 && isset($partidos[$item['id']]) && $partidos[$item['id']]['id_partido'] == $id)
                    $total_partido += $item['porcentaje'];
            }
        }
        $sql = "SELECT * FROM circuito WHERE id=?  ";
        $circuito = $this->app['db']->fetchAssoc($sql, array((int) $this->id));
        $titulares = $circuito['conc_titulares'];
        $suplentes = $circuito['conc_suplentes'];
        $dhont = array();
        $total_concejales = $titulares + $suplentes;
        $i = 1;

        while ($i <= $total_concejales) {
            foreach ($porcentajes_peso as $clave => $item) {
                if ($clave != "OTROS--" && $clave != "NULOS--" && $clave != "BLANCOS--") {
                    if ($id > 0) {
                        if ($item['id'] > 0 && isset($partidos[$item['id']]) && $partidos[$item['id']]['id_partido'] == $id)
                            $dhont[] = array('partido' => $clave, 'orden' => $i, "valor" => ($item['porcentaje'] * 100 / $total_partido) / $i, "logo" => buscarfoto($partidos, $clave));
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

    function getDistribucionCompleta($id) {
        $_porcentajes_peso = $this->getPorcentajeponderado();
        $porcentajes_peso = array();
        foreach ($_porcentajes_peso as $clave => $pp) {
            if ($pp['porcentaje'] > 3)
                $porcentajes_peso[$clave] = $pp;
        }
        $partidos = $this->getPartidos();
        $total_partido = 0;
        if ($id != 0) {
            foreach ($porcentajes_peso as $item) {
                if ($item['id'] > 0 && isset($partidos[$item['id']]) && $partidos[$item['id']]['id_partido'] == $id)
                    $total_partido += $item['porcentaje'];
            }
        }

        //print_r($porcentajes_peso);
        $sql = "SELECT * FROM circuito WHERE id=?  ";
        $circuito = $this->app['db']->fetchAssoc($sql, array((int) $this->id));
        $titulares = $circuito['conc_titulares'];
        $suplentes = $circuito['conc_suplentes'];
        $dhont = array();
        $total_concejales = 9999;
        $i = 1;

        while ($i <= $total_concejales) {
            foreach ($porcentajes_peso as $clave => $item) {
                if ($clave != "OTROS--" && $clave != "NULOS--" && $clave != "BLANCOS--") {
                    if ($id > 0) {
                        if ($item['id'] > 0 && isset($partidos[$item['id']]) && $partidos[$item['id']]['id_partido'] == $id)
                            $dhont[] = array('partido' => $clave, 'orden' => $i, "valor" => ($item['porcentaje'] * 100 / $total_partido) / $i, "logo" => buscarfoto($partidos, $clave));
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
        if ($this->seccionales > 0) {
            $sql = "SELECT * FROM seccional WHERE circuito_id=? and id in (select seccionales_id from mesa,renglon "
                    . "where mesa.id=renglon.mesa_id and  mesa.intendente>0 and renglon.intendente>0)";
            $seccionales = $this->app['db']->fetchAll($sql, array((int) $this->id));
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
        } else {   ///// NO TIENE SECCIONALES LA LOCALIDAD
            $sql = "SELECT * FROM circuito WHERE id=?";
            $circuito = $this->app['db']->fetchAssoc($sql, array((int) $this->id));

            return array("1" => array('id' => "1", "nombre" => $circuito['nombre'], 'electores' => $circuito['electores_provincia'], 'peso' => 100));
        }

        return($resultado);
    }

    function getPartidos() {
        $sql = "SELECT partido_lista.* FROM partido_lista,cargo_local "
                . "where partido_lista.id=cargo_local.lista_id and cargo_local.circuito_id=?";
        $partidos = $this->app['db']->fetchAll($sql, array((int) $this->id));
        $resultado = array();
        foreach ($partidos as $item) {
            $item['logo'] = base64_encode($item['logo']);
            $resultado[$item['id']] = $item;
        }

        return($resultado);
    }

    function getAvance() {
        $sql = "SELECT seccional.id,seccional.nombre as nombre,count(*) as mesas from seccional,mesa "
                . "where seccional.circuito_id=" . $this->id . " and mesa.seccionales_id=seccional.id "
                . " and mesa.intendente=1 "
                . "group by seccional.id,seccional.nombre";
        $_seccionales = $this->app['db']->fetchAll($sql, array((int) $this->id));
        foreach ($_seccionales as $item) {
            $sql = "select count(DISTINCT mesa.id) as cargadas from mesa,renglon "
                    . "where renglon.mesa_id=mesa.id and renglon.intendente>0 "
                    . " and mesa.seccionales_id=" . $item['id'];
            $cargadas = $this->app['db']->fetchAssoc($sql, array((int) $this->id));
            $item['cargadas'] = $cargadas['cargadas'];
            $seccionales[] = $item;
        }
        return $seccionales;
    }

    function getFaltante() {
        $sql = "SELECT seccional.id,seccional.nombre as nombre,count(*) as mesas from seccional,mesa "
                . "where seccional.circuito_id=" . $this->id . " and mesa.seccionales_id=seccional.id "
                . " and mesa.intendente=1 "
                . "group by seccional.id,seccional.nombre";
        $_seccionales = $this->app['db']->fetchAll($sql, array((int) $this->id));
        foreach ($_seccionales as $item) {
            $sql = "select  * from mesa "
                    . " where  seccionales_id=" . $item['id'] . " and mesa.intendente=1 and id not in (select mesa_id from renglon "
                    . " where renglon.intendente>0 )";

            $faltantes = $this->app['db']->fetchAll($sql, array((int) $this->id));
            $item['faltantes'] = $faltantes;
            $seccionales[] = $item;
        }
        return $seccionales;
    }

    function getFaltante_con_cargadas() {
        $sql = "SELECT seccional.id,seccional.nombre as nombre,count(*) as mesas from seccional,mesa "
                . "where seccional.circuito_id=" . $this->id . " and mesa.seccionales_id=seccional.id "
                . " and mesa.intendente=1 "
                . "group by seccional.id,seccional.nombre";
        $_seccionales = $this->app['db']->fetchAll($sql, array((int) $this->id));
        foreach ($_seccionales as $item) {
            $sql = "select  * from mesa "
                    . " where  seccionales_id=" . $item['id'] . " and mesa.intendente=1";

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
