<?php
    namespace app\models;

    use app\core\Model;

    class Blog extends Model
    {
        public int $id=0;
        public string $title = '';
        public string $description = '';
        public string $featured_img = '';
        public int $user_id; //created by user_id
        public int $status = 1; //blog status

        public static function tableName(): string {
            return 'blogs';
        }

        public function attributes(): array {
            return ['id', 'title', 'description', 'featured_img', 'user_id', 'status'];
        }

        public function labels(): array {
            return [
                'id' => '',
                'title' => 'Blog Title',
                'description' => 'Description',
                'featured_img' => 'Featured Image',
                'status' => 'Blog Status',
            ];
        }
        public function rules(): array  
        {
            return [
                'title' => [self::RULE_REQUIRED],
                'description' => [self::RULE_REQUIRED],
                'featured_img' => [self::RULE_REQUIRED],
                'status' => [self::RULE_REQUIRED],
            ];
        }
        
    }
    

?>