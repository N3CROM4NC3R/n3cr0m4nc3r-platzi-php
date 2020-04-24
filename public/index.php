<?php
    $debug = true;

    ini_set('display_errors', 1);
    ini_set('display_startups_errors', 1);
    error_reporting(-1);

    require_once '../vendor/autoload.php';

    session_start();
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/..');
    $dotenv->load();

    use Aura\Router\RouterContainer as RouterContainer;
    use Illuminate\Database\Capsule\Manager as Capsule;


    $capsule = new Capsule;

    $capsule->addConnection([
        'driver' => getenv('DB_DRIVER'),
        'host' => getenv('DB_HOST'),
        'username' => getenv('DB_USER'),
        'password' => getenv('DB_PASS'),
        'database' => getenv('DB_NAME'),
        'charset' => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix' => '',
        'port' => getenv('DB_PORT')
    ]);

    $capsule->setAsGlobal();

    $capsule->bootEloquent();

    $request = Zend\Diactoros\ServerRequestFactory::fromGlobals(
        $_SERVER,
        $_GET,
        $_POST,
        $_COOKIE,
        $_FILES
    );
    $routerContainer = new RouterContainer();
    $map = $routerContainer->getMap();
    $map->get('index','/',[
        'controller' => 'App\Controllers\IndexController',
        'action' => 'indexAction'
    ]);
    $map->get('addJobs','/jobs/add',[
        'controller' => 'App\Controllers\JobsController',
        'action' => 'getAddJobAction',
        'auth' => true
    ]);
    $map->post('saveJobs','/jobs/add',[
        'controller' => 'App\Controllers\JobsController',
        'action' => 'getAddJobAction',
        'auth' => true
    ]);
    $map->get('registerUser','/users/register',[
        'controller' => 'App\Controllers\UsersController',
        'action' => 'getRegisterUserAction',
        'auth' => true
    ]);
    $map->post('registeredUser','/users/register',[
        'controller' => 'App\Controllers\UsersController',
        'action' => 'getRegisterUserAction',
        'auth' => true
    ]);

    $map->get('loginUser','/auth',[
        'controller' => 'App\Controllers\AuthController',
        'action' => 'getLogin'
    ]);

    $map->post('loginUserPost','/auth',[
        'controller' => 'App\Controllers\AuthController',
        'action' => 'postLogin'
    ]);

    $map->get('admin','/admin', [
        'controller' => 'App\Controllers\AdminController',
        'action' => 'getIndex',
        'auth' => true
    ]);

    $map->get('logout','/logout', [
        'controller' => 'App\Controllers\AuthController',
        'action' => 'getLogout',
        'auth' => true
    ]);
    $matcher = $routerContainer->getMatcher();
    $route = $matcher->match($request);
    if(!$route){
        echo("no route");
    }
    else{
        $dataController = $route->handler;
        $nameController = $dataController['controller'];
        $nameAction = $dataController['action'];
        $needsAuth = $dataController['auth'] ?? false;

        $sessionUserId = $_SESSION['userId'] ?? null;
        if($needsAuth && !$sessionUserId) {
            echo 'Protected route';
            die;
        }

        $controller = new $nameController();

        $response = $controller->$nameAction($request);

        foreach($response->getHeaders() as $name => $values){
            foreach($values as $value){
                header(sprintf('%s: %s', $name, $value), false);
            }
        }
        http_response_code($response->getStatusCode());
        echo $response->getBody();
    }







?>
