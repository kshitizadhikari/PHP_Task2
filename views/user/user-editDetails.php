<?php
/**
 * @var $this \app\core\View
 * @var $model \app\models\UserEditDetailsForm
 * 
 */
use app\core\form\Form;

$this->title = 'User Edit Details Page';
?>
<h1>User Details</h1>

<?php $form = Form::begin('', "post") ?>
    <?php echo $form->field($model, 'id')->hiddenField(); ?>
    <div class="row">
        <div class="col"><?php echo $form->field($model, 'firstName'); ?></div>
        <div class="col"><?php echo $form->field($model, 'lastName'); ?></div>
    </div>
    <?php echo $form->field($model, 'email'); ?>
    <button type="submit" class="btn btn-primary    ">Submit</button>
    <button class="btn btn-primary  " onclick="window.location.href='/user/user-home'">Go Back</button>
<?php app\core\form\Form::end(); ?>
<div class="mt-3">
<button class="btn btn-primary" onclick="window.location.href='/user/user-changePassword?id=<?php echo $_SESSION['user']?>'">Change Password</button>

</div>
