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
                                <a href="/author/author-viewBlog?id=<?php echo $blog['id']?>">View</a>
                                <?php if($blog['user_id'] == $_SESSION['user']): ?>
                                | <a href="/author/author-editBlog?id=<?php echo $blog['id']?>">Edit</a> | 
                                <a href="/author/author-deleteBlog?id=<?php echo $blog['id']?>">Delete</a>
                                <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <nav aria-label="Page navigation example">  
            <ul class="pagination" id="pagination">
                <li class="page-item"><a class="page-link" id="page-link" href="?blogPage=1">First</a></li>
                <?php if(isset($blogPageNum) && $blogPageNum > 1): ?>
                <li class="page-item"><a class="page-link" id="page-link" href="?blogPage=<?php echo $blogPageNum-1?>">Previous</a></li>
                <?php else:?>
                <li class="page-item"><a class="page-link" id="page-link">Previous</a></li>
                <?php endif; ?>
                <?php for($i=2; $i<$totalBlogPage; $i++): ?>
                <li class="page-item"><a class="page-link" id="page-link" href="?blogPage=<?php echo $i?>"><?php echo $i ?></a></li>
                <?php endfor; ?>
                <?php if(isset($blogPageNum) && $blogPageNum < $totalBlogPage): ?>                                                                                                                         
                <li class="page-item"><a class="page-link" id="page-link" href="?blogPage=<?php echo $blogPageNum+1?>">Next</a></li>
                <?php else:?>
                <li class="page-item"><a class="page-link" id="page-link">Next</a></li>
                <?php endif; ?>
                <li class="page-item"><a class="page-link" id="page-link" href="?blogPage=<?php echo $totalBlogPage ?>">Last</a></li>
            </ul>
        </nav>
<?php endif; ?>