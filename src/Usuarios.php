<?php

/**
 * Description of Filtros
 *
 * @author pablo
 */
class Usuarios {

    private $id = '';
    private $usuario = 0;
    private $password = '';
    private $nombreyapellido = 0;
    private $admin = 0;
    private $carga = 0;
    private $lectura = 0;
    private $provincia = 0;
    private $app;

    function __construct($id,$app) {
        $this->app = $app;
        $this->id=$id;
        
    }

  function actualizar($datos) {
       
        $sql = "UPDATE usuarios SET nombreyapellido=?,admin=?,carga=?,lectura=? where id=?;";
  $this->app['db']->executeQuery($sql, array($datos['nombreyapellido'], (int) $datos['admin'],
      (int) $datos['carga'], (int) $datos['lectura'] ,(int) $this->id));
        return "Datos modificados";
    }

    static function getAll($app) {
        return $app['db']->fetchAll("SELECT * FROM usuarios");
    }

    function getByUsername($usuario) {
        $sth = $this->app['db']->executeQuery('SELECT * FROM usuarios WHERE usuario = ?', array($usuario));
        $user = $sth->fetch();
        if (!$user)
            return "Usuario inexistente";
        $this->password = $user['password'];
        $this->usuario = $user['usuario'];
        $this->nombreyapellido = $user['nombreyapellido'];
        $this->admin = $user['admin'];
        $this->lectura = $user['lectura'];
        $this->carga = $user['carga'];
        $this->provincia = $user['provincia_id'];
        return "";
    }

    function getId() {
        return $this->id;
    }

    function getUsuario() {
        return $this->usuario;
    }

    function getNombreyapellido() {
        return $this->nombreyapellido;
    }

    function getAdmin() {
        return $this->admin;
    }

    function getCarga() {
        return $this->carga;
    }

    function getLectura() {
        return $this->lectura;
    }

    function getApp() {
        return $this->app;
    }

    function getPassword() {
        return $this->password;
    }
    function getProvincia() {
        return $this->provincia;
    }


}
