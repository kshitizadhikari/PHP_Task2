<?php
    namespace app\models;

    use app\core\Model;

    class Image extends Model
    {
        public int $id;
        public string $relative_path = '';
        public string $img_name = '';
        public string $img_ext = '';
        public int $size;
        public int $status = 1;

        public static function tableName(): string {
            return 'images';
        }

        public function attributes(): array {
            return ['relative_path', 'img_name', 'img_ext', 'size', 'status'];
        }

        public static function primaryKey(): string {
            return 'id';
        }

        public function labels(): array {
            return [
                'relative_path' => 'Path',
                'img_name' => 'Image Name',
                'img_ext' => 'Image Extension',
                'size' => 'Image Size',
                'status' => 'Status',
            ];
        }
        public function rules(): array
        {
            return [
                'relative_path' => [self::RULE_REQUIRED],
                'img_name' => [self::RULE_REQUIRED],
                'img_ext' => [self::RULE_REQUIRED, ],
                'size' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 0], [self::RULE_MAX, 'max' => 3]],
            ];
        }
    }
    

?>