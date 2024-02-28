<?php
/**
 * @var $this \app\core\View
 * @var $model \app\models\User
 * 
 */
use app\core\form\Form;

$this->title = 'Admin Edit Details Page';
?>
<h1>User Details</h1>

<?php $form = Form::begin('', "post") ?>
    <?php echo $form->field($model, 'id')->hiddenField(); ?>
    <div class="row">
        <div class="col"><?php echo $form->field($model, 'firstName'); ?></div>
        <div class="col"><?php echo $form->field($model, 'lastName'); ?></div>
    </div>
    <?php echo $form->field($model, 'email'); ?>
    <?php if($model->id !== $_SESSION['user']): ?>
        <?php echo $form->dropdown($model, 'status', [
            'Active' => 1,
            'Deactivate' => 0,
        ])->render(); ?>
        <?php echo $form->field($model, 'role_id'); ?>
    <?php endif; ?>
    <button type="submit" class="btn btn-primary">Submit</button>
    <button class="btn btn-primary" onclick="window.location.href='/admin/admin-home'">Go Back</button>
<?php app\core\form\Form::end(); ?>


<!-- Button trigger modal -->
<div class="mt-3">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#changePwModal">
        Change Password
    </button>
</div>

<!-- Modal -->
    <div class="modal fade" id="changePwModal" tabindex="-1" aria-labelledby="changePwModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="changePwModalLabel">Enter New Password</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php $form = Form::begin('/admin/admin-changePassword', "post") ?>
                    <?php echo $form->field($model, 'id')->hiddenField(); ?>
                    <?php echo $form->field($model, 'password')->passwordField(); ?>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
            <?php app\core\form\Form::end(); ?>

            </div>
        </div>
    </div>