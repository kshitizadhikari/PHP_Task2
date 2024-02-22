<?php
    namespace app\core;

    class Session
    {
        protected const FLASH_KEY = 'flash_messages';

        public function __construct() {
            session_start();
            $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
            foreach($flashMessages as $key=>&$flashMessage)
            {
                //mark flash message to remove it
                $flashMessage['remove'] = true;
            }
            $_SESSION[self::FLASH_KEY] = $flashMessages;
        }

        public function setFlash($key, $message)
        {
            $_SESSION[self::FLASH_KEY][$key] = [
                'value' => $message,
                'remove' => false
            ];

        }

        public function getFlash($key)
        {   
            return $_SESSION[self::FLASH_KEY][$key]['value'] ?? NULL;
        }


        public function set($key, $value)
        {
            $_SESSION[$key] = $value;
        }

        public function get($key)
        {
            return $_SESSION[$key] ?? false;
        }

        public function remove($key)
        {
            unset($_SESSION[$key]);
        }

        public function __destruct()
        {
            //iterate over marked to be removed and remove them
            $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
            foreach($flashMessages as $key=>&$flashMessage)
            {
                //mark flash message to remove it
                if($flashMessage['remove'] == true) {
                    unset($flashMessages[$key]);
                }
            }
            $_SESSION[self::FLASH_KEY] = $flashMessages;
        }
    }
?>