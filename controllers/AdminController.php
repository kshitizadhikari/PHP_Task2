<?php
    namespace app\controllers;

    use app\core\Application;
    use app\core\Controller;
    use app\core\middlewares\AuthMiddleware;
    use app\core\Request;
    use app\core\Response;
    use app\models\Contact;
    use app\models\User;
    use app\models\UserEditDetailsForm;
    use app\models\UserEditPasswordForm;
    use app\repository\ContactRepository;
    use app\repository\RoleRepository;
    use app\repository\UserRepository;
    use PHPMailer\PHPMailer\PHPMailer;

    class AdminController extends Controller
    {
        protected UserRepository $userRepo;
        protected RoleRepository $roleRepo;
        protected ContactRepository $contactRepo;
        protected const ADMIN_ROLE = 1;
        protected const ROW_START = 0;
        protected const ROW_LIMIT = 2;
        
        public function __construct() {
            $this->setLayout('adminLayout');
            $this->registerMiddleWare(new AuthMiddleware(self::ADMIN_ROLE, []));
            $this->userRepo = new UserRepository();
            $this->roleRepo = new RoleRepository();
            $this->contactRepo = new ContactRepository();
        }

        public function home(Request $request, Response $response) {
            $searchTerm = $request->getBody()['search'] ?? null;
            $currentUserPage = 1; // Default to the first page
            $newUserPage = 0; // Start index for SQL query
            
            // Adjust current page and start index based on the request
            if (isset($request->getBody()['userPage'])) {
                $currentUserPage = (int)$request->getBody()['userPage'];
                $newUserPage = ($currentUserPage - 1) * self::ROW_LIMIT;
            }
            
            // Handle search functionality
            if ($searchTerm) {
                $searchTerm = "$searchTerm";
                $users = $this->userRepo->searchWithPagination('firstName', $searchTerm, $newUserPage, self::ROW_LIMIT);
            } else {
                //if no search return the first set of data
                $users = $this->userRepo->findWithLimit($newUserPage, self::ROW_LIMIT);
            }

            $totalUserPages = $this->userRepo->findTotalPages(self::ROW_LIMIT);
            // Handling AJAX requests differently
            if ($request->isAjax()) {
                // Assuming there's a separate view for the table to be included in AJAX response
                return $this->renderPartialView('../views/ajax-partialViews/user_table', [
                    'allUsers' => $users,
                    'userPageNum' => $currentUserPage,
                    'totalUserPage' => $totalUserPages
                ]);
            } 
            $allContactMessages = $this->contactRepo->findAll();
            return $this->render('/admin/admin-home', ['allUsers' => $users, 'userPageNum'=>$currentUserPage, 'totalUserPage' => $totalUserPages, 'allMessages' => $allContactMessages]);
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
                if(!$user->validate()) {
                    return $this->render('/admin/admin-createUser', ['model'=>$user]);
                }
                $user->unsetErrorArray();
                $unhashedPassword = $user->password;
                $hashedPassword = $this->userRepo->hashPassword($user->password);
                $user->password = $hashedPassword;
                if($this->userRepo->save($user))
                if(!self::sendMail($user, $unhashedPassword))
                {
                Application::$app->session->setFlash('error', 'Mail not sent to new user');
                return $response->redirect('/admin/admin-home');
                }
                Application::$app->session->setFlash('success', 'User created successfully');
                return $response->redirect('/admin/admin-home');
            }
            $user = new User;
            return $this->render('/admin/admin-createUser', ['model'=>$user]);
        }

        public function editDetails(Request $request, Response $response) {
            if($request->isPost())
            {
                $postObj = new UserEditDetailsForm();
                $postObj->loadData($request->getBody());
                if(!$postObj->validate())
                {   
                    return $this->render('/admin/admin-editDetails', ['model'=>$postObj]);
                }
                $user = new User();
                $user = $this->userRepo->findById($postObj->id);
                $user->firstName = $postObj->firstName;
                $user->lastName = $postObj->lastName;
                //if the admin is changing someone's else's info
                if($user->id !== $_SESSION['user'])
                {
                    $user->email = $postObj->email;
                    $user->role_id = $postObj->role_id;
                    $user->status = $postObj->status;
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

        public function changeSelfPassword(Request $request, Response $response)
        {
            if($request->isPost())
            {
                $pwObj = new UserEditPasswordForm();
                $pwObj->loadData($request->getBody());
                if(!$pwObj->validate() || !$pwObj->checkPassword())
                {
                    return $this->render('/admin/admin-changeSelfPassword', ['model' => $pwObj]);
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
                return $response->redirect('/admin/admin-home');
            }

            $pwObj = new UserEditPasswordForm();
            return $this->render('/admin/admin-changeSelfPassword', ['model' => $pwObj]);
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
        public function viewMessage(Request $request, Response $response)
        {
            $requestData = $request->getBody();
            $message_id = isset($requestData['id']) ? (int)$requestData['id'] : null;
            $message = new Contact();
            $message = $this->contactRepo->findById($message_id); 
            if(!$message) {
                Application::$app->session->setFlash('error', 'Message view error');
                return $response->redirect('/admin/admin-home');
            }
            return $this->render('/admin/admin-viewMessage', ['message' => $message]);
        }

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

        public function markMessageRead(Request $request, Response $response) {
            $requestData = $request->getBody();
            $message_id = isset($requestData['id']) ? (int)$requestData['id'] : null;
            $message = new Contact();
            $message = $this->contactRepo->findById($message_id);
            $message->status = 1;
            $message->unsetErrorArray();
            $this->contactRepo->update($message);
            Application::$app->session->setFlash('success', 'Message marked as read');
            return $response->redirect('/admin/admin-home');
        }


        public static function sendMail(User $user, string $unhashedPassword)
        {
            $mail = new PHPMailer();
            $mail->SMTPDebug = 2;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'adhikarikshitiz12@gmail.com';
            $mail->Password = 'iiiu lvpy ysyf mdgd';  
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('adhikarikshitiz12@gmail.com', 'Kshitiz Adhikari');
            $mail->addAddress($user->email);

            // Add CC and BCC recipients if needed
            // $mail->addCC('cc@example.com', 'CC Name');
            // $mail->addBCC('bcc@example.com', 'BCC Name');

            $mail->Subject = 'Account Created Successfully';
            $mail->Body    = "\n
                                FirstName:$user->firstName\n
                                LastName: $user->lastName\n
                                Email: $user->email\n
                                Password: $unhashedPassword\n
                                ";
            if(!$mail->send()) {
                return false;
            }
            return true;
        }
    }

?>