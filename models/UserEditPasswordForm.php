<?php
    namespace app\models;

use app\core\Application;
use app\core\Model;
use app\core\Request;
use app\repository\UserRepository;

    class UserEditPasswordForm extends Model
    {
        public int $id;
        public string $oldPassword = '';
        public string $newPassword = '';
        public string $confirmPassword = '';

        public function rules(): array {
            return [
                'oldPassword' => [self::RULE_REQUIRED],
                'newPassword' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8], [self::RULE_MAX, 'max' => 24]],
                'confirmPassword' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match'=> 'newPassword']],
            ];
        }

        public function labels(): array {
            return [
                'id' => '',
                'oldPasssword' => 'Old Password',
                'newPassword' => 'New Password',
                'confirmPassword' => 'Confirm Password',
            ];
        }

        public function checkPassword()
        {
            $user = Application::$app->user;
            if (!password_verify($this->oldPassword, $user->password)) {
                $this->addError('oldPassword', "Password is incorrect");
                return false;
            }
            return true;
        }
    }