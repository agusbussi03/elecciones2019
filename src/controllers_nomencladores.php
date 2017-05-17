<?php

/* * **************************************************************** */
/* * ************** PROVINCIA *********************************** */
/* * **************************************************************** */
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
    $app['db']->executeQuery($sql, array($_POST['nombre'], (int) $_POST['electores_nacion'], (int) $_POST['electores_provincia'], (int) $_POST['mesas']));
    $provincia = $app['db']->fetchAll('SELECT * FROM provincia');
    $mensaje = array('codigo' => 0, 'texto' => "La provincia fue cargada");
    return $app['twig']->render('nomencladores/provincia.html.twig', array('provincia' => $provincia, 'mensaje' => $mensaje));
})->bind('provincia_add');

$app->get('/provincia_delete/{id}', function ($id) use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $mensaje = array('codigo' => 0, 'texto' => "La provincia fue eliminada");
    try {
        $sql = "DELETE FROM provincia WHERE id=?";
        $app['db']->executeQuery($sql, array((int) $id));
    } catch (Exception $ex) {
        $mensaje = array('codigo' => 1, 'texto' => "La provincia tiene informacion cargada");
    }
    $provincia = $app['db']->fetchAll('SELECT * FROM provincia');
    return $app['twig']->render('nomencladores/provincia.html.twig', array('provincia' => $provincia, 'mensaje' => $mensaje));
})->bind('provincia_delete');

$app->get('/provincia_edit/{id}', function ($id) use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $provincia = $app['db']->fetchAssoc("SELECT * FROM provincia where id=$id");
    return $app['twig']->render('nomencladores/provincia_edit.html.twig', array('provincia' => $provincia));
})->bind('provincia_edit');

$app->post('/provincia_edit/{id}', function ($id) use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $mensaje = array('codigo' => 0, 'texto' => "La provincia fue modificada");
    try {
        $sql = "UPDATE provincia SET nombre=?,votantes_nacion=?,votantes_provincia=?,"
                . "mesas=? WHERE id=?";
        $app['db']->executeQuery($sql, array($_POST['nombre'], (int) $_POST['votantes_nacion'],
            (int) $_POST['votantes_provincia'], $_POST['mesas'], (int) $id));
    } catch (Exception $ex) {
        $mensaje = array('codigo' => 1, 'texto' => "Error de actualizacion");
    }
    $provincia = $app['db']->fetchAll('SELECT * FROM provincia');
    return $app['twig']->render('nomencladores/provincia.html.twig', array('provincia' => $provincia, 'mensaje' => $mensaje));
})->bind('provincia_editp');

/* * **************************************************************** */
/* * ************** SECCIONES *********************************** */
/* * **************************************************************** */

$app->get('/secciones/{provincia}', function ($provincia) use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $secciones = $app['db']->fetchAll("SELECT * FROM seccion where provincia_id=$provincia");
    return $app['twig']->render('nomencladores/seccion.html.twig', array('provincia' => $provincia, 'secciones' => $secciones));
})->bind('secciones');


$app->post('/seccion_add/{provincia}', function ($provincia) use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $sql = "INSERT INTO seccion VALUES (NULL,?,?,?,?,?,?)";
    $app['db']->executeQuery($sql, array($_POST['nombre'], (int) $_POST['electores_nacion'],
        (int) $_POST['electores_provincia'], (int) $_POST['mesa_desde'],
        (int) $_POST['mesa_hasta'], $provincia));
    $seccion = $app['db']->fetchAll("SELECT * FROM seccion where provincia_id=$provincia");
    $mensaje = array('codigo' => 0, 'texto' => "La seccion fue cargada");
    return $app['twig']->render('nomencladores/seccion.html.twig', array('provincia' => $provincia, 'secciones' => $seccion, 'mensaje' => $mensaje));
})->bind('seccion_add');

$app->get('/seccion_delete/{provincia}/{id}', function ($provincia, $id) use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $mensaje = array('codigo' => 0, 'texto' => "La seccion fue eliminada");
    try {
        $sql = "DELETE FROM seccion WHERE id=?";
        $app['db']->executeQuery($sql, array((int) $id));
    } catch (Exception $ex) {
        $mensaje = array('codigo' => 1, 'texto' => "La seccion tiene informacion cargada");
    }
    $seccion = $app['db']->fetchAll("SELECT * FROM seccion where provincia_id=$provincia");
    return $app['twig']->render('nomencladores/seccion.html.twig', array('provincia' => $provincia, 'secciones' => $seccion, 'mensaje' => $mensaje));
})->bind('seccion_delete');


$app->get('/seccion_edit/{id}', function ($id) use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $seccion = $app['db']->fetchAssoc("SELECT * FROM seccion where id=$id");
    return $app['twig']->render('nomencladores/seccion_edit.html.twig', array('seccion' => $seccion));
})->bind('seccion_edit');

