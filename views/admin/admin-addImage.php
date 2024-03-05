<?php
/**
 * @var $this \app\core\View
 * @var $model \app\models\Image
 * 
 */

use app\core\form\Form;

$this->title = 'Admin Add Image Page';
?>
<h1>Admin Add Image</h1>

<?php $form = Form::begin('', 'post')?>
    <?php echo $form->field($model, 'featured_img')->fileField() ?>
    <button type="submit" class="btn btn-primary">Add</button>
<?php Form::end(); ?>
<div class="mt-3">
    <button class="btn btn-primary  " onclick="window.location.href='/admin/admin-imageGallery'">Go Back</button>
</div>
