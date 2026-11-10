<?php
class Router
{
    private $routes = [];

    public function get($route, $controllerAction)
    {
        $this->routes['GET'][$route] = $controllerAction;
    }

    public function post($route, $controllerAction)
    {
        $this->routes['POST'][$route] = $controllerAction;
    }

    public function dispatch($uri)
    {
        $method = $_SERVER['REQUEST_METHOD'];

        // Parse the path component of the requested URI
        $uri = parse_url($uri, PHP_URL_PATH);

        // Clean up project base directory dynamically
        $scriptName = $_SERVER['SCRIPT_NAME']; // e.g. /Fonseka-Motors/public/index.php
        $baseDir = dirname(dirname($scriptName)); // e.g. /Fonseka-Motors

        if ($baseDir !== '/' && $baseDir !== '\\') {
            $uri = str_replace($baseDir, '', $uri);
        }

        // Remove /public if it leaks into the URI
        $uri = str_replace('/public', '', $uri);

        // Normalize trailing slashes or empty paths to '/'
        $uri = '/' . trim($uri, '/');

        if (isset($this->routes[$method][$uri])) {
            list($controller, $action) = explode('@', $this->routes[$method][$uri]);
            $controllerFile = __DIR__ . '/../controllers/' . $controller . '.php';

            if (file_exists($controllerFile)) {
                require_once $controllerFile;
                $ctrlInstance = new $controller();
                $ctrlInstance->$action();
            } else {
                http_response_code(500);
                echo "<h1>500 Internal Error</h1><p>Controller file <b>{$controller}.php</b> not found in controllers directory.</p>";
            }
        } else {
            // Fallback: If no route matches, show helpful debugging info
            http_response_code(404);
            echo "<div style='font-family:sans-serif; padding:20px; background:#1e293b; color:#f8fafc; border-radius:8px; max-width:600px; margin:40px auto;'>";
            echo "<h2 style='color:#f43f5e;'>404 Route Not Found</h2>";
            echo "<p>The router could not match the requested path:</p>";
            echo "<code style='background:#0f172a; padding:6px 12px; display:block; color:#38bdf8; margin:10px 0; border-radius:4px;'>" . htmlspecialchars($uri) . "</code>";
            echo "<p>Make sure your route is defined in <code>routes/web.php</code>.</p>";
            echo "</div>";
        }
    }
}
