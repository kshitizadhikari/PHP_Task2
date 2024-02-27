<?php
/**
 * @var $this \app\core\View
 * @var $allUsers array
 */
$this->title = 'Admin Home Page';
?>
<h1>Admin Home</h1>
<div class="mb-3">
    <button  class="btn btn-primary" onclick="window.location.href='/admin/admin-createUser'">Create User</button>
</div>

<table class="table table-dark table-striped table-hover">
    <?php if($allUsers != null): ?>
        <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">FirstName</th>
                <th scope="col">LastName</th>
                <th scope="col">Email</th>
                <th scope="col">RoleId</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($allUsers as $user): ?>
                <tr>
                    <td><?php echo $user['id'] ?></td>
                    <td><?php echo $user['firstName'] ?></td>
                    <td><?php echo $user['lastName'] ?></td>
                    <td><?php echo $user['email'] ?></td>
                    <td><?php echo $user['role_id'] ?></td>
                    <td><?php echo $user['status'] ?></td>
                    <td>
                        <a href="/admin/admin-editDetails?id=<?php echo $user['id']?>">Edit</a> | 
                        <a href="/admin/admin-deleteUser?id=<?php echo $user['id']?>">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    <?php endif; ?>
</table>
