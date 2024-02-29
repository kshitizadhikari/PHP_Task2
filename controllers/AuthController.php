<?php
    namespace app\controllers;

    use app\core\Application;
    use app\core\Controller;
    use app\core\Request;
    use app\core\Response;
    use app\models\LoginForm;
    use app\models\User;
    use app\models\UserRegisterForm;
    use app\repository\UserRepository;

    class AuthController extends Controller
    {
        protected UserRepository $userRepo;
        public function __construct() {
            $this->userRepo = new UserRepository;
        }

        public function login(Request $request, Response $response)
        {
            $this->setLayout('mainLayout');
            $loginForm = new LoginForm();
            if($request->isPost()) {
                $loginForm->loadData($request->getBody());
                if(!$loginForm->validate()){
                }
                if($loginForm->validate() && $loginForm->login()) {
                    $user_role_id = Application::$app->user->role_id;
                    $user_status = Application::$app->user->status;
                    if($user_status == 1) {
                        if($user_role_id === 1) {
                            $response->redirect('/admin/admin-home');
                        } else if($user_role_id === 2) {
                            $response->redirect('/editor/editor-home');
                        } else if($user_role_id === 3) {
                            $response->redirect('/author/author-home');
                        } else if($user_role_id === 4) {
                            $response->redirect('/user/user-home');
                        }
                    } else {
                        Application::$app->session->setFlash('error', 'Your account hasn\'t been activated');
                    }
                    return $this->render('login', ['model' => $loginForm]);
                }
            }
            return $this->render('login', ['model' => $loginForm]);
        }  

        public function register(Request $request, Response $response)
        {
            if($request->isPost()) {
                $user = new UserRegisterForm();
                $user->loadData($request->getBody());

                if(!$user->validate())
                {
                    return $this->render('register', ['model' => $user]);
                }

                $newUser = new User();
                $newUser->loadData($user);
                $newUser->password = $this->userRepo->hashPassword($newUser->password);
                $newUser->unsetErrorArray();
                if($this->userRepo->save($newUser))
                {
                    Application::$app->session->setFlash('success', 'You have been successfully registered');
                    return $response->redirect('/login');

                }
            }
            $user = new UserRegisterForm();
            return $this->render('register', ['model' => $user]);
        }

        public function logout(Request $request, Response $response)
        {
            Application::$app->logout();
            return $response->redirect('/');
        }
    }