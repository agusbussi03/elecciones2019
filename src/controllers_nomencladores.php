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
    $partido_lista = $app['db']->fetchAll("SELECT * FROM partido_lista where especial=0 order by id_partido,id_lista");
    $provincia = $app['db']->fetchAssoc("SELECT * FROM provincia where id=$provincia");
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
    $partido_lista = $app['db']->fetchAll("SELECT * FROM partido_lista  where especial=0 order by id_partido,id_lista");
    $provincia = $app['db']->fetchAssoc("SELECT * FROM provincia where id=$provincia");
    return $app['twig']->render('nomencladores/cargosgobernador.html.twig', array('provincia' => $provincia, 'partido_lista' => $partido_lista, 'cargos' => $cargos));
})->bind('cargosgobernador_delete');

$app->post('/cargosgobernador_add/{id}', function ($id) use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $provincia = $id;
   try {
        $sql = "INSERT into cargo_provincial values(NULL,?,?,'G',NULL)";
        $app['db']->executeQuery($sql, array((int) $_POST['id_lista'], (int) $id));
   } catch (Exception $ex) {
        echo $ex->getMessage();
        return $app->redirect($app['url_generator']->generate('provincia'));
    }
    $cargos = $app['db']->fetchAll("SELECT * FROM partido_lista,cargo_provincial 
             WHERE provincia_id=$provincia and tipo='G' and lista_id=partido_lista.id order by id_partido,id_lista");
    $partido_lista = $app['db']->fetchAll("SELECT * FROM partido_lista  where especial=0 order by id_partido,id_lista");
    $provincia = $app['db']->fetchAssoc("SELECT * FROM provincia where id=$provincia");
    return $app['twig']->render('nomencladores/cargosgobernador.html.twig', array('provincia' => $provincia, 'partido_lista' => $partido_lista, 'cargos' => $cargos));
})->bind('cargosgobernador_add');


$app->get('/cargosdiputado/{provincia}', function ($provincia) use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $cargos = $app['db']->fetchAll("SELECT * FROM partido_lista,cargo_provincial 
             WHERE provincia_id=$provincia and tipo='D' and lista_id=partido_lista.id order by id_partido,id_lista");
    $partido_lista = $app['db']->fetchAll("SELECT * FROM partido_lista  where especial=0 order by id_partido,id_lista");
    $provincia = $app['db']->fetchAssoc("SELECT * FROM provincia where id=$provincia");
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
             WHERE provincia_id=$provincia and tipo='D' and lista_id=partido_lista.id order by id_partido,id_lista");
    $partido_lista = $app['db']->fetchAll("SELECT * FROM partido_lista where especial=0 order by id_partido,id_lista");
    $provincia = $app['db']->fetchAssoc("SELECT * FROM provincia where id=$provincia");
    return $app['twig']->render('nomencladores/cargosdiputado.html.twig', array('provincia' => $provincia, 'partido_lista' => $partido_lista, 'cargos' => $cargos));
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
    $provincia = $app['db']->fetchAssoc("SELECT * FROM provincia where id=$provincia");
    $partido_lista = $app['db']->fetchAll("SELECT * FROM partido_lista where especial=0 order by id_partido,id_lista");
    return $app['twig']->render('nomencladores/cargosdiputado.html.twig', array('provincia' => $provincia, 'partido_lista' => $partido_lista, 'cargos' => $cargos));
})->bind('cargosdiputado_add');


$app->get('/cargossenador/{seccion}', function ($seccion) use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $cargos = $app['db']->fetchAll("SELECT * FROM partido_lista,cargo_departamental 
             WHERE seccion_id=$seccion and tipo='S' and lista_id=partido_lista.id order by id_partido,id_lista");
    $partido_lista = $app['db']->fetchAll("SELECT * FROM partido_lista  where especial=0 order by id_partido,id_lista");
    $seccion = $app['db']->fetchAssoc("SELECT * FROM seccion where id=$seccion");
    return $app['twig']->render('nomencladores/cargossenador.html.twig', array('seccion' => $seccion, 'partido_lista' => $partido_lista, 'cargos' => $cargos));
})->bind('cargossenador');

