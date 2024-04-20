<?php

// Set CORS headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

try {
    require_once("todo.controller.php");

    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $path = explode('/', $uri);
    $requestType = $_SERVER['REQUEST_METHOD'];
    $body = file_get_contents('php://input');
    $pathCount = count($path);

    $controller = new TodoController();


    switch ($requestType) {
        case 'GET':
            if ($path[$pathCount - 2] == 'todo' && isset($path[$pathCount - 1]) && strlen($path[$pathCount - 1])) {
                $id = $path[$pathCount - 1];
                $todo = $controller->load($id);

                if ($todo) {
                    http_response_code(200);
                    die(json_encode($todo));
                } else {
                    http_response_code(404);
                    die();
                }
            } else {
                $todos = $controller->loadAll();
                http_response_code(200);
                die(json_encode($todos));
            }
            break;
        case 'POST':
            $data = json_decode($body, true);
            if ($data === null) {
                http_response_code(400);
                echo json_encode(['error' => 'Invalid JSON']);
                break;
            }
            $todo = new Todo(
                isset($data['id']) ? $data['id'] : '',
                isset($data['title']) ? $data['title'] : '',
                isset($data['description']) ? $data['description'] : '',
                isset($data['done']) ? $data['done'] : false
            );
            $success = $controller->create($todo);
            if ($success) {
                http_response_code(201);
                echo json_encode(['message' => 'New TODO item created']);
                die();
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Failed to create new TODO item']);
            }
            break;
        case 'PUT':
            //implement your code here
            break;
        case 'DELETE':
            //implement your code here
            break;
        default:
            http_response_code(501);
            die();
            break;
    }
} catch (Throwable $e) {
    error_log($e->getMessage());
    http_response_code(500);
    die();
}

