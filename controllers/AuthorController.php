<?php
    namespace app\controllers;

    use app\core\Application;
    use app\core\Controller;
    use app\core\middlewares\AuthMiddleware;
    use app\core\Request;
    use app\core\Response;
    use app\models\Blog;
    use app\models\User;
    use app\models\UserEditDetailsForm;
use app\models\UserEditPassword;
use app\models\UserEditPasswordForm;
use app\repository\BlogRepository;
    use app\repository\RoleRepository;
    use app\repository\UserRepository;

    class AuthorController extends Controller
    {
        protected $userRepo;
        protected $roleRepo;
        protected $blogRepo;
        protected $role_id = 3;
        
        public function __construct() {
            $this->setLayout('authorLayout');
            $this->registerMiddleWare(new AuthMiddleware($this->role_id, []));
            $this->userRepo = new UserRepository();
            $this->roleRepo = new RoleRepository();
            $this->blogRepo = new BlogRepository();
        }

        public function home() {
            $allBlogs = $this->blogRepo->findAll();
            return $this->render('/author/author-home', ['allBlogs' => $allBlogs]);
        }

        public function profile() {
            $user = Application::$app->user;
            $role = $this->roleRepo->findById($user->role_id);
            return $this->render('/author/author-profile', ['user' => $user, 'role' => $role]);
        }


        public function editDetails(Request $request, Response $response) {
            if($request->isPost())
            {
                $user = new UserEditDetailsForm();
                $user->loadData($request->getBody());
                if(!$user->validate())
                {
                    return $this->render('/author/author-editDetails', ['model' => $user]);
                }
                $toUpdateUser = new User();
                $toUpdateUser = $this->userRepo->findById($user->id);
                $toUpdateUser->firstName = $user->firstName;
                $toUpdateUser->lastName = $user->lastName;
                $toUpdateUser->email = $user->email;
                $toUpdateUser->unsetErrorArray();
                $this->userRepo->update($toUpdateUser);
                return $response->redirect('/author/author-home');
            }

            $user = new User();
            $requestData = $request->getBody();
            $user = $this->userRepo->findById($requestData['id']);
            $user->password = '';
            if($user==null) {
                Application::$app->session->setFlash('error', 'User Not Found');
                return $response->redirect('/author/author-home');
            }
            return $this->render('/author/author-editDetails', ['model'=>$user]); //return UserEditDetailsForm obj
        }

        public function createBlog(Request $request, Response $response)
        {
            if($request->isPost()) {
                $blog = new Blog();
                $blog->loadData($request->getBody());
                if(!$blog->validate()) {
                    return $this->render('/author/author-createBlog', ['model' => $blog]);
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
                        $response->redirect('/author/author-home');
                }
            }
            $blog = new Blog();
            return $this->render('/author/author-createBlog', ['model' => $blog]);
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
                    return $this->render('/author/author-editBlog', ['model' => $blog]);
                }

                
                if(isset($requestData['featured_img']))
                {
                    // Move uploaded file to destination
                    //img_components[0] stores temporary path img_components[1] stores imageName
                    $img_components = explode("#", $blog->featured_img); 
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
                return $response->redirect('/author/author-home');
            }

            return $this->render('/author/author-editBlog', ['model' => $blog]);
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
            return $response->redirect('/author/author-home');
        }

        public function viewBlog(Request $request, Response $response)
        {
            $requestData = $request->getBody();
            $blog_id = isset($requestData['id']) ? (int)$requestData['id'] : null;
            $blog = new Blog();
            $blog = $this->blogRepo->findById($blog_id); 
            if(!$blog) {
                Application::$app->session->setFlash('error', 'Blog view error');
                return $response->redirect('/author/author-home');
            }
            return $this->render('/author/author-viewBlog', ['blog' => $blog]);
        }

        public function changePassword(Request $request, Response $response)
        {
            if($request->isPost())
            {
                $pwObj = new UserEditPasswordForm();
                $pwObj->loadData($request->getBody());
                if(!$pwObj->validate() || !$pwObj->checkPassword())
                {
                    return $this->render('/author/author-changePassword', ['model' => $pwObj]);
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
                return $response->redirect('/author/author-home');
            }

            $pwObj = new UserEditPasswordForm();
            return $this->render('/author/author-changePassword', ['model' => $pwObj]);
        }
    }   
?>