$app->get('/cargossenador_delete/{id}', function ($id) use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $cargo = $app['db']->fetchAssoc("SELECT seccion_id FROM cargo_departamental WHERE id=$id");
    $seccion = $cargo['seccion_id'];
    $sql = "DELETE from cargo_departamental WHERE id=?";
    $app['db']->executeQuery($sql, array((int) $id));
    $cargos = $app['db']->fetchAll("SELECT * FROM partido_lista,cargo_departamental 
             WHERE seccion_id=$seccion and tipo='S' and lista_id=partido_lista.id order by id_partido,id_lista");
    $partido_lista = $app['db']->fetchAll("SELECT * FROM partido_lista where especial=0 order by id_partido,id_lista");
    $seccion = $app['db']->fetchAssoc("SELECT * FROM seccion where id=$seccion");
    return $app['twig']->render('nomencladores/cargossenador.html.twig', array('seccion' => $seccion, 'partido_lista' => $partido_lista, 'cargos' => $cargos));
})->bind('cargossenador_delete');

$app->post('/cargossenador_add/{id}', function ($id) use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $seccion = $id;
    try {
        $sql = "INSERT into cargo_departamental values(NULL,'S',?,?,null)";
        $app['db']->executeQuery($sql, array((int) $id,(int) $_POST['id_lista']));
        $cargos = $app['db']->fetchAll("SELECT * FROM partido_lista,cargo_departamental
             WHERE seccion_id=$seccion and tipo='S' and lista_id=partido_lista.id order by id_partido,id_lista");
    } catch (Exception $ex) {
        print_r($ex);die;
        return $app->redirect($app['url_generator']->generate('provincia'));
    }
    $seccion = $app['db']->fetchAssoc("SELECT * FROM seccion where id=$seccion");
    $partido_lista = $app['db']->fetchAll("SELECT * FROM partido_lista  where especial=0 order by id_partido,id_lista");
    return $app['twig']->render('nomencladores/cargossenador.html.twig', array('seccion' => $seccion, 'partido_lista' => $partido_lista, 'cargos' => $cargos));
})->bind('cargossenador_add');


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
    $provincia = $app['db']->fetchAssoc("SELECT * FROM provincia where id=$provincia");
    $partido_lista = $app['db']->fetchAll("SELECT * FROM partido_lista where especial=0 order by id_partido,id_lista");
    return $app['twig']->render('nomencladores/cargosdiputado.html.twig', array('provincia' => $provincia, 'partido_lista' => $partido_lista, 'cargos' => $cargos));
})->bind('cargosdiputado_add');


$app->get('/cargossenador/{seccion}', function ($seccion) use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $cargos = $app['db']->fetchAll("SELECT * FROM partido_lista,cargo_departamental 
             WHERE seccion_id=$seccion and tipo='S' and lista_id=partido_lista.id order by id_partido,id_lista");
    $partido_lista = $app['db']->fetchAll("SELECT * FROM partido_lista where especial=0 order by id_partido,id_lista");
    $seccion = $app['db']->fetchAssoc("SELECT * FROM seccion where id=$seccion");
    return $app['twig']->render('nomencladores/cargossenador.html.twig', array('seccion' => $seccion, 'partido_lista' => $partido_lista, 'cargos' => $cargos));
})->bind('cargossenador');

$app->get('/cargossenador_delete/{id}', function ($id) use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $cargo = $app['db']->fetchAssoc("SELECT seccion_id FROM cargo_departamental WHERE id=$id");
    $seccion = $cargo['seccion_id'];
    $sql = "DELETE from cargo_departamental WHERE id=?";
    $app['db']->executeQuery($sql, array((int) $id));
    $cargos = $app['db']->fetchAll("SELECT * FROM partido_lista,cargo_departamental 
             WHERE seccion_id=$seccion and tipo='S' and lista_id=partido_lista.id order by id_partido,id_lista");
    $partido_lista = $app['db']->fetchAll("SELECT * FROM partido_lista where especial=0 order by id_partido,id_lista");
    $seccion = $app['db']->fetchAssoc("SELECT * FROM seccion where id=$seccion");
    return $app['twig']->render('nomencladores/cargossenador.html.twig', array('seccion' => $seccion, 'partido_lista' => $partido_lista, 'cargos' => $cargos));
})->bind('cargossenador_delete');

