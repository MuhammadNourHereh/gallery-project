<?php
include_once getPath("responses");
include_once getPath("corsHeaders");
include_once getPath("routes");

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

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
