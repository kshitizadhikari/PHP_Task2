<?php
/**
 * @var $this \app\core\View
 * @var $model \app\models\ContactForm
 */

use app\core\form\Form;
use app\core\form\TextareaField;

$this->title = 'Contact Page';
?>

<div class="row d-flex justify-content-center align-items-center h-50">
    <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card bg-dark text-white" style="border-radius: 1rem; box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px;">

            <div class="card-body p-4 text-center">
                <?php $form = Form::begin('', "post") ?>

                <div class="mb-md-2 mt-md-2 pb-2">
                    <h2 class="fw-bold mb-2 text-uppercase">Contact Us</h2>
                    <p class="text-white-50 mb-3">Please write .. anything!</p>

                    <div class="form-outline form-white mb-4">
                        <?php echo $form->field($model, 'email'); ?>
                    </div>

                    <div class="form-outline form-white mb-4">
                      <?php echo $form->field($model, "subject")?>
                    </div>

                    <div class="form-outline form-white mb-4">
                      <?php echo new TextareaField($model, "body")?>
                    </div>

                    <!-- <p class="small mb-3 pb-lg-1"><a class="text-white-50" href="#!">Forgot password?</a></p> -->
                    <button class="btn btn-outline-light btn-lg px-5" type="submit">Send</button>
                </div>
                <?php app\core\form\Form::end(); ?>
            </div>
        </div>
    </div>
</div>