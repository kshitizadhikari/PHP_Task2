<?php

    namespace app\controllers;
    use app\core\Application;
    use app\core\Controller;
    use app\core\middlewares\AuthMiddleware;
    use app\repository\RoleRepository;
    use app\repository\UserRepository;

    class UserController extends Controller
    {

        public UserRepository $userRepository;
        public RoleRepository $roleRepository;

        public function __construct() {
            $this->registerMiddleWare(new AuthMiddleware());
            $this->userRepository = new UserRepository('users', 'User');
            $this->roleRepository = new RoleRepository('roles', 'Role');
        }

        public function home() {
            return $this->render('/user/user-home');
            }

        public function profile() {
            $user = Application::$app->user;
            $role = $this->roleRepository->findById($user->role_id);
            return $this->render('/user/user-profile', ['user' => $user, 'role' => $role]);
        }

    }

?>