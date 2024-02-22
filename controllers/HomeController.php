<?php
    namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\models\ContactForm;

    class HomeController extends Controller
    {
        
        public function home() {
            $params = [
                'name' => 'kshitiz',
            ];
            return $this->render('home', $params);
        }

        public function contact(Request $request, Response $response) {
            $contactForm = new ContactForm();
            if($request->isPost())
            {
                $contactForm->loadData($request->getBody());
                if($contactForm->validate() && $contactForm->send())
                {
                    Application::$app->session->setFlash('success', 'Your message has been sent successfully');
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
    }

?>