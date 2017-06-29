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
    $breadcumb = $app['db']->fetchAssoc("SELECT * FROM provincia where id=$provincia");
    $secciones = $app['db']->fetchAll("SELECT * FROM seccion where provincia_id=$provincia");
    return $app['twig']->render('nomencladores/seccion.html.twig', array('breadcumb' => $breadcumb, 'provincia' => $provincia, 'secciones' => $secciones));
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
    $breadcumb = $app['db']->fetchAssoc("SELECT * FROM provincia where id=$provincia");
    return $app['twig']->render('nomencladores/seccion.html.twig', array('breadcumb' => $breadcumb, 'provincia' => $provincia, 'secciones' => $seccion, 'mensaje' => $mensaje));
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
    $breadcumb = $app['db']->fetchAssoc("SELECT * FROM provincia where id=$provincia");

    return $app['twig']->render('nomencladores/seccion.html.twig', array('breadcumb' => $breadcumb, 'provincia' => $provincia, 'secciones' => $seccion, 'mensaje' => $mensaje));
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
    $breadcumb = $app['db']->fetchAssoc("SELECT * FROM provincia where id=$provincia");
    $seccion = $app['db']->fetchAll("SELECT * FROM seccion where provincia_id=$provincia");
    return $app['twig']->render('nomencladores/seccion.html.twig', array('breadcumb' => $breadcumb, 'provincia' => $provincia, 'secciones' => $seccion, 'mensaje' => $mensaje));
})->bind('seccion_editp');


/* * **************************************************************** */
/* * ******************** C I R C U I T O S********************** */
/* * **************************************************************** */
$app->get('/circuitos/{seccion}', function ($seccion) use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $breadcumb = $app['db']->fetchAssoc("SELECT p.id as provincia_id,p.nombre as provincia_nombre,"
            . "s.id as seccion_id, s.nombre as seccion_nombre FROM provincia p,seccion s where p.id=s.provincia_id and  s.id=$seccion");
    $circuitos = $app['db']->fetchAll("SELECT * FROM circuito where seccion_id=$seccion");
    return $app['twig']->render('nomencladores/circuitos.html.twig', array('breadcumb' => $breadcumb, 'seccion' => $seccion, 'circuitos' => $circuitos));
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
    $breadcumb = $app['db']->fetchAssoc("SELECT p.id as provincia_id,p.nombre as provincia_nombre,"
            . "s.id as seccion_id, s.nombre as seccion_nombre FROM provincia p,seccion s where p.id=s.provincia_id and  s.id=$seccion");

    $circuitos = $app['db']->fetchAll("SELECT * FROM circuito where seccion_id=$seccion");
    $mensaje = array('codigo' => 0, 'texto' => "El circuito fue cargado");
    return $app['twig']->render('nomencladores/circuitos.html.twig', array('breadcumb' => $breadcumb, 'seccion' => $seccion, 'mensaje' => $mensaje, 'circuitos' => $circuitos));
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
    $breadcumb = $app['db']->fetchAssoc("SELECT p.id as provincia_id,p.nombre as provincia_nombre,"
            . "s.id as seccion_id, s.nombre as seccion_nombre FROM provincia p,seccion s where p.id=s.provincia_id and  s.id=$seccion");

    $circuitos = $app['db']->fetchAll("SELECT * FROM circuito where seccion_id=$seccion");

    return $app['twig']->render('nomencladores/circuitos.html.twig', array('breadcumb' => $breadcumb, 'seccion' => $seccion, 'mensaje' => $mensaje, 'circuitos' => $circuitos));
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
    $breadcumb = $app['db']->fetchAssoc("SELECT p.id as provincia_id,p.nombre as provincia_nombre,"
            . "s.id as seccion_id, s.nombre as seccion_nombre FROM provincia p,seccion s where p.id=s.provincia_id and  s.id=$seccion");

    $circuito = $app['db']->fetchAll("SELECT * FROM circuito where seccion_id=$seccion");
    return $app['twig']->render('nomencladores/circuitos.html.twig', array('breadcumb' => $breadcumb, 'seccion' => $seccion, 'circuitos' => $circuito, 'mensaje' => $mensaje));
})->bind('circuito_editp');


