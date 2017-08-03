<?php

/**
 * Description of Concejales
 *
 * @author pablo
 */
class DiputadosNacionales {

    private $id = 0;
    private $app;
    private $departamentos = 0;

    function __construct($id, $app) {
        $this->app = $app;
        $this->id = $id;
        $secciones = $this->app['db']->fetchAssoc("SELECT count(*) as cuenta from seccion where provincia_id=?", array((int) $this->id));
        $this->departamentos = $secciones['cuenta'];
    }

    function getResultados() {
        $sql = "SELECT sec.nombre,sec.id,p.nombre_partido,p.id as plid,p.id_partido,p.id_lista,"
                . "p.nombre_lista,sum(r.diputado) as suma,count(m.id) as cuenta "
                . "FROM renglon_nacional r, mesa m, seccion sec, partido_lista_nacional p, "
                . "cargo_nacional car "
                . "WHERE r.mesa_id=m.id and r.lista_nacional_id=p.id and "
                . "m.circuito_id in (select id from circuito c1 where c1.seccion_id=sec.id) and "
                . "r.diputado>=0 and car.lista_nacional_id=r.lista_nacional_id and car.tipo='D' "
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
                . "p.nombre_lista,sum(r.diputado) as suma,count(m.id) as cuenta "
                . "FROM renglon_nacional r, mesa m,seccion sec, partido_lista_nacional p "
                . "WHERE r.mesa_id=m.id and r.lista_nacional_id=p.id and "
                . "m.circuito_id in (select id from circuito c1 where c1.seccion_id=sec.id) and "
                . "r.diputado>=0 and p.especial=1 group by sec.nombre,sec.id,p.id_partido,p.nombre_partido,"
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
        //print_r($resultado);
        $resultado = $resultado['porcentajes'];
        $porcentajes_peso = array();
        foreach ($resultado as $clave => $item) {
            foreach ($item as $clave2 => $item2) {
               /* if ($clave2 != 'EMITIDOS' && $clave2 != 'BLANCOS--' && $clave2 != 'NULOS--' && $clave2 != 'OTROS--') {*/
                    if (!isset($porcentajes_peso[$clave2]))
                        $porcentajes_peso[$clave2]['porcentaje'] = $item2['porcentaje'] * $seccionales[$clave]['peso'] / 100;
                    else
                        $porcentajes_peso[$clave2]['porcentaje'] += $item2['porcentaje'] * $seccionales[$clave]['peso'] / 100;
                    $porcentajes_peso[$clave2]['id'] = $item2['id'];
               /* }*/
            }
        }
        //print_r($porcentajes_peso);
        return($porcentajes_peso);
    }

    function getDistribucion($id) {

        $porcentajes_peso = $this->getPorcentajeponderado();
        $titulares = 9;
        $suplentes = 9;
        $dhont = array();
        $total_concejales = $titulares + $suplentes;
        $i = 1;
        $partidos = $this->getPartidos();
        while ($i <= $total_concejales) {
            foreach ($porcentajes_peso as $clave => $item) {
                 if ($clave != "OTROS--" && $clave != "NULOS--" && $clave != "BLANCOS--") {
                    if ($id > 0) {
                        if ($item['id'] > 0 && isset($partidos[$item['id']]) && $partidos[$item['id']]['id_partido'] == $id)
                            $dhont[] = array('partido' => $clave, 'orden' => $i, "valor" => $item['porcentaje'] / $i, "logo" => buscarfoto($partidos, $clave));
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

    function getDepartamentos() {
        $total = 0;
        $resultado = array();
        $sql = "SELECT * FROM seccion WHERE id in (select seccion_id from circuito,mesa where circuito.id=mesa.circuito_id and diputado_nacional>0)";
        $departamentos = $this->app['db']->fetchAll($sql, array((int) $this->id));
        foreach ($departamentos as $item) {
            $total += $item['electores_nacion'];
        }
        foreach ($departamentos as $item) {
            $resultado[$item['id']] = array('id' => $item['id'], 'nombre' => $item['nombre'],
                'electores' => $item['electores_provincia'], 'peso' => round($item['electores_nacion'] / $total * 100, 2));
        }


        return($resultado);
    }

    function getPartidos() {
        $sql = "SELECT partido_lista_nacional.* FROM partido_lista_nacional,cargo_nacional "
                . "where partido_lista_nacional.id=cargo_nacional.lista_nacional_id "
                . "and cargo_nacional.provincia_id=?";
        $partidos = $this->app['db']->fetchAll($sql, array((int) $this->id));
        $resultado = array();
        foreach ($partidos as $item) {
            $item['logo'] = base64_encode($item['logo']);
            $resultado[$item['id']] = $item;
        }

        return($resultado);
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
