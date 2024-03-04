<?php
/**
 * @var $this \app\core\View
 * @var $blog \app\models\Blog
 */
$this->title = 'Author View Blog Page';
?>
<h1>Author View Blog</h1>

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
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Author: <?php echo $author->firstName . "  " . $author->lastName?> 
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Author Email: <?php echo $author->email?> 
                    </li>
                </ul>
                
            <div class="mt-3">
                <button class="btn btn-primary" onclick="window.location.href='/author/author-home'" >Go Back</button>
            </div>
            </div>
        </div>
        <div class="col-md-4">
        <img src="<?php echo $blog->featured_img; ?>" class="img-fluid rounded-start" alt="..." height="90%" width="90%">
        </div>
    </div>
    </div>