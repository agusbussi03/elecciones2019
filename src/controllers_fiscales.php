<?php

$app->get('/fiscales_seccion', function () use ($app) {
    if (!validar('admin') && !validar('fiscal')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    if (isset($_GET['print'])) {        imprime($app,$_GET['seccion']);}
    $sql = "SELECT * from tbcarmes where tipo='S' and sec<>99";
    $resultado = $app['db']->fetchAll($sql);
    return $app['twig']->render('fiscales/fiscales_seccion.html.twig', array('secciones' => $resultado));
})->bind('fiscales_seccion');

$app->get('/fiscales_circuito/{id}', function ( $id) use ($app) {
    if (!validar('admin') && !validar('fiscal')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
      if (isset($_GET['print'])) {        imprime($app,0,$_GET['circu']);}
    $sql = "SELECT * from tbcarmes where tipo in ('C','M','T') and cirnro<>9999 and sec=$id";
    $resultado = $app['db']->fetchAll($sql);
    return $app['twig']->render('fiscales/fiscales_circuito.html.twig', array('circuitos' => $resultado));
})->bind('fiscales_circuito');

$app->get('/fiscales_locales/{id}', function ( $id) use ($app) {
    if (!validar('admin') && !validar('fiscal')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $sql = "SELECT * from tblocales where circu='$id'";
    $resultado=array();
    $_resultado = $app['db']->fetchAll($sql);
    foreach($_resultado as $item){
         $sql = "SELECT count(*) as cuenta from mesa where numero<=".$item['hasta']." and numero>=".$item['desde'];
         $cuenta= $app['db']->fetchAssoc($sql);
         $cuenta=$cuenta['cuenta'];
         if ($cuenta==0) $item['testigo']=0;
         else $item['testigo']=1;
         $resultado[]=$item;
    }
    return $app['twig']->render('fiscales/fiscales_locales.html.twig', array('locales' => $resultado));
})->bind('fiscales_locales');

$app->get('/fiscales_mesas/{id}', function ( $id) use ($app) {
    if (!validar('admin') && !validar('fiscal')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $sql = "SELECT * from tblocales where Id='$id'";
    $local = $app['db']->fetchAssoc($sql);
    
    $sql = "SELECT tbmesas.*,mesa.numero as testigo from tbmesas "
            . "left join mesa on tbmesas.mesa=mesa.numero "
            . "where mesa>=".$local['desde']." and mesa <=".$local['hasta'];
    $resultado = $app['db']->fetchAll($sql);
    return $app['twig']->render('fiscales/fiscales_mesas.html.twig', array('escuela'=>$local,'mesas' => $resultado));
})->bind('fiscales_mesas');

$app->post('/fiscales_cargamesa/{id}', function ( $id) use ($app) {
    if (!validar('admin') && !validar('fiscal')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $sql = "UPDATE tbmesas SET dni=?,nombre=?,telefono=?,"
            . "mail=? WHERE mesa=?";
    $app['db']->executeQuery($sql, array($_POST['dni'], $_POST['nombre'],
        $_POST['telefono'], $_POST['mail'], (int) $id));
     /*$sql = "SELECT * from tbmesas where mesa='$id'";
    $resultado = $app['db']->fetchAssoc($sql);*/
     $sql = "SELECT * from tblocales where desde<=".$id." and hasta>=".$id;
    $local = $app['db']->fetchAssoc($sql);
    return $app->redirect($app['url_generator']->generate('fiscales_mesas',array('id'=>$local['Id'])));

})->bind('fiscales_cargamesa');

$app->post('/fiscales_cargalocal/{id}', function ( $id) use ($app) {
    if (!validar('admin') && !validar('fiscal')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $sql = "UPDATE tblocales SET dni=?,nombre=?,telefono=?,"
            . "mail=? WHERE Id=?";
    $app['db']->executeQuery($sql, array($_POST['dni'], $_POST['nombre'],
        $_POST['telefono'], $_POST['mail'], (int) $id));
     $sql = "SELECT * from tblocales where Id='$id'";
    $resultado = $app['db']->fetchAssoc($sql);
    return $app->redirect($app['url_generator']->generate('fiscales_locales',array('id'=>$resultado['circu'])));
})->bind('fiscales_cargalocal');

$app->get('/padron', function () use ($app) {
        $sql = "SELECT * from padron2017.padron_definitivo2017 where matricula=".$_GET['dni'];
    $resultado = $app['db']->fetchAssoc($sql);
    if ($resultado) {echo $resultado['apellido']." ".$resultado['nombres'];die;}
    echo "";die;
})->bind('padron');


function imprime($app,$seccion=0,$circuito=0){
    
    require('mc_table.php');
    require_once('Configuracion.php');
    $configuracion = new Configuracion($app);
    $pdf = new PDF_MC_Table('P', 'mm', 'A4');
    $pdf->Open();
    $pdf->AliasNbPages();
    $pdf->AddPage('L', 'A4');
    $pdf->SetMargins(15, 2, 2, 5);
    $pdf->Ln();
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetWidths(array(200));
    $titulo = 'Reporte fiscales';
    $pdf->Row(array($titulo));
    $resultado=array();
    $where=" 1 ";
    if ($seccion>0) $where.="AND secc=$seccion ";
    if ($circuito>0) $where.="AND circu=$circuito ";
    $sql="SELECT desest,direst,locest,dni,nombre,mail,desde,hasta,telefono,t1.nomb as departamento "
            . "FROM tblocales l, tbcarmes t1,tbcarmes t2 where $where and l.secc=t1.sec and t1.tipo='S' "
            . "and trim(l.circu)=concat(t2.cirnro,t2.cirlet) order by secc,t2.cirnro,t2.cirlet";
    //echo $sql;die;
    $resultado = $app['db']->fetchAll($sql);
    $pdf->SetFont('Arial', '', 8);
    $columnas = array(30, 30, 60,60,15,50,20,20);
    $pdf->SetWidths($columnas);
    $titulos = array( "Departamento","Localidad","Escuela", "Direccion","dni","nombre","telefono","mail");
    foreach ($resultado as $i) {
        $pdf->Row_b(array(utf8_decode($i['departamento']),utf8_decode($i['locest']),utf8_decode($i['direst']),
                utf8_decode($i['desest']),utf8_decode($i['dni']),utf8_decode($i['nombre']),
                utf8_decode($i['telefono']),utf8_decode($i['mail'])));
        $sql="SELECT mesa,dni,nombre,telefono,mail,numero as testigo,responsable "
                . "FROM tbmesas t left join mesa m on t.mesa=m.numero "
                . "where t.mesa BETWEEN ".$i['desde']." and ".$i['hasta'];
        $mesas = $app['db']->fetchAll($sql);
        foreach ($mesas as $mesa){
            if ($mesa['testigo']>0) $testigo="TESTIGO"; else $testigo="";
            $pdf->Row(array("Mesa: ".$mesa['mesa'],$mesa['dni'],utf8_decode($mesa['nombre']),
                utf8_decode($mesa['mail']),utf8_decode($mesa['telefono']),utf8_decode($mesa['responsable']),
                $testigo,""));
        }
    }
   
    ob_clean();
    $pdf->Output('reporte.pdf', 'D');
    die;
    
    
}