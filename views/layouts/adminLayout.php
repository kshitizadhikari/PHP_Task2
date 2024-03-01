<?php
use app\core\Application;
?>
<!doctype html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $this->title ?></title>
        <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"> -->
        <link rel="stylesheet" href="/css/bootstrap.min.css">
        <script
        src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
        crossorigin="anonymous"
    ></script>
    </head>
    <body>
    <div class="d-flex flex-row mb-3 p-4">
        <ul class="navbar-nav mr-auto d-flex flex-row">
            <li class="nav-item text-center p-3">
                <a class="nav-link" href="/admin/admin-home">Home</a>
            </li>
        </ul>
            <ul class="navbar-nav ms-auto d-flex flex-row">
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-center p-3" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <?php echo Application::$app->user->getDisplayName() ?>
                </a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link text-center" href="../admin/admin-profile">Profile</a></li>
                        <li><a class="nav-link text-center" href="/logout">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        
        <div class="container">
        
        <?php if(Application::$app->session->getFlash('success')): ?>
            <div class="alert alert-success" role="alert">
                <?php echo Application::$app->session->getFlash('success') ?>
            </div>
        <?php endif; ?>
        <?php if(Application::$app->session->getFlash('error')): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo Application::$app->session->getFlash('error') ?>
            </div>
        <?php endif; ?>
        {{content}}
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </body>
    </html>