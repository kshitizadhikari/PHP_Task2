<?php
/**
 * @var $this \app\core\View
 */
$this->title = 'Admin Profile Page';
?>

<h1>Admin Profile</h1>

<div class="row">
    <div class="col-5">
        <div class="card border-primary mb-3" style="max-width: 20rem;">
            <div class="card-header">------</div>
                <div class="card-body">
                    <h4 class="card-title">Admin Details</h4>
                    <!-- <p class="card-text"></p> -->
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            First Name: <?php echo $user->firstName?>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Last Name: <?php echo $user->lastName; ?>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Email: <?php echo $user->email; ?>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Role: <?php echo $role->role; ?>
                        </li>
                        <button class="btn btn-primary" onclick="window.location.href='/admin/admin-editDetails?id=<?php echo $_SESSION['user']?>'">Edit Details</button>
                    </ul>
                </div>
        </div>
    </div>
    <div class="col-7">
    </div>
</div>