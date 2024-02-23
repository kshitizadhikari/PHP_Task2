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
                    return $response->redirect('/author/author-home');
                }
            }
            return $this->render('/author/author-editDetails', ['model' => $editDetailsForm]);
        }

        public function createBlog(Request $request, Response $response)
        {
            $blog = new Blog();
            if($request->isPost()) {
                $blog->loadData($request->getBody());
                if($blog->validate()) {
                    $blog->unsetErrorArray();
                    $blog->user_id = $_SESSION['user'];
                    if($this->blogRepo->save($blog)){
                        Application::$app->session->setFlash('success', 'Blog created successfully');
                        $response->redirect('/author/author-home');
                    }
                }
            }
            return $this->render('/author/author-createBlog', ['model' => $blog]);
        }

        public function editBlog(Request $request, Response $response) {
            $requestData = $request->getBody();
            $blog_id = isset($requestData['id']) ? (int)$requestData['id'] : null;
            $blog = $this->blogRepo->findById($blog_id);

            if($request->isPost())
            {
                $requestData = $request->getBody();
                $blog = new Blog();
                $blog = $this->blogRepo->findById($blog_id);
                $blog->loadData($requestData);
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
    }   
?>