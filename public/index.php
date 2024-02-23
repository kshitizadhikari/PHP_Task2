<?php
    use app\controllers\AuthController;
    use app\controllers\HomeController;
    use app\controllers\UserController;
    use app\controllers\AdminController;
use app\controllers\AuthorController;
use app\core\Application;
    use app\models\User;

    require_once __DIR__.'/../vendor/autoload.php';
    $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
    $dotenv->load();
    

    $config = [
        'userClass' => User::class,
        'db' => [
            'dsn' => $_ENV['DB_DSN'],
            'user' => $_ENV['DB_USER'],
            'password' => $_ENV['DB_PASSWORD']
        ]
    ];

    $app = new Application(dirname(__DIR__), $config);

    $app->router->get('/', [HomeController::class, 'home']);
    $app->router->get('/contact', [HomeController::class, 'contact']);
    $app->router->post('/contact',[HomeController::class, 'contact']);

    $app->router->get('/login',[AuthController::class, 'login']);
    $app->router->post('/login',[AuthController::class, 'login']);
    $app->router->get('/register',[AuthController::class, 'register']);
    $app->router->post('/register',[AuthController::class, 'register']);

    $app->router->get('/logout',[AuthController::class, 'logout']);
    
    //user routes
    $app->router->get('/user/user-home', [UserController::class, 'home']);
    $app->router->get('/user/user-profile',[UserController::class, 'profile']);
    $app->router->get('/user/user-editDetails',[UserController::class, 'editDetails']);
    $app->router->post('/user/user-editDetails',[UserController::class, 'editDetails']);

    //admin routes
    $app->router->get('/admin/admin-home', [AdminController::class, 'home']);

    //author routes
    $app->router->get('/author/author-home', [AuthorController::class, 'home']);
    $app->router->get('/author/author-profile',[AuthorController::class, 'profile']);
    $app->router->post('/author/author-editDetails',[AuthorController::class, 'editDetails']);

    $app->run();

?>