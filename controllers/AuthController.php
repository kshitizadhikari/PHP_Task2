<?php
    namespace app\controllers;

    use app\core\Application;
    use app\core\Controller;
    use app\core\middlewares\AuthMiddleware;
    use app\core\Request;
    use app\core\Response;
    use app\models\User;
    use app\models\LoginForm;

    class AuthController extends Controller
    {

        public function __construct() {
            $this->registerMiddleWare(new AuthMiddleware(['profile']));
        }

        public function login(Request $request, Response $response)
        {
            $this->setLayout('mainLayout');
            $loginForm = new LoginForm();
            if($request->isPost()) {
                $loginForm->loadData($request->getBody());
                if($loginForm->validate() && $loginForm->login()) {
                    $response->redirect('/');
                    return;
                }
            }
            return $this->render('login', ['model' => $loginForm]);
        }  

        public function register(Request $request)
        {
            
            $this->setLayout('mainLayout');
            $user = new User;
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

        public function profile()
        {
            return $this->render('profile');
        }
    }