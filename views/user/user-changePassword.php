<?php
/**
 * @var $this \app\core\View
 * @var $model \app\models\UserEditPasswordForm
 * 
 */
use app\core\form\Form;

$this->title = 'User Edit Password Page';
?>
<h1>Change Password</h1>

<?php $form = Form::begin('', "post") ?>
        <div class="col"><?php echo $form->field($model, 'oldPassword')->passwordField(); ?></div>
        <div class="col"><?php echo $form->field($model, 'newPassword')->passwordField(); ?></div>
        <div class="col"><?php echo $form->field($model, 'confirmPassword')->passwordField(); ?></div>
    <button type="submit" class="btn btn-primary">Submit</button>
    <?php app\core\form\Form::end(); ?>
    <div class="mt-3">
        <button class="btn btn-primary" onclick="window.location.href='/user/user-editDetails?id=<?php echo $_SESSION['user']?> '">Go Back</button>
    </div>
