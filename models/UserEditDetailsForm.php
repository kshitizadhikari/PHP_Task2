<?php
    namespace app\models;

use app\core\Application;
use app\core\Model;
use app\core\Request;
use app\repository\UserRepository;

    class UserEditDetailsForm extends Model
    {
        public string $firstName = '';
        public string $lastName = '';
        public string $email = '';
        public string $oldPassword = '';
        public string $newPassword = '';
        public string $confirmPassword = '';

        public function rules(): array {
            return [
                'firstName' => [self::RULE_REQUIRED, ],
                'lastName' =>[self::RULE_REQUIRED],
                'email' =>[self::RULE_REQUIRED, self::RULE_EMAIL],
                'oldPassword' => [self::RULE_REQUIRED],
                'newPassword' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8], [self::RULE_MAX, 'max' => 24]],
                'confirmPassword' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match'=> 'newPassword']],
            ];
        }

        public function labels(): array {
            return [
                'firstName' => 'First Name',
                'lastName' => 'Last Name',
                'email' => 'Email',
                'oldPasssword' => 'Old Password',
                'newPassword' => 'New Password',
                'confirmPassword' => 'Confirm Password',
            ];
        }

        public function editDetails(UserRepository $userRepo)
        {
            $user = Application::$app->user;
    
            if (!password_verify($this->oldPassword, $user->password)) {
                $this->addError('oldPassword', "Password is incorrect");
                return false;
            }
            unset($user->errors);
            $user->firstName = $this->firstName;
            $user->lastName = $this->lastName;
            $user->email = $this->email;
            $user->password = $userRepo->hashPassword($this->newPassword);
            $userRepo->update($user);
            return;
        }
    }