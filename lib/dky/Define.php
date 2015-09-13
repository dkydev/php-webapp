<?php
     
    define("DKY_PATH_ROOT", realpath(__DIR__ . "/../.."));
    define("DKY_PATH_LIB", DKY_PATH_ROOT . "/lib");
    define("DKY_PATH_COM", DKY_PATH_ROOT . "/com");
    define("DKY_PATH_VAR", DKY_PATH_ROOT . "/var");
    define("DKY_PATH_WWW", DKY_PATH_ROOT . "/www");
    define("WEB_ROOT", $_SERVER["SERVER_NAME"]);
    
    define("DKY_LOG_DEBUG",       "debug");
    define("DKY_LOG_WARNING",     "warning");
    define("DKY_LOG_INFO",        "info");
    define("DKY_LOG_ERROR",       "error");
    
    define("DKY_MSG_SUCCESS",      "success");
    define("DKY_MSG_WARNING",      "warning");
    define("DKY_MSG_INFO",         "info");
    define("DKY_MSG_ERROR",        "danger");
    
?>