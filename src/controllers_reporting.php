<?php

/*
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
  })->bind('rep_circuitos'); */


$app->get('/rep_concejales_seccional/{tipo}/{id}', function ($tipo, $id) use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    require_once 'Concejales.php';
    $concejales=new Concejales($id,$app);
    //print_r($concejales->getSeccionales());
    $circuito = $app['db']->fetchAssoc("SELECT * FROM circuito where id=$id");
   
    if ($tipo == 'votos') { 
        $resultado=$concejales->getResultados();
        return $app['twig']->render('reporting/res_concejales_votos.html.twig', 
                array('votos' => $resultado['votos'], 'circuito' => $circuito, 'totales' =>$resultado['totales'],'seccionales'=>$concejales->getSeccionales()));
    }
    if ($tipo == 'porcentajes') {
        $resultado=$concejales->getPorcentajes();
        //print_r($resultado);
        return $app['twig']->render('reporting/res_concejales_porcentaje.html.twig', 
                array('votos' => $resultado['porcentajes'], 'circuito' => $circuito, 
                    'totales' => $resultado['totales_porcentajes'],'seccionales'=>$concejales->getSeccionales()));
    }
    if ($tipo == 'graficos') {
         $resultado=$concejales->getPorcentajes();
        return $app['twig']->render('reporting/res_concejales_grafico.html.twig', 
                array('votos' =>  $resultado['porcentajes'], 'circuito' => $circuito, 'totales' =>  $resultado['totales_porcentajes']));
    }
    if ($tipo == 'distribucion') {
         $resultado=$concejales->getDistribucion();
        return $app['twig']->render('reporting/res_concejales_distribucion.html.twig', 
                array('votos' =>  $resultado['porcentajes'], 'circuito' => $circuito, 'totales' =>  $resultado['totales_porcentajes']));
    }
    
    
    
})->bind('rep_concejales_seccional');

function suma($item) {
    $suma = 0;
    foreach ($item as $i) {
        $suma += $i;
    }
    return$suma;
}
