<?php

// Define your base directory 
$base_dir = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Remove the base directory from the request if present
if (strpos($request, $base_dir) === 0) {
    $request = substr($request, strlen($base_dir));
}

// Ensure the request is at least '/'
if ($request == '') {
    $request = '/';
}

$apis = [
    // user apis
    '/users' => ['controller' => 'UserController', 'method' => 'getAll'],
    '/login' => ['controller' => 'UserController', 'method' => 'getAll'],
    '/signup' => ['controller' => 'UserController', 'method' => 'getAll'],
    '/delete-account' => ['controller' => 'UserController', 'method' => 'getAll'],
    '/update-account' => ['controller' => 'UserController', 'method' => 'getAll'],
    
    // photo apis
    '/get-photos' => ['controller' => 'PhotoController', 'method' => 'getAll'],
    '/upload-photo' => ['controller' => 'PhotoController', 'method' => 'getAll'],
    '/update-photo' => ['controller' => 'PhotoController', 'method' => 'getAll'],
    '/delete-photo' => ['controller' => 'PhotoController', 'method' => 'getAll'],

    // tag apis
    '/get-tags' => ['controller' => 'PhotoController', 'method' => 'getAll'],
    '/create-tag' => ['controller' => 'PhotoController', 'method' => 'getAll'],
    '/update-tag' => ['controller' => 'PhotoController', 'method' => 'getAll'],
    '/delete-tag' => ['controller' => 'PhotoController', 'method' => 'getAll'],
];

if (isset($apis[$request])) {
    $controllerName = $apis[$request]['controller'];
    $method = $apis[$request]['method'];
    require_once "apis/v1/{$controllerName}.php";

    $controller = new $controllerName();
    if (method_exists($controller, $method)) {
        $controller->$method();
    } else {
        echo "Error: Method {$method} not found in {$controllerName}.";
    }
} else {
    echo "404 Not Found";
}