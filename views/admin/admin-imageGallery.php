<?php
/**
 * @var $this \app\core\View
 */
$this->title = 'Image Gallery Page';
?>
<div class="mb-5">
    <h1>Image Gallery</h1>
</div>

<!-- Carousel wrapper -->
<div
    id="carouselMultiItemExample"
    class="carousel slide carousel-dark text-center"
    data-mdb-ride="carousel"
    >
    <!-- Controls -->
    <!-- <div class="d-flex justify-content-center mb-4">
        <button
        class="carousel-control-prev position-relative"
        type="button"
        data-mdb-target="#carouselMultiItemExample"
        data-mdb-slide="prev"
        >
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
        </button>
        <button
        class="carousel-control-next position-relative"
        type="button"
        data-mdb-target="#carouselMultiItemExample"
        data-mdb-slide="next"
        >
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
        </button>
    </div> -->
    <!-- Inner -->
    <div class="carousel-inner py-4">
        <!-- Single item -->
        <div class="carousel-item active">
            <div class="container">
                <div class="row">
                    <?php foreach($images as $image): ?>
                        <div class="col-lg-4 mb-3">
                            <div class="card">
                            <img 
                                src="<?php echo $image['path'] ?>"
                                class="card-img-top"
                                alt="Waterfall"
                                height="300rem"
                                width="100rem"
                            />
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $image['name'] ?></h5>
                                <!-- <p class="card-text">
                                Some quick example text to build on the card title and make up the bulk
                                of the card's content.
                                </p> -->
                                <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#viewModal">
                                    View
                                </button> -->
                                <a href="/admin/admin-imageGallery/deleteImage?imgName=<?php echo $image['name']?>" class="btn btn-primary">Delete</a>
                            </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    </div>
</div>
