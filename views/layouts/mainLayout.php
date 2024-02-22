<?php
use app\core\Application;
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $this->title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  </head>
  <body>
  <div class="d-flex flex-row mb-3 p-4">
      <ul class="navbar-nav mr-auto d-flex flex-row">
        <li class="nav-item px-3">
            <a class="nav-link" href="/">Home</a>
          </li>
          <li class="nav-item px-3">
            <a class="nav-link" href="/contact">Contact</a>
          </li>
      </ul>
      <?php if(Application::isGuest()): ?>
      <ul class="navbar-nav ms-auto d-flex flex-row">
          <li class="nav-item px-3"> 
              <a class="nav-link" href="/login">Login</a>
          </li>
          <li class="nav-item px-3">
              <a class="nav-link" href="/register">Register</a>
          </li>
      </ul>
      <?php else: ?>
        <ul class="navbar-nav ms-auto d-flex flex-row">
        <li class="nav-item px-3"> 
              <a class="nav-link" href="/profile">Profile</a>
          </li>
          <li class="nav-item px-3"> 
            <?php echo Application::$app->user->getDisplayName() ?>
              <a class="nav-link" href="/logout">Logout</a>
          </li>
      </ul>
      <?php endif; ?>
    </div>
    
    <div class="container">
      
        <?php if(Application::$app->session->getFlash('success')): ?>
          <div class="alert alert-success">
            <?php echo Application::$app->session->getFlash('success') ?>
          </div>
      <?php endif; ?>
      {{content}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>