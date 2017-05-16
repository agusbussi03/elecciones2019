<?php


/* * ************** NOMENCLADORES *********************************** */
$app->get('/circuitos/{seccion}', function ($seccion) use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $circuitos = $app['db']->fetchAll("SELECT * FROM circuito where seccion_id=$seccion");
    return $app['twig']->render('nomencladores/circuitos.html.twig', array('circuitos' => $circuitos));
})->bind('circuitos');

$app->get('/secciones/{provincia}', function ($provincia) use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $secciones = $app['db']->fetchAll("SELECT * FROM seccion where provincia_id=$provincia");
    return $app['twig']->render('nomencladores/secciones.html.twig', array('secciones' => $secciones));
})->bind('secciones');

$app->get('/provincia', function () use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $provincia = $app['db']->fetchAll('SELECT * FROM provincia');
    return $app['twig']->render('nomencladores/provincia.html.twig', array('provincia' => $provincia));
})->bind('provincia');

$app->post('/provincia_add', function () use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $sql = "INSERT INTO provincia VALUES (NULL,?,?,?,?)";
            $app['db']->executeQuery($sql, 
                    array( $_POST['nombre'], (int) $_POST['electores_nacion'], (int) $_POST['electores_provincia'], (int) $_POST['mesas']));
    $provincia = $app['db']->fetchAll('SELECT * FROM provincia');
    $mensaje=array('codigo'=>0,'texto'=>"La provincia fue cargada");
    return $app['twig']->render('nomencladores/provincia.html.twig', array('provincia' => $provincia,'mensaje'=>$mensaje));
})->bind('provincia_add');

$app->get('/provincia_delete/{id}', function ($id) use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $mensaje=array('codigo'=>0,'texto'=>"La provincia fue eliminada");
    try{
    $sql = "DELETE FROM provincia WHERE id=?";
            $app['db']->executeQuery($sql, 
                    array( (int) $id));
    } catch (Exception $ex){
        $mensaje=array('codigo'=>1,'texto'=>"La provincia tiene informacion cargada");
    }
    $provincia = $app['db']->fetchAll('SELECT * FROM provincia');
    return $app['twig']->render('nomencladores/provincia.html.twig', array('provincia' => $provincia,'mensaje'=>$mensaje));
})->bind('provincia_delete');


$app->get('/filtrosgobernador', function () use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    require 'Filtros.php';
    $mensaje = "";
    $filtros = new Filtros('G', 0, 0, '', $app);
    $resultado = $filtros->getFiltros();
    return $app['twig']->render('filtrosgobernador.html.twig', array('disponibles' => $resultado['disponibles'], 'filtros' => $resultado['filtros'], 'mensaje' => $mensaje));
})->bind('filtrosgobernador');

$app->post('/filtrosgobernador', function () use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    require 'Filtros.php';
    $filtros = new Filtros('G', 0, 0, '', $app);
    $mensaje = $filtros->procesar($_POST);
    $resultado = $filtros->getFiltros();
    return $app['twig']->render('filtrosgobernador.html.twig', array('disponibles' => $resultado['disponibles'], 'filtros' => $resultado['filtros'], 'mensaje' => $mensaje));
});

$app->get('/filtrossenador/{sec}', function ($sec) use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    require 'Filtros.php';
    $mensaje = "";
    $filtros = new Filtros('S', $sec, 0, '', $app);
    $resultado = $filtros->getFiltros();
    return $app['twig']->render('filtrossenador.html.twig', array('disponibles' => $resultado['disponibles'], 'filtros' => $resultado['filtros'], 'mensaje' => $mensaje));
})->bind('filtrossenador');

$app->post('/filtro/{accion}', function ($accion) use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    require 'Filtros.php';
    Filtros::$accion($_POST['datos'], $app);
    return json_encode("OK");
})->bind('filtro');
