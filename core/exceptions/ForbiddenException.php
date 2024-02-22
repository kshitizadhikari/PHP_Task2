<?php
    namespace app\core\exceptions;

use Exception;

    class ForbiddenException extends Exception
    {
        protected $code = 403;
        protected $message = "You don't have permission to access to this page";
    }

?>