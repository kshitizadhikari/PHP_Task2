<?php
    namespace app\models;
    use app\core\Application;
    use app\core\Model;
    use app\repository\UserRepository;

    class UserEditDetailsForm extends Model
    {
        public int $id;
        public string $firstName = '';
        public string $lastName = '';
        public string $email = '';

        public function rules(): array {
            return [
                'firstName' => [self::RULE_REQUIRED, ],
                'lastName' =>[self::RULE_REQUIRED],
                'email' =>[self::RULE_REQUIRED, self::RULE_EMAIL],
            ];
        }

        public function labels(): array {
            return [
                'id' => '',
                'firstName' => 'First Name',
                'lastName' => 'Last Name',
                'email' => 'Email',
            ];
        }
    }