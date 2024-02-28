<?php
    namespace app\controllers;

    use app\core\Application;
    use app\core\Controller;
    use app\core\middlewares\AuthMiddleware;
    use app\core\Request;
    use app\core\Response;
    use app\models\User;
    use app\models\UserEditDetailsForm;
    use app\models\UserRegisterForm;
use app\repository\ContactRepository;
use app\repository\RoleRepository;
        use app\repository\UserRepository;

    class AdminController extends Controller
    {
        protected UserRepository $userRepo;
        protected RoleRepository $roleRepo;
        protected ContactRepository $contactRepo;
        
        public function __construct() {
            $this->setLayout('adminLayout');
            $this->registerMiddleWare(new AuthMiddleware(1, []));
            $this->userRepo = new UserRepository();
            $this->roleRepo = new RoleRepository();
            $this->contactRepo = new ContactRepository();
        }

        public function home() {
            $allUsers = $this->userRepo->findAll();
            $allContactMessages = $this->contactRepo->findAll();
            return $this->render('/admin/admin-home', ['allUsers' => $allUsers, 'Messages' => $allContactMessages]);
        }

        public function profile() {
            $user = Application::$app->user;
            $role = $this->roleRepo->findById($user->role_id);
            return $this->render('/admin/admin-profile', ['user' => $user, 'role' => $role]);
        }

        public function createUser(Request $request, Response $response)
        {
            if($request->isPost())
            {
                $user = new User();
                $user->loadData($request->getBody());
                if($user->validate()) {
                    $user->unsetErrorArray();
                    $hashedPassword = $this->userRepo->hashPassword($user->password);
                    $user->password = $hashedPassword;
                    if($this->userRepo->save($user))
                    Application::$app->session->setFlash('success', 'User created successfully');
                    return $response->redirect('/admin/admin-home');
                }
                
            }
            $user = new User;
            return $this->render('/admin/admin-createUser', ['model'=>$user]);
        }

        public function editDetails(Request $request, Response $response) {
            if($request->isPost())
            {
                $user = new User();
                $postData = $request->getBody();
                $user = $this->userRepo->findById($postData['id']);
                $user->firstName = $postData['firstName'];
                $user->lastName = $postData['lastName'];
                //if the admin is changing someone's else's info
                if($user->id !== $_SESSION['user'])
                {
                    $user->email = $postData['email'];
                    $user->role_id = $postData['role_id'];
                }
                $user->unsetErrorArray();
                $this->userRepo->update($user);
                return $response->redirect('/admin/admin-home');
            }

            $user = new User();
            $requestData = $request->getBody();
            $user = $this->userRepo->findById($requestData['id']);
            $user->password = '';
            if($user==null) {
                Application::$app->session->setFlash('error', 'User Not Found');
                return $response->redirect('/admin/admin-home');
            }
            return $this->render('/admin/admin-editDetails', ['model'=>$user]);
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

        public function changePassword(Request $request, Response $response)
        {
            $user = new User();
            $postData = $request->getBody();
            $user = $this->userRepo->findById($postData['id']);
            $newHashedPassword = $this->userRepo->hashPassword($postData['password']);
            $user->password = $newHashedPassword;
            $user->unsetErrorArray();
            if(!$this->userRepo->update($user)) {
                Application::$app->session->setFlash('error', 'Password change unsuccessful');
                return;
            }
            Application::$app->session->setFlash('success', 'Password changes successfully');
            return $response->redirect('/admin/admin-home');
        }

        //for the contact
        public function deleteMessage(Request $request, Response $response)
        {
            $requestData = $request->getBody();
            $contact_id = isset($requestData['id']) ? (int)$requestData['id'] : null;
            if($this->contactRepo->delete($contact_id)) {
                Application::$app->session->setFlash('success', 'Message deleted successfully');
            } else {
                Application::$app->session->setFlash('error', 'Message deletion unsuccessful');
            }
            return $response->redirect('/admin/admin-home');
        }


    }

?>