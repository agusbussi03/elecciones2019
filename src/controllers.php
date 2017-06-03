<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

//Request::setTrustedProxies(array('127.0.0.1'));

$app->get('/', function () use ($app) {
    require 'Estado.php';
    if (!validar('admin')) {
        return $app->redirect('login');
    }
   // return $app['twig']->render('index.html.twig', array('estado' => Estado::getEstado($app)));
     return $app->redirect($app['url_generator']->generate('provincia'));
})->bind('homepage');

/* * ************** L O G I N *********************************** */


$app->get('/login', function () use ($app) {
    $mensaje = '';
    return $app['twig']->render('login.html.twig', array('mensaje' => $mensaje));
})->bind('login');

$app->get('/logout', function () use ($app) {
    $mensaje = 'Ha salido del sistema';
    session_destroy();
    return $app['twig']->render('login.html.twig', array('mensaje' => $mensaje));
})->bind('logout');

$app->post('/login', function () use ($app) {
    require 'Usuarios.php';
    $mensaje = '';
    $usuario = new Usuarios($app);
    $resultado = $usuario->getByUsername($_POST['usuario']);
    if ($resultado != '')
        $mensaje = $resultado;
    if ($usuario->getPassword() != md5($_POST['password'])) {
        $mensaje = "Password incorrecta";
    }

    if ($mensaje != "")
        return $app['twig']->render('login.html.twig', array('mensaje' => $mensaje));
    else {
//$_SESSION['usuario'] = $usuario;
        $_SESSION['usuario'] = $usuario->getUsuario();
        $_SESSION['admin'] = $usuario->getAdmin();
        $_SESSION['carga'] = $usuario->getCarga();
        $_SESSION['lectura'] = $usuario->getLectura();
        $app['twig']->addGlobal('session', $_SESSION);
        return $app->redirect($app['url_generator']->generate('homepage'));
//  return $app['twig']->render('index.html.twig', array('estado' => Estado::getEstado($app)));
    }
});

include("controllers_nomencladores.php");
/* * ************** M E S A S *********************************** */

$app->get('/mesa/{nro}', function ($nro) use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    require 'Mesa.php';
    require 'Configuracion.php';
    $mensaje = "";
    try {
        $mesa = new Mesa($nro, $app);
        $mesa->sumavotos();
    } catch (Exception $ex) {
        $mensaje = array('codigo' => 1, 'texto' => $ex->getMessage());
        $mesa = array("numero" => $nro);
        return $app['twig']->render('mesa.html.twig', array('mensaje' => $mensaje, 'mesa' => $mesa));
    }
    $mascara = $mesa->getMascara();
    $votos = $mesa->votos();
//print_r($mascara);print_r($votos);
    return $app['twig']->render('mesa.html.twig', array('mesa' => $mesa, 'votos' => $votos, 'mascara' => $mascara, 'configuracion' => new Configuracion($app)));
})->bind('mesa');

$app->get('/mesastestigo/{provincia}', function ($provincia) use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    require 'Mesa.php';
    $testigos = Mesa::testigos($provincia, $app);
    $provincia = $app['db']->fetchAssoc("SELECT * FROM provincia where id=$provincia");
    return $app['twig']->render('mesastestigo.html.twig', array('provincia'=>$provincia,'testigos' => $testigos));
})->bind('mesastestigo');

$app->get('/testigo_accion/{circuito}', function ($circuito) use ($app) {
    require 'Mesa.php';

    $seccionales = $app['db']->fetchAll("SELECT * from seccional where circuito_id=$circuito", array());
    $circuito = $app['db']->fetchAssoc("SELECT * from circuito where id=$circuito", array());

    if (isset($_GET['nueva'])) {
        Mesa::setTestigo($_GET['numero'], $_GET['electores_provincia'], $_GET['electores_nacion'], $circuito['id'], $_GET['seccional_id'], $app);
    }
    if (isset($_GET['borrar'])) {
        Mesa::unsetTestigo($_GET['borrar'], $app);
    }
    $mesas = Mesa::testigosporcircuito($circuito['id'], $app);
    return $app['twig']->render('mesatestigo_accion.html.twig', array('circuito' => $circuito, 'testigos' => $mesas, 'seccionales' => $seccionales));
})->bind('testigo_accion');


