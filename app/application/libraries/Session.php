<?php

/**
 * Session class
 *
 * Manejador de sesiones.Crea sesiones cuando no existe, sets y gets de valores, correctos cierres de sesión
 * Verifica si el usuario ingresado existe o no en sesión.
 */
class Session {
    /**
     * starts the session
     */
    public static function init()
    {
        // if no session exist, start the session
        if (!self::isSession()){
            return self::createSession();
        }
        else{
            return self::createSession();
        }
    }

    /**
     * Valida si el key pertenece a una sesion registgrada por una llave valida
     * por el sistema
     *
     * @return bool user's login status
     */
    public static function isSession()
    {
        return (session_id() ? true : false);
    }

    /**
     * Valida si el key pertenece a una sesion registgrada por una llave valida
     * por el sistema
     *
     * @return bool user's login status
     */
    public static function createSession()
    {
        return session_start();
    }

    /**
     * Valida si el key pertenece a una sesion registgrada por una llave valida
     * por el sistema
     *
     * @return string key para registro de sesión
     */
    public static function hash($key)
    {
        return md5($key);
    }

    /**
     * Set de valor especifico a una variable del arraglo o nuevos
     *
     * @param mixed $key key
     * @param mixed $value value
     */
    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * gets/returns Retorna los valores especificos de un arreglo llave valor
     *
     * @param mixed $key 
     * @return mixed 
     */
    public static function get($key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
    }

    /**
     * Agrega valores en arreglos de llave valor.
     *
     * @param mixed $key
     * @param mixed $value
     */
    public static function add($key, $value)
    {
        $_SESSION[$key][] = $value;
    }

    /**
     * Elimina un objeto de sesión
     */
    public static function destroy()
    {
        session_destroy();
    }

    /**
     * Verifica si el usuario se encuentra en una sesión activa
     *
     * @return bool user's login status
     */
    public static function userIsLoggedIn()
    {
        return (Session::get('user_logged_in') ? true : false);
    }

    

}