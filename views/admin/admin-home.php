<?php
/**
 * @var $this \app\core\View
 * @var $allUsers array
 */
$this->title = 'Admin Home Page';
?>

<h1>Admin Home</h1>
<div class="mb-3">
    <div class="row">
        <div class="col-9">
            <button  class="btn btn-primary" onclick="window.location.href='/admin/admin-createUser'">Create User</button>
        </div>
        <div class="col-3">
            <form class="d-flex" role="search" action="" method="get">
                <input class="form-control me-2" type="search" placeholder="Enter FirstName" aria-label="Search" name="search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>
    </div>
    
</div>


<div class="mb-5" id="user-tableData">
    <?php if($allUsers != null): ?>
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
    <?php endif; ?>
    <nav aria-label="Page navigation">  
            <ul class="pagination" id="pagination">
                <li class="page-item"><a class="page-link" id="page-link" href="?userPage=1">First</a></li>
                <?php if(isset($userPageNum) && $userPageNum > 1): ?>
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



<div id="contact-tableData">
    <?php if($allMessages != null): ?>
        <div class="mb-3">
            <h3>Contact Messages</h3>
        </div>
        <table class="table table-dark table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Email</th>
                    <th scope="col">Subject</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($allMessages as $message): ?>
                    <tr>
                        <td><?php echo $message['id'] ?></td>
                        <td><?php echo $message['email'] ?></td>
                        <td><?php echo $message['subject'] ?></td>
                        <td><?php echo $message['status'] ?></td>
                        <td>
                            <a href="/admin/admin-viewMessage?id=<?php echo $message['id']?>">View</a> | 
                            <a href="/admin/admin-deleteMessage?id=<?php echo $message['id']?>">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
    <!-- <nav aria-label="Page navigation">  
        <ul class="pagination contact" id="pagination contact">
            <li class="page-item"><a class="page-link" id="page-link" href="?contactPage=1">First</a></li>
            <?php if(isset($contactPageNum) && $contactPageNum > 1): ?>
                <li class="page-item"><a class="page-link" id="page-link" href="?contactPage=<?php echo $contactPageNum-1?>">Previous</a></li>
            <?php else:?>
                <li class="page-item"><a class="page-link" id="page-link">Previous</a></li>
            <?php endif; ?>
            <?php for($i=2; $i<$totalContactPage; $i++): ?>
                <li class="page-item"><a class="page-link" id="page-link" href="?contactPage=<?php echo $i?>"><?php echo $i ?></a></li>
            <?php endfor; ?>
            <?php if(isset($contactPageNum) && $contactPageNum < $totalContactPage): ?>                                                                                                                         
                <li class="page-item"><a class="page-link" id="page-link" href="?contactPage=<?php echo $contactPageNum+1?>">Next</a></li>
            <?php else:?>
                <li class="page-item"><a class="page-link" id="page-link">Next</a></li>
            <?php endif; ?>
            <li class="page-item"><a class="page-link" id="page-link" href="?contactPage=<?php echo $totalContactPage ?>">Last</a></li>
        </ul>
    </nav> -->
</div>


<script>
    $(document).ready(function() {
        $(document).on("click", "#pagination a", function(e)
        {
            e.preventDefault();
            var userPage = $(this).attr('href').split('userPage=');
            fetchUserData(userPage[1]);
        })

        function fetchUserData(pageNo) {
            $.ajax({
                url: "/admin/admin-home",
                method: "GET",
                data: { userPage: pageNo },
                success: function(data) {
                    $("#user-tableData").html(data);
                },
                error: function(xhr, status, error) {
                    console.error("An error occurred: " + status + " " + error);
                }
            });
        }
    });
</script>