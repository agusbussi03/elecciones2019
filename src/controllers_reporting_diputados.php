<?php

$app->get('/mesas_diputados/{provincia}', function ($provincia) use ($app) {
    if (!validar('admin') && !validar('lectura')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    require_once 'Diputados.php';
    require_once 'Configuracion.php';
    $diputados = new Diputados($provincia, $app);
    $configuracion = new Configuracion($app);
    $partidos = $diputados->getPartidos();
    //print_r($partidos);die;
    $mesas = $app['db']->fetchAll("SELECT * FROM mesa where diputados=1");
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
            $texto .= $votos['diputados'] . ";";
        }

        foreach (array(15, 16, 17) as $partido) {
            $votos = $app['db']->fetchAssoc("SELECT * FROM renglon "
                    . "where mesa_id=" . $mesa['id'] . " and lista_id=" . $partido);
            $texto .= $votos['diputados'] . ";";
        }
        header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
        header("Content-Disposition: attachment; filename=diputados.xls");  //File name extension was wrong
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private", false);
        $texto .= "\n\r";
    }
    echo $texto;
    die;
})->bind('mesas_diputados');


$app->get('/avance_diputados/{provincia}', function ($provincia) use ($app) {
    if (!validar('admin') && !validar('lectura')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $sql = "SELECT * FROM mesa where diputados=1 and "
            . "id not in (select mesa_id from renglon where diputados>0)";
    $mesas_nocargadas_D = $app['db']->fetchAll($sql);
    $sql = "SELECT * FROM mesa where diputados=1 and "
            . "id in (select mesa_id from renglon where diputados>0)";
    $mesas_cargadas_D = $app['db']->fetchAll($sql);
    $mesas = array('diputados' => array('cargadas' => $mesas_cargadas_D, 'nocargadas' => $mesas_nocargadas_D));
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
    foreach ($mesas['diputados']['nocargadas'] as $item) {
        $pdf->Row_b(array($item['numero'], utf8_decode($configuracion->getLocalmesa($item['numero'])), $item['responsable']));
    }
    $pdf->SetWidths(array(200));
    $pdf->Row(array(date('d/M/Y h:i:s A')));
    ob_clean();
    $pdf->Output('reporte.pdf', 'D');
    die;
})->bind('avance_diputados');



$app->get('/faltante_diputados/{provincia}', function ($provincia) use ($app) {
    if (!validar('admin') && !validar('lectura')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    require_once 'Diputados.php';
    $diputados = new Diputados($provincia, $app);
    $provincia = $app['db']->fetchAssoc("SELECT * FROM provincia where id=$provincia");
    $faltantes = $diputados->getFaltante();
    return $app['twig']->render('reporting/res_diputados_faltante.html.twig', array('faltantes' => $faltantes, 'provincia' => $provincia));
})->bind('faltante_diputados');


$app->get('/rep_diputados_seccional/{tipo}/{id}', function ($tipo, $id) use ($app) {
    if (!validar('admin') && !validar('lectura')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    if (isset($_GET['tiporeporte']))
        $_SESSION['tiporeporte'] = $_GET['tiporeporte'];
    else
        $_SESSION['tiporeporte'] = "EMITIDOS";
    $app['twig']->addGlobal('session', $_SESSION);
    require_once 'Diputados.php';
    $diputados = new Diputados($id, $app);
    $circuito = $app['db']->fetchAssoc("SELECT * FROM circuito where id=$id");

    if ($tipo == 'votos') {
        $resultado = $diputados->getResultados();
        return $app['twig']->render('reporting/res_diputados_votos.html.twig', array('votos' => $resultado['votos'], 'circuito' => $circuito, 'totales' => $resultado['totales'], 'seccionales' => $diputados->getSeccionales()));
    }
    if ($tipo == 'porcentajes') {
        $resultado = $diputados->getPorcentajes();
        //$resultado=ajustar($resultado);
        return $app['twig']->render('reporting/res_diputados_porcentaje.html.twig', array('votos' => $resultado['porcentajes'], 'circuito' => $circuito,
                    'totales' => $resultado['totales_porcentajes'], 'seccionales' => $diputados->getSeccionales()));
    }
    if ($tipo == 'porcentajes_ponderado') {
        $total_ponderado = $diputados->getPorcentajeponderado();
        $resultado = $diputados->getPorcentajes();
        return $app['twig']->render('reporting/res_diputados_porcentaje_ponderado.html.twig', array('votos' => $resultado['porcentajes'], 'circuito' => $circuito,
                    'totales' => $total_ponderado, 'seccionales' => $diputados->getSeccionales()));
    }
    if ($tipo == 'mapa') {
        $resultado = $diputados->getPorcentajes();
        $seccionales = $diputados->getSeccionales();
        $partidos = $diputados->getPartidos();
       foreach ($departamentos as $departamento) {
            //$totales[$departamento['nombre']]['electores']=$departamento['electores'];
            foreach ($resultado['porcentajes'][$departamento['id']] as $clave => $item) {
                if (!(in_array($clave, array("EMITIDOS", "BLANCOS--", "NULOS--","OTROS--")))) {
                    $partido = strtok($clave, "-");
                    if (isset($totales[$departamento['nombre']][$partido]))
                        $totales[$departamento['nombre']][$partido] += $item['porcentaje'];
                    else
                        $totales[$departamento['nombre']][$partido] = $item['porcentaje'];
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
        return $app['twig']->render('reporting/res_concejales_mapas.html.twig', array('circuito' => $circuito, 'totales' => $totales, 'partidos' => $partidos2,
                    'colores_seccional' => $colores_seccional));
    }
    if ($tipo == 'graficos') {
        $resultado = $diputados->getPorcentajeponderado();
        $partidos = $diputados->getPartidos();
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
        return $app['twig']->render('reporting/res_diputados_grafico.html.twig', array('totales' => $resultado_limpio, 'totales_partido' => $resultado_partido, 'circuito' => $circuito, 'partidos' => $partidos));
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
        $resultado_grafico = $diputados->getDistribucionCompleta($id);
        if ($id > 0) {
            foreach ($resultado_grafico as $clave => $item) {
                if (!(isset($grafico[$item['partido']])))
                    $grafico[$item['partido']] = $item;
            }
        }
        //print_r($grafico);
        return $app['twig']->render('reporting/res_diputados_distribucion.html.twig', array('grafico' => $grafico, 'partidos' => $partidos, 'circuito' => $circuito, 'totales' => $resultado, 'suma' => $suma));
    }
    if ($tipo == 'votos_grafico') {
        $resultado = $diputados->getResultados();
        $datos = array();
        $seccionales = array();
        $temp = $diputados->getSeccionales();
        foreach ($resultado['votos'] as $clave => $item) {
            $seccionales[] = $temp[$clave]['nombre'];
            foreach ($item as $clave2 => $item2) {
                $datos[$clave2][] = $item2['votos'];
            }
        }
        return $app['twig']->render('reporting/res_diputados_votos_grafico.html.twig', array('circuito' => $circuito, 'seccionales' => $seccionales, 'datos' => $datos));
    }
    if ($tipo == 'avance') {
        $avance = $concejales->getAvance();
        return $app['twig']->render('reporting/res_diputados_avance.html.twig', array('circuito' => $circuito, 'avance' => $avance));
    }
})->bind('rep_diputados_seccional');


$app->get('/rep_diputados_seccion/{tipo}/{id}', function ($tipo, $id) use ($app) {
    if (!validar('admin') && !validar('lectura')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    if (isset($_GET['tiporeporte']))
        $_SESSION['tiporeporte'] = $_GET['tiporeporte'];
    else
        $_SESSION['tiporeporte'] = "EMITIDOS";
    $app['twig']->addGlobal('session', $_SESSION);
    require_once 'Diputados.php';
    $diputados = new Diputados($id, $app);
    //print_r($concejales->getSeccionales());
    $provincia = $app['db']->fetchAssoc("SELECT * FROM provincia where id=$id");

    if ($tipo == 'votos') {
        $resultado = $diputados->getResultados();
        return $app['twig']->render('reporting/res_diputados_votos.html.twig', array('votos' => $resultado['votos'], 'provincia' => $provincia, 'totales' => $resultado['totales'], 'departamentos' => $diputados->getDepartamentos()));
    }
    if ($tipo == 'porcentajes') {
        $resultado = $diputados->getPorcentajes();

        return $app['twig']->render('reporting/res_diputados_porcentaje.html.twig', array('votos' => $resultado['porcentajes'], 'provincia' => $provincia,
                    'totales' => $resultado['totales_porcentajes'], 'seccionales' => $diputados->getDepartamentos()));
    }
    if ($tipo == 'porcentajes_ponderado') {
        $total_ponderado = $diputados->getPorcentajeponderado();
        $resultado = $diputados->getPorcentajes();
        return $app['twig']->render('reporting/res_diputados_porcentaje_ponderado.html.twig', array('votos' => $resultado['porcentajes'], 'provincia' => $provincia,
                    'totales' => $total_ponderado, 'seccionales' => $diputados->getDepartamentos()));
    }
    if ($tipo == 'mapa') {
        $resultado = $diputados->getPorcentajes();
        $departamentos = $diputados->getDepartamentos();
        $partidos = $diputados->getPartidos();
        foreach ($departamentos as $departamento) {
            //$totales[$departamento['nombre']]['electores']=$departamento['electores'];
            foreach ($resultado['porcentajes'][$departamento['id']] as $clave => $item) {
                if (!(in_array($clave, array("EMITIDOS", "BLANCOS--", "NULOS--","OTROS--")))) {
                    $partido = strtok($clave, "-");
                    if (isset($totales[$departamento['nombre']][$partido]))
                        $totales[$departamento['nombre']][$partido] += $item['porcentaje'];
                    else
                        $totales[$departamento['nombre']][$partido] = $item['porcentaje'];
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

        $colores_departamento = array();
        foreach ($totales as $clave => $item) {
            $colores_departamento[$clave] = $configuracion->getColorpartidopornombre(array_keys($item)[0]);
        }
        return $app['twig']->render('reporting/res_diputados_mapas.html.twig', array('totales' => $totales, 'partidos' => $partidos2, 'colores_departamento' => $colores_departamento));
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


        return $app['twig']->render('reporting/res_diputados_grafico.html.twig', array('totales' => $resultado_limpio, 'totales_partido' => $resultado_partido, 'provincia' => $provincia, 'partidos' => $partidos));
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
        $i=0;
        foreach ($resultado as $item) {
            if (isset($suma[$item['partido']]))
                $suma[$item['partido']] ++;
            else
                $suma[$item['partido']] = 1;
            if (++$i == $provincia['dip_titular']) break;
        }
        $grafico = array();
        if ($id > 0) {
            foreach ($resultado as $clave => $item) {
                if (!(isset($grafico[$item['partido']])))
                    $grafico[$item['partido']] = $item;
            }
        }
        return $app['twig']->render('reporting/res_diputados_distribucion.html.twig', array('grafico' => $grafico, 'partidos' => $partidos, 'provincia' => $provincia, 'totales' => $resultado, 'suma' => $suma));
    }
    if ($tipo == 'avance') {
        $avance = $diputados->getAvance();
        return $app['twig']->render('reporting/res_diputados_avance.html.twig', array('provincia' => $provincia, 'avance' => $avance));
    }
})->bind('rep_diputados_seccion');
