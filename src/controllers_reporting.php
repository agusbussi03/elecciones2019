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


$app->get('/res_concejales/{sec}/{cirnro}/{cirlet}', function ($sec, $cirnro, $cirlet) use ($app) {
    if (!validar('admin')) {

        return $app->redirect($app['url_generator']->generate('login'));
    }
    if ($sec == 9) {
        $sql = "SELECT pspar,parnombre,pslista,nombre,sum(con) as cuenta FROM `renglon` "
                . "WHERE sec=9 and con>0 group by pspar,parnombre,pslista,nombre";
        $sumas = $app['db']->fetchAll($sql);
    } elseif ($sec == 13 || $sec == 14) {
        $sql = "SELECT pspar,parnombre,pslista,nombre,sum(con) as cuenta FROM `renglon` "
                . "WHERE sec in (13,14) and con>0 group by pspar,parnombre,pslista,nombre";
        $sumas = $app['db']->fetchAll($sql);
    } else {
        $sql = "SELECT pspar,parnombre,pslista,nombre,sum(con) as cuenta FROM `renglon` "
                . "WHERE sec=? and cirnro=? and cirlet=? and con>0 group by pspar,parnombre,pslista,nombre";
        $sumas = $app['db']->fetchAll($sql, array((int) $sec, (int) $cirnro, $cirlet));
    }

    $resultados = array();
    foreach ($sumas as $item) {
        $resultados[$item['pspar']]['listas'][] = array('pslista' => $item['pslista'], 'nombre' => $item['nombre'], 'cuenta' => $item['cuenta']);
        $resultados[$item['pspar']]['partido']['nombre'] = $item['parnombre'];
        if (!isset($resultados[$item['pspar']]['partido']['cuenta']))
            $resultados[$item['pspar']]['partido']['cuenta'] = $item['cuenta'];
        else
            $resultados[$item['pspar']]['partido']['cuenta'] += $item['cuenta'];
    }
    return $app['twig']->render('res_concejales.html.twig', array('resultados' => $resultados));
})->value('cirlet', '')->bind('res_concejales');
;

