<?php
    namespace app\models;

    use app\core\UserModel;

    class User extends UserModel
    {
        const STATUS_INACTIVE = 0;  
        const STATUS_ACTIVE = 1;
        const STATUS_DELETED = 2;
        public int $id;
        public string $firstName = '';
        public string $lastName = '';
        public string $email = '';
        public string $password = '';
        public int $status = 0;
        public int $role_id = 4;

        public static function tableName(): string {
            return 'users';
        }

        public function attributes(): array {
            return ['firstName', 'lastName', 'email', 'password', 'status', 'role_id'];
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
                'status' => 'Status',
                'role_id' => 'Role Id',
                'id' => ''
            ];
        }
        public function rules(): array
        {
            return [
                'firstName' => [self::RULE_REQUIRED],
                'lastName' => [self::RULE_REQUIRED],
                'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [self::RULE_UNIQUE, 'class' => self::class]],
                'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8], [self::RULE_MAX, 'max' => 24]],
            ];
        }

        public function getDisplayName(): string
        {
            return $this->firstName . ' ' . $this->lastName;
        }
    }
    

?>