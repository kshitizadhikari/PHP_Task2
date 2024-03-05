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

        public function hasfile(string $key): bool {
            return isset($_FILES[$key]) && $_FILES[$key]['error'] === UPLOAD_ERR_OK;
        }

        public function isAjax(): bool
        {
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                return true;
            }
            return false;
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
                $filesUploaded = false;
                foreach ($_FILES as $file) {
                    if ($file['error'] == UPLOAD_ERR_OK) {
                        $filesUploaded = true;
                        break; // No need to continue checking once we find a successful upload
                    }
                }
                 // Check if request contains files
                if ($filesUploaded) {
                    foreach ($_FILES as $key => $file) {
                        $file_name = $_FILES[$key]['name'];
                        $file_name_only = pathinfo($file_name, PATHINFO_FILENAME);
                        $file_size = $_FILES[$key]['size'] / (1024 * 1024); // Convert to MB
                        $file_loc = $_FILES[$key]['tmp_name'];
                        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
                        if (!in_array($file_ext, ['jpg', 'jpeg', 'png'])) {
                            Application::$app->session->setFlash('error', 'Unsupported image extension');
                            return [];
                        }

                        // Check image size (1MB limit)
                        if ($file_size > 1) {
                            Application::$app->session->setFlash('error', 'Image size must be less than 1MB');
                            return [];
                        }

                        // Define the destination path and separate the path and filename from '#'
                        $img_dest = $file_loc . "#" . $file_name_only  . "." . $file_ext;
                        $body[$key] = $img_dest;
                        $body['file_info'] = [
                            'fileName' => $file_name_only,
                            'fileSize' => $file_size,
                            'fileExt' => $file_ext,
                            'filePath' => Application::$app::$ROOT_DIR . '\public\assets/images\\' . $file_name,
                        ];
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
        