$app->post('/seccion_edit/{id}', function ($id) use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $mensaje = array('codigo' => 0, 'texto' => "La seccion fue modificada");
    try {
        $sql = "UPDATE seccion SET nombre=?,electores_nacion=?,electores_provincia=?,"
                . "mesa_desde=?,mesa_hasta=? WHERE id=?";
        $app['db']->executeQuery($sql, array($_POST['nombre'], (int) $_POST['electores_nacion'],
            (int) $_POST['electores_provincia'], (int) $_POST['mesa_desde'],
            (int) $_POST['mesa_desde'], (int) $id));
        $seccion = $app['db']->fetchAssoc("SELECT provincia_id FROM seccion where id=$id");
        $provincia = $seccion['provincia_id'];
    } catch (Exception $ex) {
        $mensaje = array('codigo' => 1, 'texto' => "Error de actualizacion");
    }
    $seccion = $app['db']->fetchAll("SELECT * FROM seccion where provincia_id=$provincia");
    return $app['twig']->render('nomencladores/seccion.html.twig', array('provincia' => $provincia, 'secciones' => $seccion, 'mensaje' => $mensaje));
})->bind('seccion_editp');


/* * **************************************************************** */
/* * ******************** C I R C U I T O S********************** */
/* * **************************************************************** */
$app->get('/circuitos/{seccion}', function ($seccion) use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $circuitos = $app['db']->fetchAll("SELECT * FROM circuito where seccion_id=$seccion");
    return $app['twig']->render('nomencladores/circuitos.html.twig', array('seccion' => $seccion, 'circuitos' => $circuitos));
})->bind('circuitos');

$app->post('/circuito_add/{seccion}', function ($seccion) use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $sql = "INSERT INTO circuito VALUES (NULL,?,?,?,?,?,?,?)";
    $app['db']->executeQuery($sql, array($_POST['nombre'],
        (int) $_POST['electores_nacion'], (int) $_POST['electores_provincia'],
        (int) $_POST['intendente'],
        (int) $_POST['conc_titulares'], (int) $_POST['conc_suplentes'],
        $seccion));
    $circuitos = $app['db']->fetchAll("SELECT * FROM circuito where seccion_id=$seccion");
    $mensaje = array('codigo' => 0, 'texto' => "El circuito fue cargado");
    return $app['twig']->render('nomencladores/circuitos.html.twig', array('seccion' => $seccion, 'mensaje' => $mensaje, 'circuitos' => $circuitos));
})->bind('circuito_add');

$app->get('/circuito_delete/{seccion}/{id}', function ($seccion, $id) use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $mensaje = array('codigo' => 0, 'texto' => "El circuito fue eliminado");
    try {
        $sql = "DELETE FROM circuito WHERE id=?";
        $app['db']->executeQuery($sql, array((int) $id));
    } catch (Exception $ex) {
        $mensaje = array('codigo' => 1, 'texto' => "El circuito tiene informacion cargada");
    }
    $mensaje = array('codigo' => 0, 'texto' => "El circuito fue cargado");
    $circuitos = $app['db']->fetchAll("SELECT * FROM circuito where seccion_id=$seccion");

    return $app['twig']->render('nomencladores/circuitos.html.twig', array('seccion' => $seccion, 'mensaje' => $mensaje, 'circuitos' => $circuitos));
})->bind('circuito_delete');

$app->get('/circuito_edit/{id}', function ($id) use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $circuito = $app['db']->fetchAssoc("SELECT * FROM circuito where id=$id");
    return $app['twig']->render('nomencladores/circuito_edit.html.twig', array('circuito' => $circuito));
})->bind('circuito_edit');

$app->post('/circuito_edit/{id}', function ($id) use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $mensaje = array('codigo' => 0, 'texto' => "El circuito fue modificado");
    try {
        $sql = "UPDATE circuito SET nombre=?,electores_nacion=?,electores_provincia=?,"
                . "intendente=?,conc_titulares=?,conc_suplentes=? WHERE id=?";
        $app['db']->executeQuery($sql, array($_POST['nombre'], (int) $_POST['electores_nacion'],
            (int) $_POST['electores_provincia'], (int) $_POST['intendente'],
            (int) $_POST['conc_titulares'], (int) $_POST['conc_suplentes'], (int) $id));
        $circuito = $app['db']->fetchAssoc("SELECT seccion_id FROM circuito where id=$id");
        $seccion = $circuito['seccion_id'];
    } catch (Exception $ex) {
        $mensaje = array('codigo' => 1, 'texto' => "Error de actualizacion");
    }
    $circuito = $app['db']->fetchAll("SELECT * FROM circuito where seccion_id=$seccion");
    return $app['twig']->render('nomencladores/circuitos.html.twig', array('seccion' => $seccion, 'circuitos' => $circuito, 'mensaje' => $mensaje));
})->bind('seccion_editp');


