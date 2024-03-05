<?php
    namespace app\controllers;

    use app\core\Application;
    use app\core\Controller;
    use app\core\middlewares\AuthMiddleware;
    use app\core\Request;
    use app\core\Response;
    use app\models\Blog;
    use app\models\Contact;
    use app\models\User;
    use app\models\UserEditDetailsForm;
    use app\models\UserEditPasswordForm;
    use app\repository\BlogRepository;
    use app\repository\ContactRepository;
    use app\repository\RoleRepository;
    use app\repository\UserRepository;
    use PHPMailer\PHPMailer\PHPMailer;

    class AdminController extends Controller
    {
        protected UserRepository $userRepo;
        protected RoleRepository $roleRepo;
        protected ContactRepository $contactRepo;
        protected BlogRepository $blogRepo;
        protected const ADMIN_ROLE = 1;
        protected const ROW_START = 0;
        protected const ROW_LIMIT = 2;
        protected const IMAGEE_LIMIT = 6;
        
        public function __construct() {
            $this->setLayout('adminLayout');
            $this->registerMiddleWare(new AuthMiddleware(self::ADMIN_ROLE, []));
            $this->userRepo = new UserRepository();
            $this->roleRepo = new RoleRepository();
            $this->contactRepo = new ContactRepository();
            $this->blogRepo = new BlogRepository();
        }

        public function home(Request $request, Response $response) {
            $searchTerm = $request->getBody()['search'] ?? null;
            $currentUserPage = 1; // Default to the first page
            $currentContactPage = 1; // Default to the first page
            $currentBlogPage = 1; // Default to the first page
            $itemsPerPage = self::ROW_LIMIT; // Define how many items you want per page
        
            if ($request->isAjax()) {
                // When it's an AJAX request, fetch the 'userPage' of 'contactPage' from the request
                $currentUserPage = (int)($request->getBody()['userPage'] ?? 1);
                $currentContactPage = (int)($request->getBody()['contactPage'] ?? 1);
                $currentBlogPage = (int)($request->getBody()['blogPage'] ?? 1);
            }
        
            // Calculate the offset for the SQL query based on the current page
            $offset = ($currentUserPage - 1) * $itemsPerPage;
            $offsetContact = ($currentContactPage - 1) * $itemsPerPage;
            $offsetBlog = ($currentBlogPage - 1) * $itemsPerPage;
        
            $users = $this->userRepo->findWithLimit($offset, $itemsPerPage);
            $totalUserPages = $this->userRepo->findTotalPages($itemsPerPage);

            $messages = $this->contactRepo->findWithLimit($offsetContact, $itemsPerPage);
            $totalContactPages = $this->contactRepo->findTotalPages($itemsPerPage);
        
            $blogs = $this->blogRepo->findWithLimit($offsetBlog, $itemsPerPage);
            $totalBlogPages = $this->blogRepo->findTotalPages($itemsPerPage);
        
            if ($request->isAjax()) {

                if(isset($request->getBody()['firstName'])) {
                     // Adjust the query based on whether there's a search term
                    $searchTerm = $request->getBody()['firstName'];
                    if ($searchTerm) {
                        $users = $this->userRepo->searchWithPagination('firstName', $searchTerm, $offset, $itemsPerPage);
                    }
                    return $this->renderPartialView('../views/ajax-partialViews/user_table', [
                        'allUsers' => $users,
                        'userPageNum' => $currentUserPage,
                        'totalUserPage' => $totalUserPages,
                    ]);
                } elseif(isset($request->getBody()['title'])) {
                    // Adjust the query based on whether there's a search term
                    $searchTerm = $request->getBody()['title'];
                    if ($searchTerm) {
                        $blogs = $this->blogRepo->searchWithPagination('title', $searchTerm, $offsetBlog, $itemsPerPage);
                    }
                    return $this->renderPartialView('../views/admin/admin-ajaxViews/admin-blog_table', [
                        'allBlogs' => $blogs,
                        'blogPageNum' => $currentBlogPage,
                        'totalBlogPage' => $totalBlogPages,
                    ]);
                }

                if(isset($request->getBody()['userPage'])) {
                    return $this->renderPartialView('../views/ajax-partialViews/user_table', [
                        'allUsers' => $users,
                        'userPageNum' => $currentUserPage,
                        'totalUserPage' => $totalUserPages,
                    ]);
                } elseif(isset($request->getBody()['blogPage'])) {
                    return $this->renderPartialView('../views/admin/admin-ajaxViews/admin-blog_table', [
                        'allBlogs' => $blogs,
                        'blogPageNum' => $currentBlogPage,
                        'totalBlogPage' => $totalBlogPages,
                    ]);
                } else {
                    return $this->renderPartialView('../views/admin/admin-ajaxViews/admin-contact_table', [
                        'allMessages' => $messages,
                        'contactPageNum' => $currentContactPage,
                        'totalContactPage' => $totalContactPages,
                    ]);
                }
                
            } else {
                // For a regular request, fetch additional data if needed and include the full page
                return $this->render('/admin/admin-home', [
                    'allUsers' => $users, 
                    'userPageNum' => $currentUserPage, 
                    'totalUserPage' => $totalUserPages, 
                    'allBlogs' => $blogs, 
                    'blogPageNum' => $currentBlogPage, 
                    'totalBlogPage' => $totalBlogPages,
                    'allMessages' => $messages,
                    'contactPageNum' => $currentContactPage,
                    'totalContactPage' => $totalContactPages
                ]);
            }
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

        public function imageGallery(Request $request) {
            $imgDir = Application::$app::$ROOT_DIR . "/public/assets/images/";
            $imgFiles = scandir($imgDir);
            if ($imgFiles !== false) {
                // Remove "." and ".." entries from the array
                $imgFiles = array_diff($imgFiles, array('.', '..'));

                foreach($imgFiles as $file) {
                    $imagesWithPath[] = [
                        'name' => $file,
                        'path' => '/assets/images/'. $file
                    ];                     
                }
            } else {
                echo "Failed to read directory.";
            }
            
            return $this->render('admin/admin-imageGallery', ['images' => $imagesWithPath]);
        }

        public function deleteImage(Request $request, Response $response) {
            $imgName = $request->getBody()['imgName'];
            
            // Specify the path to the image file
            $imagePath = Application::$app::$ROOT_DIR . '\public\assets\images\\' . $imgName;
            // Check if the file exists before attempting to delete it
            if (file_exists($imagePath)) {
                // Attempt to delete the file
                if (unlink($imagePath)) {
                    $response->setStatusCode(200);
                    Application::$app->session->setFlash('success', 'Image deleted successfully');
                    return $response->redirect('/admin/admin-imageGallery');
                } else {
                    $response->setStatusCode(500);
                    Application::$app->session->setFlash('error', 'Image couldn\'t be deleted');
                    return;
                }
            } else {
                $response->setStatusCode(404);
                Application::$app->session->setFlash('error', 'Image Not Found');
                return $response->redirect('/admin/admin-imageGallery');
            }
        }   
        public function viewBlog(Request $request, Response $response)
        {
            $requestData = $request->getBody();
            $blog_id = isset($requestData['id']) ? (int)$requestData['id'] : null;
            $blog = new Blog();
            $blog = $this->blogRepo->findById($blog_id); 
            $author = $this->userRepo->findById($blog->user_id);
            if(!$blog) {
                Application::$app->session->setFlash('error', 'Blog view error');
                return $response->redirect('/admin/admin-home');
            }
            return $this->render('/admin/admin-viewBlog', ['blog' => $blog, 'author' => $author]);
        }

        public function createBlog(Request $request, Response $response)
        {
            if($request->isPost()) {
                $blog = new Blog();
                $blog->loadData($request->getBody());
                if(!$blog->validate()) {
                    return $this->render('/admin/admin-createBlog', ['model' => $blog]);
                }
                    $blog->unsetErrorArray();
                    $blog->user_id = $_SESSION['user']; // set the blog's user id
                    // Move uploaded file to destination
                    //img_components[0] stores temporary path img_components[1] stores imageName
                    $img_components = explode("#", $blog->featured_img); 
                    $img_absolute_path = Application::$ROOT_DIR . DIRECTORY_SEPARATOR . "public" . DIRECTORY_SEPARATOR . "assets" . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . $img_components[1];
                    $img_relative_path = "/assets/images/" . $img_components[1];
                    if (!move_uploaded_file($img_components[0], $img_absolute_path)) {
                        Application::$app->session->setFlash('error', 'Image couldn\'t be uploaded');                            return;
                    }   
                    
                    $blog->featured_img = $img_relative_path;
                    if($this->blogRepo->save($blog)){
                        
                        Application::$app->session->setFlash('success', 'Blog created successfully');
                        $response->redirect('/admin/admin-home');
                }
            }
            $blog = new Blog();
            return $this->render('/admin/admin-createBlog', ['model' => $blog]);
        }

        public function editBlog(Request $request, Response $response) {
            $blog = new Blog();
            $requestData = $request->getBody();
            $blog_id = isset($requestData['id']) ? (int)$requestData['id'] : null;
            $blog = $this->blogRepo->findById($blog_id);

            if($request->isPost())
            {
                $blog = new Blog();
                $requestData = $request->getBody();
                $blog = $this->blogRepo->findById($requestData['id']);
                $blog->title = $requestData['title'] ?? $blog->title;
                $blog->description = $requestData['description'] ?? $blog->description;
                $blog->status = $requestData['status'] ?? $blog->status;
                
                if(!$blog->validate())
                {
                    return $this->render('/admin/admin-editBlog', ['model' => $blog]);
                }

                
                if(isset($requestData['featured_img']))
                {

                    // Move uploaded file to destination
                    //img_components[0] stores temporary path img_components[1] stores imageName
                    $img_components = explode("#", $requestData['featured_img']); 
                    $img_absolute_path = Application::$ROOT_DIR . DIRECTORY_SEPARATOR . "public" . DIRECTORY_SEPARATOR . "assets" . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . $img_components[1];
                    $img_relative_path = "/assets/images/" . $img_components[1];
                    if (!move_uploaded_file($img_components[0], $img_absolute_path)) {
                        Application::$app->session->setFlash('error', 'Image couldn\'t be uploaded');                            return;
                    }   
                    $blog->featured_img = $img_relative_path;
                }
                    
                $blog->unsetErrorArray();
                $this->blogRepo->update($blog);
                Application::$app->session->setFlash('success', 'Blog updated successfully');
                return $response->redirect('/admin/admin-home');
            }

            return $this->render('/admin/admin-editBlog', ['model' => $blog]);
        }

        public function deleteBlog(Request $request, Response $response)
        {
            $requestData = $request->getBody();
            $blog_id = isset($requestData['id']) ? (int)$requestData['id'] : null;
            if($this->blogRepo->delete($blog_id)) {
                Application::$app->session->setFlash('success', 'Blog deleted successfully');
            } else {
                Application::$app->session->setFlash('error', 'Blog deletion unsuccessful');
            }
            return $response->redirect('/admin/admin-home');
        }
    }

?>