<?php
/**
 * @var $this \app\core\View
 * @var $blog \app\models\Blog
 */
$this->title = 'Author View Blog Page';
?>
<h1>Author View Blog</h1>

<div class="card border-primary mb-3" style="max-width: 20rem;">
    <div class="card-header">------</div>
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
            <li class="list-group-item d-flex justify-content-between align-items-center">
                Featured Image: <?php echo $blog->featured_img; ?>
            </li>
            <button class="btn btn-primary" onclick="window.location.href='/author/author-home'" >Go Back</button>
        </ul>
    </div>
    </div>