/* * **************************************************************** */
/* * ******************** C  A  R  G  O  S********************** */
/* * **************************************************************** */
$app->get('/cargosgobernador/{provincia}', function ($provincia) use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $cargos = $app['db']->fetchAll("SELECT * FROM partido_lista,cargo_provincial 
             WHERE cargo_provincial.provincia_id=$provincia and tipo='G' and lista_id=partido_lista.id order by id_partido,id_lista");
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
             WHERE cargo_provincial.provincia_id=$provincia and tipo='D' and lista_id=partido_lista.id order by id_partido,id_lista");
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
        $sql = "INSERT into cargo_provincial values(NULL,?,?,'D',NULL)";
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
        $app['db']->executeQuery($sql, array((int) $id, (int) $_POST['id_lista']));
        $cargos = $app['db']->fetchAll("SELECT * FROM partido_lista,cargo_departamental
             WHERE seccion_id=$seccion and tipo='S' and lista_id=partido_lista.id order by id_partido,id_lista");
    } catch (Exception $ex) {
        print_r($ex);
        die;
        return $app->redirect($app['url_generator']->generate('provincia'));
    }
    $seccion = $app['db']->fetchAssoc("SELECT * FROM seccion where id=$seccion");
    $partido_lista = $app['db']->fetchAll("SELECT * FROM partido_lista  where especial=0 order by id_partido,id_lista");
    return $app['twig']->render('nomencladores/cargossenador.html.twig', array('seccion' => $seccion, 'partido_lista' => $partido_lista, 'cargos' => $cargos));
})->bind('cargossenador_add');

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
        $app['db']->executeQuery($sql, array((int) $id, (int) $_POST['id_lista']));
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
        $app['db']->executeQuery($sql, array((int) $_POST['id_lista'], (int) $id));
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
    if (isset($_GET['apellido'])) {
        $sql = "INSERT INTO candidato VALUES (NULL,?,?,NULL);";
        $app['db']->executeQuery($sql, array( $_GET['apellido'],  $_GET['nombre']));
        $candidato_id = $app['db']->lastInsertId();
        $sql = "UPDATE cargo_local set candidato_id=$candidato_id where id=" . $_GET['cargo'];
        $app['db']->executeQuery($sql);
    }
    $cargos = array();
    $cargos2 = $app['db']->fetchAll("SELECT *,cargo_local.id as id_cargo FROM partido_lista,cargo_local  left join candidato on candidato.id=candidato_id 
             WHERE circuito_id=$circuito and tipo='C' and lista_id=partido_lista.id order by id_partido,id_lista");
    $partido_lista = $app['db']->fetchAll("SELECT * FROM partido_lista where especial=0 order by id_partido,id_lista");
    foreach ($cargos2 as $item) {
        $item['foto'] = base64_encode($item['foto']);
        $cargos[] = $item;
    }
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
    $cargos2 = $app['db']->fetchAll("SELECT * ,cargo_local.id as id_cargo FROM partido_lista,cargo_local  left join candidato on candidato.id=candidato_id 
             WHERE circuito_id=$circuito and tipo='C' and lista_id=partido_lista.id order by id_partido,id_lista");
    foreach ($cargos2 as $item) {
        $item['foto'] = base64_encode($item['foto']);
        $cargos[] = $item;
    }
    $partido_lista = $app['db']->fetchAll("SELECT * FROM partido_lista where especial=0 order by id_partido,id_lista");
    $circuito = $app['db']->fetchAssoc("SELECT * FROM circuito where id=$circuito");
    return $app['twig']->render('nomencladores/cargosconcejal.html.twig', array('circuito' => $circuito, 'partido_lista' => $partido_lista, 'cargos' => $cargos));
})->bind('cargosconcejal_delete');

