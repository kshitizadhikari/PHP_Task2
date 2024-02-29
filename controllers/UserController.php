<?php

    namespace app\controllers;
    use app\core\Application;
    use app\core\Controller;
    use app\core\middlewares\AuthMiddleware;
    use app\core\Request;
    use app\core\Response;
    use app\models\User;
    use app\models\UserEditDetailsForm;
use app\models\UserEditPasswordForm;
use app\repository\RoleRepository;
    use app\repository\UserRepository;

    class UserController extends Controller
    {

        public UserRepository $userRepo;
        public RoleRepository $roleRepo;
        protected const USER_ROLE = 4;

        public function __construct() {
            $this->registerMiddleWare(new AuthMiddleware(self::USER_ROLE, []));
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
            if($request->isPost())
            {
                $user = new UserEditDetailsForm();
                $user->loadData($request->getBody());
                if(!$user->validate())
                {
                    return $this->render('/user/user-editDetails', ['model' => $user]);
                }
                $toUpdateUser = new User();
                $toUpdateUser = $this->userRepo->findById($user->id);
                $toUpdateUser->firstName = $user->firstName;
                $toUpdateUser->lastName = $user->lastName;
                $toUpdateUser->email = $user->email;
                $toUpdateUser->unsetErrorArray();
                $this->userRepo->update($toUpdateUser);
                return $response->redirect('/user/user-home');
            }

            $user = new User();
            $requestData = $request->getBody();
            $user = $this->userRepo->findById($requestData['id']);
            $user->password = '';
            if($user==null) {
                Application::$app->session->setFlash('error', 'User Not Found');
                return $response->redirect('/user/user-home');
            }
            return $this->render('/user/user-editDetails', ['model'=>$user]); //return UserEditDetailsForm obj
        }

        public function changePassword(Request $request, Response $response)
        {
            if($request->isPost())
            {
                $pwObj = new UserEditPasswordForm();
                $pwObj->loadData($request->getBody());
                if(!$pwObj->validate() || !$pwObj->checkPassword())
                {
                    return $this->render('/user/user-changePassword', ['model' => $pwObj]);
                }
                $user = new User();
                $user = $this->userRepo->findById($_SESSION['user']);
                $newHashedPassword = $this->userRepo->hashPassword($pwObj->newPassword);
                $user->password = $newHashedPassword;
                $user->unsetErrorArray();
                if(!$this->userRepo->update($user)) {
                    Application::$app->session->setFlash('error', 'Password change unsuccessful');
                    return;
                }
                Application::$app->session->setFlash('success', 'Password changes successfully');
                return $response->redirect('/user/user-home');
            }

            $pwObj = new UserEditPasswordForm();
            return $this->render('/user/user-changePassword', ['model' => $pwObj]);
        }

    }

?>