$app->post('/cargossenador_add/{id}', function ($id) use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $seccion = $id;
    try {
        $sql = "INSERT into cargo_departamental values(NULL,'S',?,?,null)";
        $app['db']->executeQuery($sql, array((int) $id,(int) $_POST['id_lista']));
        $cargos = $app['db']->fetchAll("SELECT * FROM partido_lista,cargo_departamental
             WHERE seccion_id=$seccion and tipo='S' and lista_id=partido_lista.id order by id_partido,id_lista");
    } catch (Exception $ex) {
        return $app->redirect($app['url_generator']->generate('provincia'));
    }
    $seccion = $app['db']->fetchAssoc("SELECT * FROM seccion where id=$seccion");
    $partido_lista = $app['db']->fetchAll("SELECT * FROM partido_lista where especial=0 order by id_partido,id_lista");
    return $app['twig']->render('nomencladores/cargossenador.html.twig', array('seccion' => $seccion, 'partido_lista' => $partido_lista, 'cargos' => $cargos));
})->bind('cargossenador_add');



$app->get('/cargosintendente/{circuito}', function ($circuito) use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $cargos = $app['db']->fetchAll("SELECT * FROM partido_lista,cargo_local
             WHERE circuito_id=$circuito and tipo='I' and lista_id=partido_lista.id order by id_partido,id_lista");
    $partido_lista = $app['db']->fetchAll("SELECT * FROM partido_lista where especial=0 order by id_partido,id_lista");
    $circuito = $app['db']->fetchAssoc("SELECT * FROM circuito where id=$circuito");
    return $app['twig']->render('nomencladores/cargosintendente.html.twig', array('circuito' => $circuito, 'partido_lista' => $partido_lista, 'cargos' => $cargos));
})->bind('cargosintendente');

$app->get('/cargosintendente_delete/{id}', function ($id) use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $cargo = $app['db']->fetchAssoc("SELECT circuito_id FROM cargo_local WHERE id=$id");
    $circuito = $cargo['circuito_id'];
    $sql = "DELETE from cargo_local WHERE id=?";
    $app['db']->executeQuery($sql, array((int) $id));
    $cargos = $app['db']->fetchAll("SELECT * FROM partido_lista,cargo_local 
             WHERE circuito_id=$circuito and tipo='I' and lista_id=partido_lista.id order by id_partido,id_lista");
    $partido_lista = $app['db']->fetchAll("SELECT * FROM partido_lista where especial=0 order by id_partido,id_lista");
    $circuito = $app['db']->fetchAssoc("SELECT * FROM circuito where id=$circuito");
    return $app['twig']->render('nomencladores/cargosintendente.html.twig', array('circuito' => $circuito, 'partido_lista' => $partido_lista, 'cargos' => $cargos));
})->bind('cargosintendente_delete');

$app->post('/cargosintendente_add/{id}', function ($id) use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $circuito = $id;
    try {
        $sql = "INSERT into cargo_local values(NULL,'I',?,?,null)";
        $app['db']->executeQuery($sql, array((int) $_POST['id_lista'],(int) $id));
        $cargos = $app['db']->fetchAll("SELECT * FROM partido_lista,cargo_local
             WHERE circuito_id=$circuito and tipo='I' and lista_id=partido_lista.id order by id_partido,id_lista");
    } catch (Exception $ex) {
        return $app->redirect($app['url_generator']->generate('provincia'));
    }
    $circuito = $app['db']->fetchAssoc("SELECT * FROM circuito where id=$circuito");
    $partido_lista = $app['db']->fetchAll("SELECT * FROM partido_lista where especial=0 order by id_partido,id_lista");
    return $app['twig']->render('nomencladores/cargosintendente.html.twig', array('circuito' => $circuito, 'partido_lista' => $partido_lista, 'cargos' => $cargos));
})->bind('cargosintendente_add');



