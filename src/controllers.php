<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

//Request::setTrustedProxies(array('127.0.0.1'));

$app->get('/', function () use ($app) {
    require_once'Estado.php';
    if (!validar('admin')) {
        return $app->redirect('login');
    }
    return $app['twig']->render('index.html.twig', array('estado' => Estado::getEstado($app)));
    //  return $app->redirect($app['url_generator']->generate(''));
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
    require_once'Usuarios.php';
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
        $_SESSION['provincia'] = $usuario->getProvincia();
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
    require_once'Mesa.php';
    require_once'Configuracion.php';
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

$app->get('/mesastestigoprovincia/{provincia}', function ($provincia) use ($app) {
    if (!validar('admin')) {
        return $app->redirect($app['url_generator']->generate('login'));
    }
    require_once'Mesa.php';
    $testigos = Mesa::testigosprovincia($provincia, $app);
    $provincia = $app['db']->fetchAssoc("SELECT * FROM provincia where id=$provincia");
    return $app['twig']->render('mesastestigoprovincia.html.twig', array('provincia' => $provincia, 'testigos' => $testigos));
})->bind('mesastestigoprovincia');

$app->get('/testigo_accion/{circuito}', function ($circuito) use ($app) {
    require_once'Mesa.php';

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

$app->post('/mesacargo/{accion}', function ($accion) use ($app) {
    if (!validar('admin')) {
        return $app->redirect('login');
    }
   
    Mesa::$accion($_POST['datos'], $app);
    return json_encode("OK");
})->bind('mesacargo');



$app->get('/mesacarga/{nro}', function ($nro) use ($app) {
    require_once'Mesa.php';
    require_once 'Configuracion.php';
    $mensaje = "";
    $mesa = new Mesa($nro, $app);
    $categoria = 'G';
    if (isset($_GET['categoria']))
        $categoria = $_GET['categoria'];
    $mascara = $mesa->getMascara();
    return $app['twig']->render('mesa_carga.html.twig', array('mesa' => $mesa, 'mascara' => $mascara, 'categoria' => $categoria, 'configuracion' => new Configuracion($app)));
})->bind('mesacarga');

$app->post('/mesacarga/{nro}', function ($nro) use ($app) {
    require_once'Mesa.php';
    require_once 'Configuracion.php';
    $mensaje = "";
    $mesa = new Mesa($nro, $app);
    $mesa->actualiza($_POST);
    $categorias = array();
    return $app->redirect($app['url_generator']->generate('mesacarga_elige'));
})->bind('mesacarga_p');

$app->get('/mesacarga_elige', function () use ($app) {
    require_once 'Configuracion.php';
    $mensaje = "";
    $categorias = array();
    return $app['twig']->render('mesa_carga_elige.html.twig', array('configuracion' => new Configuracion($app), 'mensaje' => $mensaje, 'categorias' => $categorias));
})->bind('mesacarga_elige');

$app->post('/mesacarga_elige', function () use ($app) {
    require_once'Mesa.php';
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
    require_once'MesaNacional.php';
    require_once 'Configuracion.php';
    $mensaje = "";
    $mesa = new MesaNacional($nro, $app);
    $mesa->sumavotos();
    $votos = $mesa->votos();
    $mascara = $mesa->getMascara();
    //print_r($mascara);
    //print_r($votos);
    return $app['twig']->render('mesanacional.html.twig', array('mesa' => $mesa, 'votos' => $votos, 'mascara' => $mascara, 'configuracion' => new Configuracion($app)));
})->bind('mesanacional');

$app->get('/mesanacionalcarga/{nro}', function ($nro) use ($app) {
    require_once'MesaNacional.php';
//require_once'Filtros.php';
    require_once 'Configuracion.php';
    $mensaje = "";
    $mesa = new MesaNacional($nro, $app);
    $categoria = 'D';
    if (isset($_GET['categoria']))
        $categoria = $_GET['categoria'];
    $mascara = $mesa->getMascara();
    return $app['twig']->render('mesanacional_carga.html.twig', array('mascara' => $mascara, 'mesa' => $mesa, 'categoria' => $categoria, 'configuracion' => new Configuracion($app)));
})->bind('mesanacionalcarga');



$app->post('/mesanacionalcarga/{nro}', function ($nro) use ($app) {
    require_once'MesaNacional.php';
    require_once 'Configuracion.php';
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
    require_once'MesaNacional.php';

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
    require_once'Configuracion.php';
    $mensaje = '';
    $configuracion = new Configuracion($app);
    $directorio = "upload";
    $gestor_dir = opendir($directorio);
    $ficheros=array();
    while (false !== ($nombre_fichero = readdir($gestor_dir))) {
        if (strpos($nombre_fichero, ".gz") > 0)
            $ficheros[] = $nombre_fichero;
    }
    return $app['twig']->render('configuracion.html.twig', array('ficheros' => $ficheros, 'configuracion' => $configuracion, 'mensaje' => $mensaje));
})->bind('configuracion');

$app->post('/configuracion', function () use ($app) {
    if (!validar('admin')) {
        return $app->redirect('login');
    }
    require_once'Configuracion.php';
    $mensaje = 'Datos almacenados';
    $configuracion = new Configuracion($app);
    $configuracion->grabar($_POST);
    $directorio = "upload";
    $gestor_dir = opendir($directorio);
        $ficheros=array();
    while (false !== ($nombre_fichero = readdir($gestor_dir))) {
        if (strpos($nombre_fichero, ".gz") > 0)
            $ficheros[] = $nombre_fichero;
    }
    return $app['twig']->render('configuracion.html.twig', array('ficheros' => $ficheros, 'configuracion' => $configuracion, 'mensaje' => $mensaje));
});

$app->get('/backup', function () use ($app) {
    $backup_file = "upload/" . $_GET['archivo'] . '.gz';
    $backup_file = str_replace(" ", "_", $backup_file);
    $command = "mysqldump --opt -h " . $app['datos_conexion']['host'] . " -u " . $app['datos_conexion']['user'] . " -p" .
            $app['datos_conexion']['password'] . "  " . $app['datos_conexion']['dbname'] . " | gzip > " . $backup_file;
    system($command);
    require_once'Configuracion.php';
    $mensaje = 'Backup enviado';
    $configuracion = new Configuracion($app);
    $directorio = "upload";
        $ficheros=array();
    $gestor_dir = opendir($directorio);
    while (false !== ($nombre_fichero = readdir($gestor_dir))) {
        if (strpos($nombre_fichero, ".gz") > 0)
            $ficheros[] = $nombre_fichero;
    }
    return $app['twig']->render('configuracion.html.twig', array('ficheros' => $ficheros, 'configuracion' => $configuracion, 'mensaje' => $mensaje));
})->bind('backup');

$app->get('/restore', function () use ($app) {
    $backup_file = "upload/" . $_GET['archivo'];
    if (!file_exists($backup_file))
        die("ERROR");

    $command = "mysqldump -u" . $app['datos_conexion']['user'] . " -p" . $app['datos_conexion']['password'] . " --add-drop-table --no-data " .
            $app['datos_conexion']['dbname'] . " | grep -e '^DROP \| FOREIGN_KEY_CHECKS' | " .
            "mysql -u" . $app['datos_conexion']['user'] . " -p" . $app['datos_conexion']['password'] . " " . $app['datos_conexion']['dbname'];
    system($command);

    $command = "zcat $backup_file | mysql -u" . $app['datos_conexion']['user'] . " -p" . $app['datos_conexion']['password'] . " " .
            $app['datos_conexion']['dbname'];
    system($command);
    require_once'Configuracion.php';
    $mensaje = 'Backup enviado';
    $configuracion = new Configuracion($app);
    $directorio = "upload";
        $ficheros=array();
    $gestor_dir = opendir($directorio);
    while (false !== ($nombre_fichero = readdir($gestor_dir))) {
        if (strpos($nombre_fichero, ".gz") > 0)
            $ficheros[] = $nombre_fichero;
    }
    return $app['twig']->render('configuracion.html.twig', array('ficheros' => $ficheros, 'configuracion' => $configuracion, 'mensaje' => $mensaje));
})->bind('restore');


/* * ************** U S U A R I O S *********************************** */

$app->get('/usuarios', function () use ($app) {
    if (!validar('admin')) {
        return $app->redirect('login');
    }
    require_once'Usuarios.php';
    $mensaje = '';
    $usuarios = Usuarios::getAll($app);
    return $app['twig']->render('usuarios.html.twig', array('usuarios' => $usuarios, 'mensaje' => $mensaje));
})->bind('usuarios');

$app->post('/usuario', function () use ($app) {
    if (!validar('admin')) {
        return $app->redirect('login');
    }
    require_once'Configuracion.php';
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
