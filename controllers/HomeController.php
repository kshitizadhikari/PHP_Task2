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
use app\repository\UserRepository;

    class HomeController extends Controller
    {
        protected BlogRepository $blogRepo;
        protected ContactRepository $contactRepo;
        protected UserRepository $userRepo;
        protected const ROW_START = 0;
        protected const ROW_LIMIT = 2;

        public function __construct() {
            $this->blogRepo = new BlogRepository();
            $this->contactRepo = new ContactRepository();
            $this->userRepo = new UserRepository();
        }
        
        public function home(Request $request) {
            $searchTerm = $request->getBody()['search'] ?? null;
            $currentBlogPage = 1; // Default to the first page
            $newBlogStart = 0; // Start index for SQL query
            
            // Adjust current page and start index based on the request
            if (isset($request->getBody()['blogPage'])) {
                $currentBlogPage = (int)$request->getBody()['blogPage'];
                $newBlogStart = ($currentBlogPage - 1) * self::ROW_LIMIT;
            }
            
            // Handle search functionality
            if ($searchTerm) {
                $searchTerm = "$searchTerm";
                $allBlogs = $this->blogRepo->searchWithPagination('title', $searchTerm, $newBlogStart, self::ROW_LIMIT);
            } else {
                //if no search return the first set of data
                $allBlogs = $this->blogRepo->findWithLimit($newBlogStart, self::ROW_LIMIT);
            }

            $totalBlogPages = $this->blogRepo->findTotalPages(self::ROW_LIMIT);
            // Handling AJAX requests differently
            if ($request->isAjax()) {
                // Assuming there's a separate view for the table to be included in AJAX response
                return $this->renderPartialView('../views/ajax-partialViews/blog_table', [
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
            $author = $this->userRepo->findById($blog->user_id);
            if(!$blog) {
                Application::$app->session->setFlash('error', 'Blog view error');
                return $response->redirect('/');
            }
            return $this->render('viewBlog', ['blog' => $blog, 'author' => $author]);
        }
    }

?>