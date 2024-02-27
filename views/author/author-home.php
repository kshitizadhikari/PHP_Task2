<?php
/**
 * @var $this \app\core\View
 * @var $allBlogs array
 */
$this->title = 'Author Home Page';
?>
<h1>Author Home</h1>
<div class="mb-3">
    <button class="btn btn-primary" onclick="window.location.href='/author/author-createBlog'">Create Blog</button>
</div>

<table class="table table-dark table-striped table-hover">
    <?php if($allBlogs != null): ?>
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
                        <a href="/author/author-viewBlog?id=<?php echo $blog['id']?>">View</a> |
                        <?php if($blog['user_id'] == $_SESSION['user']): ?>
                        <a href="/author/author-editBlog?id=<?php echo $blog['id']?>">Edit</a> | 
                        <a href="/author/author-deleteBlog?id=<?php echo $blog['id']?>">Delete</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    <?php endif; ?>
</table>
