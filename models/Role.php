<?php
    namespace app\models;

use app\core\Model;
use app\core\UserModel;

    class Role extends Model
    {

        public string $role;

        public function rules(): array
        {
            return [
                'role' => self::RULE_REQUIRED
            ];
        }

        public static function tableName(): string {
            return 'roles';
        }

        public function attributes(): array {
            return ['role'];
        }

        public static function primaryKey(): string {
            return 'id';
        }

    }