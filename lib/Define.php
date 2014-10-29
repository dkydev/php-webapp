<?php
     
    define("PATH_ROOT", realpath(__DIR__ . "/.."));
    define("PATH_LIB", PATH_ROOT . "/lib");
    define("PATH_COM", PATH_ROOT . "/com");
    define("PATH_VAR", PATH_ROOT . "/var");
    define("PATH_WWW", PATH_ROOT . "/www");
    define("WEB_ROOT", $_SERVER["SERVER_NAME"]);
    
    define("LOG_TYPE_DEBUG",       "debug");
    define("LOG_TYPE_WARNING",     "warning");
    define("LOG_TYPE_INFO",        "info");
    define("LOG_TYPE_ERROR",       "error");
    
    define("MSG_TYPE_SUCCESS",      "success");
    define("MSG_TYPE_WARNING",      "warning");
    define("MSG_TYPE_INFO",         "info");
    define("MSG_TYPE_ERROR",        "danger");
    
?>