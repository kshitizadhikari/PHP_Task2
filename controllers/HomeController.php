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
        protected const ROW_LIMIT = 5;
        public function __construct() {
            $this->blogRepo = new BlogRepository();
            $this->contactRepo = new ContactRepository();
        }
        
        public function home(Request $request) {
            if(isset($request->getBody()['search'])) {
                $searchQuery = $request->getBody()['search'] . "%";
                $allBlogs = $this->blogRepo->searchBlogs($searchQuery);

            } else {
                // Load all users if no search query
                $currentBlogPage = self::ROW_START;
                $newBlogStart = $currentBlogPage;
                if(isset($request->getBody()['blogPage'])){
                    $currentBlogPage = $request->getBody()['blogPage'] - 1;
                    $newBlogStart = $currentBlogPage * self::ROW_LIMIT;
                }
                $totalBlogPages = $this->blogRepo->findTotalPages(self::ROW_LIMIT);
                $allBlogs = $this->blogRepo->findWithLimit($newBlogStart,self::ROW_LIMIT);
            }
            // $sortBy = isset($_GET['sort_by'])  ? $_GET['sort_by'] : 'id';
            // $sortOrder = isset($_GET['sort_order']) ? $_GET['sort_order'] : 'ASC';
        
            // // Perform sorting based on the selected column and order
            // usort($allBlogs, function($a, $b) use ($sortBy, $sortOrder) {
            //     if($a[$sortBy] == $b[$sortBy]) {
            //         return 0;
            //     }
            //     return ($sortOrder == 'ASC') ? ($a[$sortBy] < $b[$sortBy] ? -1 : 1) : ($a[$sortBy] > $b[$sortBy] ? -1 : 1);
            // });
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