$app->get('/mesacarga/{nro}', function ($nro) use ($app) {
    require 'Mesa.php';
    require 'Configuracion.php';
    $mensaje = "";
    $mesa = new Mesa($nro, $app);
    $categoria = 'G';
    if (isset($_GET['categoria']))
        $categoria = $_GET['categoria'];
    $mascara = $mesa->getMascara();
    return $app['twig']->render('mesa_carga.html.twig', array('mesa' => $mesa, 'mascara' => $mascara, 'categoria' => $categoria, 'configuracion' => new Configuracion($app)));
})->bind('mesacarga');



$app->post('/mesacarga/{nro}', function ($nro) use ($app) {
    require 'Mesa.php';
    require 'Configuracion.php';
    $mensaje = "";
    $mesa = new Mesa($nro, $app);
    $mesa->actualiza($_POST);
    $categorias = array();
    return $app->redirect($app['url_generator']->generate('mesacarga_elige'));
})->bind('mesacarga_p');

$app->get('/mesacarga_elige', function () use ($app) {
    require 'Configuracion.php';
    $mensaje = "";
    $categorias = array();
    return $app['twig']->render('mesa_carga_elige.html.twig', array('configuracion' => new Configuracion($app), 'mensaje' => $mensaje, 'categorias' => $categorias));
})->bind('mesacarga_elige');

$app->post('/mesacarga_elige', function () use ($app) {
    require 'Mesa.php';
    $mensaje = "";
    $categorias = array('G', 'DN');
    $nro = $_POST['nro'];
    if (!($nro > 0)) {
        $categorias = array();
        $mensaje = array('codigo' => 1, 'texto' => 'Mesa incorrecta');
    }
    try {
        $mesa = new Mesa($nro, $app);
    } catch (Exception $ex) {
        return $app['twig']->render('mesa_carga_elige.html.twig', array('mensaje' => array('codigo' => 1, 'texto' => $ex->getMessage())));
    }
    $mesa->sumavotos();
    return $app['twig']->render('mesa_carga_elige.html.twig', array('configuracion' => new Configuracion($app), 'mensaje' => $mensaje, 'categorias' => $categorias, 'mesa' => $mesa));
})->bind('mesacarga_elige_p');


$app->get('/mesanacional/{nro}', function ($nro) use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    require 'MesaNacional.php';
    require 'Configuracion.php';
    $mensaje = "";
    $mesa = new MesaNacional($nro, $app);
    $mesa->sumavotos();
    $votos = $mesa->votos();
    $mascara = $mesa->getMascara();
//print_r($votos);
    return $app['twig']->render('mesanacional.html.twig', array('mesa' => $mesa, 'votos' => $votos, 'mascara' => $mascara, 'configuracion' => new Configuracion($app)));
})->bind('mesanacional');

$app->get('/mesanacionalcarga/{nro}', function ($nro) use ($app) {
    require 'MesaNacional.php';
//require 'Filtros.php';
    require 'Configuracion.php';
    $mensaje = "";
    $mesa = new MesaNacional($nro, $app);
    $categoria = 'D';
    if (isset($_GET['categoria']))
        $categoria = $_GET['categoria'];
    $mesa->getMascara();
    $filtroscircuitos = Filtros::getFiltrosNacionales($app);
    return $app['twig']->render('mesanacional_carga.html.twig', array('mesa' => $mesa, 'categoria' => $categoria, 'filtros' => $filtroscircuitos, 'configuracion' => new Configuracion($app)));
})->bind('mesanacionalcarga');



$app->post('/mesacarganacional/{nro}', function ($nro) use ($app) {
    require 'MesaNacional.php';
    require 'Configuracion.php';
    $mensaje = "";
    $mesa = new MesaNacional($nro, $app);
    $mesa->actualiza($_POST);
    $categorias = array();
    return $app->redirect($app['url_generator']->generate('mesacarga_elige'));
})->bind('mesanacionalcarga_p');


$app->get('/regenerarmesas/{provincia}', function ($provincia) use ($app) {
    if (!validar('admin')) {
        return $app->redirect('login');
    }
    require 'MesaNacional.php';

    $testigos = Mesa::testigos($provincia, $app);
    print_r($testigos);
    foreach ($testigos as $item) {
        $mesa = new Mesa($item['numero'], $app);
        $mesa->regenera();
    }
    return $app->redirect($app['url_generator']->generate('provincia'));
})->bind('regenerarmesas');

