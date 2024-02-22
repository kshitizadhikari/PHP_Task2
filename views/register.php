<?php
    /**
    * @var model \app\models\User
    * @var $this \app\core\View
    */
    use app\core\form\Form;
    $this->title = 'Register Page';  
?>
<h1>Register Page</h1>
<?php $form = Form::begin('', "post") ?>
    <div class="row">
        <div class="col"><?php echo $form->field($model, 'firstName'); ?></div>
        <div class="col"><?php echo $form->field($model, 'lastName'); ?></div>
    </div>
    <?php echo $form->field($model, 'email'); ?>
    <?php echo $form->field($model, 'password')->passwordField(); ?>
    <?php echo $form->field($model, 'confirmPassword')->passwordField(); ?>
    <button type="submit" class="btn btn-primary">Submit</button>
<?php app\core\form\Form::end(); ?>
