<?php
    namespace app\controllers;

    use app\core\Application;
    use app\core\Controller;
    use app\core\Request;
    use app\core\Response;
    use app\models\LoginForm;
    use app\models\UserRegisterForm;

    class AuthController extends Controller
    {
        public function login(Request $request, Response $response)
        {
            $this->setLayout('mainLayout');
            $loginForm = new LoginForm();
            if($request->isPost()) {
                $loginForm->loadData($request->getBody());
                if($loginForm->validate() && $loginForm->login()) {
                    $user_role_id = Application::$app->user->role_id;
                    if($user_role_id === 1) {
                        $response->redirect('/admin/admin-home');
                    } else if($user_role_id === 2) {
                        $response->redirect('/editor/editor-home');
                    } else if($user_role_id === 3) {
                        $response->redirect('/author/author-home');
                    } else if($user_role_id === 4) {
                        $response->redirect('/user/user-home');
                    }
                    return;
                }
            }
            return $this->render('login', ['model' => $loginForm]);
        }  

        public function register(Request $request)
        {
            
            $this->setLayout('mainLayout');
            $user = new UserRegisterForm;
            if($request->isPost()) {
                $user->loadData($request->getBody());
                if($user->validate() && $user->save())
                {
                    Application::$app->session->setFlash('success', 'You have been successfully registered');
                    Application::$app->response->redirect('/');
                }
                return $this->render('register', ['model' => $user]);
            }
            return $this->render('register', ['model' => $user]);
        }

        public function logout(Request $request, Response $response)
        {
            Application::$app->logout();
            return $response->redirect('/');
        }
    }