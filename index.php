<?php
// Enable error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session
session_start();

// Get the URL from the .htaccess rewrite
$url = isset($_GET['url']) ? $_GET['url'] : '';
$url = rtrim($url, '/');
$url = filter_var($url, FILTER_SANITIZE_URL);

// Split URL into parts
$urlParts = $url ? explode('/', $url) : [];

// Default controller and action
$controllerName = !empty($urlParts[0]) ? ucfirst($urlParts[0]) . 'Controller' : 'ProductController';
$actionName = !empty($urlParts[1]) ? $urlParts[1] : 'index';
$param = !empty($urlParts[2]) ? $urlParts[2] : null;

// Define available controllers
$availableControllers = [
    'ProductController' => 'app/controllers/ProductController.php',
    'CategoryController' => 'app/controllers/CategoryController.php',
    'DefaultController' => 'app/controllers/DefaultController.php'
];

try {
    // Check if controller exists
    if (!array_key_exists($controllerName, $availableControllers)) {
        // Default to ProductController if controller not found
        $controllerName = 'ProductController';
    }
    
    // Include the controller file
    require_once $availableControllers[$controllerName];
    
    // Create controller instance
    $controller = new $controllerName();
    
    // Check if method exists in controller
    if (!method_exists($controller, $actionName)) {
        // Default to index method if action not found
        $actionName = 'index';
    }
    
    // Call the controller method with parameter if exists
    if ($param !== null) {
        $controller->$actionName($param);
    } else {
        $controller->$actionName();
    }
    
} catch (Exception $e) {
    // Error handling
    echo '<div class="alert alert-danger">Lỗi: ' . htmlspecialchars($e->getMessage()) . '</div>';
    
    // Try to load default page
    try {
        require_once 'app/controllers/ProductController.php';
        $defaultController = new ProductController();
        $defaultController->index();
    } catch (Exception $fallbackError) {
        echo '<div class="alert alert-danger">Không thể tải trang: ' . htmlspecialchars($fallbackError->getMessage()) . '</div>';
    }
}

// Function to handle 404 errors
function show404() {
    http_response_code(404);
    echo '<!DOCTYPE html>
    <html lang="vi">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>404 - Không tìm thấy trang</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6 text-center">
                    <h1 class="display-4">404</h1>
                    <h2>Không tìm thấy trang</h2>
                    <p class="lead">Trang bạn đang tìm kiếm không tồn tại.</p>
                    <a href="/webbanhang/" class="btn btn-primary">Về trang chủ</a>
                </div>
            </div>
        </div>
    </body>
    </html>';
    exit;
}

// Auto-load function for future use
function autoload($className) {
    $directories = [
        'app/controllers/',
        'app/models/',
        'app/config/'
    ];
    
    foreach ($directories as $directory) {
        $file = $directory . $className . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
}

// Register autoload function
spl_autoload_register('autoload');
?>