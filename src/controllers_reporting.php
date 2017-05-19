<?php

$app->get('/rep_circuito', function () use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $sql = "SELECT m.sec,m.cirnro,m.cirlet,c.nomb,count(*) as cuenta from mesas m,circuitos c "
            . "where m.sec=c.sec and m.cirnro=c.cirnro and m.cirlet=c.cirlet and m.testigo=1 and m.sec not in (9,13,14) "
            . "group by m.sec,m.cirnro,m.cirlet,c.nomb "
            . "UNION select sec,9999,'','SANTA FE',count(*) as cuenta from mesas where sec=9 and testigo=1 group by sec "
            . "UNION select 13,9999,'','ROSARIO',count(*) as cuenta from mesas where sec in (13,14) and testigo=1 group by sec";
    $resultado = $app['db']->fetchAll($sql);
    foreach ($resultado as $item) {
        $sec = $item['sec'];
        $cirnro = $item['cirnro'];
        $cirlet = $item['cirlet'];
        if ($sec == 9) {
            $sql = "SELECT * FROM mesas where testigo=1 and sec=? "
                    . "and mesa not in (select mesa from renglon where con>0)";
            $mesas_nocargadas_C = $app['db']->fetchAll($sql, array((int) $sec));
            $sql = "SELECT * FROM mesas where testigo=1 and sec=? "
                    . "and mesa  in (select mesa from renglon where con>0)";
            $mesas_cargadas_C = $app['db']->fetchAll($sql, array((int) $sec));
            $sql = "SELECT * FROM mesas where testigo=1 and sec=? "
                    . "and mesa not in (select mesa from renglon where inte>0)";
            $mesas_nocargadas_I = $app['db']->fetchAll($sql, array((int) $sec));
            $sql = "SELECT * FROM mesas where testigo=1 and sec=? "
                    . "and mesa  in (select mesa from renglon where inte>0)";
            $mesas_cargadas_I = $app['db']->fetchAll($sql, array((int) $sec));
        } elseif ($sec == 13 || $sec == 14) {
            $sql = "SELECT * FROM mesas where testigo=1 and sec in (13,14)"
                    . "and mesa not in (select mesa from renglon where con>0)";
            $mesas_nocargadas_C = $app['db']->fetchAll($sql);
            $sql = "SELECT * FROM mesas where testigo=1 and sec in (13,14)"
                    . "and mesa  in (select mesa from renglon where con>0)";
            $mesas_cargadas_I = $app['db']->fetchAll($sql);
            $sql = "SELECT * FROM mesas where testigo=1 and sec in (13,14)"
                    . "and mesa not in (select mesa from renglon where inte>0)";
            $mesas_nocargadas_C = $app['db']->fetchAll($sql);
            $sql = "SELECT * FROM mesas where testigo=1 and sec in (13,14)"
                    . "and mesa  in (select mesa from renglon where inte>0)";
            $mesas_cargadas_I = $app['db']->fetchAll($sql);
        } else {
            $sql = "SELECT * FROM mesas where testigo=1 and sec=? and cirnro=? and cirlet=? "
                    . "and mesa not in (select mesa from renglon where con>0)";
            $mesas_nocargadas_C = $app['db']->fetchAll($sql, array((int) $sec, (int) $cirnro, $cirlet));
            $sql = "SELECT * FROM mesas where testigo=1 and sec=? and cirnro=? and cirlet=? "
                    . "and mesa in (select mesa from renglon where con>0)";
            $mesas_cargadas_C = $app['db']->fetchAll($sql, array((int) $sec, (int) $cirnro, $cirlet));
            $sql = "SELECT * FROM mesas where testigo=1 and sec=? and cirnro=? and cirlet=? "
                    . "and mesa not in (select mesa from renglon where inte>0)";
            $mesas_nocargadas_I = $app['db']->fetchAll($sql, array((int) $sec, (int) $cirnro, $cirlet));
            $sql = "SELECT * FROM mesas where testigo=1 and sec=? and cirnro=? and cirlet=? "
                    . "and mesa in (select mesa from renglon where inte>0)";
            $mesas_cargadas_I = $app['db']->fetchAll($sql, array((int) $sec, (int) $cirnro, $cirlet));
        }
        $circuitos[] = array('datos' => $item,
            'concejal' => array('cargadas' => $mesas_cargadas_C, 'nocargadas' => $mesas_nocargadas_C),
            'intendente' => array('cargadas' => $mesas_cargadas_I, 'nocargadas' => $mesas_nocargadas_I,));
    }
    //print_r($circuitos);
    return $app['twig']->render('rep_circuitos.html.twig', array('circuitos' => $circuitos));
})->bind('rep_circuitos');


$app->get('/rep_concejales_seccional/{id}', function ($id) use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }

    $sql = "SELECT sec.nombre,p.nombre_partido,p.id_partido,p.id_lista,p.nombre_lista,sum(concejal) as suma,count(m.id) as cuenta "
            . "FROM renglon r, mesa m, seccional sec, partido_lista p, cargo_local car "
            . "WHERE r.mesa_id=m.id and m.seccionales_id=sec.id and r.lista_id=p.id "
            . "and m.circuito_id=? and concejal>=0 and car.lista_id=r.lista_id "
            . "and car.circuito_id=m.circuito_id and car.tipo='C' "
            . "group by sec.nombre,p.id_partido,p.nombre_partido,p.id_lista,p.nombre_lista "
            . "ORDER BY sec.nombre asc,`p`.`id_partido` ASC, p.nombre_lista asc  ";
    $votos = $app['db']->fetchAll($sql, array((int) $id));
    $resultado = array();
    foreach ($votos as $item) {
        $resultado[$item['nombre']][$item['nombre_partido'] . "-" . $item['id_lista'] . "-" . $item['nombre_lista']] = $item['suma'];
    }
    //especiales
      $sql = "SELECT sec.nombre,p.nombre_partido,p.id_partido,p.id_lista,p.nombre_lista,sum(concejal) as suma,count(m.id) as cuenta "
            . "FROM renglon r, mesa m, seccional sec, partido_lista p "
            . "WHERE r.mesa_id=m.id and m.seccionales_id=sec.id and r.lista_id=p.id "
            . "and m.circuito_id=? and concejal>=0 and p.especial=1 "
            . "group by sec.nombre,p.id_partido,p.nombre_partido,p.id_lista,p.nombre_lista "
            . "ORDER BY sec.nombre asc,`p`.`id_partido` ASC, p.nombre_lista asc  ";
    $votos = $app['db']->fetchAll($sql, array((int) $id));
    foreach ($votos as $item) {
        $resultado[$item['nombre']][$item['nombre_partido'] . "-" . $item['id_lista'] . "-" . $item['nombre_lista']] = $item['suma'];
    }
    
    
    //print_r($resultado);  
    return $app['twig']->render('reporting/res_concejales.html.twig', array('votos' => $resultado));
})->bind('rep_concejales_seccional');
;