$app->post('/cargosconcejal_add/{id}', function ($id) use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $circuito = $id;
    /* try { */
    $sql = "INSERT into cargo_local values(NULL,'C',?,?,null)";
    $app['db']->executeQuery($sql, array((int) $_POST['id_lista'], (int) $id));
    $cargos2 = $app['db']->fetchAll("SELECT * ,cargo_local.id as id_cargo FROM partido_lista,cargo_local  left join candidato on candidato.id=candidato_id 
             WHERE circuito_id=$circuito and tipo='C' and lista_id=partido_lista.id order by id_partido,id_lista");
    /*  } catch (Exception $ex) {
      return $app->redirect($app['url_generator']->generate('provincia'));
      } */
    foreach ($cargos2 as $item) {
        $item['foto'] = base64_encode($item['foto']);
        $cargos[] = $item;
    }
    $circuito = $app['db']->fetchAssoc("SELECT * FROM circuito where id=$circuito");
    $partido_lista = $app['db']->fetchAll("SELECT * FROM partido_lista where especial=0 order by id_partido,id_lista");
    return $app['twig']->render('nomencladores/cargosconcejal.html.twig', array('circuito' => $circuito, 'partido_lista' => $partido_lista, 'cargos' => $cargos));
})->bind('cargosconcejal_add');

$app->post('/cargosconcejal_logo/{id}', function ($id) use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
     if (isset($_FILES['logo']['tmp_name'])) {
            $logo = file_get_contents($_FILES['logo']['tmp_name']);
            $sql = "UPDATE candidato SET foto=? WHERE id=?";
            $app['db']->executeQuery($sql, array($logo, (int) $_POST['candidato_id']));
    }
        return $app->redirect($app['url_generator']->generate('cargosconcejal', array('circuito' => $id)));

})->bind('cargosconcejal_logo');

$app->post('/cargosnacionales/{provincia}', function ($provincia) use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $sql = "DELETE FROM cargo_nacional";
    $app['db']->executeQuery($sql, array());
    foreach ($_POST as $clave => $item) {
        $datos = explode(",", $clave);
        if ($datos[0] == "D" || $datos[0] == "S") {
            $sql = "INSERT into cargo_nacional values(NULL,?,?,?)";
            $app['db']->executeQuery($sql, array($datos[0], $datos[1], (int) $provincia));
        }
    }

    return $app->redirect($app['url_generator']->generate('partidosnacionales', array('provincia' => $provincia)));
})->bind('cargosnacionales');




/* * **************************************************************** */
/* * ************** LOCALES *********************************** */
/* * **************************************************************** */
$app->get('/locales/{provincia}', function ($provincia) use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $locales = $app['db']->fetchAll("SELECT * FROM locales where provincia_id=$provincia");
    $provincia = $app['db']->fetchAssoc("SELECT * FROM provincia where id=$provincia");
    return $app['twig']->render('nomencladores/locales.html.twig', array('provincia' => $provincia, 'locales' => $locales));
})->bind('locales');

$app->post('/local_add', function () use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $sql = "INSERT INTO locales VALUES (NULL,?,?,?,?,?,?,?,?,?)";
    $app['db']->executeQuery($sql, array($_POST['nombre'], $_POST['direccion'], $_POST['telefono'],
        $_POST['contacto'], (int) $_POST['lat'], (int) $_POST['lon'], (int) $_POST['mesa_desde'],
        (int) $_POST['mesa_hasta'], 1));
    $provincia = 1;

    $locales = $app['db']->fetchAll("SELECT * FROM locales where provincia_id=$provincia");
    $provincia = $app['db']->fetchAssoc("SELECT * FROM provincia where id=$provincia");
    return $app['twig']->render('nomencladores/locales.html.twig', array('provincia' => $provincia, 'locales' => $locales));
})->bind('local_add');

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
    $provincia = 1;

    $locales = $app['db']->fetchAll("SELECT * FROM locales where provincia_id=$provincia");
    $provincia = $app['db']->fetchAssoc("SELECT * FROM provincia where id=$provincia");
    return $app['twig']->render('nomencladores/locales.html.twig', array('provincia' => $provincia, 'locales' => $locales));
})->bind('local_delete');