$app->get('/cargosconcejal/{circuito}', function ($circuito) use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $cargos = $app['db']->fetchAll("SELECT * FROM partido_lista,cargo_local
             WHERE circuito_id=$circuito and tipo='C' and lista_id=partido_lista.id order by id_partido,id_lista");
    $partido_lista = $app['db']->fetchAll("SELECT * FROM partido_lista where especial=0 order by id_partido,id_lista");
    $circuito = $app['db']->fetchAssoc("SELECT * FROM circuito where id=$circuito");
    return $app['twig']->render('nomencladores/cargosconcejal.html.twig', array('circuito' => $circuito, 'partido_lista' => $partido_lista, 'cargos' => $cargos));
})->bind('cargosconcejal');

$app->get('/cargosconcejal_delete/{id}', function ($id) use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $cargo = $app['db']->fetchAssoc("SELECT circuito_id FROM cargo_local WHERE id=$id");
    $circuito = $cargo['circuito_id'];
    $sql = "DELETE from cargo_local WHERE id=?";
    $app['db']->executeQuery($sql, array((int) $id));
    $cargos = $app['db']->fetchAll("SELECT * FROM partido_lista,cargo_local 
             WHERE circuito_id=$circuito and tipo='C' and lista_id=partido_lista.id order by id_partido,id_lista");
    $partido_lista = $app['db']->fetchAll("SELECT * FROM partido_lista where especial=0 order by id_partido,id_lista");
    $circuito = $app['db']->fetchAssoc("SELECT * FROM circuito where id=$circuito");
    return $app['twig']->render('nomencladores/cargosconcejal.html.twig', array('circuito' => $circuito, 'partido_lista' => $partido_lista, 'cargos' => $cargos));
})->bind('cargosconcejal_delete');

$app->post('/cargosconcejal_add/{id}', function ($id) use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $circuito = $id;
   /* try {*/
        $sql = "INSERT into cargo_local values(NULL,'C',?,?,null)";
        $app['db']->executeQuery($sql, array((int) $_POST['id_lista'],(int) $id));
        $cargos = $app['db']->fetchAll("SELECT * FROM partido_lista,cargo_local
             WHERE circuito_id=$circuito and tipo='C' and lista_id=partido_lista.id order by id_partido,id_lista");
  /*  } catch (Exception $ex) {
        return $app->redirect($app['url_generator']->generate('provincia'));
    }*/
    $circuito = $app['db']->fetchAssoc("SELECT * FROM circuito where id=$circuito");
    $partido_lista = $app['db']->fetchAll("SELECT * FROM partido_lista where especial=0 order by id_partido,id_lista");
    return $app['twig']->render('nomencladores/cargosconcejal.html.twig', array('circuito' => $circuito, 'partido_lista' => $partido_lista, 'cargos' => $cargos));
})->bind('cargosconcejal_add');



/* * **************************************************************** */
/* * ************** LOCALES *********************************** */
/* * **************************************************************** */
$app->get('/locales', function () use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $locales = $app['db']->fetchAll('SELECT * FROM locales');
    return $app['twig']->render('nomencladores/locales.html.twig', array('locales' => $locales));
})->bind('locales');
/*
$app->post('/local_add', function () use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $sql = "INSERT INTO provincia VALUES (NULL,?,?,?,?)";
    $app['db']->executeQuery($sql, array($_POST['nombre'], (int) $_POST['electores_nacion'], (int) $_POST['electores_provincia'], (int) $_POST['mesas']));
    $provincia = $app['db']->fetchAll('SELECT * FROM provincia');
    $mensaje = array('codigo' => 0, 'texto' => "La provincia fue cargada");
    return $app['twig']->render('nomencladores/provincia.html.twig', array('provincia' => $provincia, 'mensaje' => $mensaje));
})->bind('provincia_add');
*/
$app->get('/local_delete/{id}', function ($id) use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $mensaje = array('codigo' => 0, 'texto' => "El local fue eliminado");
    try {
        $sql = "DELETE FROM locales WHERE id=?";
        $app['db']->executeQuery($sql, array((int) $id));
    } catch (Exception $ex) {
        $mensaje = array('codigo' => 1, 'texto' => "El local tiene informacion relacionado");
    }
    $locales = $app['db']->fetchAll('SELECT * FROM locales');
    return $app['twig']->render('nomencladores/locales.html.twig', array('locales' => $locales, 'mensaje' => $mensaje));
})->bind('locales_delete');
/*
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
 
 * */

 
 /* * **************************************************************** */
