<?php
    /**
     * @var model \app\models\User 
    * @var $this \app\core\View
    */
    use app\core\form\Form;
$this->title = 'Login Page';
?>

<div class="row d-flex justify-content-center align-items-center h-50">
    <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card bg-dark text-white" style="border-radius: 1rem; box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px;">

            <div class="card-body p-5 text-center">
                <?php $form = Form::begin('', "post") ?>

                <div class="mb-md-2 mt-md-2 pb-2">
                    <h2 class="fw-bold mb-2 text-uppercase">Login</h2>
                    <p class="text-white-50 mb-5">Please enter your email and password!</p>

                    <div class="form-outline form-white mb-4">
                        <?php echo $form->field($model, 'email'); ?>
                    </div>

                    <div class="form-outline form-white mb-4">
                        <?php echo $form->field($model, 'password')->passwordField(); ?>
                    </div>
                    <!-- <p class="small mb-3 pb-lg-1"><a class="text-white-50" href="#!">Forgot password?</a></p> -->
                    <button class="btn btn-outline-light btn-lg px-5" type="submit">Login</button>
                </div>
                <?php app\core\form\Form::end(); ?>
                <div>
                    <p class="mb-0">Don't have an account? <a href="/register" class="text-white-50 fw-bold">Sign Up</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
