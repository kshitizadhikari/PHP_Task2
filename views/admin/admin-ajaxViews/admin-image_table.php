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
    <?php if($currentNumImages > $totalImages): ?>
        <p class="mt-3">You have reached the end</p>
    <?php else: ?>
        <a href="?imagePage=<?php echo $currentNumImages?>"  class="btn btn-primary" id="loadMoreBtn">Load More</a>
    <?php endif;?>