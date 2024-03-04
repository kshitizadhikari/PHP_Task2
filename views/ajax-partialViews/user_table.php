<?php if($allUsers != null): ?>
    <div class="mb-3" id="tableData">
        <table class="table table-dark table-striped table-hover">
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
        </table>
        <nav aria-label="Page navigation example">  
            <ul class="pagination" id="pagination">
                <li class="page-item"><a class="page-link" id="page-link" href="?userPage=1">First</a></li>
                <?php if(isset($userPageNum) && $userPageNum >= 1): ?>
                <li class="page-item"><a class="page-link" id="page-link" href="?userPage=<?php echo $userPageNum-1?>">Previous</a></li>
                <?php else:?>
                <li class="page-item"><a class="page-link" id="page-link">Previous</a></li>
                <?php endif; ?>
                <?php for($i=2; $i<$totalUserPage; $i++): ?>
                <li class="page-item"><a class="page-link" id="page-link" href="?userPage=<?php echo $i?>"><?php echo $i ?></a></li>
                <?php endfor; ?>
                <?php if(isset($userPageNum) && $userPageNum < $totalUserPage): ?>                                                                                                                         
                <li class="page-item"><a class="page-link" id="page-link" href="?userPage=<?php echo $userPageNum+1?>">Next</a></li>
                <?php else:?>
                <li class="page-item"><a class="page-link" id="page-link">Next</a></li>
                <?php endif; ?>
                <li class="page-item"><a class="page-link" id="page-link" href="?userPage=<?php echo $totalUserPage ?>">Last</a></li>
            </ul>
        </nav>
    </div>
    <?php else: ?>
    <div>
        <h3>User Not Found</h3>
    </div>
    <?php endif; ?>
