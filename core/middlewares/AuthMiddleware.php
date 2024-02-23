<?php
    namespace app\core\middlewares;

use app\core\Application;
use app\core\exceptions\ForbiddenException;

    class AuthMiddleware extends BaseMiddleware
    {

        public array $actions = [];
        public int $role_id;

        public function __construct(int $role_id,array $actions = []) {
            $this->actions = $actions;
            $this->role_id = $role_id;
        }
        public function execute()
        {
            if(Application::isGuest())
            {
                if(empty($this->actions) || in_array(Application::$app->controller->action, $this->actions))
                {
                    throw new ForbiddenException();
                }
            }

            if(Application::$app->user->role_id !== $this->role_id) {
                throw new ForbiddenException();
            }
            
        }
    }

?>