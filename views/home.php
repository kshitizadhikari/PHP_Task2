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

    <div class="row mb-3 d-flex">
        <div class="col-5 p-3">
            <h3>All Blogs</h3>
        </div>
        <div class="col-7 d-flex flex-row-reverse p-3 align-items-center">
        <form role="search" action="" method="get" class="d-flex">
            
            <div class="mr-2">
                <input class="form-control" type="search" id="searchByTitle" placeholder="Enter Title" aria-label="Search" name="search">
            </div>
            <button class="btn btn-outline-success" id="submitBtn" type="submit">Search</button>
        </form>
        </div>
    </div>
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
                <?php if(isset($blogPageNum) && $blogPageNum > 1): ?>
                <li class="page-item"><a class="page-link" id="page-link" href="?blogPage=<?php echo $blogPageNum?>">Previous</a></li>
                <?php else:?>
                <li class="page-item"><a class="page-link" id="page-link">Previous</a></li>
                <?php endif; ?>
                <?php for($i=2; $i<$totalBlogPages; $i++): ?>
                <li class="page-item"><a class="page-link" id="page-link" href="?blogPage=<?php echo $i?>"><?php echo $i ?></a></li>
                <?php endfor; ?>
                <?php if(isset($blogPageNum) && $blogPageNum < $totalBlogPages-1): ?>
                <li class="page-item"><a class="page-link" id="page-link" href="?blogPage=<?php echo $blogPageNum+2?>">Next</a></li>
                <?php else:?>
                <li class="page-item"><a class="page-link" id="page-link">Next</a></li>
                <?php endif; ?>
                <li class="page-item"><a class="page-link" id="page-link" href="?blogPage=<?php echo $totalBlogPages ?>">Last</a></li>
            </ul>
        </nav>
    </div>
<?php endif; ?>



<script>
    $(document).ready(function() {
        $(document).on("click", "#pagination a", function(e)
        {
            e.preventDefault();
            var blogPageNo = $(this).attr('href').split('blogPage=');
            fetchData(blogPageNo[1]);
        })

        function fetchData(pageNo) {
            $.ajax({
                url: "/",
                method: "GET",
                data: { blogPage: pageNo },
                success: function(data) {
                    $("#tableData").html(data);
                },
                error: function(xhr, status, error) {
                    console.error("An error occurred: " + status + " " + error);
                }
            });
        }

        $(document).on("click", "#submitBtn", function(e) {
            e.preventDefault();

            var title = $("#searchByTitle").val();
            console.log(title);
            fetchSearchBlogData(title);
        });

        function fetchSearchBlogData(title) {
            $.ajax({
                url: '/',
                method: 'GET',
                data: {searchTitle: title},
                success: function(data) {
                    $("#tableData").html(data)
                }, 
                error: function(xhr, status, error) {
                    console.error("An error occurred: " + status + " " + error);
                }
            });
        }
    });
</script>