<?php
/**
 * @var $this \app\core\View
 * @var $blog \app\models\Blog
 */
$this->title = 'Home View Blog Page';
?>
<h1>Home View Blog</h1>

    <div class="card mb-3" style="max-width: 80%;">
    <div class="row g-0">
        
        <div class="col-md-8">
        <div class="card-body">
        <h4 class="card-title"><?php echo $blog->title ?></h4>
                <!-- <p class="card-text"></p> -->
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Blog Title: <?php echo $blog->title?>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Description: <?php echo $blog->description?>
                    </li>
                </ul>
                <button class="btn btn-primary" onclick="window.location.href='/Home/Home-home'" >Go Back</button>
            </div>
        </div>
        <div class="col-md-4">
        <img src="<?php echo $blog->featured_img; ?>" class="img-fluid rounded-start" alt="..." height="90%" width="90%">
        </div>
    </div>
    </div>