/* * ******************** S E C C I O N A L E S *************************** */
 /* * **************************************************************** */


$app->get('/seccionales/{circuito}', function ($circuito) use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $seccionales = $app['db']->fetchAll("SELECT * FROM seccional where circuito_id=$circuito");
    return $app['twig']->render('nomencladores/seccionales.html.twig', array('circuito' => $circuito, 'seccionales' => $seccionales));
})->bind('seccionales');

$app->post('/seccional_add/{circuito}', function ($circuito) use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $sql = "INSERT INTO seccional VALUES (NULL,?,?,?,?)";
    $app['db']->executeQuery($sql, array($_POST['nombre'],(int) $_POST['electores_nacion'], (int) $_POST['electores_provincia'],(int) $circuito));
    $seccionales = $app['db']->fetchAll("SELECT * FROM seccional where circuito_id=$circuito");
    $mensaje = array('codigo' => 0, 'texto' => "La seccional fue cargada");
    return $app['twig']->render('nomencladores/seccionales.html.twig', array('circuito' => $circuito, 'mensaje' => $mensaje, 'seccionales' => $seccionales));
})->bind('seccional_add');

$app->get('/seccional_delete/{circuito}/{id}', function ($circuito, $id) use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $mensaje = array('codigo' => 0, 'texto' => "La seccion fue eliminada");
    try {
        $sql = "DELETE FROM seccional WHERE id=?";
        $app['db']->executeQuery($sql, array((int) $id));
    } catch (Exception $ex) {
        $mensaje = array('codigo' => 1, 'texto' => "La seccional tiene informacion cargada");
    }
    $seccionales = $app['db']->fetchAll("SELECT * FROM seccional where circuito_id=$circuito");
    return $app['twig']->render('nomencladores/seccionales.html.twig', array('circuito' => $circuito, 'mensaje' => $mensaje, 'seccionales' => $seccionales));
})->bind('seccional_delete');

$app->get('/seccional_edit/{id}', function ($id) use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $seccional = $app['db']->fetchAssoc("SELECT * FROM seccional where id=$id");
    return $app['twig']->render('nomencladores/seccional_edit.html.twig', array('seccional' => $seccional));
})->bind('seccional_edit');

$app->post('/seccional_edit/{id}', function ($id) use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $mensaje = array('codigo' => 0, 'texto' => "La seccional fue modificada");
    try {
        $sql = "UPDATE seccional SET nombre=?,electores_nacion=?,electores_provincia=? WHERE id=?";
        $app['db']->executeQuery($sql, array($_POST['nombre'], (int) $_POST['electores_nacion'],
            (int) $_POST['electores_provincia'], (int) $id));
        $circuito = $app['db']->fetchAssoc("SELECT circuito_id FROM seccional where id=$id");
        $circuito = $circuito['circuito_id'];
    } catch (Exception $ex) {
        $mensaje = array('codigo' => 1, 'texto' => "Error de actualizacion");
    }
    $seccionales = $app['db']->fetchAll("SELECT * FROM seccional where circuito_id=$circuito");
    return $app['twig']->render('nomencladores/seccionales.html.twig', array('circuito' => $circuito, 'seccionales' => $seccionales, 'mensaje' => $mensaje));
})->bind('seccional_editp');
