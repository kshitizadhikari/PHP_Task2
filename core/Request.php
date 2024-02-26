<?php
    namespace app\core;

    class Request
    {
        public function getPath()
        {
            $path = $_SERVER['REQUEST_URI'] ??  '/';
            $position = strpos($path, '?');

            if($position === false){
                return $path;
            }
            $path = substr($path, 0, $position);
            return $path;
        }

        public function getMethod()
        {
            return strtolower($_SERVER['REQUEST_METHOD']);
        }

        public function isGet()
        {
            return $this->getMethod() === 'get';
        }

        public function isPost()
        {
            return $this->getMethod() === 'post';
        }

        public function getBody()
        {
            $body = [];
            if($this->getMethod() == 'get')
            {
                foreach($_GET as $key=>$value)
                {
                    $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                }
            }

            if($this->getMethod() == 'post')
            {
                 // Check if request contains files
                if (!empty($_FILES)) {
                    foreach ($_FILES as $key => $file) {
                        $img_name = $_FILES[$key]['name'];
                        $pictureName = pathinfo($img_name, PATHINFO_FILENAME);
                        $img_size = $_FILES[$key]['size'] / (1024 * 1024); // Convert to MB
                        $img_loc = $_FILES[$key]['tmp_name'];
                        $img_ext = strtolower(pathinfo($img_name, PATHINFO_EXTENSION));
                        if (!in_array($img_ext, ['jpg', 'jpeg', 'png'])) {
                            Application::$app->session->setFlash('error', 'Unsupported image extension');
                            return [];
                        }

                        // Check image size (1MB limit)
                        if ($img_size > 1) {
                            Application::$app->session->setFlash('error', 'Image size must be less than 1MB');
                            return [];
                        }

                        // Define the destination path
                        $img_dest = $img_loc . "#" . $pictureName  . "." . $img_ext;
                        $body[$key] = $img_dest;

                    }
                }
                foreach($_POST as $key=>$value)
                {
                    $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                }
            }
            return $body;
        }
    }
        