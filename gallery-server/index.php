<?php
include_once getPath("responses");

// Define your base directory 
$base_dir = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// get request method
$request_method = $_SERVER['REQUEST_METHOD'];


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
    '/users' => ['controller' => 'UserController', 'method' => 'getAllUsers', 'allowed_methods' => ['GET']],
    '/login' => ['controller' => 'UserController', 'method' => 'login', 'allowed_methods' => ['POST']],
    '/signup' => ['controller' => 'UserController', 'method' => 'signup', 'allowed_methods' => ['POST']],
    '/delete-account' => ['controller' => 'UserController', 'method' => 'deleteAccount', 'allowed_methods' => ['DELETE']],
    '/update-account' => ['controller' => 'UserController', 'method' => 'updateAccount', 'allowed_methods' => ['PUT', 'PATCH', 'POST']],

    // photo APIs
    '/get-photos' => ['controller' => 'PhotoController', 'method' => 'getPhotos', 'allowed_methods' => ['GET']],
    '/upload-photo' => ['controller' => 'PhotoController', 'method' => 'uploadPhoto', 'allowed_methods' => ['POST']],
    '/update-photo' => ['controller' => 'PhotoController', 'method' => 'updatePhoto', 'allowed_methods' => ['PUT', 'PATCH']],
    '/delete-photo' => ['controller' => 'PhotoController', 'method' => 'deletePhoto', 'allowed_methods' => ['DELETE']],

    // tag APIs
    '/get-tags' => ['controller' => 'TagController', 'method' => 'getTags', 'allowed_methods' => ['GET']],
    '/create-tag' => ['controller' => 'TagController', 'method' => 'createTag', 'allowed_methods' => ['POST']],
    '/update-tag' => ['controller' => 'TagController', 'method' => 'updateTag', 'allowed_methods' => ['PUT', 'PATCH']],
    '/delete-tag' => ['controller' => 'TagController', 'method' => 'deleteTag', 'allowed_methods' => ['DELETE']],
];



if (!isset($apis[$request])) {
    http_response_code(BAD_REQUEST);
    echo "404 Not Found";
    exit();
}

$controllerName = $apis[$request]['controller'];
$method = $apis[$request]['method'];
$allowedMethods = $apis[$request]['allowed_methods'];

// Validate request method
if (!in_array($request_method, $allowedMethods)) {
    http_response_code(METHOD_NOT_ALLOWED); // 405 Method Not Allowed
    echo json_encode(["message" => "Method Not Allowed. Allowed methods: " . implode(", ", $allowedMethods)]);
    exit();
}

// get controller
require_once getPath($controllerName);

$controller = new $controllerName();
if (method_exists($controller, $method)) {
    $data = json_decode(file_get_contents("php://input"), true);
    $controller->$method($data);
} else {
    echo "Error: Method {$method} not found in {$controllerName}.";
}
