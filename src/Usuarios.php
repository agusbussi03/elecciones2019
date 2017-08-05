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
        private $fiscal = 0;
    private $provincia = 0;
    private $seccion = 0;
    private $circuito = 0;
    private $seccional = 0;
    private $mesas = array();
    private $app;

    function __construct($id, $app) {
        $this->app = $app;
        $this->id = $id;
    }

    function actualizar($datos) {

        $sql = "UPDATE usuarios SET nombreyapellido=?,admin=?,carga=?,lectura=?,fiscal=?,provincia_id=? where id=?;";
        $this->app['db']->executeQuery($sql, array($datos['nombreyapellido'], (int) $datos['admin'],
            (int) $datos['carga'], (int) $datos['lectura'], (int) $datos['fiscal'], (int) $datos['provincia'], (int) $this->id));

        if ($datos['seccion'] == 0) {
            $sql = "UPDATE usuarios SET seccion_id=NULL where id=?;";
            $this->app['db']->executeQuery($sql, array((int) $this->id));
        } else {
            $sql = "UPDATE usuarios SET seccion_id=? where id=?;";
            $this->app['db']->executeQuery($sql, array((int) $datos['seccion'], (int) $this->id));
        }
        if ($datos['ciudad'] == 0) {
            $sql = "UPDATE usuarios SET circuito_id=NULL where id=?;";
            $this->app['db']->executeQuery($sql, array((int) $this->id));
        } else {
            $sql = "UPDATE usuarios SET circuito_id=? where id=?;";
            $this->app['db']->executeQuery($sql, array((int) $datos['ciudad'], (int) $this->id));
        }
        if ($datos['seccional'] == 0) {
            $sql = "UPDATE usuarios SET seccional_id=NULL where id=?;";
            $this->app['db']->executeQuery($sql, array((int) $this->id));
        } else {
            $sql = "UPDATE usuarios SET seccional_id=? where id=?;";
            $this->app['db']->executeQuery($sql, array((int) $datos['seccional'], (int) $this->id));
        }
        if ($datos['password'] != "") {
            $sql = "UPDATE usuarios SET password=md5(?) where id=?;";
            $this->app['db']->executeQuery($sql, array($datos['password'], (int) $this->id));
        }

        return "Datos modificados";
    }

    static function getAll($app) {
        return $app['db']->fetchAll("SELECT * FROM usuarios");
    }

    static function quitarmesausuario($id, $app) {
        $sql = "DELETE FROM mesa_usuario where id=?;";
        $app['db']->executeQuery($sql, array((int) $id));
    }

    static function agregarmesausuario($usuario, $mesa, $app) {
        $sql = "INSERT INTO mesa_usuario VALUES (NULL,?,?);";
        $app['db']->executeQuery($sql, array((int) $usuario, (int) $mesa));
    }

    static function crearusuario($usuario, $nombre, $password, $app) {
        $sql = "INSERT INTO usuarios (id,usuario,nombreyapellido,password,provincia_id) VALUES (NULL,?,?,md5(?),1);";
        $app['db']->executeQuery($sql, array($usuario, $nombre, $password));
    }

    function getByUsername($usuario) {
        $sth = $this->app['db']->executeQuery('SELECT * FROM usuarios WHERE usuario = ?', array($usuario));
        $user = $sth->fetch();
        if (!$user)
            return "Usuario inexistente";
        $this->id=$user['id'];
        $this->password = $user['password'];
        $this->usuario = $user['usuario'];
        $this->nombreyapellido = $user['nombreyapellido'];
        $this->admin = $user['admin'];
        $this->lectura = $user['lectura'];
        $this->fiscal = $user['fiscal'];
        $this->carga = $user['carga'];
        $this->provincia = $user['provincia_id'];
        $this->seccion = $user['seccion_id'];
        $this->circuito = $user['circuito_id'];
        $this->seccional = $user['seccional_id'];
        $resultado=$this->app['db']->fetchAll("SELECT * from mesa_usuario where usuario_id=" . $this->id);
        $this->mesas = array();
        foreach ($resultado as $item){
            $this->mesas[]=$item['mesa_id'];
        }
        return "";
    }

    function mesapermitida($mesa) {
        if ($this->admin == 1)
            return true;
        if ($this->carga == 0)
            return false;
        if ($this->seccion == '' && $this->circuito == "" && $this->seccional == "" && count($this->mesas) == 0)
            return true;
        if ($this->seccion != '' && $this->seccion == $mesa->getSeccion())
            return true;
        if ($this->circuito != '' && $this->circuito == $mesa->getCircuito())
            return true;
        if ($this->seccional != '' && $this->seccional == $mesa->getSeccional())
            return true;
       
        if (count($this->mesas )> 0) {
            return in_array($mesa->getId(), $this->mesas);
        }
        return false;
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
    
     function getFiscal() {
        return $this->fiscal;
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
