<?php
/**
 * @var $this \app\core\View
 * @var $model \app\models\UserEditDetailsForm
 * 
 */
use app\core\form\Form;

$this->title = 'Author Edit Details Page';
?>

<h1>Author Edit Details</h1>

<?php $form = Form::begin('', "post") ?>
    <div class="row">
        <div class="col"><?php echo $form->field($model, 'firstName'); ?></div>
        <div class="col"><?php echo $form->field($model, 'lastName'); ?></div>
    </div>
    <?php echo $form->field($model, 'email'); ?>
    <?php echo $form->field($model, 'oldPassword')->passwordField(); ?>
    <?php echo $form->field($model, 'newPassword')->passwordField(); ?>
    <?php echo $form->field($model, 'confirmPassword')->passwordField(); ?>
    <button type="submit" class="btn btn-primary">Submit</button>
<?php app\core\form\Form::end(); ?>