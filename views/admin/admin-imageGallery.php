<?php
/**
 * @var $this \app\core\View
 */
$this->title = 'Image Gallery Page';
?>
<div class="mb-5">
    <h1>Image Gallery</h1>
</div>

<div>
    <button class="btn btn-primary" onclick="window.location.href='/admin/admin-imageGallery/addImage'">Add Image</button>
</div>

<div
    id="carouselMultiItemExample"
    class="carousel slide carousel-dark text-center"
    data-mdb-ride="carousel"
    >
    
    <div class="carousel-inner py-4">
        <!-- Single item -->
        <div class="carousel-item active">
            <div class="container">
                <div class="image-tableData" id="image-tableData">
                    <div class="row">
                        <?php foreach($allImages as $image): ?>
                            <div class="col-lg-4 mb-3">
                                <div class="card">
                                    <img 
                                        src="<?php echo $image['relative_path'] ?>"
                                        class="card-img-top"
                                        alt="Waterfall"
                                        height="300rem"
                                        width="100rem"
                                    />
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo ($image['img_name'] . "." . $image['img_ext']) ?></h5>
                                        <a href="/admin/admin-imageGallery/deleteImage?imgName=<?php echo $image['name']?>" class="btn btn-primary">Delete</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>
                    <a href="?imagePage=<?php echo $currentNumImages?>"  class="btn btn-primary" id="loadMoreBtn">Load More</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#loadMoreBtn').on('click', function(e) {
            e.preventDefault();
            var currentImageNum = $(this).attr('href').split('imagePage=');
            fetchImageData(currentImageNum[1]);
        });
        function fetchImageData(pageNo) {
            $.ajax({
                url: "/admin/admin-imageGallery",
                method: "GET",
                data: { currentNumOfImages: pageNo },
                success: function(data) {
                    $("#image-tableData").html(data);
                },
                error: function(xhr, status, error) {
                    console.error("An error occurred: " + status + " " + error);
                }
            });
        }
    })

</script>
