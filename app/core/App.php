<?php

class App
{
    protected string $controller = 'HomeController';
    protected string $method = 'index';
    protected array $params = [];

    public function __construct()
    {
        $routes = $this->routes();
        $url = trim($_GET['url'] ?? '', '/');
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $routeKey = $requestMethod . ' ' . ($url === '' ? '/' : $url);

        $matched = $routes[$routeKey] ?? null;
        $params = [];

        if ($matched === null) {
            foreach ($routes as $pattern => $target) {
                [$verb, $path] = explode(' ', $pattern, 2);
                if ($verb !== $requestMethod || !str_contains($path, '{')) {
                    continue;
                }

                $regex = '#^' . preg_replace('#\{[a-zA-Z_]+\}#', '([^/]+)', $path) . '$#';
                if (preg_match($regex, $url === '' ? '/' : $url, $matches)) {
                    array_shift($matches);
                    $matched = $target;
                    $params = $matches;
                    break;
                }
            }
        }

        if ($matched === null) {
            http_response_code(404);
            require APP_ROOT . '/app/views/errors/404.php';
            return;
        }

        [$this->controller, $this->method] = explode('@', $matched);
        $this->params = $params;
        require_once APP_ROOT . '/app/controllers/' . $this->controller . '.php';
        call_user_func_array([new $this->controller(), $this->method], $this->params);
    }

    private function routes(): array
    {
        return [
            'GET /' => 'HomeController@index',
            'GET login' => 'AuthController@login',
            'POST login' => 'AuthController@processLogin',
            'GET register' => 'AuthController@register',
            'POST register' => 'AuthController@processRegister',
            'GET logout' => 'AuthController@logout',

            'GET user/dashboard' => 'UserController@dashboard',
            'GET user/reports/create' => 'ReportController@create',
            'POST user/reports/store' => 'ReportController@store',
            'GET user/reports' => 'ReportController@history',
            'GET user/reports/{id}' => 'ReportController@show',
            'GET user/profile' => 'ProfileController@index',
            'POST user/profile' => 'ProfileController@update',

            'GET petugas/dashboard' => 'PetugasController@dashboard',
            'GET petugas/reports' => 'PetugasController@reports',
            'POST petugas/reports/{id}/status' => 'PetugasController@updateStatus',

            'GET admin/dashboard' => 'AdminController@dashboard',
            'GET admin/reports' => 'AdminController@reports',
            'POST admin/reports/{id}/status' => 'AdminController@updateStatus',
            'GET admin/users' => 'AdminController@users',
            'POST admin/users/{id}/role' => 'AdminController@updateUserRole',
            'POST admin/users/{id}/delete' => 'AdminController@deleteUser',
            'GET admin/categories' => 'AdminController@categories',
            'POST admin/categories/store' => 'AdminController@storeCategory',
            'POST admin/categories/{id}/update' => 'AdminController@updateCategory',
            'POST admin/categories/{id}/delete' => 'AdminController@deleteCategory',
            'GET admin/map-data' => 'AdminController@mapData',
            'GET admin/export-pdf' => 'AdminController@exportPdf',
        ];
    }
}

