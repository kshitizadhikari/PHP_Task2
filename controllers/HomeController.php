<?php
    namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\models\Blog;
use app\models\Contact;
use app\repository\BlogRepository;
use app\repository\ContactRepository;

    class HomeController extends Controller
    {
        protected BlogRepository $blogRepo;
        protected ContactRepository $contactRepo;
        public function __construct() {
            $this->blogRepo = new BlogRepository();
            $this->contactRepo = new ContactRepository();
        }
        
        public function home() {
            $allBlogs = $this->blogRepo->findAll();
            return $this->render('home', ['allBlogs' => $allBlogs]);
        }

        public function contact(Request $request, Response $response) {
            if($request->isPost())
            {
                $contact = new Contact();
                $contact->loadData($request->getBody());
                if(!$contact->validate())
                {
                    return $this->render('contact', ['model'=>$contact]);
                }
                $contact->unsetErrorArray();
                if(!$this->contactRepo->save($contact))
                {
                    Application::$app->session->setFlash('error', 'Error sending message');
                    return $response->redirect('/');
                }
                Application::$app->session->setFlash('success', 'Message successfully sent');
                return $response->redirect('/');

            }
            $contact = new Contact();
            return $this->render('contact', ['model' => $contact]);
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