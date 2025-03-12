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
    // user APIs
    '/users' => ['controller' => 'UserController', 'method' => 'getAllUsers'],
    '/login' => ['controller' => 'UserController', 'method' => 'login'],
    '/signup' => ['controller' => 'UserController', 'method' => 'signup'],
    '/delete-account' => ['controller' => 'UserController', 'method' => 'deleteAccount'],
    '/update-account' => ['controller' => 'UserController', 'method' => 'updateAccount'],

    // photo APIs
    '/get-photos' => ['controller' => 'PhotoController', 'method' => 'getPhotos'],
    '/upload-photo' => ['controller' => 'PhotoController', 'method' => 'uploadPhoto'],
    '/update-photo' => ['controller' => 'PhotoController', 'method' => 'updatePhoto'],
    '/delete-photo' => ['controller' => 'PhotoController', 'method' => 'deletePhoto'],

    // tag APIs
    '/get-tags' => ['controller' => 'TagController', 'method' => 'getTags'],
    '/create-tag' => ['controller' => 'TagController', 'method' => 'createTag'],
    '/update-tag' => ['controller' => 'TagController', 'method' => 'updateTag'],
    '/delete-tag' => ['controller' => 'TagController', 'method' => 'deleteTag'],
];

if (isset($apis[$request])) {
    $controllerName = $apis[$request]['controller'];
    $method = $apis[$request]['method'];
    require_once getPath($controllerName);

    $controller = new $controllerName();
    if (method_exists($controller, $method)) {
        $controller->$method();
    } else {
        echo "Error: Method {$method} not found in {$controllerName}.";
    }
} else {
    echo "404 Not Found";
}