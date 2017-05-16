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
    return $app['twig']->render('index.html.twig', array('estado' => Estado::getEstado($app)));
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
        return $app['twig']->render('index.html.twig', array('estado' => Estado::getEstado($app)));
    }
});

include("controllers_nomencladores.php");
/* * ************** M E S A S *********************************** */

$app->get('/mesa/{nro}', function ($nro) use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    require 'Mesa.php';
    require 'Filtros.php';
    require 'Configuracion.php';
    $mensaje = "";
    $mesa = new Mesa($nro, $app);
    $mesa->getMascara();
    $filtroscircuitos = Filtros::getFiltrosCircuito($mesa->getSec(), $mesa->getCirnro(), $mesa->getCirlet(), $app);
    return $app['twig']->render('mesa.html.twig', array('mesa' => $mesa, 'filtros' => $filtroscircuitos, 'configuracion' => new Configuracion($app)));
})->bind('mesa');


$app->get('/mesastestigo', function () use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    require 'Mesa.php';
    $testigos = Mesa::testigos($app);
    return $app['twig']->render('mesastestigo.html.twig', array('testigos' => $testigos));
})->bind('mesastestigo');

$app->get('/testigo/{nro}/{accion}', function ($nro, $accion) use ($app) {
    require 'Mesa.php';
    require 'Filtros.php';
    require 'Configuracion.php';
    $mensaje = "";
    $mesa = new Mesa($nro, $app);
    $mesa->$accion();
    $mesa->getMascara();
    $filtroscircuitos = Filtros::getFiltrosCircuito($mesa->getSec(), $mesa->getCirnro(), $mesa->getCirlet(), $app);
    return $app['twig']->render('mesa.html.twig', array('mesa' => $mesa, 'filtros' => $filtroscircuitos, 'configuracion' => new Configuracion($app)));
})->bind('testigo');


$app->get('/mesacarga/{nro}', function ($nro) use ($app) {
    require 'Mesa.php';
    require 'Filtros.php';
    require 'Configuracion.php';
    $mensaje = "";
    $mesa = new Mesa($nro, $app);
    $categoria = 'G';
    if (isset($_GET['categoria']))
        $categoria = $_GET['categoria'];
    $mesa->getMascara();
    $filtroscircuitos = Filtros::getFiltrosCircuito($mesa->getSec(), $mesa->getCirnro(), $mesa->getCirlet(), $app);
    return $app['twig']->render('mesa_carga.html.twig', array('mesa' => $mesa, 'categoria' => $categoria, 'filtros' => $filtroscircuitos, 'configuracion' => new Configuracion($app)));
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
        $mensaje = array('codigo'=>1,'texto'=>'Mesa incorrecta');
    }
    try {
         $mesa = new Mesa($nro, $app);
    } catch (Exception $ex) {
        return $app['twig']->render('mesa_carga_elige.html.twig', array('mensaje' => array('codigo'=>1,'texto'=>$ex->getMessage())));
    }
   
    if ($mesa->getTestigo() != 1) {
        $categorias = array();
        $mensaje = array('codigo'=>1,'texto'=>'Mesa no definida como testigo');
       return $app['twig']->render('mesa_carga_elige.html.twig', array('mensaje' => $mensaje));

    }
    $mesa->sumavotos();
    return $app['twig']->render('mesa_carga_elige.html.twig', array('configuracion' => new Configuracion($app), 'mensaje' => $mensaje, 'categorias' => $categorias, 'mesa' => $mesa));
})->bind('mesacarga_elige_p');


$app->get('/mesanacional/{nro}', function ($nro) use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    require 'MesaNacional.php';
    require 'Filtros.php';
    require 'Configuracion.php';
    $mensaje = "";
    $mesa = new MesaNacional($nro, $app);
    $mesa->getMascara();
    $filtrosnacionales = Filtros::getFiltrosNacionales( $app);
    return $app['twig']->render('mesanacional.html.twig', array('mesa' => $mesa, 'filtros' => $filtrosnacionales, 'configuracion' => new Configuracion($app)));
})->bind('mesanacional');

$app->get('/mesanacionalcarga/{nro}', function ($nro) use ($app) {
    require 'MesaNacional.php';
    require 'Filtros.php';
    require 'Configuracion.php';
    $mensaje = "";
    $mesa = new MesaNacional($nro, $app);
    $categoria = 'D';
    if (isset($_GET['categoria']))
        $categoria = $_GET['categoria'];
    $mesa->getMascara();
    $filtroscircuitos = Filtros::getFiltrosNacionales( $app);
    return $app['twig']->render('mesanacional_carga.html.twig', array('mesa' => $mesa, 'categoria' => $categoria, 'filtros' => $filtroscircuitos, 'configuracion' => new Configuracion($app)));
})->bind('mesanacionalcarga');



$app->post('/mesacarga/{nro}', function ($nro) use ($app) {
    require 'MesaNacional.php';
    require 'Configuracion.php';
    $mensaje = "";
    $mesa = new MesaNacional($nro, $app);
    $mesa->actualiza($_POST);
    $categorias = array();
    return $app->redirect($app['url_generator']->generate('mesacarga_elige'));
})->bind('mesanacionalcarga_p');


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
    $sql = "SELECT *,1 testigo from locales l where EXISTS (select * from mesas m where testigo=1 and m.mesa<=l.mesahasta and m.mesa>=l.mesadesde) UNION SELECT *,0 testigo from locales l where NOT EXISTS (select * from mesas m where testigo=1 and m.mesa<=l.mesahasta and m.mesa>=l.mesadesde)";
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