/* * **************************************************************** */
/* * ******************** C  A  R  G  O  S********************** */
/* * **************************************************************** */
$app->get('/cargosgobernador/{provincia}', function ($provincia) use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $cargos = $app['db']->fetchAll("SELECT * FROM partido_lista,cargo_provincial 
             WHERE provincia_id=1 and tipo='G' and lista_id=partido_lista.id order by id_partido,id_lista");
    $partido_lista = $app['db']->fetchAll("SELECT * FROM partido_lista order by id_partido,id_lista");
    return $app['twig']->render('nomencladores/cargosgobernador.html.twig', array('provincia' => $provincia, 'partido_lista' => $partido_lista, 'cargos' => $cargos));
})->bind('cargosgobernador');

$app->get('/cargosgobernador_delete/{id}', function ($id) use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $cargo = $app['db']->fetchAssoc("SELECT provincia_id FROM cargo_provincial WHERE id=$id");
    $provincia = $cargo['provincia_id'];
    $sql = "DELETE from cargo_provincial WHERE id=?";
    $app['db']->executeQuery($sql, array((int) $id));
    $cargos = $app['db']->fetchAll("SELECT * FROM partido_lista,cargo_provincial 
             WHERE provincia_id=1 and tipo='G' and lista_id=partido_lista.id order by id_partido,id_lista");
    $partido_lista = $app['db']->fetchAll("SELECT * FROM partido_lista order by id_partido,id_lista");
    return $app['twig']->render('nomencladores/cargosgobernador.html.twig', array('partido_lista' => $partido_lista, 'cargos' => $cargos));
})->bind('cargosgobernador_delete');

$app->post('/cargosgobernador_add/{id}', function ($id) use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $provincia = $id;
    try{
         $sql = "INSERT into cargo_provincial values(NULL,?,?,'G')";
    $app['db']->executeQuery($sql, array((int) $_POST['id_lista'], (int) $id));
    } catch (Exception $ex) {
        return $app->redirect($app['url_generator']->generate('provincia'));

    }
    $cargos = $app['db']->fetchAll("SELECT * FROM partido_lista,cargo_provincial 
             WHERE provincia_id=$provincia and tipo='G' and lista_id=partido_lista.id order by id_partido,id_lista");
    $partido_lista = $app['db']->fetchAll("SELECT * FROM partido_lista order by id_partido,id_lista");
    return $app['twig']->render('nomencladores/cargosgobernador.html.twig', array('partido_lista' => $partido_lista, 'cargos' => $cargos));
})->bind('cargosgobernador_add');


$app->get('/cargosdiputado/{provincia}', function ($provincia) use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $cargos = $app['db']->fetchAll("SELECT * FROM partido_lista,cargo_provincial 
             WHERE provincia_id=1 and tipo='D' and lista_id=partido_lista.id order by id_partido,id_lista");
    $partido_lista = $app['db']->fetchAll("SELECT * FROM partido_lista order by id_partido,id_lista");
    return $app['twig']->render('nomencladores/cargosdiputado.html.twig', array('provincia' => $provincia, 'partido_lista' => $partido_lista, 'cargos' => $cargos));
})->bind('cargosdiputado');

$app->get('/cargosdiputado_delete/{id}', function ($id) use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $cargo = $app['db']->fetchAssoc("SELECT provincia_id FROM cargo_provincial WHERE id=$id");
    $provincia = $cargo['provincia_id'];
    $sql = "DELETE from cargo_provincial WHERE id=?";
    $app['db']->executeQuery($sql, array((int) $id));
    $cargos = $app['db']->fetchAll("SELECT * FROM partido_lista,cargo_provincial 
             WHERE provincia_id=1 and tipo='D' and lista_id=partido_lista.id order by id_partido,id_lista");
    $partido_lista = $app['db']->fetchAll("SELECT * FROM partido_lista order by id_partido,id_lista");
    return $app['twig']->render('nomencladores/cargosdiputado.html.twig', array('partido_lista' => $partido_lista, 'cargos' => $cargos));
})->bind('cargosdiputado_delete');

$app->post('/cargosdiputado_add/{id}', function ($id) use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $provincia = $id;
    try {
        $sql = "INSERT into cargo_provincial values(NULL,?,?,'D')";
        $app['db']->executeQuery($sql, array((int) $_POST['id_lista'], (int) $id));
        $cargos = $app['db']->fetchAll("SELECT * FROM partido_lista,cargo_provincial 
             WHERE provincia_id=$provincia and tipo='D' and lista_id=partido_lista.id order by id_partido,id_lista");
    } catch (Exception $ex) {
        return $app->redirect($app['url_generator']->generate('provincia'));
    }

    $partido_lista = $app['db']->fetchAll("SELECT * FROM partido_lista order by id_partido,id_lista");
    return $app['twig']->render('nomencladores/cargosdiputado.html.twig', array('partido_lista' => $partido_lista, 'cargos' => $cargos));
})->bind('cargosdiputado_add');
