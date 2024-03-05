<?php
    namespace app\models;

use app\core\Model;

    class AddImageForm extends Model
    {
        public string $absolute_path = '';
        public function rules(): array {
            return [
                'absolute_path' => [self::RULE_REQUIRED]
            ];
        }


        public function labels(): array
        {
            return [
                'absolute_path' => 'Choose Image File',
            ];
        }
    }