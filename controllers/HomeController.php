<?php
    namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\models\Blog;
use app\models\ContactForm;
use app\repository\BlogRepository;

    class HomeController extends Controller
    {
        protected BlogRepository $blogRepo;
        public function __construct() {
            $this->blogRepo = new BlogRepository();
        }
        
        public function home() {
            $allBlogs = $this->blogRepo->findAll();
            return $this->render('home', ['allBlogs' => $allBlogs]);
        }

        public function contact(Request $request, Response $response) {
            $contactForm = new ContactForm();
            if($request->isPost())
            {
                $contactForm->loadData($request->getBody());
                if($contactForm->validate() && $contactForm->send())
                {
                    Application::$app->session->setFlash('success', 'Your message has been mailed successfully');
                    return $response->redirect('/');
                }
            }
            return $this->render('contact', ['model' => $contactForm]);
        }

        public function handleContact(Request $request) {
            $body = $request->getBody();
            var_dump($body);
            return "handle contact";
        }

        public function viewBlog(Request $request, Response $response)
        {
            $requestData = $request->getBody();
            $blog_id = isset($requestData['id']) ? (int)$requestData['id'] : null;
            $blog = new Blog();
            $blog = $this->blogRepo->findById($blog_id); 
            if(!$blog) {
                Application::$app->session->setFlash('error', 'Blog view error');
                return $response->redirect('/');
            }
            return $this->render('viewBlog', ['blog' => $blog]);
        }
    }

?>