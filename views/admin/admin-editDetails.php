<?php
/**
 * @var $this \app\core\View
 * @var $model \app\models\User
 * 
 */
use app\core\form\Form;

$this->title = 'Admin Edit Details Page';
?>
<div class="row d-flex justify-content-center align-items-center h-50">
    <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card bg-dark text-white" style="border-radius: 1rem; box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px;">

            <div class="card-body p-5 text-center">

                <div class="mb-md-2 mt-md-2 pb-2">
                    <h2 class="fw-bold mb-4">Edit User Details</h2>

                    <?php $form = Form::begin('', "post") ?>
                    <?php echo $form->field($model, 'id')->hiddenField(); ?>
                    <div class="form-outline form-white mb-2">
                    <div class="row">
                        <div class="col"><?php echo $form->field($model, 'firstName'); ?></div>
                        <div class="col"><?php echo $form->field($model, 'lastName'); ?></div>
                    </div>
                    </div>

                    <div class="form-outline form-white mb-4">
                        <?php echo $form->field($model, 'email'); ?>
                    </div>

                    <div class="form-outline form-white mb-4">
                        <?php if($model->id !== $_SESSION['user']): ?>
                            <div class="row">
                                <div class="col">
                                    <?php echo $form->dropdown($model, 'status', [
                                        'Active' => 1,
                                        'Deactivate' => 0,
                                    ])->render(); ?>
                                </div>
                                <div class="col">
                                    <?php echo $form->dropdown($model, 'role_id', [
                                            'Admin' => 1,
                                            'Editor' => 2,
                                            'Author' => 3,
                                            'User' => 4,
                                        ])->render(); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <!-- <p class="small mb-3 pb-lg-1"><a class="text-white-50" href="#!">Forgot password?</a></p> -->
                    <button class="btn btn-outline-light btn-lg px-5" type="submit">Update</button>
                </div>
                <?php app\core\form\Form::end(); ?>
                <div>
                    <p class="mb-0">
                        <button class="btn btn-primary" onclick="window.location.href='/admin/admin-profile'">Go Back</button>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#changePwModal">
                            Change Password
                        </button>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Button trigger modal -->
<div class="mt-3">
    
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