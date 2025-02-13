<?php

function autoload($class)
{
    $path = $class . ".php";
    if (file_exists($path)) {
        include_once ($path);
    }
}

spl_autoload_register("autoload");
