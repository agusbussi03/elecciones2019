<?php

use Silex\Application;
use Silex\Provider\AssetServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;

$app = new Application();
$app->register(new ServiceControllerServiceProvider());
$app->register(new AssetServiceProvider());
$app->register(new TwigServiceProvider());
$app->register(new HttpFragmentServiceProvider());

$datos_conexion=array (
            'driver'    => 'pdo_mysql',
            'host'      => 'localhost',
            'dbname'    => 'elecciones',
            'user'      => 'root',
            'password'  => 'root',
            'charset'   => 'utf8mb4',
);
$app['datos_conexion']=$datos_conexion;

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => $datos_conexion));
session_start();
if (!isset($_SESSION['usuario'])){
        $_SESSION['usuario']="";
        $_SESSION['admin']=0;
        $_SESSION['carga']=0;
        $_SESSION['lectura']=0;
         $_SESSION['fiscal']=0;
}
    require 'Configuracion.php';

$app['twig'] = $app->extend('twig', function ($twig, $app) {
    // add custom globals, filters, tags, ...
    $twig->addGlobal('session', $_SESSION);
    $twig->addGlobal('config', new Configuracion($app));
   
    return $twig;
});

return $app;
