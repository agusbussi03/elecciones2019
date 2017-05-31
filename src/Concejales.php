<?php

/**
 * Description of Concejales
 *
 * @author pablo
 */
class Concejales {

    private $id = 0;
    private $app;

    function __construct($id, $app) {
        $this->app = $app;
        $this->id = $id;
    }

    function getResultados() {
        $sql = "SELECT sec.nombre,sec.id,p.nombre_partido,p.id_partido,p.id_lista,p.nombre_lista,sum(concejal) as suma,count(m.id) as cuenta "
                . "FROM renglon r, mesa m, seccional sec, partido_lista p, cargo_local car "
                . "WHERE r.mesa_id=m.id and m.seccionales_id=sec.id and r.lista_id=p.id "
                . "and m.circuito_id=? and concejal>=0 and car.lista_id=r.lista_id "
                . "and car.circuito_id=m.circuito_id and car.tipo='C' "
                . "group by sec.nombre,sec.id,p.id_partido,p.nombre_partido,p.id_lista,p.nombre_lista "
                . "ORDER BY sec.nombre asc,`p`.`id_partido` ASC, p.nombre_lista asc  ";
        $votos = $this->app['db']->fetchAll($sql, array((int) $this->id));
        $resultado = $totales = array();
        foreach ($votos as $item) {
            $resultado[$item['id']][$item['nombre_partido'] . "-" . $item['id_lista'] . "-" . $item['nombre_lista']] = $item['suma'];
            if (isset($totales[$item['nombre_partido'] . "-" . $item['id_lista'] . "-" . $item['nombre_lista']]))
                $totales[$item['nombre_partido'] . "-" . $item['id_lista'] . "-" . $item['nombre_lista']] += $item['suma'];
            else
                $totales[$item['nombre_partido'] . "-" . $item['id_lista'] . "-" . $item['nombre_lista']] = $item['suma'];
        }
        //especiales
        $sql = "SELECT sec.nombre,sec.id,p.nombre_partido,p.id_partido,p.id_lista,p.nombre_lista,sum(concejal) as suma,count(m.id) as cuenta "
                . "FROM renglon r, mesa m, seccional sec, partido_lista p "
                . "WHERE r.mesa_id=m.id and m.seccionales_id=sec.id and r.lista_id=p.id "
                . "and m.circuito_id=? and concejal>=0 and p.especial=1 "
                . "group by sec.nombre,sec.id,p.id_partido,p.nombre_partido,p.id_lista,p.nombre_lista "
                . "ORDER BY sec.nombre asc,`p`.`id_partido` ASC, p.nombre_lista asc  ";
        $votos = $this->app['db']->fetchAll($sql, array((int) $this->id));
        foreach ($votos as $item) {
            $resultado[$item['id']][$item['nombre_partido'] . "-" . $item['id_lista'] . "-" . $item['nombre_lista']] = $item['suma'];
            if (isset($totales[$item['nombre_partido'] . "-" . $item['id_lista'] . "-" . $item['nombre_lista']]))
                $totales[$item['nombre_partido'] . "-" . $item['id_lista'] . "-" . $item['nombre_lista']] += $item['suma'];
            else
                $totales[$item['nombre_partido'] . "-" . $item['id_lista'] . "-" . $item['nombre_lista']] = $item['suma'];
        }
        return(array('votos' => $resultado, 'totales' => $totales));
    }

    function getPorcentajes() {
        $porcentajes = $totales_porcentajes = array();
        $general = 0;
        $resultado = $this->getResultados();
        foreach ($resultado['votos'] as $clave => $valor) {
            $suma = suma($valor);
            $general += $suma;
            $porcentajes[$clave]['EMITIDOS'] = $suma;
            foreach ($valor as $clave2 => $valor2) {
                $porcentajes[$clave][$clave2] = $valor2 / $suma * 100;
            }
        }
        $totales_porcentajes['EMITIDOS'] = $general;
        foreach ($resultado['totales'] as $clave => $valor) {
            $totales_porcentajes[$clave] = $valor / $general * 100;
        }
        return(array('porcentajes' => $porcentajes, 'totales_porcentajes' => $totales_porcentajes));
    }

    function getDistribucion() {
        $resultado = $this->getPorcentajes();
        $resultado = $resultado['porcentajes'];
        $seccionales = $this->getSeccionales();
        $sql = "SELECT * FROM circuito WHERE id=?  ";
        $circuito = $this->app['db']->fetchAssoc($sql, array((int) $this->id));
        $titulares = $circuito['conc_titulares'];
        $suplentes = $circuito['conc_suplentes'];
        //print_r($resultado);
        //print_r($seccionales);
        $porcentajes_peso = array();
        foreach ($resultado as $clave => $item) {
            foreach ($item as $clave2 => $item2) {
                if ($clave2 != 'EMITIDOS' && $clave2 != 'BLANCOS--' && $clave2 != 'NULOS--' && $clave2 != 'OTROS--') {
                    if (!isset($porcentajes_peso[$clave2]))
                        $porcentajes_peso[$clave2] = $item2 * $seccionales[$clave]['peso'] / 100;
                    else
                        $porcentajes_peso[$clave2] += $item2 * $seccionales[$clave]['peso'] / 100;
                }
            }
        }
        //print_r($porcentajes_peso);
        $dhont = array();
        $total_concejales = $titulares + $suplentes;
        $i = 1;
        $partidos= $this->getPartidos();
        //print_r($partidos);
        while ($i <= $total_concejales) {
            foreach ($porcentajes_peso as $clave => $item) {
                $dhont[] = array('partido' => $clave, 'orden' => $i, "valor" => $item / $i,"logo"=> buscarfoto($partidos, $clave));
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
        $sql = "SELECT * FROM seccional WHERE circuito_id=?";
        $total = 0;
        $resultado = array();
        $seccionales = $this->app['db']->fetchAll($sql, array((int) $this->id));
        foreach ($seccionales as $item) {
            $total += $item['electores_provincia'];
        }
        foreach ($seccionales as $item) {
            $resultado[$item['id']] = array('id' => $item['id'], 'nombre' => $item['nombre'],
                'electores' => $item['electores_provincia'], 'peso' => round($item['electores_provincia'] / $total * 100, 2));
        }
        return($resultado);
    }

    function getPartidos() {
        $sql = "SELECT * FROM partido_lista,cargo_local "
                . "where partido_lista.id=cargo_local.lista_id and cargo_local.circuito_id=?";
        $partidos = $this->app['db']->fetchAll($sql, array((int) $this->id));
        $resultado=array();
        
        return($partidos);
    }

}

function ordena_dhont($a, $b) { {
        if ($a['valor'] == $b['valor']) {
            return 0;
        }
        return ($a['valor'] > $b['valor']) ? -1 : 1;
    }
}
function buscarfoto($partido,$patron){
    foreach($partido as $item){
        if ($item['nombre_partido']."-".$item['id_lista']."-".$item['nombre_lista']==$patron) 
                return base64_encode($item['logo']);
    }
    return "";
}
