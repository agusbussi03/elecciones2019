<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

//Request::setTrustedProxies(array('127.0.0.1'));

$app->get('/', function () use ($app) {
            //$zonas = $app['db']->fetchAll('SELECT * FROM zonas');
            //print_r($zonas);
            return $app['twig']->render('index.html.twig', array());
        })
        ->bind('homepage')
;

$app->get('/circuitos', function () use ($app) {
    $circuitos = $app['db']->fetchAll('SELECT * FROM circuitos');
    return $app['twig']->render('circuitos.html.twig', array('circuitos' => $circuitos));
})->bind('circuitos');

$app->get('/secciones', function () use ($app) {
    $secciones = $app['db']->fetchAll('SELECT * FROM circuitos');
    return $app['twig']->render('secciones.html.twig', array('secciones' => $secciones));
})->bind('secciones');

$app->get('/provincia', function () use ($app) {
    $provincia = $app['db']->fetchAll('SELECT * FROM circuitos');
    return $app['twig']->render('provincia.html.twig', array('provincia' => $provincia));
})->bind('provincia');

$app->get('/filtrosgobernador', function () use ($app) {
    require 'Filtros.php';
    $mensaje = "";
    $filtros = new Filtros('G',0,0,'', $app);
    $resultado = $filtros->getFiltros();
    return $app['twig']->render('filtrosgobernador.html.twig', array('disponibles' => $resultado['disponibles'], 'filtros' => $resultado['filtros'], 'mensaje' => $mensaje));
})->bind('filtrosgobernador');

$app->post('/filtrosgobernador', function () use ($app) {
    require 'Filtros.php';
    $filtros = new Filtros('G',0,0,'', $app);
    $mensaje = $filtros->procesar($_POST);
    $resultado = $filtros->getFiltros();
    return $app['twig']->render('filtrosgobernador.html.twig', array('disponibles' => $resultado['disponibles'], 'filtros' => $resultado['filtros'], 'mensaje' => $mensaje));
});

$app->get('/filtrossenador/{sec}', function ($sec) use ($app) {
    require 'Filtros.php';
    $mensaje = "";
    $filtros = new Filtros('S',$sec,0,'', $app);
    $resultado = $filtros->getFiltros();
    return $app['twig']->render('filtrossenador.html.twig', array('disponibles' => $resultado['disponibles'], 'filtros' => $resultado['filtros'], 'mensaje' => $mensaje));
})->bind('filtrossenador');

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