$app->get('/local_edit/{id}', function ($id) use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $local = $app['db']->fetchAssoc("SELECT * FROM locales where id=$id");
    return $app['twig']->render('nomencladores/local_edit.html.twig', array('local' => $local));
})->bind('local_edit');

$app->post('/local_edit/{id}', function ($id) use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $mensaje = array('codigo' => 0, 'texto' => "El local fue modificado");
    try {
        $sql = "UPDATE locales SET nombre=?,direccion=?,telefono=?,"
                . "contacto=?,lat=?,lon=?,mesadesde=?,mesahasta=? WHERE id=?";
        $app['db']->executeQuery($sql, array($_POST['nombre'], $_POST['direccion'], $_POST['telefono'],
            $_POST['contacto'], $_POST['lat'], $_POST['lon'],
            (int) $_POST['mesa_desde'], (int) $_POST['mesa_hasta'], (int) $id));
    } catch (Exception $ex) {
        $mensaje = array('codigo' => 1, 'texto' => "Error de actualizacion:" . $ex->getMessage());
    }

    $localeditado = $app['db']->fetchAssoc("SELECT * FROM locales where id=$id");
    $provincia = $app['db']->fetchAssoc("SELECT * FROM provincia where id=" . $localeditado['provincia_id']);
    $locales = $app['db']->fetchAll('SELECT * FROM locales where provincia_id=' . $provincia['id']);
    return $app['twig']->render('nomencladores/locales.html.twig', array('provincia' => $provincia, 'locales' => $locales, 'mensaje' => $mensaje));
})->bind('local_editp');




/* * **************************************************************** */
/* * ******************** S E C C I O N A L E S *************************** */
/* * **************************************************************** */


$app->get('/seccionales/{circuito}', function ($circuito) use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $seccionales = $app['db']->fetchAll("SELECT * FROM seccional where circuito_id=$circuito");
    $breadcumb = $app['db']->fetchAssoc("SELECT * FROM circuito where id=$circuito");
    return $app['twig']->render('nomencladores/seccionales.html.twig', array('breadcumb' => $breadcumb, 'circuito' => $circuito, 'seccionales' => $seccionales));
})->bind('seccionales');

$app->post('/seccional_add/{circuito}', function ($circuito) use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $breadcumb = $app['db']->fetchAssoc("SELECT * FROM circuito where id=$circuito");
    $sql = "INSERT INTO seccional VALUES (NULL,?,?,?,?)";
    $app['db']->executeQuery($sql, array($_POST['nombre'], (int) $_POST['electores_nacion'], (int) $_POST['electores_provincia'], (int) $circuito));
    $seccionales = $app['db']->fetchAll("SELECT * FROM seccional where circuito_id=$circuito");
    $mensaje = array('codigo' => 0, 'texto' => "La seccional fue cargada");
    return $app['twig']->render('nomencladores/seccionales.html.twig', array('breadcumb' => $breadcumb, 'circuito' => $circuito, 'mensaje' => $mensaje, 'seccionales' => $seccionales));
})->bind('seccional_add');

