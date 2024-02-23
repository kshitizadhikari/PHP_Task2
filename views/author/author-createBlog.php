<?php
/**
 * @var $this \app\core\View
 * @var $model \app\models\Blog
 * 
 */

use app\core\form\Form;
use app\core\form\TextareaField;

$this->title = 'Author Create Blog Page';
?>
<h1>Author Create Blog</h1>

<?php $form = Form::begin('', 'post')?>
    <?php echo $form->field($model, 'title') ?>
    <?php echo new TextareaField($model, "description")?>
    <?php echo $form->field($model, 'featured_img') ?>
    <button type="submit" class="btn btn-primary">Create</button>
<?php Form::end(); ?>