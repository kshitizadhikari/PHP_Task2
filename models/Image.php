<?php
    namespace app\models;

    use app\core\Model;

    class Image extends Model
    {
        public int $id;
        public string $img_name = '';
        public string $img_ext = '';
        public string $relative_path = '';
        public string $absolute_path = '';
        public int $size;
        public int $status = 1;

        public static function tableName(): string {
            return 'images';
        }

        public function attributes(): array {
            return ['img_name', 'img_ext', 'relative_path', 'absolute_path', 'size', 'status'];
        }

        public static function primaryKey(): string {
            return 'id';
        }

        public function labels(): array {
            return [
                'img_name' => 'Image Name',
                'img_ext' => 'Image Extension',
                'relative_path' => 'Relative Path',
                'absolute_path' => 'Absolute Path',
                'size' => 'Image Size',
                'status' => 'Status',
            ];
        }
        public function rules(): array
        {
            return [
                'img_name' => [self::RULE_REQUIRED],
                'img_ext' => [self::RULE_REQUIRED, ],
                'relative_path' => [self::RULE_REQUIRED],
                'absolute_path' => [self::RULE_REQUIRED],
                'size' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 0], [self::RULE_MAX, 'max' => 3]],
            ];
        }
    }
    

?>