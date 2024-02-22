<?php

    namespace app\models;

use app\core\Application;
use app\core\Model;
use app\core\Request;
use app\core\Response;
use PHPMailer\PHPMailer\PHPMailer;

    class ContactForm extends Model
    {
        public string $subject = '';
        public string $email = '';
        public string $body = '';

        public function rules(): array
        {
            return [
                'subject' => [self::RULE_REQUIRED],
                'email' => [self::RULE_REQUIRED],
                'body' => [self::RULE_REQUIRED],
            ];
        }

        public function labels(): array {
            return [
                'subject' => 'Enter Subject',
                'email' => 'Enter Your Email',
                'body' => 'Enter Body',
            ];
        }

        public function send()
        {
            return true;
        }
    }