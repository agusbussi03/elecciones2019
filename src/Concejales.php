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
        return(array('votos'=>$resultado,'totales'=>$totales));
    }
    
    function getPorcentajes(){
        $porcentajes = $totales_porcentajes = array();
        $general=0;
        $resultado=$this->getResultados();
         foreach ($resultado['votos'] as $clave => $valor) {
            $suma = suma($valor);
            $general += $suma;
            $porcentajes[$clave]['EMITIDOS'] = $suma;
            foreach ($valor as $clave2 => $valor2) {
                $porcentajes[$clave][$clave2] = round($valor2 / $suma*100, 2);
            }
        }
        $totales_porcentajes['EMITIDOS'] = $general;
        foreach ($resultado['totales'] as $clave => $valor) {
            $totales_porcentajes[$clave] = round($valor / $general*100, 2);
        }
         return(array('porcentajes'=>$porcentajes,'totales_porcentajes'=>$totales_porcentajes));
    }
    
      function getSeccionales(){
        $sql = "SELECT * FROM seccional WHERE circuito_id=?";
        $total=0;
        $resultado=array();
        $seccionales = $this->app['db']->fetchAll($sql, array((int) $this->id));
        foreach($seccionales as $item){
            $total+=$item['electores_provincia'];
        }
        foreach($seccionales as $item){
            $resultado[$item['id']]=array('id'=>$item['id'],'nombre'=>$item['nombre'],
                'electores'=>$item['electores_provincia'],'peso'=>round($item['electores_provincia']/$total*100,2));
        }
        
         return($resultado);
    }
    

}
