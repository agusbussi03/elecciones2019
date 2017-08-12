<?php

$app->get('/rep_circuito', function () use ($app) {
    if (!validar('admin') && !validar('lectura')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $sql = "SELECT distinct c.* from circuito c, mesa m where c.id=m.circuito_id and m.intendente+m.concejal>=1";
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

$app->get('/rep_nacional', function () use ($app) {
    if (!validar('admin') && !validar('lectura')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $sql = "SELECT * FROM mesa where diputado_nacional=1 and "
            . "id not in (select mesa_id from renglon_nacional where renglon_nacional.diputado>0)";
    $mesas_nocargadas_D = $app['db']->fetchAll($sql);
    $sql = "SELECT * FROM mesa where diputado_nacional=1 and "
            . "id  in (select mesa_id from renglon_nacional where renglon_nacional.diputado>0)";
    $mesas_cargadas_D = $app['db']->fetchAll($sql);
    $sql = "SELECT * FROM mesa where senador_nacional=1 and "
            . "id not in (select mesa_id from renglon_nacional where senador_nacional>0)";
    $mesas_nocargadas_S = $app['db']->fetchAll($sql);
    $sql = "SELECT * FROM mesa where  senador_nacional=1 and "
            . "id  in (select mesa_id from renglon_nacional where senador_nacional>0)";
    $mesas_cargadas_S = $app['db']->fetchAll($sql);

    $provincia = array(
        'datos' => array('id' => 1),
        'dipnac' => array('cargadas' => $mesas_cargadas_D, 'nocargadas' => $mesas_nocargadas_D),
        'sennac' => array('cargadas' => $mesas_cargadas_S, 'nocargadas' => $mesas_nocargadas_S,));
    //print_r($provincia);
    return $app['twig']->render('rep_nacional.html.twig', array('provincia' => $provincia));
})->bind('rep_nacional');

$app->get('/avance_circuito/{circuito}', function ($circuito) use ($app) {
    if (!validar('admin') && !validar('lectura')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $sql = "SELECT distinct c.* from circuito c, mesa m where c.id=m.circuito_id and c.id=$circuito";
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
    //print_r($circuitos);
    require('mc_table.php');
    require_once('Configuracion.php');
    $configuracion = new Configuracion($app);
    $pdf = new PDF_MC_Table('P', 'mm', 'A4');
    $pdf->Open();
    $pdf->AliasNbPages();
    $pdf->AddPage('P', 'A4');
    $pdf->SetMargins(15, 2, 2, 5);
    $pdf->Ln();
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetWidths(array(200));
    $titulo = 'Faltantes concejal:  ' . $circuitos[0]['datos']['nombre'];
    $pdf->Row(array($titulo));
    $pdf->SetFont('Arial', '', 10);
    $columnas = array(15, 80, 80);
    $pdf->SetWidths($columnas);
    $titulos = array("Mesa", "Escuela", "Responsable");
    $pdf->Row_b($titulos);
    foreach ($circuitos[0]['concejal']['nocargadas'] as $item) {
        $pdf->Row_b(array($item['numero'], utf8_decode($configuracion->getLocalmesa($item['numero'])), $item['responsable']));
    }
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetWidths(array(200));
    $titulo = 'Faltantes intendente:  ' . $circuitos[0]['datos']['nombre'];
    $pdf->Row(array($titulo));
    $pdf->SetFont('Arial', '', 10);
    $columnas = array(15, 80, 80);
    $pdf->SetWidths($columnas);
    $titulos = array("Mesa", "Escuela", "Responsable");
    $pdf->Row_b($titulos);
    foreach ($circuitos[0]['intendente']['nocargadas'] as $item) {
        $pdf->Row_b(array($item['numero'], utf8_decode($configuracion->getLocalmesa($item['numero'])), $item['responsable']));
    }
    $pdf->Ln();
    $pdf->Ln();
    $pdf->SetWidths(array(200));
    $pdf->Row(array(date('d/M/Y h:i:s A')));
    ob_clean();
    $pdf->Output('reporte.pdf', 'D');
    die;
})->bind('avance_circuito');

$app->get('/faltante_circuito/{circuito}', function ($circuito) use ($app) {
    if (!validar('admin') && !validar('lectura')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    require_once 'Concejales.php';
    $concejales = new Concejales($circuito, $app);
    $circuito = $app['db']->fetchAssoc("SELECT * FROM circuito where id=$circuito");
    $faltantes = $concejales->getFaltante();
    return $app['twig']->render('reporting/res_concejales_faltante.html.twig', array('faltantes' => $faltantes, 'circuito' => $circuito));
})->bind('faltante_circuito');

$app->get('/avance_nacional/{provincia}', function ($provincia) use ($app) {
    if (!validar('admin') && !validar('lectura')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $sql = "SELECT * FROM mesa where diputado_nacional=1 and "
            . "id not in (select mesa_id from renglon_nacional where diputado>0)";
    $mesas_nocargadas_D = $app['db']->fetchAll($sql);
    $sql = "SELECT * FROM mesa where diputado_nacional=1 and "
            . "id in (select mesa_id from renglon_nacional where diputado>0)";
    $mesas_cargadas_D = $app['db']->fetchAll($sql);
    $mesas = array('diputado' => array('cargadas' => $mesas_cargadas_D, 'nocargadas' => $mesas_nocargadas_D));
    require('mc_table.php');
    require_once('Configuracion.php');
    $configuracion = new Configuracion($app);
    $pdf = new PDF_MC_Table('P', 'mm', 'A4');
    $pdf->Open();
    $pdf->AliasNbPages();
    $pdf->AddPage('P', 'A4');
    $pdf->SetMargins(15, 2, 2, 5);
    $pdf->Ln();
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetWidths(array(200));
    $titulo = 'Faltantes Diputados';
    $pdf->Row(array($titulo));
    $pdf->SetFont('Arial', '', 10);
    $columnas = array(15, 80, 80);
    $pdf->SetWidths($columnas);
    $titulos = array("Mesa", "Escuela", "Responsable");
    $pdf->Row_b($titulos);
    foreach ($mesas['diputado']['nocargadas'] as $item) {
        $pdf->Row_b(array($item['numero'], utf8_decode($configuracion->getLocalmesa($item['numero'])), $item['responsable']));
    }
    $pdf->SetWidths(array(200));
    $pdf->Row(array(date('d/M/Y h:i:s A')));
    ob_clean();
    $pdf->Output('reporte.pdf', 'D');
    die;
})->bind('avance_nacional');



$app->get('/faltante_nacional/{provincia}', function ($provincia) use ($app) {
    if (!validar('admin') && !validar('lectura')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    require_once 'DiputadosNacionales.php';
    $diputados = new DiputadosNacionales($provincia, $app);
    $provincia = $app['db']->fetchAssoc("SELECT * FROM provincia where id=$provincia");
    $faltantes = $diputados->getFaltante();
    return $app['twig']->render('reporting/res_dipnac_faltante.html.twig', array('faltantes' => $faltantes, 'provincia' => $provincia));
})->bind('faltante_nacional');


$app->get('/rep_concejales_seccional/{tipo}/{id}', function ($tipo, $id) use ($app) {
    if (!validar('admin') && !validar('lectura')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    if (isset($_GET['tiporeporte']))
        $_SESSION['tiporeporte'] = $_GET['tiporeporte'];
    else
        $_SESSION['tiporeporte'] = "EMITIDOS";
    $app['twig']->addGlobal('session', $_SESSION);
    require_once 'Concejales.php';
    $concejales = new Concejales($id, $app);
    $circuito = $app['db']->fetchAssoc("SELECT * FROM circuito where id=$id");

    if ($tipo == 'votos') {
        $resultado = $concejales->getResultados();
        return $app['twig']->render('reporting/res_concejales_votos.html.twig', array('votos' => $resultado['votos'], 'circuito' => $circuito, 'totales' => $resultado['totales'], 'seccionales' => $concejales->getSeccionales()));
    }
    if ($tipo == 'porcentajes') {
        $resultado = $concejales->getPorcentajes();
        //$resultado=ajustar($resultado);
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
        return $app['twig']->render('reporting/res_concejales_grafico.html.twig', array('totales' => $resultado_limpio, 'totales_partido' => $resultado_partido, 'circuito' => $circuito, 'partidos' => $partidos));
    }
    if ($tipo == 'distribucion') {

        $id = 0;
        if (isset($_GET['id']))
            $id = $_GET['id'];
        $resultado = $concejales->getDistribucion($id);
        $_partidos = $concejales->getPartidos();

        $partidos = array();
        foreach ($_partidos as $item) {
            $partidos[$item['id_partido']] = $item['nombre_partido'];
        }
        $suma = array();
        foreach ($resultado as $item) {
            if (isset($suma[$item['partido']]))
                $suma[$item['partido']] ++;
            else
                $suma[$item['partido']] = 1;
        }
        //print_r($resultado);
        $grafico = array();
        $resultado_grafico = $concejales->getDistribucionCompleta($id);
        if ($id > 0) {
            foreach ($resultado_grafico as $clave => $item) {
                if (!(isset($grafico[$item['partido']])))
                    $grafico[$item['partido']] = $item;
            }
        }
        //print_r($grafico);
        return $app['twig']->render('reporting/res_concejales_distribucion.html.twig', array('grafico' => $grafico, 'partidos' => $partidos, 'circuito' => $circuito, 'totales' => $resultado, 'suma' => $suma));
    }
    if ($tipo == 'votos_grafico') {
        $resultado = $concejales->getResultados();
        $datos = array();
        $seccionales = array();
        $temp = $concejales->getSeccionales();
        foreach ($resultado['votos'] as $clave => $item) {
            $seccionales[] = $temp[$clave]['nombre'];
            foreach ($item as $clave2 => $item2) {
                $datos[$clave2][] = $item2['votos'];
            }
        }
        return $app['twig']->render('reporting/res_concejales_votos_grafico.html.twig', array('circuito' => $circuito, 'seccionales' => $seccionales, 'datos' => $datos));
    }
    if ($tipo == 'avance') {
        $avance = $concejales->getAvance();
        return $app['twig']->render('reporting/res_concejales_avance.html.twig', array('circuito' => $circuito, 'avance' => $avance));
    }
})->bind('rep_concejales_seccional');


$app->get('/rep_dipnac_seccion/{tipo}/{id}', function ($tipo, $id) use ($app) {
    if (!validar('admin') && !validar('lectura')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    if (isset($_GET['tiporeporte']))
        $_SESSION['tiporeporte'] = $_GET['tiporeporte'];
    else
        $_SESSION['tiporeporte'] = "EMITIDOS";
    $app['twig']->addGlobal('session', $_SESSION);
    require_once 'DiputadosNacionales.php';
    $diputados = new DiputadosNacionales($id, $app);
    //print_r($concejales->getSeccionales());
    $circuito = $app['db']->fetchAssoc("SELECT * FROM circuito where id=$id");

    if ($tipo == 'votos') {
        $resultado = $diputados->getResultados();
        return $app['twig']->render('reporting/res_dipnac_votos.html.twig', array('votos' => $resultado['votos'], 'circuito' => $circuito, 'totales' => $resultado['totales'], 'departamentos' => $diputados->getDepartamentos()));
    }
    if ($tipo == 'porcentajes') {
        $resultado = $diputados->getPorcentajes();

        return $app['twig']->render('reporting/res_dipnac_porcentaje.html.twig', array('votos' => $resultado['porcentajes'], 'circuito' => $circuito,
                    'totales' => $resultado['totales_porcentajes'], 'seccionales' => $diputados->getDepartamentos()));
    }
    if ($tipo == 'porcentajes_ponderado') {
        $total_ponderado = $diputados->getPorcentajeponderado();
        $resultado = $diputados->getPorcentajes();
        return $app['twig']->render('reporting/res_dipnac_porcentaje_ponderado.html.twig', array('votos' => $resultado['porcentajes'], 'circuito' => $circuito,
                    'totales' => $total_ponderado, 'seccionales' => $diputados->getDepartamentos()));
    }
    if ($tipo == 'graficos') {
        $resultado = $diputados->getPorcentajeponderado();
        $partidos = $diputados->getPartidos();
        uasort($resultado, 'ordena');
        $resultado_limpio = $resultado_partido = array();
        $otros = $blancos = $nulos = array();

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
        
        return $app['twig']->render('reporting/res_dipnac_grafico.html.twig', array('totales' => $resultado_limpio, 'totales_partido' => $resultado_partido, 'circuito' => $circuito, 'partidos' => $partidos));
    }

    if ($tipo == 'distribucion') {
        $id = 0;
        if (isset($_GET['id']))
            $id = $_GET['id'];
        $resultado = $diputados->getDistribucion($id);
        $_partidos = $diputados->getPartidos();

        $partidos = array();
        foreach ($_partidos as $item) {
            $partidos[$item['id_partido']] = $item['nombre_partido'];
        }
        $suma = array();
        foreach ($resultado as $item) {
            if (isset($suma[$item['partido']]))
                $suma[$item['partido']] ++;
            else
                $suma[$item['partido']] = 1;
        }
        $grafico = array();
        if ($id > 0) {
            foreach ($resultado as $clave => $item) {
                if (!(isset($grafico[$item['partido']])))
                    $grafico[$item['partido']] = $item;
            }
        }




        return $app['twig']->render('reporting/res_dipnac_distribucion.html.twig', array('grafico' => $grafico, 'partidos' => $partidos, 'circuito' => $circuito, 'totales' => $resultado, 'suma' => $suma));
    }
    if ($tipo == 'avance') {
        $avance = $diputados->getAvance();
        return $app['twig']->render('reporting/res_dipnac_avance.html.twig', array('circuito' => $circuito, 'avance' => $avance));
    }
})->bind('rep_dipnac_seccion');

function suma($item) {
    $suma = 0;
    foreach ($item as $clave => $valor) {
        $suma += $valor['votos'];
    }
    return$suma;
}

function sumavalidos($item) {
    $suma = 0;
    foreach ($item as $clave => $valor) {
        if ($clave != "NULOS--")
            $suma += $valor['votos'];
    }
    return$suma;
}

function sumaafirmativos($item) {
    $suma = 0;
    foreach ($item as $clave => $valor) {
        if ($clave != "NULOS--" && $clave != "BLANCOS--")
            $suma += $valor['votos'];
    }
    return$suma;
}

function ordena($a, $b) {
    if ($a['porcentaje'] == $b['porcentaje']) {
        return 0;
    }
    return ($a['porcentaje'] > $b['porcentaje']) ? -1 : 1;
}
