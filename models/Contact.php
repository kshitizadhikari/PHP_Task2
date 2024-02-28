<?php
    namespace app\models;

    use app\core\Model;

    class Contact extends Model
    {
        public int $id;
        public string $email = '';
        public string $subject = '';
        public string $body = '';
        public int $status = 0; //blog status

        public static function tableName(): string {
            return 'contacts';
        }

        public function attributes(): array {
            return ['id', 'email', 'subject', 'body', 'status'];
        }

        public function labels(): array {
            return [
                'id' => '',
                'email' => 'Enter your Email',
                'subject' => 'Subject',
                'body' => 'Body',
                'status' => 'Status',
            ];
        }
        public function rules(): array  
        {
            return [
                'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
                'subject' => [self::RULE_REQUIRED],
                'body' => [self::RULE_REQUIRED],
            ];
        }
        
    }
    

?>