<?php


$app->get('/intendente_faltante_circuito/{circuito}', function ($circuito) use ($app) {
    if (!validar('admin') && !validar('lectura')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    require_once 'Intendente.php';
    $intendente = new Intendente($circuito, $app);
    $circuito = $app['db']->fetchAssoc("SELECT * FROM circuito where id=$circuito");
    if (isset($_GET['completo']))
        $faltantes = $intendente->getFaltante_con_cargadas();
    else
        $faltantes = $intendente->getFaltante();

    return $app['twig']->render('reporting/res_$intendente_faltante.html.twig', array('faltantes' => $faltantes, 'circuito' => $circuito));
})->bind('intendente_faltante_circuito');

$app->get('/mesas_circuito_intendente/{circuito}', function ($circuito) use ($app) {
    if (!validar('admin') && !validar('lectura')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    require_once 'Intendente.php';
    require_once 'Configuracion.php';
    $concejales = new Concejales($circuito, $app);
    $configuracion = new Configuracion($app);
    $partidos = $concejales->getPartidos();
    $mesas = $app['db']->fetchAll("SELECT * FROM mesa where intendente=1 and circuito_id=$circuito");
    $texto = "";
    $texto = "Mesa;Ubicacion;";
    //print_r($partidos);
    foreach ($partidos as $partido)
        $texto .= $partido['nombre_partido'] . "/" . $partido['nombre_lista'] . ";";
    $texto .= "OTROS;BLANCOS;NULOS;";
    $texto .= "\n\r";
    foreach ($mesas as $mesa) {
        $texto .= $mesa['numero'] . ";";
        $texto .= $configuracion->getLocalmesa($mesa['numero']) . ";";
        foreach ($partidos as $partido) {
            $votos = $app['db']->fetchAssoc("SELECT * FROM renglon "
                    . "where mesa_id=" . $mesa['id'] . " and lista_id=" . $partido['id']);
            $texto .= $votos['intendente'] . ";";
        }

        foreach (array(989, 990, 991) as $partido) {
            $votos = $app['db']->fetchAssoc("SELECT * FROM renglon "
                    . "where mesa_id=" . $mesa['id'] . " and lista_id=" . $partido);
            $texto .= $votos['intendente'] . ";";
        }
        header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
        header("Content-Disposition: attachment; filename=concejales.xls");  //File name extension was wrong
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private", false);
        $texto .= "\n\r";
    }
    echo $texto;
    die;
})->bind('mesas_circuito_intendente');



$app->get('/rep_intendente_seccional/{tipo}/{id}', function ($tipo, $id) use ($app) {
    if (!validar('admin') && !validar('lectura')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    if (isset($_GET['tiporeporte']))
        $_SESSION['tiporeporte'] = $_GET['tiporeporte'];
    else
        $_SESSION['tiporeporte'] = "EMITIDOS";
    $app['twig']->addGlobal('session', $_SESSION);
    require_once 'Intendente.php';
    $intendente = new Intendente($id, $app);
    $circuito = $app['db']->fetchAssoc("SELECT * FROM circuito where id=$id");

    if ($tipo == 'votos') {
        $resultado = $intendente->getResultados();
        return $app['twig']->render('reporting/res_intendente_votos.html.twig', array('votos' => $resultado['votos'], 'circuito' => $circuito, 'totales' => $resultado['totales'], 'seccionales' => $intendente->getSeccionales()));
    }
    if ($tipo == 'porcentajes') {
        $resultado = $intendente->getPorcentajes();
        //$resultado=ajustar($resultado);
        return $app['twig']->render('reporting/res_intendente_porcentaje.html.twig', array('votos' => $resultado['porcentajes'], 'circuito' => $circuito,
                    'totales' => $resultado['totales_porcentajes'], 'seccionales' => $intendente->getSeccionales()));
    }
    if ($tipo == 'porcentajes_ponderado') {
        $total_ponderado = $intendente->getPorcentajeponderado();
        $resultado = $intendente->getPorcentajes();
        return $app['twig']->render('reporting/res_intendente_porcentaje_ponderado.html.twig', array('votos' => $resultado['porcentajes'], 'circuito' => $circuito,
                    'totales' => $total_ponderado, 'seccionales' => $intendente->getSeccionales()));
    }
    if ($tipo == 'mapa') {
        $resultado = $intendente->getPorcentajes();
        $seccionales = $intendente->getSeccionales();
        $partidos = $intendente->getPartidos();
        foreach ($seccionales as $seccional) {
            //$totales[$departamento['nombre']]['electores']=$departamento['electores'];
            foreach ($resultado['porcentajes'][$seccional['id']] as $clave => $item) {
                if (!(in_array($clave, array("EMITIDOS", "BLANCOS--", "NULOS--","OTROS--")))) {
                    $partido = strtok($clave, "-");
                    if (isset($totales[$seccional['nombre']][$partido]))
                        $totales[$seccional['nombre']][$partido] += $item['porcentaje'];
                    else
                        $totales[$seccional['nombre']][$partido] = $item['porcentaje'];
                }
            }
        }
        require_once('Configuracion.php');
        $configuracion = new Configuracion($app);
        $partidos2 = array();
        foreach ($partidos as $clave => $item) {
            if (!(isset($partidos2[$item['id_partido']]))) {
                $partidos2[$item['id_partido']]['nombre_partido'] = $item['nombre_partido'];
                $partidos2[$item['id_partido']]['color'] = $configuracion->getColorpartido($item['id_partido']);
            }
        }

        $totales2 = array();
        foreach ($totales as $clave => $item) {
            foreach ($item as $clave2 => $item2) {
                $totales2[$clave][$clave2] = number_format($item2, 2, ".", ",");
            }
        }
        $totales = array();
        foreach ($totales2 as $clave => $item) {
            arsort($item);
            $totales[$clave] = $item;
        }

        $colores_seccional = array();
        foreach ($totales as $clave => $item) {
            $colores_seccional[$clave] = $configuracion->getColorpartidopornombre(array_keys($item)[0]);
        }
       // print_r($colores_seccional);
        return $app['twig']->render('reporting/res_intendente_mapas.html.twig', array('circuito' => $circuito, 'totales' => $totales, 'partidos' => $partidos2,
                    'colores_seccional' => $colores_seccional));
    }
    if ($tipo == 'graficos') {
        $resultado = $intendente->getPorcentajeponderado();
        $partidos = $intendente->getPartidos();
        uasort($resultado, 'ordena');
        $otros = $blancos = $nulos = array();
        $resultado_limpio = $resultado_partido = array();
        foreach ($resultado as $clave => $item) {
            if ($clave == "EMITIDOS") {
                
            } elseif ($clave == "BLANCOS--") {
                $blancos = $item;
            } elseif ($clave == "NULOS--") {
                $nulos = $item;
            } elseif ($clave == "OTROS--") {
                $otros = $item;
            } else {
                $partido = explode("-", $clave);
                $partido = $partido[0];
                if (isset($resultado_partido[$partido]['porcentaje']))
                    $resultado_partido[$partido]['porcentaje'] += $item['porcentaje'];
                else
                    $resultado_partido[$partido]['porcentaje'] = $item['porcentaje'];
                $resultado_partido[$partido]['id'] = $item['id'];
                $resultado_limpio[$clave] = $item;
            }
        }
        uasort($resultado_partido, 'ordena');
        $resultado_limpio['OTROS'] = $otros;
        $resultado_limpio['BLANCOS'] = $blancos;
        $resultado_limpio['NULOS'] = $nulos;
        return $app['twig']->render('reporting/res_intendente_grafico.html.twig', array('totales' => $resultado_limpio, 'totales_partido' => $resultado_partido, 'circuito' => $circuito, 'partidos' => $partidos));
    }
    if ($tipo == 'distribucion') {

        $id = 0;
        if (isset($_GET['id']))
            $id = $_GET['id'];
        $resultado = $intendente->getDistribucion($id);
        $_partidos = $intendente->getPartidos();

        $partidos = array();
        foreach ($_partidos as $item) {
            $partidos[$item['id_partido']] = $item['nombre_partido'];
        }
        $suma = array();
        $i=0;
        
        foreach ($resultado as $item) {
            if (isset($suma[$item['partido']]))
                $suma[$item['partido']] ++;
            else
                $suma[$item['partido']] = 1;
            if (++$i == $circuito['conc_titulares']) break;
        }
        //print_r($resultado);
        $grafico = array();
        $resultado_grafico = $intendente->getDistribucionCompleta($id);
        if ($id > 0) {
            foreach ($resultado_grafico as $clave => $item) {
                if (!(isset($grafico[$item['partido']])))
                    $grafico[$item['partido']] = $item;
            }
        }
        //print_r($grafico);
        return $app['twig']->render('reporting/res_intendente_distribucion.html.twig', array('grafico' => $grafico, 'partidos' => $partidos, 'circuito' => $circuito, 'totales' => $resultado, 'suma' => $suma));
    }
    if ($tipo == 'votos_grafico') {
        $resultado = $intendente->getResultados();
        $datos = array();
        $seccionales = array();
        $temp = $intendente->getSeccionales();
        foreach ($resultado['votos'] as $clave => $item) {
            $seccionales[] = $temp[$clave]['nombre'];
            foreach ($item as $clave2 => $item2) {
                $datos[$clave2][] = $item2['votos'];
            }
        }
        return $app['twig']->render('reporting/res_intendente_votos_grafico.html.twig', array('circuito' => $circuito, 'seccionales' => $seccionales, 'datos' => $datos));
    }
    if ($tipo == 'avance') {
        $avance = $intendente->getAvance();
        return $app['twig']->render('reporting/res_intendente_avance.html.twig', array('circuito' => $circuito, 'avance' => $avance));
    }
})->bind('rep_intendente_seccional');
