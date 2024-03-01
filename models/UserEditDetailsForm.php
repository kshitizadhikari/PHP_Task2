<?php
    namespace app\models;

    class UserEditDetailsForm extends User
    {
        public int $id;
        public string $firstName = '';
        public string $lastName = '';
        public string $email = '';
        public int $status;
        public int $role_id;

        public function rules(): array {
            return [
                'firstName' => [self::RULE_REQUIRED, ],
                'lastName' =>[self::RULE_REQUIRED],
                'email' =>[self::RULE_REQUIRED, self::RULE_EMAIL]
            ];
        }

        public function labels(): array {
            return [
                'id' => '',
                'firstName' => 'First Name',
                'lastName' => 'Last Name',
                'email' => 'Email',
                'status' => 'Status',
            ];
        }
    }