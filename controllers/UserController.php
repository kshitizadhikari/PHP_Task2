<?php

    namespace app\controllers;
    use app\core\Application;
    use app\core\Controller;
    use app\core\middlewares\AuthMiddleware;
    use app\core\Request;
use app\core\Response;
use app\models\User;
    use app\models\UserEditDetailsForm;
    use app\repository\RoleRepository;
    use app\repository\UserRepository;

    class UserController extends Controller
    {

        public UserRepository $userRepo;
        public RoleRepository $roleRepo;

        public function __construct() {
            $this->registerMiddleWare(new AuthMiddleware(4, []));
            $this->userRepo = new UserRepository();
            $this->roleRepo = new RoleRepository();
        }

        public function home() {
            return $this->render('/user/user-home');
            }

        public function profile() {
            $user = Application::$app->user;
            $role = $this->roleRepo->findById($user->role_id);
            return $this->render('/user/user-profile', ['user' => $user, 'role' => $role]);
        }

        public function editDetails(Request $request, Response $response) {
            $editDetailsForm = new UserEditDetailsForm;
            $user = new User();
            $user = $this->userRepo->findById($_SESSION['user']);
            $editDetailsForm->firstName = $user->firstName;
            $editDetailsForm->lastName = $user->lastName;
            if($request->isPost())
            {
                $editDetailsForm->loadData($request->getBody());
                if($editDetailsForm->validate() && $editDetailsForm->editDetails($this->userRepo))
                {   
                    $response->redirect('/user/user-home');
                }
            }
            return $this->render('/user/user-editDetails', ['model' => $editDetailsForm]);
        }

    }

?>