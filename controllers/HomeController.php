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
            $currentBlogPage = 1; // Default to the first page
            $offset = 0; // Start index for SQL query'
            $itemsPerPage = self::ROW_LIMIT;
            
            // Adjust current page and start index based on the request
            if (isset($request->getBody()['blogPage'])) {
                $currentBlogPage = (int)$request->getBody()['blogPage'];
                $offset = ($currentBlogPage - 1) * $itemsPerPage;
            }
            
            $allBlogs = $this->blogRepo->findWithLimit($offset, $itemsPerPage);

            $totalBlogPages = $this->blogRepo->findTotalPages($itemsPerPage);
            // Handling AJAX requests differently
            if ($request->isAjax()) {
                if(isset($request->getBody()['searchTitle'])) {
                    // Adjust the query based on whether there's a search term
                    $searchTerm = $request->getBody()['searchTitle'];
                    $blogs = $this->blogRepo->searchWithPagination('title', $searchTerm, $offset, $itemsPerPage);
                    return $this->renderPartialView('../views/ajax-partialViews/blog_table', [                                                                                  
                        'allBlogs' => $blogs,
                        'blogPageNum' => $currentBlogPage,
                        'totalBlogPages' => $totalBlogPages,
                    ]);                         
                }
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

        public function imageGallery() {
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
            
            return $this->render('/imageGallery', ['images' => $imagesWithPath]);
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
                    return $response->redirect('/');
                } else {
                    $response->setStatusCode(500);
                    Application::$app->session->setFlash('error', 'Image couldn\'t be deleted');

                }
            } else {
                $response->setStatusCode(404);
            }
        
            return;
        }                                                                               
        
    }

?>