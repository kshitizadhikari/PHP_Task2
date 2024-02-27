<?php
/**
 * @var $this \app\core\View
 * @var $model \app\models\User
 * 
 */
use app\core\form\Form;

$this->title = 'Admin Create User Page';
?>

<h1>Create New User</h1>

<?php $form = Form::begin('', "post") ?>
    <div class="row">
        <div class="col"><?php echo $form->field($model, 'firstName'); ?></div>
        <div class="col"><?php echo $form->field($model, 'lastName'); ?></div>
    </div>
    <?php echo $form->field($model, 'email'); ?>
    <?php echo $form->field($model, 'password')->passwordField(); ?>
    <?php echo $form->field($model, 'status'); ?>
    <?php echo $form->field($model, 'role_id'); ?>
    <button type="submit" class="btn btn-primary">Submit</button>
<?php app\core\form\Form::end(); ?>