$app->get('/seccional_delete/{circuito}/{id}', function ($circuito, $id) use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $breadcumb = $app['db']->fetchAssoc("SELECT * FROM circuito where id=$circuito");
    $mensaje = array('codigo' => 0, 'texto' => "La seccion fue eliminada");
    try {
        $sql = "DELETE FROM seccional WHERE id=?";
        $app['db']->executeQuery($sql, array((int) $id));
    } catch (Exception $ex) {
        $mensaje = array('codigo' => 1, 'texto' => "La seccional tiene informacion cargada");
    }
    $seccionales = $app['db']->fetchAll("SELECT * FROM seccional where circuito_id=$circuito");
    return $app['twig']->render('nomencladores/seccionales.html.twig', array('breadcumb' => $breadcumb, 'circuito' => $circuito, 'mensaje' => $mensaje, 'seccionales' => $seccionales));
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
    $breadcumb = $app['db']->fetchAssoc("SELECT * FROM circuito where id=$circuito");
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
    return $app['twig']->render('nomencladores/seccionales.html.twig', array('breadcumb' => $breadcumb, 'circuito' => $circuito, 'seccionales' => $seccionales, 'mensaje' => $mensaje));
})->bind('seccional_editp');



/* * **************************************************************** */
/* * ******************** P A R T I D O S *************************** */
/* * **************************************************************** */


$app->get('/partidos/{provincia}', function ($provincia) use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    if (isset($_GET['borrar'])) {
        $id_borrar = $_GET['borrar'];
        $sql = "DELETE FROM renglon WHERE lista_id=?";
        $app['db']->executeQuery($sql, array((int) $id_borrar));
        $sql = "DELETE FROM cargo_local WHERE lista_id=?";
        $app['db']->executeQuery($sql, array((int) $id_borrar));
        $sql = "DELETE FROM cargo_departamental WHERE lista_id=?";
        $app['db']->executeQuery($sql, array((int) $id_borrar));
        $sql = "DELETE FROM cargo_provincial WHERE lista_id=?";
        $app['db']->executeQuery($sql, array((int) $id_borrar));
        $sql = "DELETE FROM partido_lista WHERE id=?";
        $app['db']->executeQuery($sql, array((int) $id_borrar));
    }
    $partidos = array();
    $partidos2 = $app['db']->fetchAll("SELECT * FROM partido_lista where provincia_id=$provincia and especial=0");
    foreach ($partidos2 as $item) {
        $item['logo'] = base64_encode($item['logo']);
        $partidos[] = $item;
    }
    $provincia = $app['db']->fetchAssoc("SELECT * FROM provincia where id=$provincia");
    return $app['twig']->render('nomencladores/partidos.html.twig', array('provincia' => $provincia, 'partidos' => $partidos));
})->bind('partidos');

$app->post('/partidos/{provincia}', function ($provincia) use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $sql = "INSERT INTO partido_lista VALUES(NULL,?,?,?,?,0,NULL,?)";
    $app['db']->executeQuery($sql, array($_POST['id_partido'], $_POST['nombre_partido'],
        $_POST['id_lista'], $_POST['nombre_lista'], (int) $provincia));
    $partidos2 = $app['db']->fetchAll("SELECT * FROM partido_lista where provincia_id=$provincia and especial=0");
    foreach ($partidos2 as $item) {
        $item['logo'] = base64_encode($item['logo']);
        $partidos[] = $item;
    }
    $provincia = $app['db']->fetchAssoc("SELECT * FROM provincia where id=$provincia");
    return $app['twig']->render('nomencladores/partidos.html.twig', array('provincia' => $provincia, 'partidos' => $partidos));
})->bind('partidosp');



