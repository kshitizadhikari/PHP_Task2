<?php
/**
 * @var $this \app\core\View
 * @var $model \app\models\User
 * 
 */
use app\core\form\Form;

$this->title = 'Admin Create User Page';
?>

<div class="row d-flex justify-content-center align-items-center h-50">
    <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card bg-dark text-white" style="border-radius: 1rem; box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px;">

            <div class="card-body p-5 text-center">
                <?php $form = Form::begin('', "post") ?>

                <div class="mb-md-2 mt-md-2 pb-2">
                    <h2 class="fw-bold mb-2">Create New User</h2>
                    <div class="row">
                        <div class="col">
                            <div class="form-outline form-white mb-4">
                                <?php echo $form->field($model, 'firstName'); ?>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-outline form-white mb-4">
                                <?php echo $form->field($model, 'lastName'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-outline form-white mb-4">
                        <?php echo $form->field($model, 'email'); ?>
                    </div>

                    <div class="form-outline form-white mb-4">
                        <?php echo $form->field($model, 'password')->passwordField(); ?>
                    </div>
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

                    <!-- <p class="small mb-3 pb-lg-1"><a class="text-white-50" href="#!">Forgot password?</a></p> -->
                    <button class="btn btn-outline-light btn-lg px-5" type="submit">Create</button>
                </div>
                <?php app\core\form\Form::end(); ?>
                
            </div>
        </div>
    </div>
</div>