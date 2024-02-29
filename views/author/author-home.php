<?php
/**
 * @var $this \app\core\View
 * @var $allBlogs array
 */
$this->title = 'Author Home Page';
?>
<h1>Author Home</h1>
<div class="row mb-3 d-flex">
    <div class="col-5">
        <button class="btn btn-primary" onclick="window.location.href='/author/author-createBlog'">Create Blog</button>
    </div>
    <div class="col-7 d-flex  flex-row-reverse">
        <form role="search" action="" method="get" class="d-flex">
            <div class="mr-2">
                <select class="form-control" id="sort_by" name="sort_by">
                    <option value="id">Id</option>
                    <option value="title">Title</option>
                    <!-- Add options for other columns -->
                </select>
            </div>
            <div class="mr-2">
                <select class="form-control" id="sort_order" name="sort_order">
                    <option value="ASC">Ascending</option>
                    <option value="DESC">Descending</option>
                </select>
            </div>
            <div class="mr-2">
                <input class="form-control" type="search" placeholder="Enter Title" aria-label="Search" name="search">
            </div>
            <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
    </div>
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
                        <a href="/author/author-viewBlog?id=<?php echo $blog['id']?>">View</a>
                        <?php if($blog['user_id'] == $_SESSION['user']): ?>
                        | <a href="/author/author-editBlog?id=<?php echo $blog['id']?>">Edit</a> | 
                        <a href="/author/author-deleteBlog?id=<?php echo $blog['id']?>">Delete</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    <?php endif; ?>
</table>
