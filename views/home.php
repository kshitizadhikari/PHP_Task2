<?php
/**
 * @var $this \app\core\View
 * @var $allBlogs array
 */
$this->title = 'Home Page';
?>
<div class="mb-5">
    <h1>Home</h1>
</div>

<?php if($allBlogs != null): ?>
    <div class="mb-3">
        <h3>All Blogs</h3>
    </div>

    <div class="mb-3">
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
    </div>
<?php endif; ?>