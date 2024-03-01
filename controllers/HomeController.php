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
        protected const ROW_START = 0;
        protected const ROW_LIMIT = 2;

        public function __construct() {
            $this->blogRepo = new BlogRepository();
            $this->contactRepo = new ContactRepository();
        }
        
        public function home(Request $request) {
            $searchParam = $request->getBody()['search'] ?? null;
            $currentBlogPage = 1; // Default to the first page
            $newBlogStart = 0; // Start index for SQL query
            
            // Adjust current page and start index based on the request
            if (isset($request->getBody()['blogPage'])) {
                $currentBlogPage = (int)$request->getBody()['blogPage'];
                $newBlogStart = ($currentBlogPage - 1) * self::ROW_LIMIT;
            }
            
            // Handle search functionality
            if ($searchParam) {
                $searchParam = "$searchParam%";
                $allBlogs = $this->blogRepo->searchBlogs($searchParam, $newBlogStart, self::ROW_LIMIT);
            } else {
                $allBlogs = $this->blogRepo->findWithLimit($newBlogStart, self::ROW_LIMIT);
            }
            
            $totalBlogPages = $this->blogRepo->findTotalPages(self::ROW_LIMIT);
            // Handling AJAX requests differently
            if ($request->isAjax()) {
                // Assuming there's a separate view for the table to be included in AJAX response
                return $this->renderPartialView('blog_table', [
                    'allBlogs' => $allBlogs,
                    'blogPageNum' => $currentBlogPage,
                    'totalBlogPages' => $totalBlogPages
                ]);
            } 
            return $this->render('home', ['allBlogs' => $allBlogs, 'blogPageNum'=>$currentBlogPage, 'totalBlogPages' => $totalBlogPages]);
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