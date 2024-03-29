<?php
    namespace app\models;

use app\core\db\DbModel;

    class UserRegisterForm extends DbModel
    {
        const STATUS_INACTIVE = 0;
        const STATUS_ACTIVE = 1;
        const STATUS_DELETED = 2;
        public string $firstName = '';
        public string $lastName = '';
        public string $email = '';
        public string $password = '';
        public string $confirmPassword = '';
        public int $status;
        public ?int $role_id;

        public static function tableName(): string {
            return 'users';
        }

        public function attributes(): array {
            return ['firstName', 'lastName', 'email', 'password', 'status'];
        }

        public static function primaryKey(): string {
            return 'id';
        }

        public function labels(): array {
            return [
                'firstName' => 'First Name',
                'lastName' => 'Last Name',
                'email' => 'Email',
                'password' => 'Password',
                'confirmPassword' => 'Confirm Password',
            ];
        }

        public function save()
        {
            
            $this->password = password_hash($this->password, PASSWORD_DEFAULT);
            $this->status = self::STATUS_INACTIVE; 
            return parent::save();
        }

        public function rules(): array
        {
            return [
                'firstName' => [self::RULE_REQUIRED],
                'lastName' => [self::RULE_REQUIRED],
                'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [self::RULE_UNIQUE, 'class' => self::class]],
                'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8], [self::RULE_MAX, 'max' => 24]],
                'confirmPassword' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']],
            ];
        }
    }
    

?>