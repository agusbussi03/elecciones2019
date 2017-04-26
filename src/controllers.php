<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

//Request::setTrustedProxies(array('127.0.0.1'));

$app->get('/', function () use ($app) {
    $zonas=$app['db']->fetchAll('SELECT * FROM zonas');
    require 'Mesa.php';
    $mesa=new Elecciones\Common\Mesa('1');
    echo $mesa->getId();
    return $app['twig']->render('index.html.twig', array());
})
->bind('homepage')
;

$app->get('/flot', function () use ($app) {
    $name = 'morris-data.js';
    $fp = fopen($name, 'r');
    header("Content-Type: application/javascript");
    header("Content-Length: " . filesize($name));
    fpassthru($fp);
    exit;
});

$app->error(function (\Exception $e, Request $request, $code) use ($app) {
    if ($app['debug']) {
        return;
    }

    // 404.html, or 40x.html, or 4xx.html, or error.html
    $templates = array(
        'errors/'.$code.'.html.twig',
        'errors/'.substr($code, 0, 2).'x.html.twig',
        'errors/'.substr($code, 0, 1).'xx.html.twig',
        'errors/default.html.twig',
    );

    return new Response($app['twig']->resolveTemplate($templates)->render(array('code' => $code)), $code);
});
