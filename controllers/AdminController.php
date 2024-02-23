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
            $this->setLayout('adminLayout');
            $this->registerMiddleWare(new AuthMiddleware(1, []));
            $this->userRepo = new UserRepository();
            $this->roleRepo = new RoleRepository();
        }

        public function home() {
            return $this->render('/admin/admin-home');
        }
    }

?>