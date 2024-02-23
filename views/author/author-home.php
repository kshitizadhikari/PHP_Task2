<?php
/**
 * @var $this \app\core\View
 * @var $allBlogs array
 */
$this->title = 'Author Home Page';
?>
<h1>Author Home</h1>
<div class="mb-3">
    <button onclick="window.location.href='/author/author-createBlog'">Create Blog</button>
</div>

<table class="table table-dark table-striped">
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
                    <td><?php echo $blog['featured_img'] ?></td>
                    <td><a href="/author/author-editBlog?id=<?php echo $blog['id']?>">Edit</a> | <a>Delete</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    <?php endif; ?>
</table>
