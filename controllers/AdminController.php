<?php
    namespace app\controllers;

    use app\core\Application;
    use app\core\Controller;
    use app\core\middlewares\AuthMiddleware;
    use app\repository\RoleRepository;
    use app\repository\UserRepository;

    class AdminController extends Controller
    {
        protected $userRepo;
        protected $roleRepo;
        
        public function __construct() {
            $this->registerMiddleWare(new AuthMiddleware(1, []));
            $this->userRepo = new UserRepository('User');
            $this->roleRepo = new RoleRepository('Role');
        }

        public function home() {
            return $this->render('/admin/admin-home');
        }
    }

?>