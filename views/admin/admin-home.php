<?php
/**
 * @var $this \app\core\View
 * @var $allUsers array
 */
$this->title = 'Admin Home Page';
?>

<h1>Admin Home</h1>
<section class="user">
    <div class="mb-3 mt-5">
        <div class="mb-3">
            <h3>User Section</h3>
        </div>
        <div class="row mb-3">
            <div class="col-9">
                <button  class="btn btn-primary" onclick="window.location.href='/admin/admin-createUser'">Create User</button>
            </div>
            <div class="col-3">
                <form class="d-flex" role="search" action="" method="get">
                    <input class="form-control me-2" id="firstName" type="search" placeholder="Enter FirstName" aria-label="Search" name="search">
                    <button class="btn btn-outline-success" type="submit" id="submitBtn">Search</button>
                </form>
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
    </div>
</section>

<section class="blog">
    <div class="mb-3 mt-5">
        <div class="mb-3">
            <h3>Blog Section</h3>
        </div>
        <div class="row mb-3">
            <div class="col-9">
                <button  class="btn btn-primary" onclick="window.location.href='/admin/admin-createBlog'">Create Blog</button>
            </div>
            <div class="col-3">
                <form class="d-flex" role="search" action="" method="get">
                    <input class="form-control me-2" id="searchByTitle" type="search" placeholder="Enter Title" aria-label="Search" name="search">
                    <button class="btn btn-outline-success" type="submit" id="submitBlogSearchBtn">Search</button>
                </form>
            </div>
        </div>
        <div id="blog-tableData">
            <?php if($allBlogs != null): ?>
                <table class="table table-dark table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Title</th>
                            <th scope="col">Description</th>
                            <th scope="col">FeaturedImg</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                        <tbody>
                            <?php foreach($allBlogs as $blog): ?>
                                <tr>
                                    <td><?php echo $blog['id'] ?></td>
                                    <td><?php echo $blog['title'] ?></td>
                                    <td><?php echo $blog['description'] ?></td>
                                    <td><img src="<?php echo $blog['featured_img'] ?>" height="100rem" width="100rem" /></td>
                                    <td>
                                        <a href="/admin/admin-viewBlog?id=<?php echo $blog['id']?>">View</a>
                                        | <a href="/admin/admin-editBlog?id=<?php echo $blog['id']?>">Edit</a>
                                        | <a href="/admin/admin-deleteBlog?id=<?php echo $blog['id']?>">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    
                </table>
                <nav aria-label="Page navigation example">  
                    <ul class="pagination" id="pagination">
                            <li class="page-item"><a class="page-link" id="page-link" href="?blogPage=1">First</a></li>
                            <?php if(isset($blogPageNum) && $blogPageNum > 1): ?>
                            <li class="page-item"><a class="page-link" id="page-link" href="?blogPage=<?php echo $blogPageNum?>">Previous</a></li>
                            <?php else:?>
                            <li class="page-item"><a class="page-link" id="page-link">Previous</a></li>
                            <?php endif; ?>
                            <?php for($i=2; $i<$totalBlogPage; $i++): ?>
                            <li class="page-item"><a class="page-link" id="page-link" href="?blogPage=<?php echo $i?>"><?php echo $i ?></a></li>
                            <?php endfor; ?>
                            <?php if(isset($blogPageNum) && $blogPageNum < $totalBlogPage-1): ?>
                            <li class="page-item"><a class="page-link" id="page-link" href="?blogPage=<?php echo $blogPageNum+2?>">Next</a></li>
                            <?php else:?>
                            <li class="page-item"><a class="page-link" id="page-link">Next</a></li>
                            <?php endif; ?>
                            <li class="page-item"><a class="page-link" id="page-link" href="?blogPage=<?php echo $totalBlogPage ?>">Last</a></li>
                    </ul>
                </nav>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="contact">
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
        <nav aria-label="Page navigation">  
            <ul class="pagination" id="pagination">
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
        </nav>
    </div>
</section>


<script>
    $(document).ready(function() {
        // Handle user pagination clicks
        $(document).on("click", "#pagination a", function(e) {
            e.preventDefault();
            var pageType = '';
            var pageLink = $(this).attr('href');
            var pageType = pageLink.includes('userPage') ? 'user' : pageLink.includes('contactPage') ? 'contact' : 'blog';
            
            var pageNumber = pageLink.split(pageType + 'Page=')[1];

            if (pageType === 'user') {
                fetchUserData(pageNumber);
            } else if(pageType === 'contact') {
                fetchContactData(pageNumber);
            } else {
                fetchBlogData(pageNumber);
            }
        });

        // Fetch user data with AJAX
        function fetchUserData(userPageNo) {
            $.ajax({
                url: "/admin/admin-home",
                method: "GET",
                data: { userPage: userPageNo },
                success: function(data) {
                    $("#user-tableData").html(data);
                },
                error: function(xhr, status, error) {
                    console.error("An error occurred fetching user data: " + status + " " + error);
                }
            });
        }

        // Fetch contact data with AJAX
        function fetchContactData(contactPageNo) {
            $.ajax({
                url: "/admin/admin-home",
                method: "GET",
                data: { contactPage: contactPageNo },
                success: function(data) {
                    $("#contact-tableData").html(data);
                },
                error: function(xhr, status, error) {
                    console.error("An error occurred fetching contact data: " + status + " " + error);
                }
            });
        }

        //fetch search user data
        $(document).on("click", "#submitBtn", function(e) {
            e.preventDefault();
            var firstname = $("#firstName").val();
            fetchUserSearchData(firstname);
        })

        function fetchUserSearchData(firstName)
        {
            $.ajax({
                url: '/admin/admin-home',
                method: 'GET',
                data: {firstName: firstName},
                success: function(data) {
                    $("#user-tableData").html(data);
                },
                error: function(xhr, status, error) {
                    console.error("An error occurred fetching search user data: " + status + " " + error);
                }
            });
        }

        function fetchBlogData(blogPageNo)
        {
            $.ajax({
                url: "/admin/admin-home",
                method: "GET",
                data: {blogPage: blogPageNo},
                success: function(data) {
                    $('#blog-tableData').html(data);
                }, 
                error: function(xhr, status, error) {
                    console.error("An error occurred fetching contact data: " + status + " " + error);
                }
            })
        }

        //fetch search blog data
        $(document).on("click", "#submitBlogSearchBtn", function(e) {
            e.preventDefault();
            var title = $("#searchByTitle").val();
            fetchBlogSearchData(title);
        })

        function fetchBlogSearchData(title)
        {
            $.ajax({
                url: '/admin/admin-home',
                method: 'GET',
                data: {title: title},
                success: function(data) {
                    $("#blog-tableData").html(data);
                },
                error: function(xhr, status, error) {
                    console.error("An error occurred fetching search user data: " + status + " " + error);
                }
            });
        }
    });
</script>
