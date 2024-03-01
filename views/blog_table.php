<?php if($allBlogs != null): ?>
    <div class="mb-3" id="tableData">
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
                            <a href="/home/home-viewBlog?id=<?php echo $blog['id']?>">View</a> 
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <nav aria-label="Page navigation example">  
            <ul class="pagination" id="pagination">
                <li class="page-item"><a class="page-link" id="page-link" href="?blogPage=1">First</a></li>
                <?php if(isset($blogPageNum) && $blogPageNum >= 1): ?>
                <li class="page-item"><a class="page-link" id="page-link" href="?blogPage=<?php echo $blogPageNum-1?>">Previous</a></li>
                <?php else:?>
                <li class="page-item"><a class="page-link" id="page-link">Previous</a></li>
                <?php endif; ?>
                <?php for($i=2; $i<$totalBlogPages; $i++): ?>
                <li class="page-item"><a class="page-link" id="page-link" href="?blogPage=<?php echo $i?>"><?php echo $i ?></a></li>
                <?php endfor; ?>
                <?php if(isset($blogPageNum) && $blogPageNum < $totalBlogPages): ?>                                                                                                                         
                <li class="page-item"><a class="page-link" id="page-link" href="?blogPage=<?php echo $blogPageNum+1?>">Next</a></li>
                <?php else:?>
                <li class="page-item"><a class="page-link" id="page-link">Next</a></li>
                <?php endif; ?>
                <li class="page-item"><a class="page-link" id="page-link" href="?blogPage=<?php echo $totalBlogPages ?>">Last</a></li>
            </ul>
        </nav>
    </div>
<?php endif; ?>