<?php
/**
 * @var $this \app\core\View
 * @var $model \app\models\Blog
 * 
 */

use app\core\form\Form;
use app\core\form\TextareaField;

$this->title = 'Admin Create Blog Page';
?>
<h1>Admin Create Blog</h1>

<?php $form = Form::begin('', 'post')?>
    <?php echo $form->field($model, 'title') ?>
    <?php echo new TextareaField($model, "description")?>
    <?php echo $form->field($model, 'featured_img')->fileField() ?>
    <button type="submit" class="btn btn-primary">Create</button>
<?php Form::end(); ?>
<div class="mt-3">
    <button class="btn btn-primary  " onclick="window.location.href='/admin/admin-home'">Go Back</button>
</div>
