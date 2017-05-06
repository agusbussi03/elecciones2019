<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

//Request::setTrustedProxies(array('127.0.0.1'));
$app->get('/', function () use ($app) {
            if (!validar('admin')) {
                return $app->redirect('login');
            }
            return $app['twig']->render('index.html.twig', array());
        })
        ->bind('homepage');

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
        return $app['twig']->render('index.html.twig', array());
    }
});


/* * ************** F I L T R O S *********************************** */
$app->get('/circuitos', function () use ($app) {
    if (!validar('admin')) {
        return $app->redirect('login');
    }
    $circuitos = $app['db']->fetchAll("SELECT * FROM circuitos where tipo='M'");
    return $app['twig']->render('circuitos.html.twig', array('circuitos' => $circuitos));
})->bind('circuitos');

$app->get('/secciones', function () use ($app) {
    if (!validar('admin')) {
        return $app->redirect('login');
    }
    $secciones = $app['db']->fetchAll("SELECT * FROM circuitos where tipo='S'");
    return $app['twig']->render('secciones.html.twig', array('secciones' => $secciones));
})->bind('secciones');

$app->get('/provincia', function () use ($app) {
    if (!validar('admin')) {
        return $app->redirect('login');
    }
    $provincia = $app['db']->fetchAll('SELECT * FROM circuitos');
    return $app['twig']->render('provincia.html.twig', array('provincia' => $provincia));
})->bind('provincia');

$app->get('/filtrosgobernador', function () use ($app) {
    if (!validar('admin')) {
        return $app->redirect('login');
    }
    require 'Filtros.php';
    $mensaje = "";
    $filtros = new Filtros('G', 0, 0, '', $app);
    $resultado = $filtros->getFiltros();
    return $app['twig']->render('filtrosgobernador.html.twig', array('disponibles' => $resultado['disponibles'], 'filtros' => $resultado['filtros'], 'mensaje' => $mensaje));
})->bind('filtrosgobernador');

$app->post('/filtrosgobernador', function () use ($app) {
    if (!validar('admin')) {
        return $app->redirect('login');
    }
    require 'Filtros.php';
    $filtros = new Filtros('G', 0, 0, '', $app);
    $mensaje = $filtros->procesar($_POST);
    $resultado = $filtros->getFiltros();
    return $app['twig']->render('filtrosgobernador.html.twig', array('disponibles' => $resultado['disponibles'], 'filtros' => $resultado['filtros'], 'mensaje' => $mensaje));
});

$app->get('/filtrossenador/{sec}', function ($sec) use ($app) {
    if (!validar('admin')) {
        return $app->redirect('login');
    }
    require 'Filtros.php';
    $mensaje = "";
    $filtros = new Filtros('S', $sec, 0, '', $app);
    $resultado = $filtros->getFiltros();
    return $app['twig']->render('filtrossenador.html.twig', array('disponibles' => $resultado['disponibles'], 'filtros' => $resultado['filtros'], 'mensaje' => $mensaje));
})->bind('filtrossenador');

$app->post('/filtro/{accion}', function ($accion) use ($app) {
    if (!validar('admin')) {
        return $app->redirect('login');
    }
    require 'Filtros.php';
    Filtros::$accion($_POST['datos'], $app);
    return json_encode("OK");
})->bind('filtro');

/* * ************** M E S A S *********************************** */

$app->get('/mesa/{nro}', function ($nro) use ($app) {
        if (!validar('admin')) {
        return $app->redirect('login');
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
        return $app->redirect('login');
    }
    require 'Mesa.php';
    $testigos=Mesa::testigos($app);
    return $app['twig']->render('mesastestigo.html.twig', array('testigos' => $testigos));
})->bind('mesastestigo');

$app->get('/testigo/{nro}/{accion}', function ($nro,$accion) use ($app) {
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
    $mesa->getMascara();
    $filtroscircuitos = Filtros::getFiltrosCircuito($mesa->getSec(), $mesa->getCirnro(), $mesa->getCirlet(), $app);
    return $app['twig']->render('mesa_carga.html.twig', array('mesa' => $mesa, 'filtros' => $filtroscircuitos, 'configuracion' => new Configuracion($app)));
})->bind('mesacarga');


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

function validar($rol) {
    if (!isset($_SESSION['usuario']))
        return false;
    if (!isset($_SESSION[$rol]))
        return false;
    if ($_SESSION[$rol] == 0)
        return false;
    return true;
}
