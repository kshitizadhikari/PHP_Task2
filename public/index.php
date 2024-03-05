<?php
    require_once("./cors.php");
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
    $app->router->get('/home/home-viewBlog', [HomeController::class, 'viewBlog']);
    $app->router->get('/contact', [HomeController::class, 'contact']);
    $app->router->post('/contact',[HomeController::class, 'contact']);
    $app->router->get('/imageGallery',[HomeController::class, 'imageGallery']);
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
    $app->router->get('/user/user-changePassword', [UserController::class, 'changePassword']);
    $app->router->post('/user/user-changePassword',[UserController::class, 'changePassword']);

    //admin routes
    $app->router->get('/admin/admin-home', [AdminController::class, 'home']);
    $app->router->get('/admin/admin-profile',[AdminController::class, 'profile']);

    $app->router->get('/admin/admin-searchUser',[AdminController::class, 'searchUser']);
    $app->router->get('/admin/admin-createUser',[AdminController::class, 'createUser']);
    $app->router->post('/admin/admin-createUser',[AdminController::class, 'createUser']);
    $app->router->get('/admin/admin-editDetails',[AdminController::class, 'editDetails']);
    $app->router->post('/admin/admin-editDetails',[AdminController::class, 'editDetails']);
    $app->router->post('/admin/admin-changePassword',[AdminController::class, 'changePassword']);
    $app->router->get('/admin/admin-changeSelfPassword',[AdminController::class, 'changeSelfPassword']);
    $app->router->post('/admin/admin-changeSelfPassword',[AdminController::class, 'changeSelfPassword']);
    $app->router->get('/admin/admin-deleteUser',[AdminController::class, 'deleteUser']);

    $app->router->get('/admin/admin-createBlog',[AdminController::class, 'createBlog']);
    $app->router->post('/admin/admin-createBlog',[AdminController::class, 'createBlog']);
    $app->router->get('/admin/admin-editBlog',[AdminController::class, 'editBlog']);
    $app->router->post('/admin/admin-editBlog',[AdminController::class, 'editBlog']);
    $app->router->get('/admin/admin-deleteBlog',[AdminController::class, 'deleteBlog']);
    $app->router->get('/admin/admin-viewBlog',[AdminController::class, 'viewBlog']);

    $app->router->get('/admin/admin-viewMessage',[AdminController::class, 'viewMessage']);
    $app->router->get('/admin/admin-deleteMessage',[AdminController::class, 'deleteMessage']);
    $app->router->get('/admin/admin-markMessageRead',[AdminController::class, 'markMessageRead']);

    $app->router->get('/admin/admin-imageGallery',[AdminController::class, 'imageGallery']);
    $app->router->get('/admin/admin-imageGallery/deleteImage',[AdminController::class, 'deleteImage']);

    


    //author routes
    $app->router->get('/author/author-home', [AuthorController::class, 'home']);
    $app->router->get('/author/author-profile',[AuthorController::class, 'profile']);
    $app->router->get('/author/author-editDetails',[AuthorController::class, 'editDetails']);
    $app->router->post('/author/author-editDetails',[AuthorController::class, 'editDetails']);
    $app->router->get('/author/author-changePassword', [AuthorController::class, 'changePassword']);
    $app->router->post('/author/author-changePassword', [AuthorController::class, 'changePassword']);
    $app->router->get('/author/author-createBlog',[AuthorController::class, 'createBlog']);
    $app->router->post('/author/author-createBlog',[AuthorController::class, 'createBlog']);
    $app->router->get('/author/author-editBlog',[AuthorController::class, 'editBlog']);
    $app->router->post('/author/author-editBlog',[AuthorController::class, 'editBlog']);
    $app->router->get('/author/author-deleteBlog',[AuthorController::class, 'deleteBlog']);
    $app->router->get('/author/author-viewBlog',[AuthorController::class, 'viewBlog']);

    $app->run();

?>