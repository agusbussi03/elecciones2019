<?php

$app->get('/rep_circuito', function () use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }

    $sql = "SELECT m.sec,m.cirnro,m.cirlet,c.nomb,count(*) from mesas m,circuitos c "
            . "where m.sec=c.sec and m.cirnro=c.cirnro and m.cirlet=c.cirlet and m.testigo=1 and m.sec not in (9,13,14) "
            . "group by m.sec,m.cirnro,m.cirlet,c.nomb "
            . "UNION select sec,9999,'','SANTA FE',count(*) from mesas where sec=9 and testigo=1 group by sec "
            . "UNION select 13,9999,'','ROSARIO',count(*) from mesas where sec in (13,14) and testigo=1 group by sec";
    $resultado = $app['db']->fetchAll($sql);
    foreach ($resultado as $item) {

        $sec = $item['sec'];
        $cirnro = $item['cirnro'];
        $cirlet = $item['cirlet'];

        if ($sec == 9) {
            $sql = "SELECT * FROM mesas where testigo=1 and sec=? "
                    . "and mesa not in (select mesa from renglon where con>0)";
            $mesas_nocargadas = $app['db']->fetchAll($sql, array((int) $sec));
            $sql = "SELECT * FROM mesas where testigo=1 and sec=? "
                    . "and mesa  in (select mesa from renglon where con>0)";
            $mesas_cargadas = $app['db']->fetchAll($sql, array((int) $sec));
        } elseif ($sec == 13 || $sec == 14) {
            $sql = "SELECT * FROM mesas where testigo=1 and sec in (13,14)"
                    . "and mesa not in (select mesa from renglon where con>0)";
            $mesas_nocargadas = $app['db']->fetchAll($sql);
            $sql = "SELECT * FROM mesas where testigo=1 and sec in (13,14)"
                    . "and mesa  in (select mesa from renglon where con>0)";
            $mesas_cargadas = $app['db']->fetchAll($sql);
        } else {
            $sql = "SELECT * FROM mesas where testigo=1 and sec=? and cirnro=? and cirlet=? "
                    . "and mesa not in (select mesa from renglon where con>0)";
            $mesas_nocargadas = $app['db']->fetchAll($sql, array((int) $sec, (int) $cirnro, $cirlet));
            $sql = "SELECT * FROM mesas where testigo=1 and sec=? and cirnro=? and cirlet=? "
                    . "and mesa in (select mesa from renglon where con>0)";
            $mesas_cargadas = $app['db']->fetchAll($sql, array((int) $sec, (int) $cirnro, $cirlet));
        }


        $circuitos[] = array('datos' => $item, 'concejal' => array('cargadas' => $mesas_cargadas,'nocargadas' => $mesas_nocargadas,));
    }
    print_r($circuitos);
});

