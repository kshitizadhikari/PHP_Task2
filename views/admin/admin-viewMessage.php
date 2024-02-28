<?php
/**
 * @var $this \app\core\View
 * @var $message \app\models\Contact
 */
$this->title = 'Admin View Message Page';
?>

<div class="mb-3">
    <h1>Admin View Message</h1>
</div>

<div class="card mb-3" style="max-width: 80%;">
        <div class="row g-0">
            
            <div class="card-body">
            <h4 class="card-title"><?php echo $message->title ?></h4>
                    <!-- <p class="card-text"></p> -->
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Sent By : <?php echo $message->email?>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Subject: <?php echo $message->subject?>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Body: <?php echo $message->body?>
                        </li>
                    </ul>
                </div>
            </div>
</div>
<div class="mb-3">
    <button class="btn btn-primary" onclick="window.location.href='/admin/admin-markMessageRead?id=<?php echo $message->id ?>'" >Mark as Read</button>
    <button class="btn btn-primary" onclick="window.location.href='/admin/admin-home'" >Go Back</button>
</div>
