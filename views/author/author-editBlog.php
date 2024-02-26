<?php
/**
 * @var $this \app\core\View
 * @var $model \app\models\Blog
 * 
 */
use app\core\form\Form;
use app\core\form\TextareaField;

$this->title = 'Author Edit Blog Page';
?>

<h1>Author Edit Blog</h1>

<?php $form = Form::begin('', 'post')?>
    <?php echo $form->field($model, 'id')->hiddenField(); ?>
    <?php echo $form->field($model, 'title') ?>
    <?php echo new TextareaField($model, "description")?>
    <?php echo $form->field($model, 'featured_img') ?>
    <?php echo $form->field($model, 'status') ?>
    <button type="submit" class="btn btn-primary">Update</button>
<?php Form::end(); ?>