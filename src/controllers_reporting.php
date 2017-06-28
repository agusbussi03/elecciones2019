<?php

$app->get('/rep_circuito', function () use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $sql = "SELECT distinct c.* from circuito c, mesa m where c.id=m.circuito_id";
    $resultado = $app['db']->fetchAll($sql);
    foreach ($resultado as $item) {
        $sql = "SELECT * FROM mesa where circuito_id=" . $item['id'] . " and concejal=1 and "
                . "id not in (select mesa_id from renglon where concejal>0)";
        $mesas_nocargadas_C = $app['db']->fetchAll($sql);
        $sql = "SELECT * FROM mesa where circuito_id=" . $item['id'] . " and concejal=1 and "
                . "id  in (select mesa_id from renglon where concejal>0)";
        $mesas_cargadas_C = $app['db']->fetchAll($sql);
        $sql = "SELECT * FROM mesa where circuito_id=" . $item['id'] . " and intendente=1 and "
                . "id not in (select mesa_id from renglon where intendente>0)";
        $mesas_nocargadas_I = $app['db']->fetchAll($sql);
        $sql = "SELECT * FROM mesa where circuito_id=" . $item['id'] . " and intendente=1 and "
                . "id  in (select mesa_id from renglon where intendente>0)";
        $mesas_cargadas_I = $app['db']->fetchAll($sql);

        $circuitos[] = array('datos' => $item,
            'concejal' => array('cargadas' => $mesas_cargadas_C, 'nocargadas' => $mesas_nocargadas_C),
            'intendente' => array('cargadas' => $mesas_cargadas_I, 'nocargadas' => $mesas_nocargadas_I,));
    }
    return $app['twig']->render('rep_circuitos.html.twig', array('circuitos' => $circuitos));
})->bind('rep_circuito');


$app->get('/rep_concejales_seccional/{tipo}/{id}', function ($tipo, $id) use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    require_once 'Concejales.php';
    $concejales = new Concejales($id, $app);
    //print_r($concejales->getSeccionales());
    $circuito = $app['db']->fetchAssoc("SELECT * FROM circuito where id=$id");

    if ($tipo == 'votos') {
        $resultado = $concejales->getResultados();
        return $app['twig']->render('reporting/res_concejales_votos.html.twig', array('votos' => $resultado['votos'], 'circuito' => $circuito, 'totales' => $resultado['totales'], 'seccionales' => $concejales->getSeccionales()));
    }
    if ($tipo == 'porcentajes') {
        $resultado = $concejales->getPorcentajes();
        return $app['twig']->render('reporting/res_concejales_porcentaje.html.twig', array('votos' => $resultado['porcentajes'], 'circuito' => $circuito,
                    'totales' => $resultado['totales_porcentajes'], 'seccionales' => $concejales->getSeccionales()));
    }
    if ($tipo == 'porcentajes_ponderado') {
        $total_ponderado = $concejales->getPorcentajeponderado();
        $resultado = $concejales->getPorcentajes();
        return $app['twig']->render('reporting/res_concejales_porcentaje_ponderado.html.twig', array('votos' => $resultado['porcentajes'], 'circuito' => $circuito,
                    'totales' => $total_ponderado, 'seccionales' => $concejales->getSeccionales()));
    }
    if ($tipo == 'graficos') {
        $resultado = $concejales->getPorcentajeponderado();
        $partidos = $concejales->getPartidos();
        uasort($resultado,'ordena');
        return $app['twig']->render('reporting/res_concejales_grafico.html.twig', array('totales' => $resultado, 'circuito' => $circuito, 'partidos' => $partidos));
    }
    if ($tipo == 'distribucion') {
        $resultado = $concejales->getDistribucion();
        return $app['twig']->render('reporting/res_concejales_distribucion.html.twig', array('circuito' => $circuito, 'totales' => $resultado));
    }
})->bind('rep_concejales_seccional');

function suma($item) {
    $suma = 0;
    foreach ($item as $i) {
        $suma += $i['votos'];
    }
    return$suma;
}
function ordena($a, $b){
         if ($a['porcentaje'] == $b['porcentaje']) {
            return 0;
        }
        return ($a['porcentaje'] > $b['porcentaje']) ? -1 : 1;
}