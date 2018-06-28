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

$app->get('/rep_provincia', function () use ($app) {
    if (!validar('admin') && !validar('lectura')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $sql = "SELECT distinct p.* from circuito c,seccion s,provincia p, mesa m where c.id=m.circuito_id and m.gobernador+m.diputado>=1 and c.seccion_id=s.id and s.provincia_id=p.id";
    $resultado = $app['db']->fetchAll($sql);
    foreach ($resultado as $item) {
        $sql = "SELECT m.* FROM mesa m, circuito c,seccion s "
                . "where s.provincia_id=" . $item['id'] . " and c.seccion_id=s.id and m.circuito_id=c.id "
                . "and gobernador=1 and m.id not in (select mesa_id from renglon where gobernador>0)";
        $mesas_nocargadas_G = $app['db']->fetchAll($sql);
        $sql = "SELECT m.* FROM mesa m, circuito c,seccion s "
                . "where s.provincia_id=" . $item['id'] . " and c.seccion_id=s.id and m.circuito_id=c.id "
                . "and gobernador=1 and m.id in (select mesa_id from renglon where gobernador>0)";
        $mesas_cargadas_G = $app['db']->fetchAll($sql);
        $sql = "SELECT m.* FROM mesa m, circuito c,seccion s "
                . "where s.provincia_id=" . $item['id'] . " and c.seccion_id=s.id and m.circuito_id=c.id "
                . "and diputado=1 and m.id not in (select mesa_id from renglon where diputado>0)";
        $mesas_nocargadas_D = $app['db']->fetchAll($sql);
        $sql = "SELECT m.* FROM mesa m, circuito c,seccion s "
                . "where s.provincia_id=" . $item['id'] . " and c.seccion_id=s.id and m.circuito_id=c.id "
                . "and diputado=1 and m.id in (select mesa_id from renglon where diputado>0)";
        $mesas_cargadas_D = $app['db']->fetchAll($sql);

        $provincias[] = array('datos' => $item,
            'gobernador' => array('cargadas' => $mesas_cargadas_G, 'nocargadas' => $mesas_nocargadas_G),
            'diputados' => array('cargadas' => $mesas_cargadas_D, 'nocargadas' => $mesas_nocargadas_D,));
    }
    return $app['twig']->render('rep_provincia.html.twig', array('provincias' => $provincias));
})->bind('rep_provincia');




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

$app->get('/mesas_dipnac/{provincia}', function ($provincia) use ($app) {
    if (!validar('admin') && !validar('lectura')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    require_once 'DiputadosNacionales.php';
    require_once 'Configuracion.php';
    $diputados = new DiputadosNacionales($provincia, $app);
    $configuracion = new Configuracion($app);
    $partidos = $diputados->getPartidos();
    //print_r($partidos);die;
    $mesas = $app['db']->fetchAll("SELECT * FROM mesa where diputado_nacional=1");
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
            $votos = $app['db']->fetchAssoc("SELECT * FROM renglon_nacional "
                    . "where mesa_id=" . $mesa['id'] . " and lista_nacional_id=" . $partido['id']);
            $texto .= $votos['diputado'] . ";";
        }

        foreach (array(15, 16, 17) as $partido) {
            $votos = $app['db']->fetchAssoc("SELECT * FROM renglon_nacional "
                    . "where mesa_id=" . $mesa['id'] . " and lista_nacional_id=" . $partido);
            $texto .= $votos['diputado'] . ";";
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
})->bind('mesas_dipnac');


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

$app->get('/logo_partido/{id}', function ($id) use ($app) {
    $logo = $app['db']->fetchAssoc("SELECT logo FROM partido_lista where id=$id");
    header('Content-Type: image/jpeg');
     header("Cache-Control: max-age=3600");
     header("Pragma: cache");
    echo $logo['logo'];
    die;
})->bind('logo_partido');
$app->get('/logo_partido_nacional/{id}', function ($id) use ($app) {
    $logo = $app['db']->fetchAssoc("SELECT logo FROM partido_lista_nacional where id=$id");
    header('Content-Type: image/jpeg');
    header("Cache-Control: max-age=3600");
    header("Pragma: cache");

    echo $logo['logo'];
    die;
})->bind('logo_partido_nacional');


$app->get('/logo_candidato/{nombre}', function ($nombre) use ($app) {
    $candidato = $app['db']->fetchAssoc("SELECT * FROM cargo_local c left join candidato can on c.candidato_id=can.id ,"
            . "partido_lista l where tipo='C' and c.lista_id=l.id and concat(l.nombre_partido,'-',l.id_lista,'-',l.nombre_lista)='$nombre' ");
    header('Content-Type: image/jpeg');
    header("Cache-Control: max-age=3600");
    header("Pragma: cache");
    if ($candidato['apellido'] == "")
        echo file_get_contents("imagenes/default.jpg");
    echo $candidato['foto'];
    die;
})->bind('logo_candidato');

$app->get('/logo_candidato_intendente/{nombre}', function ($nombre) use ($app) {
    $candidato = $app['db']->fetchAssoc("SELECT * FROM cargo_local c left join candidato can on c.candidato_id=can.id ,"
            . "partido_lista l where tipo='I' and c.lista_id=l.id and concat(l.nombre_partido,'-',l.id_lista,'-',l.nombre_lista)='$nombre' ");
    header('Content-Type: image/jpeg');
    header("Cache-Control: max-age=3600");
    header("Pragma: cache");
    if ($candidato['apellido'] == "")
        echo file_get_contents("imagenes/default.jpg");
    echo $candidato['foto'];
    die;
})->bind('logo_candidato_intendente');

$app->get('/logo_candidato_gobernador/{nombre}', function ($nombre) use ($app) {
    $candidato = $app['db']->fetchAssoc("SELECT * FROM cargo_provincial c left join candidato can on c.candidato_id=can.id ,"
            . "partido_lista l where tipo='G' and c.lista_id=l.id and concat(l.nombre_partido,'-',l.id_lista,'-',l.nombre_lista)='$nombre' ");
    header('Content-Type: image/jpeg');
    header("Cache-Control: max-age=3600");
    header("Pragma: cache");
    if ($candidato['apellido'] == "")
        echo file_get_contents("imagenes/default.jpg");
    echo $candidato['foto'];
    die;
})->bind('logo_candidato_gobernador');

$app->get('/logo_candidato_diputado/{nombre}', function ($nombre) use ($app) {
    $candidato = $app['db']->fetchAssoc("SELECT * FROM cargo_provincial c left join candidato can on c.candidato_id=can.id ,"
            . "partido_lista l where tipo='D' and c.lista_id=l.id and concat(l.nombre_partido,'-',l.id_lista,'-',l.nombre_lista)='$nombre' ");
    header('Content-Type: image/jpeg');
    header("Cache-Control: max-age=3600");
    header("Pragma: cache");
    if ($candidato['apellido'] == "")
        echo file_get_contents("imagenes/default.jpg");
    echo $candidato['foto'];
    die;
})->bind('logo_candidato_diputado');

$app->get('/logo_candidato_nacional/{nombre}', function ($nombre) use ($app) {
    $candidato = $app['db']->fetchAssoc("SELECT * FROM cargo_nacional c left join candidato can "
            . "on c.candidato_id=can.id ,partido_lista_nacional l where tipo='D' "
            . "and c.lista_nacional_id=l.id "
            . "and concat(l.nombre_partido,'-',l.id_lista,'-',l.nombre_lista)='$nombre'");
    header('Content-Type: image/jpeg');
    header("Cache-Control: max-age=3600");
    header("Pragma: cache");

    if ($candidato['apellido'] == "")
        echo file_get_contents("imagenes/default.jpg");
    echo $candidato['foto'];
    die;
})->bind('logo_candidato_nacional');


$app->get('/provisorio', function () use ($app) {
    $ganadores=array();
    $array_votos=array();
    $circuitos = $app['db']->fetchAll("SELECT distinct circuito,letra FROM resultados where concejal>0");
    foreach ($circuitos as $circuito){
        $ganador = $app['db']->fetchAssoc("SELECT nropartido,concejal FROM resultados_agrupados ".
                "where concejal>0 and circuito=".$circuito['circuito']." and letra='".$circuito['letra']."'"
                . "  order by concejal desc");
        $color="";
        if($ganador['nropartido']==26) $color="red";
        if($ganador['nropartido']==27) $color="yellow";
        if($ganador['nropartido']==32) $color="blue";
        $ganadores[str_pad($circuito['circuito'],3,0,STR_PAD_LEFT).$circuito['letra']]=array('partido'=>$ganador['nropartido'],
            'color'=>$color);
        $votos = $app['db']->fetchAll("SELECT nombrepartido,concejal FROM resultados_agrupados ".
                "where concejal>0 and circuito=".$circuito['circuito']." and letra='".$circuito['letra']."'"
                . "  order by concejal desc");
        foreach ($votos as $voto){
             $array_votos[str_pad($circuito['circuito'],3,0,STR_PAD_LEFT).$circuito['letra']][]=array('partido'=>$voto['nombrepartido'],
            'votos'=>$voto['concejal']);
        }
        
    }
    
     $circuitos = $app['db']->fetchAll("SELECT distinct circuito,letra FROM resultados where comunal>0");
    foreach ($circuitos as $circuito){
        $ganador = $app['db']->fetchAssoc("SELECT nropartido,comunal FROM resultados_agrupados ".
                "where comunal>0 and circuito=".$circuito['circuito']." and letra='".$circuito['letra']."'"
                . " order by comunal desc");
        $color="";
        if($ganador['nropartido']==26) $color="red";
        if($ganador['nropartido']==27) $color="yellow";
        if($ganador['nropartido']==32) $color="blue";
        if($ganador['nropartido']==4) $color="green";
        $ganadores[str_pad($circuito['circuito'],3,0,STR_PAD_LEFT).$circuito['letra']]=array('partido'=>$ganador['nropartido'],
            'color'=>$color);
        $votos = $app['db']->fetchAll("SELECT nombrepartido,comunal FROM resultados_agrupados ".
                "where comunal>0 and circuito=".$circuito['circuito']." and letra='".$circuito['letra']."'"
                . "  order by comunal desc");
        foreach ($votos as $voto){
             $array_votos[str_pad($circuito['circuito'],3,0,STR_PAD_LEFT).$circuito['letra']][]=array('partido'=>$voto['nombrepartido'],
            'votos'=>$voto['comunal']);
        }
    }
    //print_r($ganadores);die;
    
    $partidos=array(
        array("nombre_partido"=>"Frente Justicialista","color"=> "blue"),
        array("nombre_partido"=>"FPCS","color"=> "red"),
        array("nombre_partido"=>"Cambiemos","color"=> "yellow",
            array("nombre_partido"=>"Frente para el Cambio","color"=> "green")),
        
    );
   return $app['twig']->render('provisorios_mapas.html.twig', 
           array('ganadores' => $ganadores,'votos' => $array_votos, 'partidos' => $partidos));
})->bind('provisorio');