$app->post('/partido_logo/{id}', function ($id) use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $provincia = $app['db']->fetchAssoc("SELECT * FROM partido_lista where id=$id");
    $provincia = $provincia['id'];

    if (isset($_FILES['logo']['tmp_name'])) {

        try {
            $logo = file_get_contents($_FILES['logo']['tmp_name']);
            $sql = "UPDATE partido_lista SET logo=? WHERE id=?";
            $app['db']->executeQuery($sql, array($logo, (int) $id));
        } catch (Exception $ex) {
            $mensaje = array('codigo' => 1, 'texto' => "Error de actualizacion: " . $ex->getMessage());
            $partidos2 = $app['db']->fetchAll("SELECT * FROM partido_lista");
            foreach ($partidos2 as $item) {
                $item['logo'] = base64_encode($item['logo']);
                $partidos[] = $item;
            }
            $provincia = $app['db']->fetchAssoc("SELECT * FROM provincia where id=$provincia");
            return $app['twig']->render('nomencladores/partidos.html.twig', array('provincia' => $provincia, 'mensaje' => $mensaje, 'partidos' => $partidos));
        }
    }
    $partidos2 = $app['db']->fetchAll("SELECT * FROM partido_lista");
    foreach ($partidos2 as $item) {
        $item['logo'] = base64_encode($item['logo']);
        $partidos[] = $item;
    }
    $provincia = $app['db']->fetchAssoc("SELECT * FROM provincia where id=$provincia");
    return $app['twig']->render('nomencladores/partidos.html.twig', array('provincia' => $provincia, 'partidos' => $partidos));
})->bind('partido_logo');


/*
  $app->post('/seccional_add/{circuito}', function ($circuito) use ($app) {
  if (!validar('admin')) {
  return $app->redirect($app['url_generator']->generate('login'));
  }
  $sql = "INSERT INTO seccional VALUES (NULL,?,?,?,?)";
  $app['db']->executeQuery($sql, array($_POST['nombre'], (int) $_POST['electores_nacion'], (int) $_POST['electores_provincia'], (int) $circuito));
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
 */


$app->get('/partidosnacionales/{provincia}', function ($provincia) use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    if (isset($_GET['borrar'])) {
        $id_borrar = $_GET['borrar'];
        $sql = "DELETE FROM renglon_nacional WHERE lista_nacional_id=?";
        $app['db']->executeQuery($sql, array((int) $id_borrar));
        $sql = "DELETE FROM cargo_nacional WHERE lista_nacional_id=?";
        $app['db']->executeQuery($sql, array((int) $id_borrar));
        $sql = "DELETE FROM partido_lista_nacional WHERE id=?";
        $app['db']->executeQuery($sql, array((int) $id_borrar));
    }
    $partidos = $app['db']->fetchAll("SELECT p.*,cnd.tipo as diputado,cns.tipo as senador  FROM partido_lista_nacional p "
            . "LEFT JOIN (select * from cargo_nacional where tipo='D') cnd on p.id=cnd.lista_nacional_id "
            . "LEFT JOIN (select * from cargo_nacional where tipo='S') cns on p.id=cns.lista_nacional_id where p.provincia_id=$provincia");
    $provincia = $app['db']->fetchAssoc("SELECT * FROM provincia where id=$provincia");
//print_r($partidos);
    return $app['twig']->render('nomencladores/partidosnacionales.html.twig', array('partidos' => $partidos, 'provincia' => $provincia));
})->bind('partidosnacionales');

$app->post('/partidosnacionales/{provincia}', function ($provincia) use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    $sql = "INSERT INTO partido_lista_nacional VALUES(NULL,?,?,?,?,0,?)";
    $app['db']->executeQuery($sql, array($_POST['id_partido'], $_POST['nombre_partido'],
        (int) $_POST['id_lista'], $_POST['nombre_lista'], (int) $provincia));
    $partidos = $app['db']->fetchAll("SELECT p.*,cnd.tipo as diputado,cns.tipo as senador  FROM partido_lista_nacional p "
            . "LEFT JOIN (select * from cargo_nacional where tipo='D') cnd on p.id=cnd.lista_nacional_id "
            . "LEFT JOIN (select * from cargo_nacional where tipo='S') cns on p.id=cns.lista_nacional_id where p.provincia_id=$provincia");
    $provincia = $app['db']->fetchAssoc("SELECT * FROM provincia where id=$provincia");
//print_r($partidos);
    return $app['twig']->render('nomencladores/partidosnacionales.html.twig', array('partidos' => $partidos, 'provincia' => $provincia));
})->bind('partidosnacionalesp');

