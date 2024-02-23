<?php
    namespace app\controllers;

    use app\core\Application;
    use app\core\Controller;
    use app\core\middlewares\AuthMiddleware;
use app\core\Request;
use app\models\UserEditDetailsForm;
use app\repository\RoleRepository;
    use app\repository\UserRepository;

    class AuthorController extends Controller
    {
        protected $userRepo;
        protected $roleRepo;
        protected $role_id = 3;
        
        public function __construct() {
            $this->registerMiddleWare(new AuthMiddleware($this->role_id, []));
            $this->userRepo = new UserRepository('User');
            $this->roleRepo = new RoleRepository('Role');
        }

        public function home() {
            $this->setLayout('authorLayout');
            
            return $this->render('/author/author-home');
        }

        public function profile() {
            $this->setLayout('authorLayout');
            $user = Application::$app->user;
            $role = $this->roleRepo->findById($user->role_id);
            return $this->render('/author/author-profile', ['user' => $user, 'role' => $role]);
        }


        public function editDetails(Request $request) {
            $this->setLayout('authorLayout');

            $editDetailsForm = new UserEditDetailsForm;
            if($request->isPost())
            {
                $editDetailsForm->loadData($request->getBody());
                if($editDetailsForm->validate() && $editDetailsForm->editDetails($this->userRepo))
                {   
                    return 'success';
                }
            }
            return $this->render('/author/author-editDetails', ['model' => $editDetailsForm]);
        }
    }

?>