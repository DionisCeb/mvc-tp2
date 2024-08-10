<?php
namespace App\Routes;

class Route {
    private static $routes = [];

    public static function get($url, $controller){
        self::$routes[] = ['url'=>$url, 'controller' => $controller, 'method' => 'GET'];
    }

    public static function post($url, $controller){
        self::$routes[] = ['url'=>$url, 'controller' => $controller, 'method' => 'POST'];
    }

    public static function dispatch(){
       $url = $_SERVER['REQUEST_URI'];
       $urlSegments = explode('?', $url);
       $urlPath = rtrim($urlSegments[0], '/');
       $method = $_SERVER['REQUEST_METHOD'];

       foreach(self::$routes as $route){
            if(BASE.$route['url'] == $urlPath && $route['method']== $method){
                $controllerSegments = explode('@',$route['controller']);
                $controllerName = "App\\Controllers\\".$controllerSegments[0];
                $methodName = $controllerSegments[1];

                $controllerInstance = new $controllerName();
                if($method == "GET"){
                    $controllerInstance->$methodName(isset($urlSegments[1]) ? parse_str($urlSegments[1], $queryParams) : []);
                } elseif($method == "POST"){
                    $controllerInstance->$methodName($_POST, isset($urlSegments[1]) ? parse_str($urlSegments[1], $queryParams) : []);
                }
                return;
            }
       }
       http_response_code(404);
       echo "404 not found";
    }
}
?>
