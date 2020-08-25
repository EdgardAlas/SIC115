<?php

/**
 * Simple Session Manager
 * @license    http://www.opensource.org/licenses/mit-license.php The MIT License
*/

class Session
{
    public function __construct(){
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    /* Set a session variable by key and value. */
    public function set($key, $value){
        if (session_status() !== PHP_SESSION_NONE) {
            $_SESSION[$key] = $value;
        }
        
    }

    /* Return a session value by key. */
    public function get($key){
        if(isset($_SESSION[$key])){
            return $_SESSION[$key];
        }
        return null;
    }   

    /* Destroy de session */
    public function destroy(){
        session_destroy();
    }
}


