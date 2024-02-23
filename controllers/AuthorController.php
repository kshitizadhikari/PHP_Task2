<?php
    namespace app\controllers;

    use app\core\Application;
    use app\core\Controller;
    use app\core\middlewares\AuthMiddleware;
    use app\core\Request;
    use app\core\Response;
    use app\models\Blog;
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


        public function editDetails(Request $request) {
            $editDetailsForm = new UserEditDetailsForm;
            if($request->isPost())
            {
                $editDetailsForm->loadData($request->getBody());
                if($editDetailsForm->validate() && $editDetailsForm->editDetails($this->userRepo))
                {   
                    return 'success';
                }
            }
            return $this->render('/author/author-editDetails', ['model' => $editDetailsForm]);
        }

        public function createBlog(Request $request, Response $response)
        {
            $blog = new Blog();
            if($request->isPost())
            {
                $blog->loadData($request->getBody());
                if($blog->validate())
                {
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
    }

?>