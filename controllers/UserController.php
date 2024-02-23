<?php

    namespace app\controllers;
    use app\core\Application;
    use app\core\Controller;
    use app\core\middlewares\AuthMiddleware;
    use app\core\Request;
    use app\models\User;
    use app\models\UserEditDetailsForm;
    use app\repository\RoleRepository;
    use app\repository\UserRepository;

    class UserController extends Controller
    {

        public UserRepository $userRepository;
        public RoleRepository $roleRepository;

        public function __construct() {
            $this->registerMiddleWare(new AuthMiddleware(4, []));
            $this->userRepository = new UserRepository('User');
            $this->roleRepository = new RoleRepository('Role');
        }

        public function home() {
            return $this->render('/user/user-home');
            }

        public function profile() {
            $user = Application::$app->user;
            $role = $this->roleRepository->findById($user->role_id);
            return $this->render('/user/user-profile', ['user' => $user, 'role' => $role]);
        }

        public function editDetails(Request $request) {
            $editDetailsForm = new UserEditDetailsForm;
            if($request->isPost())
            {
                $editDetailsForm->loadData($request->getBody());
                if($editDetailsForm->validate() && $editDetailsForm->editDetails($this->userRepository))
                {   
                    return 'success';
                }
            }
            return $this->render('/user/user-editDetails', ['model' => $editDetailsForm]);
        }

    }

?>