/* * ************** C O N F I G U  R A C I O N *********************************** */


$app->get('/configuracion', function () use ($app) {
    if (!validar('admin')) {
        return $app->redirect('login');
    }
    require 'Configuracion.php';
    $mensaje = '';
    $configuracion = new Configuracion($app);
    return $app['twig']->render('configuracion.html.twig', array('configuracion' => $configuracion, 'mensaje' => $mensaje));
})->bind('configuracion');

$app->post('/configuracion', function () use ($app) {
    if (!validar('admin')) {
        return $app->redirect('login');
    }
    require 'Configuracion.php';
    $mensaje = 'Datos almacenados';
    $configuracion = new Configuracion($app);
    $configuracion->grabar($_POST);
    return $app['twig']->render('configuracion.html.twig', array('configuracion' => $configuracion, 'mensaje' => $mensaje));
});

$app->get('/backup', function () use ($app) {
    $backup_file = "backup_" . date("Y-m-d-H-i-s") . '.gz';
    $command = "mysqldump --opt -h " . $app['datos_conexion']['host'] . " -u " . $app['datos_conexion']['user'] . " -p" .
            $app['datos_conexion']['password'] . "  " . $app['datos_conexion']['dbname'] . " | gzip > " . $backup_file;
    system($command);
    //header("Content-Type: image/png");
header("Content-Length: " . filesize($backup_file));
header('Content-Type: application/zip');
header('Content-Disposition: attachment; filename="'.$backup_file.'"');
    $fp = fopen($backup_file, 'rb');
    fpassthru($fp);
    require 'Configuracion.php';
    $mensaje = 'Backup enviado';
    $configuracion = new Configuracion($app);
    return $app['twig']->render('configuracion.html.twig', array('configuracion' => $configuracion, 'mensaje' => $mensaje));
})->bind('backup');
/* * ************** U S U A R I O S *********************************** */

$app->get('/usuarios', function () use ($app) {
    if (!validar('admin')) {
        return $app->redirect('login');
    }
    require 'Usuarios.php';
    $mensaje = '';
    $usuarios = Usuarios::getAll($app);
    return $app['twig']->render('usuarios.html.twig', array('usuarios' => $usuarios, 'mensaje' => $mensaje));
})->bind('usuarios');

$app->post('/usuario', function () use ($app) {
    if (!validar('admin')) {
        return $app->redirect('login');
    }
    require 'Configuracion.php';
    $mensaje = 'Datos almacenados';
    $configuracion = new Configuracion($app);
    $configuracion->grabar($_POST);
    return $app['twig']->render('configuracion.html.twig', array('configuracion' => $configuracion, 'mensaje' => $mensaje));
});

/* * ************** L O C A L E S *********************************** */

$app->get('/geolocales', function () use ($app) {
    if (!validar('admin')) {
        return $app->redirect('login');
    }
    $sql = "SELECT *,1 testigo from locales l where EXISTS (select * from mesa m where m.numero<=l.mesahasta and m.numero>=l.mesadesde) UNION SELECT *,0 testigo from locales l where NOT EXISTS (select * from mesa m where m.numero<=l.mesahasta and m.numero>=l.mesadesde)";
    $locales = $app['db']->fetchAll($sql, array());

    return $app['twig']->render('geolocales.html.twig', array('locales' => $locales));
})->bind('geolocales');



$app->error(function (\Exception $e, Request $request, $code) use ($app) {
    if ($app['debug']) {
        return;
    }

// 404.html, or 40x.html, or 4xx.html, or error.html
    $templates = array(
        'errors/' . $code . '.html.twig',
        'errors/' . substr($code, 0, 2) . 'x.html.twig',
        'errors/' . substr($code, 0, 1) . 'xx.html.twig',
        'errors/default.html.twig',
    );

    return new Response($app['twig']->resolveTemplate($templates)->render(array('code' => $code)), $code);
});

include('controllers_reporting.php');

function validar($rol) {
    if (!isset($_SESSION['usuario']))
        return false;
    if (!isset($_SESSION[$rol]))
        return false;
    if ($_SESSION[$rol] == 0)
        return false;
    return true;
}
