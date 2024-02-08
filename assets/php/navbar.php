<?php

session_start();
?>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">My Library</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/index.php">Home</a>
        </li>
        <?php
        if(isset($_SESSION['login'])) {
           ?> <li class="nav-item">
          <a class="nav-link" href="controller.php?mode=logout">Log Out</a>
        </li> <?php
        } else {
           ?> <li class="nav-item">
          <a class="nav-link" href="/login.php">Log In</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/newuser.php">New Account</a>
        </li> <?php
        } 
        
        if(isset($_SESSION['login'])) {
            ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Manage
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="/books.php">Your Books</a></li>
            <li><a class="dropdown-item" href="/addbook.php">Add Book</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">My Profile</a></li>
          </ul>
        </li> <?php
        } ?>
        
      </ul>
      <form class="d-flex" role="search" method="POST" action="controller.php?mode=searchBooks">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
      <?php
        if($_SESSION['login'] === 'true') {
          ?>
          <a href="profilo.php"><img src="<?= $_SESSION['user_image'] ?>" style="width: 30px; height: 30px;border-radius: 50%; cursor: pointer;" class="mx-3" alt="immagine profilo"> </a>
          
          <?php
        }
        ?>
    </div>
  </div>
</nav>