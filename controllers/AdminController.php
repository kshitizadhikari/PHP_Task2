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
            $allUsers = $this->userRepo->findAll();
            return $this->render('/admin/admin-home', ['allUsers' => $allUsers]);
        }

        public function profile() {
            $user = Application::$app->user;
            $role = $this->roleRepo->findById($user->role_id);
            return $this->render('/admin/admin-profile', ['user' => $user, 'role' => $role]);
        }


        public function editDetails(Request $request, Response $response) {
            $editDetailsForm = new UserEditDetailsForm;
            $user = new User();
            $user = $this->userRepo->findById($_SESSION['user']);
            $editDetailsForm->firstName = $user->firstName;
            $editDetailsForm->lastName = $user->lastName;
            $editDetailsForm->email = $user->email;
            if($request->isPost()) {
                $editDetailsForm->loadData($request->getBody());
                if($editDetailsForm->validate() && $editDetailsForm->editDetails($this->userRepo)) {
                    Application::$app->session->setFlash('success', 'User details updated successfully');
                    return $response->redirect('/admin/admin-home');
                }
            }
            return $this->render('/admin/admin-editDetails', ['model' => $editDetailsForm]);
        }

        public function editUser(Request $request, Response $response)
        {
            if($request->isPost())
            {
                $user = new User();
                $postData = $request->getBody();
                $user = $this->userRepo->findById($postData['id']);
                $user->firstName = $postData['firstName'];
                $user->lastName = $postData['lastName'];
                $user->email = $postData['email'];
                $user->role_id = $postData['role_id'];
                $user->unsetErrorArray();
                $this->userRepo->update($user);
                return $response->redirect('/admin/admin-home');
            }
            $user = new User();
            $requestData = $request->getBody();
            $user = $this->userRepo->findById($requestData['id']);
            
            if($user==null) {
                Application::$app->session->setFlash('error', 'User Not Found');
                return $response->redirect('/admin/admin-home');
            }
            
            return $this->render('/admin/admin-editUser', ['model'=>$user]);
        }

        public function deleteUser(Request $request, Response $response)
        {
            $requestData = $request->getBody();
            $user_id = isset($requestData['id']) ? (int)$requestData['id'] : null;
            if($this->userRepo->delete($user_id)) {
                Application::$app->session->setFlash('success', 'user deleted successfully');
            } else {
                Application::$app->session->setFlash('error', 'user deletion unsuccessful');
            }
            return $response->redirect('/admin/admin-home');
        }
    }

?>