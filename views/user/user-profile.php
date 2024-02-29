<?php
/**
 * @var $this \app\core\View
 */
$this->title = 'User Profile Page';
?>

<div class="row d-flex justify-content-center align-items-center h-50">
    <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card bg-dark text-white" style="border-radius: 1rem; box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px;">

            <div class="card-body p-5 text-center">
                <div class="mb-md-2 mt-md-2 pb-2">
                    <h2 class="fw-bold mb-5 text-uppercase">User Details</h2>
                    <div class="form-outline form-white mb-4">
                        <p>First Name: <?php echo $user->firstName?></p>
                    </div>

                    <div class="form-outline form-white mb-4">
                    <p>Last Name: <?php echo $user->lastName?></p>
                    </div>

                    <div class="form-outline form-white mb-4">
                    <p>Email: <?php echo $user->email?></p>
                    </div>

                    <div class="form-outline form-white mb-4">
                    <p>Email: <?php echo $role->role?></p>
                    </div>
                    <!-- <p class="small mb-3 pb-lg-1"><a class="text-white-50" href="#!">Forgot password?</a></p> -->
                    <button class="btn btn-outline-light btn-lg px-5" type="submit"onclick="window.location.href='/user/user-editDetails?id=<?php echo $_SESSION['user']?>'">Edit Details</button>
                    </div>
                <div>
                    <p class="mb-0">
                        <button class="btn btn-primary" onclick="window.location.href='/user/user-home'">Go Back</button>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
