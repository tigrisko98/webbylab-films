<?php

spl_autoload_register(function ($class_name) {
    $array_paths = [
        '/models/',
        '/components/',
        '/controllers/'
    ];

    foreach ($array_paths as $path){
        $path = ROOT. $path . $class_name . '.php';
        if(is_file($path)){
            include_once $path;
        }
    }
});