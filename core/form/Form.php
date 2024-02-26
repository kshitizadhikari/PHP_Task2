<?php
    namespace app\core\form;

    use app\core\Model;

    class Form
    {
        public static function begin($action, $method)
        {
            echo sprintf('<form action="%s" method="%s" enctype="multipart/form-data">', $action, $method);
            return new Form; // Return an instance of Form for chaining
        }

        public static function end()
        {
            echo '</form>';
        }

        public function field(Model $model, $attribute)
        {
            return new InputField($model, $attribute); // Return an instance of Field
        }
    }
?>
